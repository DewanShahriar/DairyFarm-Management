<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->lang->load('content', $_SESSION['lang']);

        if (!isset($_SESSION['user_auth']) || $_SESSION['user_auth'] != true) {
            redirect('login', 'refresh');
        }
        if ($_SESSION['userType'] != 'user')
            redirect('login', 'refresh');

        $this->load->model('UserModel');
        $this->load->library("pagination");
        $this->load->helper("url");
        $this->load->helper("text");
        date_default_timezone_set("Asia/Dhaka");
    }

    public function index() {


        $user_id = $this->session->userdata('userid');

        $data['title'] = 'Admin Panel • HRSOFTBD News Portal Admin Panel';
        $data['page'] = 'backEnd/user/user_dashboard';
        $data['activeMenu'] = 'dashboard_view';

        $this->load->view('backEnd/master_page', $data);
    }

    public function get_zilla_from_division() {

        $divission_data['divission_id'] = $this->input->post('divission_id');
        $divission_data['distrcts'] = $this->db->get_where('tbl_zilla', array('divission_id' => $divission_data['divission_id']))->result_Array();

        $this->load->view('backEnd/' . $_SESSION['userType'] . '/get_zilla_from_division', $divission_data);
    }

    public function get_upozilla_from_division_and_zilla() {

        $district_data['divission_id'] = $this->input->post('divission_id');
        $district_data['district_id'] = $this->input->post('district_id');

        $district_data['upozilla'] = $this->db->get_where('tbl_upozilla', array('division_id' => $district_data['divission_id'], 'zilla_id' => $district_data['district_id']))->result_Array();

        $this->load->view('backEnd/' . $_SESSION['userType'] . '/get_upozilla_from_division_and_zilla', $district_data);
    }

    public function profile($param1 = '') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $old_password = sha1($this->input->post('old_password'));
            $new_password = sha1($this->input->post('new_password'));
            $user_id = $this->input->post('user_id');

            $user_query = $this->db->get_where('user', array('id' => $user_id, 'password' => $old_password));
            $user_exist = $user_query->num_rows();

            //if user exist
            if ($user_exist > 0) {

                $this->db->where('id', $user_id);
                $this->db->update('user', array('password' => $new_password));

                $this->session->set_flashdata('message', 'Data Updated Successfully');
            }

            $config['upload_path'] = 'assets/userPhoto/';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = '116';

            //load upload class library
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userphoto')) {
                // case - failure
                $upload_error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('message', "Failed to upload image.");
            } else {
                // case - success
                $old_photo_info = $this->db->get_where('user', array('id' => $user_id))->row();
                if (isset($old_photo_info->photo)) {
                    unlink($old_photo_info->photo);
                }

                $upload_data = $this->upload->data();
                $userphoto_path = $config['upload_path'] . $upload_data['file_name'];
                //update new path delete old path
                $this->db->where('id', $user_id);
                $this->db->update('user', array('photo' => $userphoto_path));

                $this->session->set_userdata('userPhoto', $userphoto_path);
                $this->session->set_flashdata('message', $this->lang->line("upload_success"));
            }
            redirect($_SESSION['userType'] . '/profile', 'refresh');
        }

        $data['user_info'] = $this->db->get_where('user', array('id' => $_SESSION['userid'], 'username' => $_SESSION['username']))->row();

        $data['title'] = 'Change Progile Admin Panel • HRSOFTBD News Portal Admin Panel';

        $data['page'] = 'backEnd/' . $_SESSION['userType'] . '/profile';
        $data['activeMenu'] = '';

        $this->load->view('backEnd/master_page', $data);
    }



    public function projects($param1 = '', $param2 = '', $param3 = '')
    {
        if ($param1 == 'add') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $insert_project['name']                 = $this->input->post('name', true);
                $insert_project['address']              = $this->input->post('address', true);
                $insert_project['remark']               = $this->input->post('remark', true);
                $insert_project['project_start_date']   = date("Y-m-d", strtotime($this->input->post('project_start_date', true)));
                $insert_project['insert_by']            = $this->session->userdata('userid');

                if ($this->UserModel->add_project($insert_project)) {

                    $this->session->set_flashdata('message','Project Added Successfully!');
                    redirect('user/projects','refresh');

                } else {

                    $this->session->set_flashdata('message','Project Add Failed!');
                    redirect('user/projects','refresh');

                }
                
            }
            
        } elseif ($param1 == 'edit') {

            $param2 = $this->input->post('project_id', true);

            $data['edit_info'] = $this->db->get_where('tbl_project',array('id'=>$param2));

            if ($data['edit_info']->num_rows() > 0) {

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $update_project['name']               = $this->input->post('name', true);
                    $update_project['remark']             = $this->input->post('remark', true);
                    $update_project['address']            = $this->input->post('address', true);
                    $update_project['project_start_date'] = date("Y-m-d", strtotime($this->input->post('project_start_date', true)));


                    if ($this->UserModel->project_update($update_project,$param2)) {

                        $this->session->set_flashdata('message','Project Updated Successfully!');
                        redirect('user/projects','refresh');

                    } else {

                        $this->session->set_flashdata('message','Project Update Failed!');
                        redirect('user/projects','refresh');

                    }
                
                }

            }else{

            }

            

        } elseif ($param1 == 'statuschange') {

            $param2 = $this->input->post('project_note_id', true);

            $data['edit_info'] = $this->db->get_where('tbl_project',array('id'=>$param2));

            if ($data['edit_info']->num_rows() > 0) {

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {


                    $update_project['remark']             = $this->input->post('remark_status', true);
                    $update_project['completed']          = $this->input->post('project_status', true);

                    if ($this->UserModel->project_update($update_project,$param2)) {

                        $this->session->set_flashdata('message','Project Updated Successfully!');
                        redirect('user/projects','refresh');

                    } else {

                        $this->session->set_flashdata('message','Project Update Failed!');
                        redirect('user/projects','refresh');

                    }
                
                }

            }else{
                return false;
            }



        } elseif ($param1 == 'delete' && $param2 > 0) {

            $projects_delete = $this->db->where('id',$param2)->delete('tbl_project');

            if ($projects_delete) {

                $this->session->set_flashdata('message','Project Deleted Successfully!');
                redirect('user/projects','refresh');

            } else {

                $this->session->set_flashdata('message','Project Delete Failed!');
                redirect('user/projects','refresh');

            }

        }


        $data['title']      = 'Project';
        $data['activeMenu'] = 'projects';
        $data['page']       = 'backEnd/user/projects';
        $data['projects']   = $this->UserModel->project_lists();

        
        $this->load->view('backEnd/master_page',$data);
    }


    public function accounthead($param1 = '', $param2 = '', $param3 = '')
    {
        if ($param1 == 'add') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $insert_accounthead['name']      = $this->input->post('name', true);
                $insert_accounthead['category']  = $this->input->post('category', true);
                $insert_accounthead['parent_id'] = $this->input->post('parent_id', true);
                $insert_accounthead['insert_by'] = $this->session->userdata('userid');

                if ($this->UserModel->add_accounthead($insert_accounthead)) {

                    $this->session->set_flashdata('message','Account Head Added Successfully!');
                    redirect('user/accounthead','refresh');

                } else {

                    $this->session->set_flashdata('message','Account Head Add Failed!');
                    redirect('user/accounthead','refresh');

                }
                
            }           

        }elseif ($param1 == 'edit' && $param2 > 0) {

            $data['edit_info'] = $this->db->get_where('tbl_account_head',array('id'=>$param2));

            if ($data['edit_info']->num_rows() > 0) {

                $data['edit_info']    = $data['edit_info']->row();
                $data['edit_info_id'] = $param2;

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $update_accounthead['name']      = $this->input->post('name', true);
                $update_accounthead['category']  = $this->input->post('category', true);
                $update_accounthead['parent_id'] = $this->input->post('parent_id', true);
                $update_accounthead['insert_by'] = $this->session->userdata('userid');

                if ($this->UserModel->accounthead_update($update_accounthead, $param2)) {

                    $this->session->set_flashdata('message','Account Head Updated Successfully!');
                    redirect('user/accounthead/edit/'.$param2,'refresh');

                } else {

                    $this->session->set_flashdata('message','Account Head Update Failed!');
                    redirect('user/accounthead/edit/'.$param2,'refresh');

                }
                
            }

            } else {

                $this->session->set_flashdata('message','Wrong Attempt!');
                redirect('user/accounthead','refresh');
            }
            

        }elseif ($param1 == 'delete' && $param2 > 0) {

            $account_head_delete = $this->db->where('id',$param2)->delete('tbl_account_head');

            if ($account_head_delete) {

                $this->session->set_flashdata('message','Account Head Deleted Successfully!');
                redirect('user/accounthead','refresh');

            } else {

                $this->session->set_flashdata('message','Account Head Delete Failed!');
                redirect('user/accounthead','refresh');

            }

        }

        $data['title']        = 'Account Head';
        $data['activeMenu']   = 'account_head';
        $data['page']         = 'backEnd/user/account_head';
        $data['parent_zero']  = $this->db->get_where('tbl_account_head',array('parent_id'=>0))->result();
        $data['account_head'] = $this->db->order_by('id','desc')->get('tbl_account_head')->result();
        $this->load->view('backEnd/master_page',$data);
    }

    public function accounts($param1 = 'add', $param2 = '', $param3 = '')
    {
        if ($param1 == 'add' ) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $insert_account['project_id']  = $this->input->post('project_id', true);
                $insert_account['date']        = date("Y-m-d", strtotime($this->input->post('date', true)));
                $insert_account['insert_by']   = $this->session->userdata('userid');
                $insert_account['insert_time'] = date('Y-m-d H:i:s');

                foreach ($this->input->post('amount', true) as $key => $value) {

                    if($value == 0 ) continue; 

                    $insert_account['amount']          = $value;
                    $insert_account['account_head_id'] = $this->input->post('account_head_id', true)[$key];
                    $insert_account['description']     = $this->input->post('description', true)[$key];
                    $insert_account['quantity']        = $this->input->post('quantity', true)[$key];
                    $insert_account['rate']            = $this->input->post('rate', true)[$key];            
                    
                    $this->UserModel->add_accounts($insert_account);
                }

                $match_serialgenerate = $this->db->where('project_id',$insert_account['project_id'])->where('date',$insert_account['date'])->get('tbl_serialgenerate')->num_rows();
                if ($match_serialgenerate > 0) {
                    
                } else {
                    $this->db->insert('tbl_serialgenerate',array("project_id" => $insert_account['project_id'],"date" => $insert_account['date']));
                }

                $this->session->set_flashdata('message','Account Added Successfully!');
                redirect('user/accounts','refresh');

                $this->session->set_flashdata('message','Account Added Successfully!');
                redirect('user/accounts','refresh');
            }


            $data['title']          = 'Accounts Add';
            $data['activeMenu']     = 'accounts_add';
            $data['page']           = 'backEnd/user/accounts_add';
            $data['projects']       = $this->db->get('tbl_project')->result();
            $data['account_head']   = $this->db->get('tbl_account_head')->result();
            $data['parent_head']    = $this->db->where('parent_id', 0)->get('tbl_account_head')->result();

        }elseif ($param1 == 'edit' && $param2 > 0) {

            $data['edit_info'] = $this->db->get_where('tbl_accounts',array('id'=>$param2));

            if ($data['edit_info']->num_rows() > 0) {

                $data['edit_info']    = $data['edit_info']->row();
                $data['edit_info_id'] = $param2;

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $update_account['project_id']      = $this->input->post('project_id', true);
                    $update_account['date']            = date("Y-m-d", strtotime($this->input->post('date', true)));
                    $update_account['account_head_id'] = $this->input->post('account_head_id', true);
                    $update_account['amount']          = $this->input->post('amount', true);
                    $update_account['rate']            = $this->input->post('rate', true);
                    $update_account['description']     = $this->input->post('description', true);
                    $update_account['quantity']        = $this->input->post('quantity', true);
                    $update_account['insert_by']       = $this->session->userdata('userid');
                    $update_account['insert_time']     = date('Y-m-d H:i:s');

                    if ($this->UserModel->accounts_update($update_account,$param2)) {

                        $this->session->set_flashdata('message', 'Account Updated Successfully!');
                        redirect('user/accounts/edit/'.$param2, 'refresh');

                    } else {

                        $this->session->set_flashdata('message', 'Account Update Failed!');
                        redirect('user/accounts/edit/'.$param2, 'refresh');

                    }
                }
            } else {
                
                $this->session->set_flashdata('message','Wrong Attempt!');
                redirect('user/accounts/list','refresh');
            }

            $data['title']          = 'Accounts Update';
            $data['activeMenu']     = 'accounts_edit';
            $data['page']           = 'backEnd/user/accounts_edit';
            $data['projects']       = $this->db->get('tbl_project')->result();
            $data['account_head']   = $this->db->get('tbl_account_head')->result();
            $data['parent_head']    = $this->db->where('parent_id', 0)->get('tbl_account_head')->result();
            

        }elseif ($param1 == 'delete' && $param2 > 0) {

            $account_delete = $this->db->where('id',$param2)->delete('tbl_accounts');

            if ($account_delete) {

                $this->session->set_flashdata('message','Account Deleted Successfully!');
                redirect('user/accounts/list','refresh');

            } else {

                $this->session->set_flashdata('message','Account Delete Failed!');
                redirect('user/accounts/list','refresh');

            }

        }elseif ($param1 == 'list') {

            $data['project_id']   = $this->input->get('project_id', true);
            $data['all_project']  = $this->db->get('tbl_project')->result();
            $data['title']        = 'Accounts List';
            $data['activeMenu']   = 'accounts_list';
            $data['page']         = 'backEnd/user/accounts_list';
            $data['account']      = $this->UserModel->all_accounts($data['project_id']);

        }

        
        $this->load->view('backEnd/master_page',$data);
    }
    
    public function get_account_head ($parent_id){
        
        $result = $this->db->where('parent_id', $parent_id)->or_where('id', $parent_id)->get('tbl_account_head')->result();
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        
    }

    public function report($param1 = 'profit_loss', $param2 = '', $param3 = '')
    {
        if ($param1 == 'profit_loss') {

            $data['title']      = 'Project Profit Loss';
            $data['activeMenu'] = 'profit_loss';
            $data['projects']   = $this->db->get('tbl_project')->result();
            $data['page']       = 'backEnd/user/project_profit_loss';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $data['project_id'] = $this->input->post('project_id', true);

                $data['start_date'] = $this->input->post('start_date', true) != null ? date("Y-m-d", strtotime($this->input->post('start_date', true))) : '' ;

                $data['end_date']   = $this->input->post('end_date', true) != null ? date("Y-m-d", strtotime($this->input->post('end_date', true))) : '' ;

                $data['search_data']  = $this->UserModel->project_search($data['project_id']);

                $data['account_data'] = $this->UserModel->get_account($data['project_id'], $data['start_date'], $data['end_date']);

            }

        }elseif ($param1 == 'income_expance') {

            $data['title']      = 'Daily Income Expence';
            $data['activeMenu'] = 'income_expance';
            $data['page']       = 'backEnd/user/daily_income_expence';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $data['income_expance'] = $this->input->post('income_expance', true);

                $data['start_date']     = $this->input->post('start_date', true) != null ? date("Y-m-d", strtotime($this->input->post('start_date', true))) : '' ;

                $data['end_date']       = $this->input->post('end_date', true) != null ? date("Y-m-d", strtotime($this->input->post('end_date', true))) : '' ;

                $data['search_data']    = $this->UserModel->income_expence_search($data['income_expance'], $data['start_date'], $data['end_date']);
            }

        }elseif ($param1 == 'project_cost_analysis') {

            $data['title']       = 'Project Cost Analysis';
            $data['activeMenu']  = 'project_cost_analysis';
            $data['projects']    = $this->db->get('tbl_project')->result();
            $data['accounthead'] = $this->db->get('tbl_account_head')->result();
            $data['page']        = 'backEnd/user/project_cost_analysis';
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $data['project_id']      = $this->input->post('project_id', true);
                $data['account_head_id'] = $this->input->post('account_head_id', true);

                $data['start_date']      = $this->input->post('start_date', true) != null ? date("Y-m-d", strtotime($this->input->post('start_date', true))) : '' ;

                $data['end_date']        = $this->input->post('end_date', true) != null ? date("Y-m-d", strtotime($this->input->post('end_date', true))) : '' ;

                $data['project_data']    = $this->UserModel->project_search($data['project_id']);

                $data['search_data']     = $this->UserModel->project_cost_analysis_search($data['project_id'],$data['account_head_id'], $data['start_date'], $data['end_date']);

            }

        }elseif ($param1 == 'search') {

            $search_data['accounthead_id'] = $this->input->get('account_head_id', true);
            $search_data['project_id']     = $this->input->get('project_id', true);

            $data['accounthead_id']        = $search_data['accounthead_id'];


            $find_withdraw_id      = $this->db->where('cash_in_id', $search_data['accounthead_id'])->or_where('withraw_id', $search_data['accounthead_id'])->get('tbl_cashidwithdrawjoin');

            if ($find_withdraw_id->num_rows() > 0) {

                $withdraw_id = $find_withdraw_id->row()->withraw_id;

                if($withdraw_id == $data['accounthead_id']) {
                
                    $search_data['accounthead_id'] = $data['accounthead_id'] = $find_withdraw_id->row()->cash_in_id;

                }
                
                $data['is_withdraw'] = true;

                $data['search_info'] = $this->UserModel->cash_in_withdraw_join_search($search_data['accounthead_id'], $withdraw_id, $search_data['project_id']);
                /*echo "<pre>";
                print_r($data['search_info']);
                echo "</pre>";
                exit();*/

            }else {
                
                $data['is_withdraw'] = false;
                
                $data['search_info'] = $this->UserModel->search_project($search_data['accounthead_id'], $search_data['project_id']);
            }

            $data['title']       = 'Account Head';
            $data['activeMenu']  = 'account_head';
            $data['page']        = 'backEnd/user/account_head_search';
            
        }elseif ($param1 == 'all_report') {

            $data['title']                     = 'All Report';
            $data['activeMenu']                = 'all_report';
            $data['page']                      = 'backEnd/user/all_report';
            $data['projects']                  = $this->db->get('tbl_project')->result();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $project_id = $this->input->post('project_id', true);
                redirect('user/all_report_print/'.$project_id, 'refresh');
                
            }else{

            }

        }

        $this->load->view('backEnd/master_page',$data);
    }
    
    public function all_report_print($project_id)
    {
        
        $start_date = $this->db->order_by('date','asc')->get_where('tbl_accounts',array('project_id'=>$project_id))->row()->date;

        $end_date   = $this->db->order_by('date','desc')->get_where('tbl_accounts',array('project_id'=>$project_id))->row()->date;
        
        $findsearial = $this->db->select('date')->where('project_id', $project_id)->order_by('id', 'asc')->get('tbl_serialgenerate')->result();

        $temp_serial_array = array("0");
        $data['serial_no'] = 0;

        foreach ($findsearial as $key => $datevalue) {

            array_push($temp_serial_array, $datevalue->date);

        }
        

        while (strtotime($start_date) <= strtotime($end_date)) {
            
            
            $data['project_id'] = $project_id;
            $data['start_date'] = $start_date;

            $data['print_break'] = true;
            
            $data['todays_expenditure']        = $this->UserModel->todays_expenditure($data['project_id'], $data['start_date']);
            
            if(count($data['todays_expenditure']) > 0) {
                
                $data['previous_accounts_income']  = $this->UserModel->previous_accounts($data['project_id'], $data['start_date'], 1);

                $data['previous_accounts_expense'] = $this->UserModel->previous_accounts($data['project_id'], $data['start_date'], 0);
    
                $data['todays_depostite']          = $this->UserModel->todays_depostite($data['project_id'], $data['start_date'], 1);
    
                $data['todays_all_depostite']      = $this->UserModel->todays_all_depostite($data['project_id'], $data['start_date'], 1);
                
                $data['previous_withdraw'] = $this->UserModel->previous_accounts($data['project_id'], $data['start_date'], 2);

                $data['todays_withdraw'] = $this->UserModel->todays_withdraw($data['project_id'], $data['start_date']);
                
                
                $data['serial_no'] = array_search($data['start_date'], $temp_serial_array);
                
    
                $data['project_info']              = $this->UserModel->project_search($data['project_id']);
    
                $this->load->view('backEnd/user/print_income_expance',$data);
                
                
            }
            
            $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));

            
        }
    }

    public function dailyledger()
    {

        $data['title']       = 'Daily Ledger';
        $data['activeMenu']  = 'daily_ledger';
        $data['page']        = 'backEnd/user/daily_ledger';
        $data['projects']    = $this->db->get('tbl_project')->result();
        $this->load->view('backEnd/master_page',$data); 
    }

    public function print_income_expance()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $search_data['project_id']         = $this->input->post('project_id', true);
            $data['start_date']                = $this->input->post('start_date', true) != null ? date("Y-m-d", strtotime($this->input->post('start_date', true))) : '' ;

            $data['todays_expenditure']        = $this->UserModel->todays_expenditure($search_data['project_id'], $data['start_date']);
            
            $findsearial = $this->db->select('date')->where('project_id', $search_data['project_id'])->order_by('id', 'asc')->get('tbl_serialgenerate')->result();

            $data['serial_no'] = 0;

            foreach ($findsearial as $key => $datevalue) {
                
                if($datevalue->date == $data['start_date']) {
                    $data['serial_no'] = $key+1;
                    break;
                }
            }
            
            if(count($data['todays_expenditure']) > 0 || true) {
            
                $data['previous_accounts_income']  = $this->UserModel->previous_accounts($search_data['project_id'], $data['start_date'], 1);
    
                $data['previous_accounts_expense'] = $this->UserModel->previous_accounts($search_data['project_id'], $data['start_date'], 0);
    
                $data['todays_depostite']          = $this->UserModel->todays_depostite($search_data['project_id'], $data['start_date'], 1);
                $data['todays_all_depostite']      = $this->UserModel->todays_all_depostite($search_data['project_id'], $data['start_date'], 1);
                
                
                $data['previous_withdraw'] = $this->UserModel->previous_accounts($search_data['project_id'], $data['start_date'], 2);

                $data['todays_withdraw'] = $this->UserModel->todays_withdraw($search_data['project_id'], $data['start_date']);
                
                
                $data['project_info']              = $this->UserModel->project_search($search_data['project_id']);
                
                $this->load->view('backEnd/user/print_income_expance',$data);
                
            } else {
                echo "<script>window.close();</script>";
                return false;
                
            }
            
        }else{
            redirect('user/dailyledger','refresh');
        }   
    }

    public function cashin_withdraw_join($param1 = '', $param2 = '', $param3 = '')
    {

        if ($param1 == 'add') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $insert_cashin_withdraw['cash_in_id']  = $this->input->post('cash_in_id', true);

                $insert_cashin_withdraw['withraw_id']  = $this->input->post('withraw_id', true);

                $insert_cashin_withdraw['insert_by']   = $_SESSION['userid'];
                $insert_cashin_withdraw['insert_time'] = date('Y-m-d H:i:s');

                $join_exist = $this->db->get_where('tbl_cashidwithdrawjoin',array('cash_in_id'=>$insert_cashin_withdraw['cash_in_id'], 'withraw_id'=>$insert_cashin_withdraw['withraw_id']))->num_rows();

                if ($join_exist > 0) {

                    $this->session->set_flashdata('message','Join Already Exists!');
                        redirect('user/cashin_withdraw_join','refresh');

                }else{

                    $add_cashin_withdraw = $this->db->insert('tbl_cashidwithdrawjoin',$insert_cashin_withdraw);

                    if ($add_cashin_withdraw) {

                        $this->session->set_flashdata('message','Cash In And Withdraw Added Successfully');
                        redirect('user/cashin_withdraw_join','refresh');

                    } else {

                        $this->session->set_flashdata('message','Cash In And Withdraw Add Failed');
                        redirect('user/cashin_withdraw_join','refresh');

                    }
                }

            }   

        }elseif ($param1 == 'edit' && $param2 > 0) {

            $data['edit_info'] = $this->db->get_where('tbl_cashidwithdrawjoin',array('id'=>$param2));
            
            if ($data['edit_info']->num_rows() > 0) {

                $data['edit_info'] = $data['edit_info']->row();
                $data['edit_info_id'] = $param2;

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $update_cashin_withdraw['cash_in_id']  = $this->input->post('cash_in_id', true);

                    $update_cashin_withdraw['withraw_id']  = $this->input->post('withraw_id', true);

                    $cashin_withdraw_update = $this->db->where('id',$param2)->update('tbl_cashidwithdrawjoin',$update_cashin_withdraw);

                    if ($cashin_withdraw_update) {

                        $this->session->set_flashdata('message','Cash In And Withdraw Updated Successfully');
                        redirect('user/cashin_withdraw_join/edit/'.$param2,'refresh');

                    } else {

                        $this->session->set_flashdata('message','Cash In And Withdraw Update Failed');
                        redirect('user/cashin_withdraw_join/edit/'.$param2,'refresh');

                    }

            }

            } else {

                $this->session->set_flashdata('message','Wrong Attempt!');
                redirect('user/cashin_withdraw_join','refresh');
            }
            

        }elseif ($param1 == 'delete' && $param2 > 0) {

            $cashin_withdraw_delete = $this->db->where('id',$param2)->delete('tbl_cashidwithdrawjoin');

            if ($cashin_withdraw_delete) {

                $this->session->set_flashdata('message','Cash In And Withdraw Deleted Successfully');
                redirect('user/cashin_withdraw_join','refresh');

            } else {

                $this->session->set_flashdata('message','Cash In And Withdraw Delete Failed');
                redirect('user/cashin_withdraw_join','refresh');

            }

        }

        $data['title']            = 'Cash In and Withdraw';
        $data['activeMenu']       = 'cashin_withdraw_join';
        $data['page']             = 'backEnd/user/cashin_withdraw_join';
        $data['accounthead']      = $this->db->get('tbl_account_head')->result();
        $data['cash_in_withdraw'] = $this->db->order_by('id','desc')->get('tbl_cashidwithdrawjoin')->result();
        $this->load->view('backEnd/master_page',$data);
    }

    public function mail_setting()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            foreach ($this->input->post('mail_setting_id', true) as $key => $id_value) {

                $id    = $id_value;
                $value = $this->input->post('value', true)[$key];

                $this->db->where('id', $id)->update('tbl_mail_send_setting', array('value'=>$value));

            }

            $this->session->set_flashdata('message','Mail Send Setting Updated Successfully!');
            redirect('user/mail_setting','refresh');
        }

        $data['title']             = 'Mail Setting';
        $data['activeMenu']        = 'mail_setting';
        $data['page']              = 'backEnd/user/mail_setting';
        $data['mail_setting_info'] = $this->db->get('tbl_mail_send_setting')->result();
        $this->load->view('backEnd/master_page', $data);
    }



}
