<?php

defined('BASEPATH') OR exit('No direct script access allowed');


//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends CI_Controller {

	function __construct() {

		parent::__construct();

		//$this->load->library('pdf');

		$this->lang->load('content', $_SESSION['lang']);

		if (!isset($_SESSION['user_auth']) || $_SESSION['user_auth'] != true) {
			redirect('login', 'refresh');
		}
		if ($_SESSION['userType'] != 'admin')
			redirect('login', 'refresh');
		//Model Loading
		$this->load->model('AdminModel');
		$this->load->library("pagination");
		$this->load->helper("url");
		$this->load->helper("text");
		$this->load->helper("quickfunction"); 

		date_default_timezone_set("Asia/Dhaka");
	}

	public function index() {
		
		$data['title']      = 'Admin Panel • HRSOFTBD Admin Panel';
		$data['page']       = 'backEnd/dashboard_view';
		$data['activeMenu'] = 'dashboard_view';

		$today = date('Y-m-d');
		$lastdate = date('Y-m-d', strtotime('-1 day', strtotime($today)));

		$data['today_milk'] = $this->db->select_sum('collection_amount')->where('collection_date', $today)->get('tbl_cow_milk_collection')->row()->collection_amount;
		$data['lastday_milk'] = $this->db->select_sum('collection_amount')->where('collection_date', $lastdate)->get('tbl_cow_milk_collection')->row()->collection_amount;

		$total_target = $this->AdminModel->get_total_target();
		$sum = 0;
		foreach ($total_target as $key => $value) {
			
			$sum = $sum + $value->milk_target;
		}

		$data['total_target_sum'] = $sum;

		$data['total_cow']          = $this->db->get('tbl_cow_details')->num_rows();
		$data['total_account_head'] = $this->db->get('tbl_account_head')->num_rows();
		$data['today_income']       = $this->AdminModel->todays_income();
		$data['today_expance']      = $this->AdminModel->todays_expance();
		$data['projects']           = $this->db->get('tbl_project')->result();

		$data['income_project_id']  = $this->input->get('income_project_id', true);
		$data['expense_project_id'] = $this->input->get('expense_project_id', true);


		$data['cash_in_list']            = $this->AdminModel->get_cash_in_list();
		$data['expense_list']            = $this->AdminModel->get_expense_list();
		// echo '<pre>';
		// print_r($data['cash_in']);
		// exit;


		$data['income_type']        = $this->input->get('income_type', true);
		$data['expense_type']       = $this->input->get('expense_type', true);
		$data['upcoming_vaccine_list'] = $this->AdminModel->upcoming_vaccine_list();


		if ($data['income_type'] == 'open') {

			$data['project_income'] = $this->AdminModel->project_income_expense($data['income_project_id'], 1);

			$data['withdrawn'] = array();

			foreach ($data['project_income'] as $key => $value) {

				$withdraw_count = $this->db->get_where('tbl_cashidwithdrawjoin',array('cash_in_id'=>$value->id));
				$withdraw_id = 0;
				$data['withdrawn'][$value->id] = 0;
				
				if ($withdraw_count->num_rows() > 0) {

					$withdraw_id = $withdraw_count->row()->withraw_id;

					if ($withdraw_id > 0) {

						$data['withdrawn'][$value->id] = $this->AdminModel->get_withdrawn_money($data['income_project_id'], $withdraw_id);

					}					
				}
			}

		}

		if ($data['expense_type'] == 'open') {

			$data['project_expense'] = $this->AdminModel->project_income_expense($data['expense_project_id'], 0);
		}

		$this->load->view('backEnd/master_page', $data);
	}

    

	public function add_user($param1 = '') {


		$messagePage['divissions']  = $this->db->get('tbl_divission')->result_array();
		$messagePage['userType']    = $this->db->get('user_type')->result_array();

		$messagePage['title']       = 'Add User Admin Panel • HRSOFTBD Admin Panel';
		$messagePage['page']        = 'backEnd/admin/add_user';
		$messagePage['activeMenu']  = 'add_user';
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$saveData['firstname']       = $this->input->post('first_name', true);
			$saveData['lastname']        = $this->input->post('last_name', true);
			$saveData['username']        = $this->input->post('user_name', true);
			$saveData['email']           = $this->input->post('email', true);
			$saveData['phone']           = $this->input->post('phone', true);
			$saveData['password']        = sha1($this->input->post('password', true));
			$saveData['address']         = $this->input->post('address', true);
			$saveData['roadHouse']       = $this->input->post('road_house', true);
			$saveData['userType']        = $this->input->post('user_type', true);
			$saveData['photo']           = 'assets/userPhoto/defaultUser.jpg';


			//This will returns as third parameter num_rows, result_array, result
			$username_check = $this->AdminModel->isRowExist('user', array('username' => $saveData['username']), 'num_rows');
			$email_check    = $this->AdminModel->isRowExist('user', array('email'    => $saveData['email']), 'num_rows');

			if ($username_check > 0 || $email_check > 0) {
				//Invalid message
				$messagePage['page'] = 'backEnd/admin/insertFailed';
				$messagePage['noteMessage']      = "<hr> UserName: " . $saveData['username'] . " can not be create.";
				if ($username_check > 0) {

					$messagePage['noteMessage'] .= '<br> Cause this username is already exist.';
				} else if ($email_check > 0) {

					$messagePage['noteMessage'] .= '<br> Cause this email is already exist.';
				}
			} else {
				//success
				$insertId = $this->AdminModel->saveDataInTable('user', $saveData, 'true');

				$messagePage['page'] = 'backEnd/admin/insertSuccessfull';
				$messagePage['noteMessage'] = "<hr> UserName: " . $saveData['username'] . " has been created successfully.";

				// Category allocate for users
				if (!empty($this->input->post('selectCategory', true))) {

					foreach ($this->input->post('selectCategory', true) as $cat_value) {

						$this->db->insert('category_user', array('userId' => $insertId, 'categoryId' => $cat_value));
					}
				}
			}
		}


		$this->load->view('backEnd/master_page', $messagePage);
	}

	public function edit_user($param1 = '') {
		// Update using post method 
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$saveData['firstname'] = $this->input->post('first_name', true, true);
			$saveData['lastname'] = $this->input->post('last_name', true, true);
			$saveData['phone'] = $this->input->post('phone', true, true);
			$saveData['address'] = $this->input->post('address', true, true);
			$saveData['roadHouse'] = $this->input->post('road_house', true, true);
			$saveData['userType'] = $this->input->post('user_type', true, true);
			$user_id = $this->input->post('user_id', true, true);


			$this->db->where('id', $user_id);
			$this->db->update('user', $saveData);
			
			$data['page'] = 'backEnd/admin/insertSuccessfull';
			$data['noteMessage'] = "<hr> Data has been Updated successfully.";

		} else if ($this->AdminModel->isRowExist('user', array('id' => $param1), 'num_rows') > 0) {

			$data['userDetails'] = $this->AdminModel->isRowExist('user', array('id' => $param1), 'result_array');

			$myupozilla_id = $this->db->get_where('tbl_upozilla', array("id"=>$data['userDetails'][0]['address']))->row();

			$data['myzilla_id'] = $myupozilla_id->zilla_id;
			$data['mydivision_id'] = $myupozilla_id->division_id;

			$data['divissions'] = $this->db->get('tbl_divission')->result();
		
			$data['distrcts'] = $this->db->get_where('tbl_zilla',array('divission_id'=>$data['mydivision_id']))->result();
			$data['upozilla'] = $this->db->get_where('tbl_upozilla',array('zilla_id'=>$data['myzilla_id']))->result();

			$data['userType'] = $this->db->get('user_type')->result_array();
			$data['user_id'] = $param1;
			$data['page'] = 'backEnd/admin/edit_user';

		} else {

			$data['page'] = 'errors/invalidInformationPage';
			$data['noteMessage'] = $this->lang->line('wrong_info_search');
		}
		
		$data['title'] = 'Users List Admin Panel • HRSOFTBD Admin Panel';
		$data['activeMenu'] = 'user_list';
		$this->load->view('backEnd/master_page', $data);
	}

	public function suspend_user($id, $setvalue) {

		$this->db->where('id', $id);
		$this->db->update('user', array('status' => $setvalue));
		$this->session->set_flashdata('message', 'Data Saved Successfully.');
		redirect('admin/user_list', 'refresh');
	}

	public function delete_user($id) {

		$old_image_url=$this->db->where('id', $id)->get('user')->row();
		$this->db->where('id', $id)->delete('user');
		if(isset($old_image_url->photo)){
			unlink($old_image_url->photo);
		}

		$this->session->set_flashdata('message', 'Data Deleted.');
		redirect('admin/user_list', 'refresh');
	}

	public function user_list() {

		$this->db->where('userType !=', 'admin');
		$data['myUsers'] = $this->db->get('user')->result_array();
		$data['title'] = 'Users List Admin Panel • HRSOFTBD Admin Panel';
		$data['page'] = 'backEnd/admin/user_list';
		$data['activeMenu'] = 'user_list';
		$this->load->view('backEnd/master_page', $data);
	}


	public function image_size_fix($filename, $width = 600, $height = 400, $destination = '') {

		// Content type
		// header('Content-Type: image/jpeg');
		// Get new dimensions
		list($width_orig, $height_orig) = getimagesize($filename);

		// Output 20 May, 2018 updated below part
		if ($destination == '' || $destination == null)
			$destination = $filename;

		$extention = pathinfo($destination, PATHINFO_EXTENSION);
		if ($extention != "png" && $extention != "PNG" && $extention != "JPEG" && $extention != "jpeg" && $extention != "jpg" && $extention != "JPG") {
 
			return true;
		}
		// Resample 
		$image_p = imagecreatetruecolor($width, $height);
		$black = imagecolorallocate($image_p, 0, 0, 0);

        // Make the background transparent
        imagecolortransparent($image_p, $black);

		$image   = imagecreatefromstring(file_get_contents($filename));
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

		

		if ($extention == "png" || $extention == "PNG") {
			imagepng($image_p, $destination, 9);
		} else if ($extention == "jpg" || $extention == "JPG" || $extention == "jpeg" || $extention == "JPEG") {
			imagejpeg($image_p, $destination, 70);
		} else {
			imagepng($image_p, $destination);
		}
		return true;
	}


	public function get_division() {

		$result = $this->db->select('id, name')->get('tbl_divission')->result();
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	public function get_zilla_from_division($division_id = 1) {

		$result = $this->db->select('id, name')->where('divission_id', $division_id)->get('tbl_zilla')->result();
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	public function get_upozilla_from_division_zilla($zilla_id = 1) {

		$result = $this->db->select('id, name')->where('zilla_id', $zilla_id)->get('tbl_upozilla')->result();
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	public function download_file($file_name = '', $fullpath='') {

		// echo $file_name; exit();
		$filePath = 'assets/ebookDocument/' . $file_name;

		if($file_name=='full' && ($fullpath != '' || $fullpath != null)) $filePath = $fullpath;

		if($_GET['file_path']) $filePath = $_GET['file_path'];
		// echo $filePath; exit();
		if (file_exists($filePath)) {
			$fileName = basename($filePath);
			$fileSize = filesize($filePath);

			// Output headers.
			header("Cache-Control: private");
			header("Content-Type: application/stream");
			header("Content-Length: " . $fileSize);
			header("Content-Disposition: attachment; filename=" . $fileName);

			// Output file.
			readfile($filePath);
			exit();
		} else {
			die('The provided file path is not valid.');
		}
	}
	
	public function profile($param1 = '')
	{

		$user_id            = $this->session->userdata('userid');
		$data['user_info']  = $this->AdminModel->get_user($user_id);


		$myzilla_id         = $data['user_info']->zilla_id;
		$mydivision_id      = $data['user_info']->division_id;

		$data['divissions'] = $this->db->get('tbl_divission')->result();

		$data['distrcts']   = $this->db->get_where('tbl_zilla', array('divission_id' => $mydivision_id))->result();
		$data['upozilla']   = $this->db->get_where('tbl_upozilla', array('zilla_id'  => $myzilla_id))->result();

		if ($param1 == 'update_photo') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    
			    
			    //exta work
                $path_parts               = pathinfo($_FILES["photo"]['name']);
                $newfile_name             = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
                $dir                      = date("YmdHis", time());
                $config['file_name']      = $newfile_name . '_' . $dir;
                $config['remove_spaces']  = TRUE;
                //exta work
                $config['upload_path']    = 'assets/userPhoto/';
                $config['max_size']       = '20000'; //  less than 20 MB
                $config['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('photo')) {

                    // case - failure
					$upload_error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('message', "Failed to update image.");

                } else {

                    $upload                 = $this->upload->data();
                    $newphotoadd['photo']   = $config['upload_path'] . $upload['file_name'];

                    $old_photo              = $this->db->where('id', $user_id)->get('user')->row()->photo;
                    
                    if(file_exists($old_photo)) unlink($old_photo);

                    $this->image_size_fix($newphotoadd['photo'], 200, 200);

                    $this->db->where('id', $user_id)->update('user', $newphotoadd);

                    $this->session->set_userdata('userPhoto', $newphotoadd['photo']);
					$this->session->set_flashdata('message', 'User Photo Updated Successfully!');
					
					redirect('admin/profile','refresh');
                }
                
			  }
			  
		}else if($param1 == 'update_pass'){

		   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		       
			   $old_pass    = sha1($this->input->post('old_pass', true)); 
			   $new_pass    = sha1($this->input->post('new_pass', true)); 
			   $user_id     = $this->session->userdata('userid');

			   $get_user    = $this->db->get_where('user',array('id'=>$user_id, 'password'=>$old_pass));
			   $user_exist  = $get_user->row();

			   if($user_exist){
			       
					$this->db->where('id',$user_id)
							->update('user',array('password'=>$new_pass));
					$this->session->set_flashdata('message', 'Password Updated Successfully');
					redirect('admin/profile','refresh');
					
			   }else{
			       
				    $this->session->set_flashdata('message', 'Password Update Failed');
				    redirect('admin/profile','refresh');
				   
			   }
			   
			}
			
		}else if($param1 == 'update_info'){

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    
				$update_data['firstname']   = $this->input->post('firstname', true);
				$update_data['lastname']    = $this->input->post('lastname', true);
				$update_data['roadHouse']   = $this->input->post('roadHouse', true);
				$update_data['address']     = $this->input->post('address', true);


				$db_email     = $this->db->where('id!=', $user_id)->where('email', $this->input->post('email', true))->get('user')->num_rows();
				$db_username  = $this->db->where('id!=', $user_id)->where('username', $this->input->post('username', true))->get('user')->num_rows();


				if ( $db_username == 0) {

					 $update_data['username']    = $this->input->post('username', true);
					 
				}if ( $db_email == 0) {

					 $update_data['email']       = $this->input->post('email', true);
					 
				}
				

    			if ($this->AdminModel->update_pro_info($update_data, $user_id)) {
    			    
    			    $this->session->set_userdata('username_first', $update_data['firstname']);
    			    $this->session->set_userdata('username_last', $update_data['lastname']);
    			    $this->session->set_userdata('username', $update_data['username']);
    			    
    				$this->session->set_flashdata('message', 'Information Updated Successfully!');
    				redirect('admin/profile', 'refresh');
    				
    			} else {
    			    
    				$this->session->set_flashdata('message', 'Information Update Failed!');
    				redirect('admin/profile', 'refresh');
    				
    			} 
				
			}
		}
		
		$data['title']        = 'Profile Admin Panel • HRSOFTBD Admin Panel';
		$data['activeMenu']   = 'Profile';
		$data['page']         = 'backEnd/admin/profile';
		
		$this->load->view('backEnd/master_page',$data);
	}
	

	public function projects($param1 = '', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$insert_project['name']               	= $this->input->post('name', true);
				$insert_project['address']            	= $this->input->post('address', true);
				$insert_project['remark']            	= $this->input->post('remark', true);
				$insert_project['project_start_date'] 	= date("Y-m-d", strtotime($this->input->post('project_start_date', true)));
				$insert_project['insert_by']          	= $this->session->userdata('userid');

				if ($this->AdminModel->add_project($insert_project)) {

					$this->session->set_flashdata('message','Project Added Successfully!');
					redirect('admin/projects','refresh');

				} else {

					$this->session->set_flashdata('message','Project Add Failed!');
					redirect('admin/projects','refresh');

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


					if ($this->AdminModel->project_update($update_project,$param2)) {

						$this->session->set_flashdata('message','Project Updated Successfully!');
						redirect('admin/projects','refresh');

					} else {

						$this->session->set_flashdata('message','Project Update Failed!');
						redirect('admin/projects','refresh');

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

					if ($this->AdminModel->project_update($update_project,$param2)) {

						$this->session->set_flashdata('message','Project Updated Successfully!');
						redirect('admin/projects','refresh');

					} else {

						$this->session->set_flashdata('message','Project Update Failed!');
						redirect('admin/projects','refresh');

					}
				
				}

			}else{
                return false;
			}



		} elseif ($param1 == 'delete' && $param2 > 0) {

			$projects_delete = $this->db->where('id',$param2)->delete('tbl_project');

			if ($projects_delete) {

				$this->session->set_flashdata('message','Project Deleted Successfully!');
				redirect('admin/projects','refresh');

			} else {

				$this->session->set_flashdata('message','Project Delete Failed!');
				redirect('admin/projects','refresh');

			}

		}


		$data['title']      = 'Project';
		$data['activeMenu'] = 'projects';
		$data['page']       = 'backEnd/admin/projects';
		$data['projects']   = $this->AdminModel->project_lists();

		
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

				if ($this->AdminModel->add_accounthead($insert_accounthead)) {

					$this->session->set_flashdata('message','Account Head Added Successfully!');
					redirect('admin/accounthead','refresh');

				} else {

					$this->session->set_flashdata('message','Account Head Add Failed!');
					redirect('admin/accounthead','refresh');

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

				if ($this->AdminModel->accounthead_update($update_accounthead, $param2)) {

					$this->session->set_flashdata('message','Account Head Updated Successfully!');
					redirect('admin/accounthead/edit/'.$param2,'refresh');

				} else {

					$this->session->set_flashdata('message','Account Head Update Failed!');
					redirect('admin/accounthead/edit/'.$param2,'refresh');

				}
				
			}

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/accounthead','refresh');
			}
			

		}elseif ($param1 == 'delete' && $param2 > 0) {

			$account_head_delete = $this->db->where('id',$param2)->delete('tbl_account_head');

			if ($account_head_delete) {

				$this->session->set_flashdata('message','Account Head Deleted Successfully!');
				redirect('admin/accounthead','refresh');

			} else {

				$this->session->set_flashdata('message','Account Head Delete Failed!');
				redirect('admin/accounthead','refresh');

			}

		}

		$data['title']        = 'Account Head';
		$data['activeMenu']   = 'account_head';
		$data['page']         = 'backEnd/admin/account_head';
		$data['parent_zero']  = $this->db->get_where('tbl_account_head',array('parent_id'=>0))->result();
		$data['account_head'] = $this->db->order_by('id','desc')->get('tbl_account_head')->result();
		$this->load->view('backEnd/master_page',$data);
	}

	public function accounts($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add' ) {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$insert_account['invoice_number'] 	= date('YmdHis');
				$insert_account['project_id']  		= $this->input->post('project_id', true);
				$insert_account['date']        		= date("Y-m-d", strtotime($this->input->post('date', true)));
				$insert_account['insert_by']   		= $this->session->userdata('userid');
				$insert_account['insert_time'] 		= date('Y-m-d H:i:s');

				foreach ($this->input->post('amount', true) as $key => $value) {

					if($value == 0 ) continue; 

					$insert_account['amount']          = $value;
					$insert_account['account_head_id'] = $this->input->post('account_head_id', true)[$key];
					$insert_account['description']     = $this->input->post('description', true)[$key];
					$insert_account['quantity']        = $this->input->post('quantity', true)[$key];
					$insert_account['rate']            = $this->input->post('rate', true)[$key];			
					
					$this->AdminModel->add_accounts($insert_account);
				}

				$match_serialgenerate = $this->db->where('project_id',$insert_account['project_id'])->where('date',$insert_account['date'])->get('tbl_serialgenerate')->num_rows();
				if ($match_serialgenerate > 0) {
					
				} else {
					$this->db->insert('tbl_serialgenerate',array("project_id" => $insert_account['project_id'],"date" => $insert_account['date']));
				}

				$this->session->set_flashdata('message','Account Added Successfully!');
				redirect('admin/accounts','refresh');

				$this->session->set_flashdata('message','Account Added Successfully!');
				redirect('admin/accounts','refresh');
			}


			$data['title']        = 'Accounts Add';
			$data['activeMenu']   = 'accounts_add';
			$data['page']         = 'backEnd/admin/accounts_add';
			$data['projects']     = $this->db->get('tbl_project')->result();
			$data['account_head'] = $this->db->get('tbl_account_head')->result();
			$data['parent_head']  = $this->db->where('parent_id', 0)->get('tbl_account_head')->result();

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

					if ($this->AdminModel->accounts_update($update_account,$param2)) {

						$this->session->set_flashdata('message', 'Account Updated Successfully!');
						redirect('admin/accounts/edit/'.$param2, 'refresh');

					} else {

						$this->session->set_flashdata('message', 'Account Update Failed!');
						redirect('admin/accounts/edit/'.$param2, 'refresh');

					}
				}
			} else {
				
				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/accounts/list','refresh');
			}

			$data['title']        = 'Accounts Update';
			$data['activeMenu']   = 'accounts_edit';
			$data['page']         = 'backEnd/admin/accounts_edit';
			$data['projects']     = $this->db->get('tbl_project')->result();
			$data['account_head'] = $this->db->get('tbl_account_head')->result();
			$data['parent_head']  = $this->db->where('parent_id', 0)->get('tbl_account_head')->result();
			

		}elseif ($param1 == 'delete' && $param2 > 0) {

			$account_delete = $this->db->where('id',$param2)->delete('tbl_accounts');

			if ($account_delete) {

				$this->session->set_flashdata('message','Account Deleted Successfully!');
				redirect('admin/accounts/list','refresh');

			} else {

				$this->session->set_flashdata('message','Account Delete Failed!');
				redirect('admin/accounts/list','refresh');

			}

		}elseif ($param1 == 'list') {

			$data['search'] = array();

    		$data['search']['project_id'] = '';
    		$data['search']['date']       = '';

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				if ($this->input->post('project_id', true)){

					$data['search']['project_id'] = $this->input->post('project_id', true);
				}

				if ($this->input->post('date', true)){

					$data['search']['date'] = date('Y-m-d', strtotime($this->input->post('date', true)));
				}
			}

			$config = array();
	        $config["base_url"] = base_url() . "admin/accounts/list";
	        $config["total_rows"] = $this->db->count_all('tbl_accounts');
	        $config["per_page"] = 10;
	        $config["uri_segment"] = 4;

	        //custom
	        $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            
            $config['first_link'] = "First";
            $config['last_link'] = "Last";
            
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
                
            $config['prev_link'] = '«';
            $config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
            
            $config['next_link'] = '»';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            
            $config['cur_tag_open'] = '<li class="active"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

	         
	       
	        $this->pagination->initialize($config);

	        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

	        $data["links"] = $this->pagination->create_links();

	        

			$data['account']      = $this->AdminModel->all_accounts($config["per_page"], $page, $data['search']);
			$data['all_project']  = $this->db->get('tbl_project')->result(); 

			
			
			$data['title']        = 'Accounts List';
			$data['activeMenu']   = 'accounts_list';
			$data['page']         = 'backEnd/admin/accounts_list';
			

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
			$data['page']       = 'backEnd/admin/project_profit_loss';

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$data['project_id'] = $this->input->post('project_id', true);

				$data['start_date'] = $this->input->post('start_date', true) != null ? date("Y-m-d", strtotime($this->input->post('start_date', true))) : '' ;

				$data['end_date']   = $this->input->post('end_date', true) != null ? date("Y-m-d", strtotime($this->input->post('end_date', true))) : '' ;

				$data['search_data']  = $this->AdminModel->project_search($data['project_id']);

				$data['account_data'] = $this->AdminModel->get_account($data['project_id'], $data['start_date'], $data['end_date']);

			}

		}elseif ($param1 == 'income_expance') {

			$data['title']      = 'Daily Income Expence';
			$data['activeMenu'] = 'income_expance';
			$data['page']       = 'backEnd/admin/daily_income_expence';

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$data['income_expance'] = $this->input->post('income_expance', true);

				$data['start_date']     = $this->input->post('start_date', true) != null ? date("Y-m-d", strtotime($this->input->post('start_date', true))) : '' ;

				$data['end_date']       = $this->input->post('end_date', true) != null ? date("Y-m-d", strtotime($this->input->post('end_date', true))) : '' ;

				$data['search_data']    = $this->AdminModel->income_expence_search($data['income_expance'], $data['start_date'], $data['end_date']);
			}

		}elseif ($param1 == 'project_cost_analysis') {

			$data['title']       = 'Project Cost Analysis';
			$data['activeMenu']  = 'project_cost_analysis';
			$data['projects']    = $this->db->get('tbl_project')->result();
			$data['accounthead'] = $this->db->get('tbl_account_head')->result();
			$data['page']        = 'backEnd/admin/project_cost_analysis';
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$data['project_id']      = $this->input->post('project_id', true);
				$data['account_head_id'] = $this->input->post('account_head_id', true);

				$data['start_date']      = $this->input->post('start_date', true) != null ? date("Y-m-d", strtotime($this->input->post('start_date', true))) : '' ;

				$data['end_date']        = $this->input->post('end_date', true) != null ? date("Y-m-d", strtotime($this->input->post('end_date', true))) : '' ;

				$data['project_data']    = $this->AdminModel->project_search($data['project_id']);

				$data['search_data']     = $this->AdminModel->project_cost_analysis_search($data['project_id'],$data['account_head_id'], $data['start_date'], $data['end_date']);

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

				$data['search_info'] = $this->AdminModel->cash_in_withdraw_join_search($search_data['accounthead_id'], $withdraw_id, $search_data['project_id']);
				/*echo "<pre>";
				print_r($data['search_info']);
				echo "</pre>";
				exit();*/

			}else {
                
                $data['is_withdraw'] = false;
                
				$data['search_info'] = $this->AdminModel->search_project($search_data['accounthead_id'], $search_data['project_id']);
			}

			$data['title']       = 'Account Head';
			$data['activeMenu']  = 'account_head';
			$data['page']        = 'backEnd/admin/account_head_search';
			
		}elseif ($param1 == 'all_report') {

			$data['title']                     = 'All Report';
			$data['activeMenu']                = 'all_report';
			$data['page']                      = 'backEnd/admin/all_report';
			$data['projects']                  = $this->db->get('tbl_project')->result();

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$project_id = $this->input->post('project_id', true);
				redirect('admin/all_report_print/'.$project_id, 'refresh');
				
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
			
			$data['todays_expenditure']        = $this->AdminModel->todays_expenditure($data['project_id'], $data['start_date']);
			
			if(count($data['todays_expenditure']) > 0) {
			    
			    $data['previous_accounts_income']  = $this->AdminModel->previous_accounts($data['project_id'], $data['start_date'], 1);

    			$data['previous_accounts_expense'] = $this->AdminModel->previous_accounts($data['project_id'], $data['start_date'], 0);
    
    			$data['todays_depostite']          = $this->AdminModel->todays_depostite($data['project_id'], $data['start_date'], 1);
    
    			$data['todays_all_depostite']      = $this->AdminModel->todays_all_depostite($data['project_id'], $data['start_date'], 1);
    			
    			$data['previous_withdraw'] = $this->AdminModel->previous_accounts($data['project_id'], $data['start_date'], 2);

    			$data['todays_withdraw'] = $this->AdminModel->todays_withdraw($data['project_id'], $data['start_date']);
    			
    			
    			$data['serial_no'] = array_search($data['start_date'], $temp_serial_array);
    			
    
    			$data['project_info']  	           = $this->AdminModel->project_search($data['project_id']);
    
    			$this->load->view('backEnd/admin/print_income_expance',$data);
    			
    			
			}
			
			$start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));

			
		}
	}

	public function dailyledger()
	{

		$data['title']       = 'Daily Ledger';
		$data['activeMenu']  = 'daily_ledger';
		$data['page']        = 'backEnd/admin/daily_ledger';
		$data['projects']    = $this->db->get('tbl_project')->result();
		$this->load->view('backEnd/master_page',$data);	
	}

	public function print_income_expance()
	{

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    
			$search_data['project_id']         = $this->input->post('project_id', true);
			$data['start_date'] 	           = $this->input->post('start_date', true) != null ? date("Y-m-d", strtotime($this->input->post('start_date', true))) : '' ;

			$data['todays_expenditure']        = $this->AdminModel->todays_expenditure($search_data['project_id'], $data['start_date']);
			
			$findsearial = $this->db->select('date')->where('project_id', $search_data['project_id'])->order_by('id', 'asc')->get('tbl_serialgenerate')->result();

			$data['serial_no'] = 0;

			foreach ($findsearial as $key => $datevalue) {
				
				if($datevalue->date == $data['start_date']) {
					$data['serial_no'] = $key+1;
					break;
				}
			}
			
			if(count($data['todays_expenditure']) > 0 || true) {
			
    			$data['previous_accounts_income']  = $this->AdminModel->previous_accounts($search_data['project_id'], $data['start_date'], 1);
    
    			$data['previous_accounts_expense'] = $this->AdminModel->previous_accounts($search_data['project_id'], $data['start_date'], 0);
    
    			$data['todays_depostite']          = $this->AdminModel->todays_depostite($search_data['project_id'], $data['start_date'], 1);
    			$data['todays_all_depostite']      = $this->AdminModel->todays_all_depostite($search_data['project_id'], $data['start_date'], 1);
                
                
                $data['previous_withdraw'] = $this->AdminModel->previous_accounts($search_data['project_id'], $data['start_date'], 2);

    			$data['todays_withdraw'] = $this->AdminModel->todays_withdraw($search_data['project_id'], $data['start_date']);
    			
    			
    			$data['project_info']  	           = $this->AdminModel->project_search($search_data['project_id']);
    	        
    			$this->load->view('backEnd/admin/print_income_expance',$data);
    			
			} else {
			    echo "<script>window.close();</script>";
			    return false;
			    
			}
			
		}else{
			redirect('admin/dailyledger','refresh');
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
						redirect('admin/cashin_withdraw_join','refresh');

				}else{

					$add_cashin_withdraw = $this->db->insert('tbl_cashidwithdrawjoin',$insert_cashin_withdraw);

					if ($add_cashin_withdraw) {

						$this->session->set_flashdata('message','Cash In And Withdraw Added Successfully');
						redirect('admin/cashin_withdraw_join','refresh');

					} else {

						$this->session->set_flashdata('message','Cash In And Withdraw Add Failed');
						redirect('admin/cashin_withdraw_join','refresh');

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
						redirect('admin/cashin_withdraw_join/edit/'.$param2,'refresh');

					} else {

						$this->session->set_flashdata('message','Cash In And Withdraw Update Failed');
						redirect('admin/cashin_withdraw_join/edit/'.$param2,'refresh');

					}

			}

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/cashin_withdraw_join','refresh');
			}
			

		}elseif ($param1 == 'delete' && $param2 > 0) {

			$cashin_withdraw_delete = $this->db->where('id',$param2)->delete('tbl_cashidwithdrawjoin');

			if ($cashin_withdraw_delete) {

				$this->session->set_flashdata('message','Cash In And Withdraw Deleted Successfully');
				redirect('admin/cashin_withdraw_join','refresh');

			} else {

				$this->session->set_flashdata('message','Cash In And Withdraw Delete Failed');
				redirect('admin/cashin_withdraw_join','refresh');

			}

		}

		$data['title']            = 'Cash In and Withdraw';
		$data['activeMenu']       = 'cashin_withdraw_join';
		$data['page']             = 'backEnd/admin/cashin_withdraw_join';
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
			redirect('admin/mail_setting','refresh');
		}

		$data['title']             = 'Mail Setting';
		$data['activeMenu']        = 'mail_setting';
		$data['page']              = 'backEnd/admin/mail_setting';
		$data['mail_setting_info'] = $this->db->get('tbl_mail_send_setting')->result();
		$this->load->view('backEnd/master_page', $data);
	}

	//employee crud

	public function employee($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$insertEmployee['name']           = $this->input->post('name', true);
				$insertEmployee['phone_number']   = $this->input->post('phone_number', true);
				$insertEmployee['password']       = sha1($this->input->post('password', true));
				$insertEmployee['position']       = $this->input->post('position', true);
				$insertEmployee['join_date']      =  date("Y-m-d", strtotime($this->input->post('join_date', true))); 

				$insertEmployee['expire_date']    = date("Y-m-d", strtotime($this->input->post('expire_date', true))); 

				$insertEmployee['active']         = $this->input->post('active', true);
				$insertEmployee['priority']       = $this->input->post('priority', true);
				$insertEmployee['insert_by']      = $_SESSION['userid'];
				$insertEmployee['insert_time']    = date('Y-m-d H:i');

				if (!empty($_FILES['photo']['name'])) {

					$path_parts                   = pathinfo($_FILES["photo"]['name']);
					$newfile_name                 = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
					$dir                          = date("YmdHis", time());
					$config_c['file_name']        = $newfile_name . '_' . $dir;
					$config_c['remove_spaces']    = TRUE;
					$config_c['upload_path']      = 'assets/employeePhoto/';
					$config_c['max_size']         = '20000'; //  less than 20 MB
					$config_c['allowed_types']    = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

					$this->load->library('upload', $config_c);
					$this->upload->initialize($config_c);
					if (!$this->upload->do_upload('photo')) {

					} else {

						$upload_c = $this->upload->data();
						$insertEmployee['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
						$this->image_size_fix($insertEmployee['photo'], 400, 400);
					}
					
				}

				$add_employee = $this->db->insert('tbl_employee',$insertEmployee);

				if ($add_employee) {

					$this->session->set_flashdata('message','Employee Added Successfully!');
					redirect('admin/employee/list','refresh');

				} else {

				   $this->session->set_flashdata('message','Employee Add Failed!');
					redirect('admin/employee/list','refresh');
				}
			}

			$data['title']             = 'Employee Add';
			$data['activeMenu']        = 'employee_add';
			$data['page']              = 'backEnd/admin/employee_add';
			
		} elseif ($param1 == 'list' ) {


			$data['employee_list'] = $this->AdminModel->employee_lists();

			$data['title']        = 'Employee List';
			$data['activeMenu']   = 'employee_list';
			$data['page']         = 'backEnd/admin/employee_list';

		   
		} elseif ($param1 == 'edit' && $param2 > 0) {

			$data['edit_info']   = $this->db->get_where('tbl_employee',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$updateEmployee['name']           = $this->input->post('name', true);
					$updateEmployee['phone_number']   = $this->input->post('phone_number', true);
					$updateEmployee['password']       = sha1($this->input->post('password', true));
					$updateEmployee['position']       = $this->input->post('position', true);
					$updateEmployee['join_date']      =  date("Y-m-d", strtotime($this->input->post('join_date', true))); 

					$updateEmployee['expire_date']    = date("Y-m-d", strtotime($this->input->post('expire_date', true))); 

					$updateEmployee['active']         = $this->input->post('active', true);
					$updateEmployee['priority']       = $this->input->post('priority', true);
					$updateEmployee['insert_by']      = $_SESSION['userid'];
					$updateEmployee['insert_time']    = date('Y-m-d H:i:s');



					if (!empty($_FILES['photo']['name'])) {

						$path_parts                 = pathinfo($_FILES["photo"]['name']);
						$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
						$dir                        = date("YmdHis", time());
						$config_c['file_name']      = $newfile_name . '_' . $dir;
						$config_c['remove_spaces']  = TRUE;
						$config_c['upload_path']    = 'assets/employeePhoto/';
						$config_c['max_size']       = '20000'; //  less than 20 MB
						$config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

						$this->load->library('upload', $config_c);
						$this->upload->initialize($config_c);
						if (!$this->upload->do_upload('photo')) {

						} else {

							$upload_c = $this->upload->data();
							$updateEmployee['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
							$this->image_size_fix($updateEmployee['photo'], 400, 400);
						}
						
					}

					if ($this->AdminModel->updateEmployee($updateEmployee, $param2)) {

						$this->session->set_flashdata('message','Employee  Updated Successfully!');
						redirect('admin/employee/list', 'refresh');

					} else {

					   $this->session->set_flashdata('message','Employee Update Failed!');
						redirect('admin/employee/edit/'.$param2, 'refresh');
					}
				}

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/employee/list','refresh');
			}

			$data['title']      = 'Employee Edit';
			$data['activeMenu'] = 'employee_edit';
			$data['page']       = 'backEnd/admin/employee_edit';
			
		   
		} elseif($param1 == 'delete' && $param2 > 0) {
			
		   	if ($this->AdminModel->delete_employee($param2)) {

				$this->session->set_flashdata('message','Employee  Deleted Successfully!');
				redirect('admin/employee/list','refresh');

			} else {

			    $this->session->set_flashdata('message','Employee Deleted Failed!');
				redirect('admin/employee/list','refresh');
			}
			
		} else {

			$this->session->set_flashdata('message', 'Wrong Attempt!');
			redirect('admin/employee/list','refresh');

		}

		$this->load->view('backEnd/master_page',$data);        
	}

	//cow type
	public function cow_type($param1 = 'add', $param2 = '', $param3 = '') {
        
    	if ($param1 == 'add') {

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	    		$cow_type_data['name']           = $this->input->post('name', true);
	    		$cow_type_data['insert_by']      = $_SESSION['userid'];
	    		$cow_type_data['insert_time']    = date('Y-m-d H:i');

	    		$cow_type = $this->db->insert('tbl_cow_type', $cow_type_data);

				if ($cow_type) {

					$this->session->set_flashdata('message','Cow type Created Successfully!');
					redirect('admin/cow-type/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Cow type Failed!');
					redirect('admin/cow-type', 'refresh');
				}
			}

			$data['title']         = 'Cow type Add';
            $data['page']          = 'backEnd/admin/cow_type_add';
            $data['activeMenu']    = 'cow_type_add';
            
    	} elseif ($param1 == 'list') {

        	$data['title']         = 'Cow Type List';
            $data['page']          = 'backEnd/admin/cow_type_list';
            $data['activeMenu']    = 'cow_type_list';

			$data['cow_type_list'] =  $this->db->order_by('insert_time', 'DESC')->get('tbl_cow_type')->result();
			
        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['edit_info']    = $this->db->where('id', $param2)->get('tbl_cow_type')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            	$cow_type_update_data['name']           = $this->input->post('name', true);

	    		if ($this->AdminModel->update_cow_type($cow_type_update_data, $param2)) {

				$this->session->set_flashdata('message','Cow type  Updated Successfully!');
				redirect('admin/cow-type/list', 'refresh');

				} else {

				   $this->session->set_flashdata('message','Items Update Failed!');
					redirect('admin/cow-type/list/'.$param2, 'refresh');
				}

            }
            $data['cow_type_list'] =  $this->db->order_by('insert_time', 'DESC')->get('tbl_cow_type')->result();
			$data['title']         = 'Cow Type Update';
            $data['page']          = 'backEnd/admin/cow_type_list';
			$data['activeMenu']    = 'cow_type_edit';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_cow_type($param2)) {

				$this->session->set_flashdata('message','Cow type  Deleted Successfully!');
				redirect('admin/cow-type/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Cow type Deleted Failed!');
				redirect('admin/cow-type/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/cow-type/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //cow details
    public function cow_details($param1 = 'add', $param2 = '', $param3 = '') {
        
    	if ($param1 == 'add') {

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	    		$cow_details_data['cow_no']               = $this->input->post('cow_no', true);
	    		$cow_details_data['cow_type_id']          = $this->input->post('cow_type_id', true);
	    		$cow_details_data['start_date']           = date('Y-m-d', strtotime($this->input->post('start_date', true)));
	    		$cow_details_data['purchase_cost']        = $this->input->post('purchase_cost', true);
	    		$cow_details_data['target_sale_cost']     = $this->input->post('target_sale_cost', true);
	    		$cow_details_data['color']                = $this->input->post('color', true);
	    		$cow_details_data['is_sold']              = $this->input->post('is_sold', true);
	    		$cow_details_data['is_death']             = $this->input->post('is_death', true);


	    		$cow_details_data['insert_by']            = $_SESSION['userid'];
	    		$cow_details_data['insert_time']          = date('Y-m-d H:i');
	    		

	    		$cow_details = $this->db->insert('tbl_cow_details', $cow_details_data);

	    		if($this->input->post('health_test_date', true) != ''){

	    			$cow_health_test_data['cow_details_id']   = $this->db->insert_id();
		    		$cow_health_test_data['height']           = $this->input->post('height', true);
		    		$cow_health_test_data['width']            = $this->input->post('width', true);
		    		$cow_health_test_data['health_test_date'] = $this->input->post('health_test_date', true);
		    		$cow_health_test_data['weight']           = $this->input->post('weight', true);
		    		$cow_health_test_data['insert_by']        = $_SESSION['userid'];

		    		$cow_health_test_data['insert_time']      = date('Y-m-d H:i');
		    		
		    		$cow_health_test = $this->db->insert('tbl_cow_health_test', $cow_health_test_data);
	    		}
	    		

				if ($cow_details) {

					$this->session->set_flashdata('message','Cow details Created Successfully!');
					redirect('admin/cow-details/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Cow details Failed!');
					redirect('admin/cow-details', 'refresh');
				}
			}

			$data['cow_type_list'] = $this->db->select('id, name')->get('tbl_cow_type')->result();

			$data['title']         = 'Cow details Add';
            $data['page']          = 'backEnd/admin/cow_details_add';
            $data['activeMenu']    = 'cow_details_add';
            
    	} elseif ($param1 == 'list') {

    		$data['search'] = array();

    		$data['search']['cow_no'] = '';

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				if ($this->input->post('cow_no', true)){

					$data['search']['cow_no'] = $this->input->post('cow_no', true);
				}
			}

			$data['cow_details_list'] = $this->AdminModel->get_cow_details_list($data['search']);

			$data['cow_details'] = $this->db->select('id, cow_no')->order_by('cow_no','desc')->get('tbl_cow_details')->result();

        	$data['title']            = 'Cow Details List';
            $data['page']             = 'backEnd/admin/cow_details_list';
            $data['activeMenu']       = 'cow_details_list';

        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['edit_info']    = $this->AdminModel->get_cow_details_data($param2);

			$data['cow_type_list']    = $this->db->select('id, name')->get('tbl_cow_type')->result();

			$data['health_test_list'] = $this->db->where('cow_details_id', $param2)->order_by('health_test_date', 'DESC')->get('tbl_cow_health_test')->result();

			$data['milk_target_list'] = $this->db->where('cow_details_id', $param2)->order_by('start_date', 'DESC')->get('tbl_cow_milk_target')->result();

			$data['milk_collection_list'] = $this->db->where('cow_details_id', $param2)->order_by('collection_date', 'DESC')->get('tbl_cow_milk_collection')->result();

			$data['total_milk_collected'] = $this->db->select_sum('collection_amount')->where('cow_details_id', $param2)->get('tbl_cow_milk_collection')->row();
			

			$data['pregnancy_list']   = $this->db->where('cow_details_id', $param2)->order_by('semens_push_date', 'DESC')->get('tbl_cow_pregnancy')->result();

			$data['vaccine_list']     = $this->db->select('id, name')->get('tbl_vaccine_list')->result();

			$data['cow_vaccine_list']     = $this->AdminModel->get_single_cow_vaccine_list($param2);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            	$update_cow_details_data['cow_no']               = $this->input->post('cow_no', true);
	    		$update_cow_details_data['cow_type_id']          = $this->input->post('cow_type_id', true);
	    		$update_cow_details_data['start_date']           = date('Y-m-d', strtotime($this->input->post('start_date', true)));
	    		$update_cow_details_data['purchase_cost']        = $this->input->post('purchase_cost', true);
	    		$update_cow_details_data['target_sale_cost']     = $this->input->post('target_sale_cost', true);
	    		$update_cow_details_data['color']                = $this->input->post('color', true);
	    		$update_cow_details_data['is_sold']              = $this->input->post('is_sold', true);
	    		$update_cow_details_data['is_death']             = $this->input->post('is_death', true);
            	$update_cow_details_data['last_update']          = date('Y-m-d H:i');

	    		if ($this->AdminModel->update_cow_details($update_cow_details_data, $param2)) {

				$this->session->set_flashdata('message','Cow Details  Updated Successfully!');
				redirect('admin/cow-details/list', 'refresh');

				} else {

				   $this->session->set_flashdata('message','Cow Details Update Failed!');
					redirect('admin/cow-details/edit/'.$param2, 'refresh');
				}

            }

			$data['title']         = 'Cow Details Update';
            $data['page']          = 'backEnd/admin/cow_details_edit';
			$data['activeMenu']    = 'cow_details_edit';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_cow_details($param2)) {

				$this->session->set_flashdata('message','Cow Details  Deleted Successfully!');
				redirect('admin/cow-details/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Cow Details Deleted Failed!');
				redirect('admin/cow-details/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/cow-details/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //health test add from cow profile
    public function health_test_add($param) {

    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    		$health_test_data['cow_details_id']   = $param;

			$health_test_data['health_test_date'] = date('Y-m-d', strtotime($this->input->post('health_test_date', true)));

    		$health_test_data['height']           = $this->input->post('height', true);
	    	$health_test_data['width']            = $this->input->post('width', true);
	    		
	    	$health_test_data['weight']           = $this->input->post('weight', true);
			$health_test_data['insert_by']        = $_SESSION['userid'];
    		$health_test_data['insert_time']      = date('Y-m-d H:i');

    		$health_test_add = $this->db->insert('tbl_cow_health_test', $health_test_data);

    		$last_id = $this->db->insert_id();
			$last_insert_data  = $this->db->get_where('tbl_cow_health_test', array('id' => $last_id))->row();
			
			if ($health_test_add) {

				echo json_encode([
		            'status'  => "success",
		            'message' => "Successfully Added.",
		            'data'    => $last_insert_data
		        ]);
				

			} else {

				echo json_encode([
		            'status'  => "error",
		            'message' => "Failed"
		            
		        ]);
				
			}
		}
    }

    //milk target add from cow profile
    public function milk_target_add($param) {

    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    		$milk_target_data['cow_details_id']     = $param;

			$milk_target_data['start_date']         = date('Y-m-d', strtotime($this->input->post('start_date', true)));

    		$milk_target_data['milk_target']        = $this->input->post('milk_target', true);
	    	
			$milk_target_data['insert_by']          = $_SESSION['userid'];
    		$milk_target_data['insert_time']        = date('Y-m-d H:i');

    		$milk_target_add = $this->db->insert('tbl_cow_milk_target', $milk_target_data);

    		$last_id = $this->db->insert_id();
			$last_insert_data  = $this->db->get_where('tbl_cow_milk_target', array('id' => $last_id))->row();

			if ($milk_target_add) {

				echo json_encode([
		            'status'  => "success",
		            'message' => "Successfully Added.",
		            'data'    => $last_insert_data
		        ]);

			} else {

				echo json_encode([
		            'status'  => "error",
		            'message' => "Failed"
		            
		        ]);
				
			}
		}
    }

    //milk collection add from cow profile
    public function milk_collection_add($param) {

    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    		$milk_collection_data['cow_details_id']           = $param;

			$milk_collection_data['collection_date']          = date('Y-m-d', strtotime($this->input->post('collection_date', true)));

    		$milk_collection_data['collection_amount']        = $this->input->post('collection_amount', true);
	    	
			$milk_collection_data['collection_by']            = $_SESSION['userid'];
    		$milk_collection_data['insert_time']              = date('Y-m-d H:i');

    		$milk_collection_add = $this->db->insert('tbl_cow_milk_collection', $milk_collection_data);

    		$last_id = $this->db->insert_id();
			$last_insert_data  = $this->db->get_where('tbl_cow_milk_collection', array('id' => $last_id))->row();
			
			if ($milk_collection_add) {

				echo json_encode([
		            'status'  => "success",
		            'message' => "Successfully Added.",
		            'data'    => $last_insert_data
		        ]);


			} else {

				echo json_encode([
		            'status'  => "error",
		            'message' => "Failed"
		            
		        ]);
				
			}
		}
    }

    //vaccine add from cow profile
    public function vaccine_add($param) {

    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    		$vaccine_data['cow_details_id']         = $param;

    		$vaccine_data['vaccine_id']             = $this->input->post('vaccine_id', true);
    		$vaccine_data['notes']             = $this->input->post('notes', true);

			$vaccine_data['push_date']              = date('Y-m-d', strtotime($this->input->post('push_date', true)));

			$vaccine_data['next_push_date']         = date('Y-m-d', strtotime($this->input->post('next_push_date', true)));

			$vaccine_data['insert_by']              = $_SESSION['userid'];
    		$vaccine_data['insert_time']            = date('Y-m-d H:i');

    		$vaccine_add = $this->db->insert('tbl_cow_vaccine', $vaccine_data);

    		$last_id = $this->db->insert_id();

    		$this->db->select('tbl_cow_vaccine.id, tbl_cow_vaccine.push_date, tbl_cow_vaccine.next_push_date, tbl_cow_vaccine.notes, tbl_cow_vaccine.vaccine_id, tbl_vaccine_list.name AS vaccine_name')
    			->from('tbl_cow_vaccine')
         		
         		->join('tbl_vaccine_list', 'tbl_vaccine_list.id = tbl_cow_vaccine.vaccine_id', 'left')
         		->where('tbl_cow_vaccine.id', $last_id)
         		->group_by('tbl_cow_vaccine.id');

			$last_insert_data  = $this->db->get()->row();
			
			if ($vaccine_add) {

				echo json_encode([
		            'status'  => "success",
		            'message' => "Successfully Added.",
		            'data'    => $last_insert_data
		        ]);


			} else {

				echo json_encode([
		            'status'  => "error",
		            'message' => "Failed"
		            
		        ]);
				
			}
		}
    }

    //cow feeds
    public function cow_feeds($param1 = 'add', $param2 = '', $param3 = '') {
        
    	if ($param1 == 'add') {

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	    		$cow_type_data['name']           = $this->input->post('name', true);
	    		$cow_type_data['insert_by']      = $_SESSION['userid'];
	    		$cow_type_data['insert_time']    = date('Y-m-d H:i');

	    		$cow_type = $this->db->insert('tbl_cow_feeds', $cow_type_data);

				if ($cow_type) {

					$this->session->set_flashdata('message','Cow Feeds Created Successfully!');
					redirect('admin/cow-feeds/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Cow feeds Failed!');
					redirect('admin/cow-feeds', 'refresh');
				}
			}

			$data['title']         = 'Cow feeds Add';
            $data['page']          = 'backEnd/admin/cow_feeds_add';
            $data['activeMenu']    = 'cow_feeds_add';
            
    	} elseif ($param1 == 'list') {

        	$data['title']         = 'Cow Feeds List';
            $data['page']          = 'backEnd/admin/cow_feeds_list';
            $data['activeMenu']    = 'cow_feeds_list';

			$data['cow_feeds_list'] =  $this->db->get('tbl_cow_feeds')->result();
			
        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['edit_info']    = $this->db->where('id', $param2)->get('tbl_cow_feeds')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            	$cow_feeds_update_data['name']           = $this->input->post('name', true);

	    		if ($this->AdminModel->update_cow_feeds($cow_feeds_update_data, $param2)) {

				$this->session->set_flashdata('message','Cow Feeds  Updated Successfully!');
				redirect('admin/cow-feeds/list', 'refresh');

				} else {

				   $this->session->set_flashdata('message','Cow Feeds Update Failed!');
					redirect('admin/cow-feeds/edit/'.$param2, 'refresh');
				}

            }

			$data['title']         = 'Cow Feeds Update';
            $data['page']          = 'backEnd/admin/cow_feeds_edit';
			$data['activeMenu']    = 'cow_feeds_edit';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_cow_feeds($param2)) {

				$this->session->set_flashdata('message','Cow type  Deleted Successfully!');
				redirect('admin/cow-feeds/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Cow type Deleted Failed!');
				redirect('admin/cow-feeds/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/cow-feeds/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //cow health test
    public function cow_health_test($param1 = 'add', $param2 = '', $param3 = '') {
        
    	if ($param1 == 'add') {

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    			$cow_health_test_data['health_test_date'] = date('Y-m-d', strtotime($this->input->post('health_test_date', true)));
    			$cow_health_test_data['insert_by']        = $_SESSION['userid'];
	    		$cow_health_test_data['insert_time']      = date('Y-m-d H:i');

    			foreach ($this->input->post('height', true) as $key => $value) {

    				if($value < 1) continue;
    				
    				$cow_health_test_data['cow_details_id']   = $this->input->post('cow_details_id', true)[$key];
		    		$cow_health_test_data['height']           = $value;
		    		$cow_health_test_data['width']            = $this->input->post('width', true)[$key];
		    		
		    		$cow_health_test_data['weight']           = $this->input->post('weight', true)[$key];
		    		
		    		$this->db->insert('tbl_cow_health_test', $cow_health_test_data);

    			}
	    		

				if (true) {

					$this->session->set_flashdata('message','Cow Health Test Created Successfully!');
					redirect('admin/cow-health-test/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Cow Health Test Failed!');
					redirect('admin/cow-health-test', 'refresh');
				}
			}

			$data['cow_details_list'] = $this->db->select('id, cow_no')->order_by('cow_no','desc')->get('tbl_cow_details')->result();

			$data['title']         = 'Cow Health Test Add';
            $data['page']          = 'backEnd/admin/cow_health_test_add';
            $data['activeMenu']    = 'cow_health_test_add';
            
    	} elseif ($param1 == 'list') {

    		$data['search'] = array();

    		$data['search']['cow_no']           = '';
    		$data['search']['health_test_date'] = '';


    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				if ($this->input->post('cow_no', true)){

					$data['search']['cow_no'] = $this->input->post('cow_no', true);
				}

				if ($this->input->post('health_test_date', true)){

					$data['search']['health_test_date'] = date('Y-m-d', strtotime($this->input->post('health_test_date', true)));
				}
			}

			$data['cow_health_test_list'] = $this->AdminModel->get_cow_health_test_list($data['search']);

			$data['cow_details'] = $this->db->select('id, cow_no')->order_by('cow_no','desc')->get('tbl_cow_details')->result();

        	$data['title']            = 'Cow Health Test List';
            $data['page']             = 'backEnd/admin/cow_health_test_list';
            $data['activeMenu']       = 'cow_health_test_list';

			
			
        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['edit_info']    = $this->db->where('id', $param2)->get('tbl_cow_health_test')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            	$cow_health_test_update_data['cow_details_id']   = $this->input->post('cow_details_id', true);
	    		$cow_health_test_update_data['height']           = $this->input->post('height', true);
	    		$cow_health_test_update_data['width']            = $this->input->post('width', true);
	    		$cow_health_test_update_data['health_test_date'] = date('Y-m-d', strtotime($this->input->post('health_test_date', true)));
	    		$cow_health_test_update_data['weight']           = $this->input->post('weight', true);
	    		
	    		if ($this->AdminModel->update_cow_health_test($cow_health_test_update_data, $param2)) {

				$this->session->set_flashdata('message','Cow Health Test Updated Successfully!');
				redirect('admin/cow-health-test/list', 'refresh');

				} else {

				   $this->session->set_flashdata('message','Cow Health Test Update Failed!');
					redirect('admin/cow-health-test/edit/'.$param2, 'refresh');
				}

            }
            $data['cow_details_list'] = $this->db->select('id, cow_no')->order_by('cow_no','desc')->get('tbl_cow_details')->result();

			$data['title']         = 'Cow Health Test Update';
            $data['page']          = 'backEnd/admin/cow_health_test_edit';
			$data['activeMenu']    = 'cow_health_test_edit';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_cow_health_test($param2)) {

				$this->session->set_flashdata('message','Cow Health Test Deleted Successfully!');
				redirect('admin/cow-health-test/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Cow Health Test Deleted Failed!');
				redirect('admin/cow-health-test/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/cow-health-test/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //cow milk collection
    public function cow_milk_collection($param1 = 'add', $param2 = '', $param3 = '') {
        
    	if ($param1 == 'add') {

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    			$cow_milk_collection_data['collection_date']       = date('Y-m-d', strtotime($this->input->post('collection_date', true)));
    			$cow_milk_collection_data['collection_by']         = $_SESSION['userid'];
	    		$cow_milk_collection_data['insert_time']           = date('Y-m-d H:i');

    			foreach ($this->input->post('collection_amount', true) as $key => $value) {

    				if( $value < 1 ) continue;

    				$cow_milk_collection_data['cow_details_id']        = $this->input->post('cow_details_id', true)[$key];
    				$cow_milk_collection_data['collection_amount']     = $value;

    				$this->db->insert('tbl_cow_milk_collection', $cow_milk_collection_data);

    			}

				if (true) {

					$this->session->set_flashdata('message','Cow Milk Collection Created Successfully!');
					redirect('admin/cow-milk-collection/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Cow Milk Collection Failed!');
					redirect('admin/cow-milk-collection', 'refresh');
				}
			}
			
			$data['cow_details_list'] = $this->AdminModel->get_target();

			$data['title']         = 'Cow Milk Collection Add';
            $data['page']          = 'backEnd/admin/cow_milk_collection_add';
            $data['activeMenu']    = 'cow_milk_collection_add';
            
    	} elseif ($param1 == 'list') {

    		$data['search'] = array();

    		$data['search']['cow_no']           = '';
    		$data['search']['collection_date']  = '';
    		$data['search']['collection_by']    = '';
    		$data['cow_milk_collection_list']   = array();

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				if ($this->input->post('cow_no', true)){

					$data['search']['cow_no'] = $this->input->post('cow_no', true);
				}

				if ($this->input->post('collection_date', true)){

					$data['search']['collection_date'] = date('Y-m-d', strtotime($this->input->post('collection_date', true)));
				}

				if ($this->input->post('collection_by', true)){

					$data['search']['collection_by'] = $this->input->post('collection_by', true);
				}

				$data['cow_milk_collection_list'] = $this->AdminModel->get_cow_milk_collection_list($data['search']);
			}

    		

    		$data['cow_details'] = $this->db->select('id, cow_no')->order_by('cow_no','desc')->get('tbl_cow_details')->result();
    		$data['user_list']   = $this->db->select('id, username')->get('user')->result();

        	$data['title']         = 'Cow Milk Collection List';
            $data['page']          = 'backEnd/admin/cow_milk_collection_list';
            $data['activeMenu']    = 'cow_milk_collection_list';

        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['edit_info']    = $this->db->where('id', $param2)->get('tbl_cow_milk_collection')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            	$update_cow_milk_collection_data['cow_details_id']        = $this->input->post('cow_details_id', true);
	    		$update_cow_milk_collection_data['collection_date']       = date('Y-m-d', strtotime($this->input->post('collection_date', true)));
	    		$update_cow_milk_collection_data['collection_amount']     = $this->input->post('collection_amount', true);

	    		if ($this->AdminModel->update_cow_milk_collection($update_cow_milk_collection_data, $param2)) {

				$this->session->set_flashdata('message','Cow Feeds  Updated Successfully!');
				redirect('admin/cow-milk-collection/list', 'refresh');

				} else {

				   $this->session->set_flashdata('message','Cow Feeds Update Failed!');
					redirect('admin/cow-milk-collection/edit/'.$param2, 'refresh');
				}

            }

            $data['cow_details_list'] = $this->db->select('id, cow_no')->order_by('cow_no','desc')->get('tbl_cow_details')->result();

			$data['title']         = 'Cow Milk Collection Update';
            $data['page']          = 'backEnd/admin/cow_milk_collection_edit';
			$data['activeMenu']    = 'cow_milk_collection_edit';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_cow_milk_collection($param2)) {

				$this->session->set_flashdata('message','Cow Milk Collection  Deleted Successfully!');
				redirect('admin/cow-milk-collection/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Cow Milk Collection Deleted Failed!');
				redirect('admin/cow-milk-collection/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/cow-milk-collection/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //cow milk collection target
    public function cow_milk_target($param1 = 'add', $param2 = '', $param3 = '') {
        
    	if ($param1 == 'add') {

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    			$cow_milk_target_data['start_date']   = date('Y-m-d', strtotime($this->input->post('start_date', true)));
    			$cow_milk_target_data['insert_by']    = $_SESSION['userid'];
	    		$cow_milk_target_data['insert_time']  = date('Y-m-d H:i');

    			foreach ($this->input->post('milk_target', true) as $key => $value) {

    				if($value < 1) continue;

    				$cow_milk_target_data['milk_target']      = $value;
    				$cow_milk_target_data['cow_details_id']   = $this->input->post('cow_details_id', true)[$key];

    				$this->db->insert('tbl_cow_milk_target', $cow_milk_target_data);

    			}

	    	
				if (true) {

					$this->session->set_flashdata('message','Cow Milk target Created Successfully!');
					redirect('admin/cow-milk-target', 'refresh');

				} else {

					$this->session->set_flashdata('message','Cow Milk target Failed!');
					redirect('admin/cow-milk-target', 'refresh');
				}
			}

			$data['cow_details_list'] = $this->db->select('id, cow_no')->order_by('cow_no', 'desc')->get('tbl_cow_details')->result();

			$data['title']         = 'Cow Milk target Add';
            $data['page']          = 'backEnd/admin/cow_milk_target_add';
            $data['activeMenu']    = 'cow_milk_target_add';
            
    	} elseif ($param1 == 'list') {

    		$data['search'] = array();

    		$data['search']['cow_no']       = '';
    		$data['search']['start_date']   = '';
    		$data['cow_milk_target_list']   = array();

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				if ($this->input->post('cow_no', true)){

					$data['search']['cow_no'] = $this->input->post('cow_no', true);
				}

				if ($this->input->post('start_date', true)){

					$data['search']['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date', true)));
				}

				$data['cow_milk_target_list'] = $this->AdminModel->get_cow_milk_target_list($data['search']);

			}

    		

    		$data['cow_details_list'] = $this->db->select('id, cow_no')->order_by('cow_no','desc')->get('tbl_cow_details')->result();
    		
        	$data['title']         = 'Cow Milk target List';
            $data['page']          = 'backEnd/admin/cow_milk_target_list';
            $data['activeMenu']    = 'cow_milk_target_list';

        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['edit_info']    = $this->db->where('id', $param2)->get('tbl_cow_milk_target')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            	$cow_milk_target_data['cow_details_id']   = $this->input->post('cow_details_id', true);

            	$cow_milk_target_data['start_date']       = date('Y-m-d', strtotime($this->input->post('start_date', true)));
    			
	    		$cow_milk_target_data['milk_target']      = $this->input->post('milk_target', true);

				$cow_milk_target_data['insert_by']        = $_SESSION['userid'];
	    		$cow_milk_target_data['insert_time']      = date('Y-m-d H:i');

	    		if ($this->AdminModel->update_cow_milk_target($cow_milk_target_data, $param2)) {

				$this->session->set_flashdata('message','Cow Milk Target  Updated Successfully!');
				redirect('admin/cow-milk-target/list', 'refresh');

				} else {

				   $this->session->set_flashdata('message', 'Cow Milk Target Update Failed!');
					redirect('admin/cow-milk-target/edit/'.$param2, 'refresh');
				}

            }

            $data['cow_details_list'] = $this->db->select('id, cow_no')->order_by('cow_no','desc')->get('tbl_cow_details')->result();

			$data['title']       = 'Cow Milk Target Update';
            $data['page']        = 'backEnd/admin/cow_milk_target_edit';
			$data['activeMenu']  = 'cow_milk_target_edit';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_cow_milk_target($param2)) {

				$this->session->set_flashdata('message','Cow Milk target  Deleted Successfully!');
				redirect('admin/cow-milk-target/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Cow Milk target Deleted Failed!');
				redirect('admin/cow-milk-target/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/cow-milk-collection/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);

    }

    //cow pregnancy
    public function cow_pregnancy($param1 = 'add', $param2 = '', $param3 = '') {
        
    	if ($param1 == 'add') {

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	    		$cow_pregnancy_data['cow_details_id']            = $this->input->post('cow_details_id', true);

	    		$cow_pregnancy_data['semens_push_date']          = date('Y-m-d', strtotime($this->input->post('semens_push_date', true)));

	    		$cow_pregnancy_data['pregnancy_start_date']      = date('Y-m-d', strtotime($this->input->post('pregnancy_start_date', true)));

	    		$cow_pregnancy_data['approximate_delivery_date'] = date('Y-m-d', strtotime($this->input->post('approximate_delivery_date', true)));

	    		$cow_pregnancy_data['is_success']                = $this->input->post('is_success', true);

	    		$cow_pregnancy_data['baby_cow_no']               = $this->input->post('baby_cow_no', true);

	    		$cow_pregnancy_data['notes']                     = $this->input->post('notes', true);
	    		
	    		$cow_pregnancy_data['insert_by']                 = $_SESSION['userid'];
	    		
	    		$cow_pregnancy_data['insert_time']               = date('Y-m-d H:i');

	    		$cow_pregnancy_add = $this->db->insert('tbl_cow_pregnancy', $cow_pregnancy_data);

				if ($cow_pregnancy_add) {

					$this->session->set_flashdata('message','Cow Pregnancy Created Successfully!');
					redirect('admin/cow-pregnancy/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Cow Pregnancy Failed!');
					redirect('admin/cow-pregnancy', 'refresh');
				}
			}

			$data['cow_details_list'] = $this->db->select('id, cow_no')->order_by('cow_no', 'desc')->get('tbl_cow_details')->result();

			$data['title']         = 'Cow Milk target Add';
            $data['page']          = 'backEnd/admin/cow_pregnancy_add';
            $data['activeMenu']    = 'cow_pregnancy_add';
            
    	} elseif ($param1 == 'list') {

    		$data['search'] = array();

    		$data['search']['cow_no']                  = '';
    		$data['search']['semens_push_date']        = '';
    		$data['search']['pregnancy_start_date']    = '';

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				if ($this->input->post('cow_no', true)){

					$data['search']['cow_no'] = $this->input->post('cow_no', true);
				}

				if ($this->input->post('semens_push_date', true)){

					$data['search']['semens_push_date'] = date('Y-m-d', strtotime($this->input->post('semens_push_date', true)));
				}

				if ($this->input->post('pregnancy_start_date', true)){

					$data['search']['pregnancy_start_date'] = date('Y-m-d', strtotime($this->input->post('pregnancy_start_date', true)));
				}
			}

    		$data['cow_pregnancy_list'] = $this->AdminModel->get_cow_pregnancy_list($data['search']);

    		$data['cow_details'] = $this->db->select('id, cow_no')->order_by('cow_no','desc')->get('tbl_cow_details')->result();

        	$data['title']         = 'Cow Pregnancy List';
            $data['page']          = 'backEnd/admin/cow_pregnancy_list';
            $data['activeMenu']    = 'cow_pregnancy_list';

        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['edit_info']    = $this->db->where('id', $param2)->get('tbl_cow_pregnancy')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            	$update_cow_pregnancy_data['cow_details_id']            = $this->input->post('cow_details_id', true);

	    		$update_cow_pregnancy_data['semens_push_date']          = date('Y-m-d', strtotime($this->input->post('semens_push_date', true)));

	    		$update_cow_pregnancy_data['pregnancy_start_date']      = date('Y-m-d', strtotime($this->input->post('pregnancy_start_date', true)));

	    		$update_cow_pregnancy_data['approximate_delivery_date'] = date('Y-m-d', strtotime($this->input->post('approximate_delivery_date', true)));

	    		$update_cow_pregnancy_data['is_success']                = $this->input->post('is_success', true);

	    		$update_cow_pregnancy_data['baby_cow_no']               = $this->input->post('baby_cow_no', true);

	    		$update_cow_pregnancy_data['notes']                     = $this->input->post('notes', true);

	    		$update_cow_pregnancy_data['last_update']               = $_SESSION['userid'];


	    		if ($this->AdminModel->update_cow_pregnancy($update_cow_pregnancy_data, $param2)) {

				$this->session->set_flashdata('message','Cow Pregnancy Updated Successfully!');
				redirect('admin/cow-pregnancy/list', 'refresh');

				} else {

				   $this->session->set_flashdata('message', 'Cow Pregnancy Update Failed!');
					redirect('admin/cow-pregnancy/edit/'.$param2, 'refresh');
				}

            }

            $data['cow_details_list'] = $this->db->select('id, cow_no')->order_by('cow_no','desc')->get('tbl_cow_details')->result();

			$data['title']         = 'Cow Pregnancy Update';
            $data['page']          = 'backEnd/admin/cow_pregnancy_edit';
			$data['activeMenu']    = 'cow_pregnancy_edit';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_cow_pregnancy($param2)) {

				$this->session->set_flashdata('message','Cow Pregnancy Deleted Successfully!');
				redirect('admin/cow-pregnancy/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Cow Pregnancy Deleted Failed!');
				redirect('admin/cow-pregnancy/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/cow-pregnancy/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
        
    }

    //cow type
	public function vaccine($param1 = 'add', $param2 = '', $param3 = '') {
        
    	if ($param1 == 'add') {

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	    		$vaccine_data['name']           = $this->input->post('name', true);
	    		$vaccine_data['type']           = $this->input->post('type', true);
	    		$vaccine_data['insert_by']      = $_SESSION['userid'];
	    		$vaccine_data['insert_time']    = date('Y-m-d H:i');

	    		$add_vaccine = $this->db->insert('tbl_vaccine_list', $vaccine_data);

				if ($add_vaccine) {

					$this->session->set_flashdata('message','Vaccine Created Successfully!');
					redirect('admin/vaccine/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Vaccine Failed!');
					redirect('admin/vaccine', 'refresh');
				}
			}

			$data['title']         = 'Vaccine Add';
            $data['page']          = 'backEnd/admin/vaccine_add';
            $data['activeMenu']    = 'vaccine_add';
            
    	} elseif ($param1 == 'list') {

        	$data['title']         = 'Vaccine List';
            $data['page']          = 'backEnd/admin/vaccine_list';
            $data['activeMenu']    = 'vaccine_list';

			$data['vaccine_list'] =  $this->db->get('tbl_vaccine_list')->result();
			
        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['edit_info']    = $this->db->where('id', $param2)->get('tbl_vaccine_list')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            	$vaccine_update_data['name']           = $this->input->post('name', true);
	    		$vaccine_update_data['type']           = $this->input->post('type', true);

	    		if ($this->AdminModel->update_vaccine($vaccine_update_data, $param2)) {

				$this->session->set_flashdata('message','Vaccine  Updated Successfully!');
				redirect('admin/vaccine/list', 'refresh');

				} else {

				   $this->session->set_flashdata('message','Vaccine Update Failed!');
					redirect('admin/vaccine/list/'.$param2, 'refresh');
				}

            }
            $data['vaccine_list'] =  $this->db->get('tbl_vaccine_list')->result();

			$data['title']         = 'Vaccine Update';
            $data['page']          = 'backEnd/admin/vaccine_list';
			$data['activeMenu']    = 'vaccine_edit';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_vaccine($param2)) {

				$this->session->set_flashdata('message','Vaccine  Deleted Successfully!');
				redirect('admin/vaccine/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Vaccine Deleted Failed!');
				redirect('admin/vaccine/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/vaccine/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //cow health test
    public function cow_vaccine($param1 = 'add', $param2 = '', $param3 = '') {
        
    	if ($param1 == 'add') {

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    			$cow_vaccine_data['push_date']       = date('Y-m-d', strtotime($this->input->post('push_date', true)));

    			$cow_vaccine_data['next_push_date']  = date('Y-m-d', strtotime($this->input->post('next_push_date', true)));
    			
    			$cow_vaccine_data['insert_by']       = $_SESSION['userid'];
	    		$cow_vaccine_data['insert_time']     = date('Y-m-d H:i');



    			foreach ($this->input->post('cow_details_id', true) as $key => $value) {

    				if($this->input->post('vaccine_id', true)[$key] < 1) continue;

    				$cow_vaccine_data['cow_details_id']   = $value;
		    		$cow_vaccine_data['vaccine_id']       = $this->input->post('vaccine_id', true)[$key];
		    		$cow_vaccine_data['notes']            = $this->input->post('notes', true)[$key];
		    		
		    		$this->db->insert('tbl_cow_vaccine', $cow_vaccine_data);

    			}

	    		

				if (true) {

					$this->session->set_flashdata('message','Cow Vaccine Created Successfully!');
					redirect('admin/cow-vaccine/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Cow Vaccine Failed!');
					redirect('admin/cow-vaccine', 'refresh');
				}
			}

			$data['cow_details_list'] = $this->db->select('id, cow_no')->order_by('cow_no','desc')->get('tbl_cow_details')->result();
			$data['vaccine_list']     = $this->db->select('id, name')->get('tbl_vaccine_list')->result();

			$data['title']         = 'Cow Vaccine Add';
            $data['page']          = 'backEnd/admin/cow_vaccine_add';
            $data['activeMenu']    = 'cow_vaccine_add';
            
    	} elseif ($param1 == 'list') {

    		$data['search'] = array();

    		$data['search']['cow_no']           = '';
    		$data['search']['push_date'] = '';
    		$data['search']['next_push_date'] = '';


    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				if ($this->input->post('cow_no', true)){

					$data['search']['cow_no'] = $this->input->post('cow_no', true);
				}

				if ($this->input->post('push_date', true)){

					$data['search']['push_date'] = date('Y-m-d', strtotime($this->input->post('push_date', true)));
				}

				if ($this->input->post('next_push_date', true)){

					$data['search']['next_push_date'] = date('Y-m-d', strtotime($this->input->post('next_push_date', true)));
				}
			}

			$data['cow_vaccine_list'] = $this->AdminModel->get_cow_vaccine_list($data['search']);

			$data['cow_details'] = $this->db->select('id, cow_no')->order_by('cow_no','desc')->get('tbl_cow_details')->result();

        	$data['title']            = 'Cow Vaccine List';
            $data['page']             = 'backEnd/admin/cow_vaccine_list';
            $data['activeMenu']       = 'cow_vaccine_list';

			
			
        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['edit_info']    = $this->db->where('id', $param2)->get('tbl_cow_vaccine')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            	$cow_vaccine_update_data['push_date']        = date('Y-m-d', strtotime($this->input->post('push_date', true)));

    			$cow_vaccine_update_data['next_push_date']   = date('Y-m-d', strtotime($this->input->post('next_push_date', true)));

    			$cow_vaccine_update_data['cow_details_id']   = $this->input->post('cow_details_id', true);

		    	$cow_vaccine_update_data['vaccine_id']       = $this->input->post('vaccine_id', true);
		    	$cow_vaccine_update_data['notes']            = $this->input->post('notes', true);
    			
	    		
	    		if ($this->AdminModel->update_cow_vaccine($cow_vaccine_update_data, $param2)) {

				$this->session->set_flashdata('message','Cow Vaccine Updated Successfully!');
				redirect('admin/cow-vaccine/list', 'refresh');

				} else {

				   $this->session->set_flashdata('message','Cow Vaccine Update Failed!');
					redirect('admin/cow-vaccine/edit/'.$param2, 'refresh');
				}

            }
            $data['cow_details_list'] = $this->db->select('id, cow_no')->order_by('cow_no','desc')->get('tbl_cow_details')->result();

            $data['vaccine_list']     = $this->db->select('id, name')->get('tbl_vaccine_list')->result();

			$data['title']         = 'Cow Vaccine Update';
            $data['page']          = 'backEnd/admin/cow_vaccine_edit';
			$data['activeMenu']    = 'cow_vaccine_edit';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_cow_vaccine($param2)) {

				$this->session->set_flashdata('message','Cow Vaccine Deleted Successfully!');
				redirect('admin/cow-vaccine/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Cow Vaccine Deleted Failed!');
				redirect('admin/cow-vaccine/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/cow-vaccine/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    public function pagination()
    {

    	$config = array();
        $config["base_url"] = base_url() . "admin/pagination";
        $config["total_rows"] = $this->db->count_all('authors');
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
         
        //custom
        $config['full_tag_open']   = '<ul class="pagination">';
        $config['full_tag_close']  = '</ul>';
        
        $config['first_link']      = "First";
        $config['last_link']       = "Last";
        
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
            
        $config['prev_link']       = '«';
        $config['prev_tag_open']   = '<li class="prev">';
        $config['prev_tag_close']  = '</li>';
        
        $config['next_link']       = '»';
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        
        $config['cur_tag_open']    = '<li class="active"><a href="#">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["links"] = $this->pagination->create_links();

        $data['authors'] = $this->AdminModel->get_authors($config["per_page"], $page);

    	$data['title']         = 'pagination';
        $data['page']          = 'backEnd/admin/pagination';
	    $data['activeMenu']    = 'pagination';
    	
    	$this->load->view('backEnd/master_page', $data);
    }

    public function server_side($param1 = 'show')
    {
    	
    	$data['title']         = 'server_side';
        $data['page']          = 'backEnd/admin/server_side';
	    $data['activeMenu']    = 'server_side';
	    $this->load->view('backEnd/master_page', $data);
    }

    public function accouts_list()
    {

    	
    	$limit = 10;
    	$start = 0;
    	$response['data'] = $this->AdminModel->all_accounts_list($limit, $start);
    	
    	echo json_encode($response);

    }

    //12.04.2021
	public function salary($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$salary_data['employee_id']      = $this->input->post('employee_id', true);
				$salary_data['day']              = $this->input->post('day', true);
				$salary_data['month']            = $this->input->post('month', true);
				$salary_data['year']             = $this->input->post('year', true);
				$salary_data['amount']           = $this->input->post('amount', true);
				$salary_data['notes']            = $this->input->post('notes', true);

				$salary_data['insert_time']      = date('Y-m-d H:i');

				$salary_data['insert_by']        = $_SESSION['userid'];
				
				$add_salary = $this->db->insert('tbl_salary',$salary_data);

				if ($add_salary) {

					$this->session->set_flashdata('message','Salary Added Successfully!');
					redirect('admin/salary/list','refresh');

				} else {

				   $this->session->set_flashdata('message','Salary Add Failed!');
					redirect('admin/salary/add','refresh');
				}
			}

			$data['employee_list']     = $this->db->get('tbl_employee')->result();

			$data['title']             = 'Salary Add';
			$data['activeMenu']        = 'salary_add';
			$data['page']              = 'backEnd/admin/salary_add';
			
		} elseif ($param1 == 'list' ) {

			$config = array();
	        $config["base_url"] = base_url() . "admin/salary/list";
	        $config["total_rows"] = $this->db->count_all('tbl_salary');
	        $config["per_page"] = 10;
	        $config["uri_segment"] = 4;

	        //custom
	        $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            
            $config['first_link'] = "First";
            $config['last_link'] = "Last";
            
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
                
            $config['prev_link'] = '«';
            $config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
            
            $config['next_link'] = '»';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            
            $config['cur_tag_open'] = '<li class="active"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

	         
	       
	        $this->pagination->initialize($config);

	        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

	        $data["links"] = $this->pagination->create_links();



			$data['salary_list'] = $this->AdminModel->salary_list($config["per_page"], $page);
			

			$data['title']        = 'Salary List';
			$data['activeMenu']   = 'salary_list';
			$data['page']         = 'backEnd/admin/salary_list';

		   
		} elseif ($param1 == 'report') {

			$data = array();

			$data['search']['employee_id'] = '';
			$data['search']['start_date']  = '';
			$data['search']['end_date']    = '';

			$data['salary_data']           = array();

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				if ($this->input->post('start_date', true)){

					$data['search']['start_date']     = date('Y-m-d', strtotime($this->input->post('start_date', true)));
				}

				if ($this->input->post('end_date', true)){

					$data['search']['end_date']       = date('Y-m-d', strtotime($this->input->post('end_date', true)));
				}

				if ($this->input->post('employee_id', true)){

					$data['search']['employee_id']    = $this->input->post('employee_id', true);
				}

				$data['salary_data'] = $this->AdminModel->get_salary_report($data['search']);
				

			}

			
			
			$data['employee_list'] = $this->db->get('tbl_employee')->result();

			$data['title']        = 'Salary Report';
			$data['activeMenu']   = 'salary_report';
			$data['page']         = 'backEnd/admin/salary_report';

		} elseif ($param1 == 'edit' && $param2 > 0) {

			$data['edit_info']             = $this->db->get_where('tbl_salary',array('id'=>$param2));

			$data['employee_list']         = $this->db->get('tbl_employee')->result();

			
			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$update_salary_data['employee_id']      = $this->input->post('employee_id', true);
					$update_salary_data['day']              = $this->input->post('day', true);
					$update_salary_data['month']            = $this->input->post('month', true);
					$update_salary_data['year']             = $this->input->post('year', true);
					$update_salary_data['amount']           = $this->input->post('amount', true);
					$update_salary_data['notes']            = $this->input->post('notes', true);
					

					if ($this->AdminModel->updateSalary($update_salary_data, $param2)) {

						$this->session->set_flashdata('message','Salary Updated Successfully!');
						redirect('admin/salary/list', 'refresh');

					} else {

					   $this->session->set_flashdata('message','Salary Update Failed!');
						redirect('admin/salary/edit/'.$param2, 'refresh');
					}
				}

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/salary/list','refresh');
			}

			$data['title']      = 'Salary Update';
			$data['activeMenu'] = 'salary_edit';
			$data['page']       = 'backEnd/admin/salary_edit';
			
		   
		} elseif($param1 == 'delete' && $param2 > 0) {
			
		   	if ($this->AdminModel->delete_salary($param2)) {

				$this->session->set_flashdata('message','Salary  Deleted Successfully!');
				redirect('admin/salary/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Salary Deleted Failed!');
				redirect('admin/salary/list', 'refresh');
			}
			
		} else {

			$this->session->set_flashdata('message', 'Wrong Attempt!');
			redirect('admin/salary/list', 'refresh');

		}

		$this->load->view('backEnd/master_page',$data);        
	}


}
