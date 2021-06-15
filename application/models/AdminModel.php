<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
	class AdminModel extends CI_Model{
		
	// $returnmessage can be num_rows, result_array, result
		public function isRowExist($tableName,$data, $returnmessage, $user_id = NULL){
		
				$this->db->where($data);
				if($user_id !== NULL) {
						$this->db->where('userId',$user_id);
				}
				if($returnmessage == 'num_rows'){
						return $this->db->get($tableName)->num_rows();
				}else if($returnmessage == 'result_array'){
						return $this->db->get($tableName)->result_array();
				}else{
						return $this->db->get($tableName)->result();
				}
		}
			// saveDataInTable table name , array, and return type is null or last inserted ID.
		public function saveDataInTable($tableName, $data, $returnInsertId = 'false'){
		
				$this->db->insert($tableName,$data);
				if($returnInsertId == 'true'){
						return $this->db->insert_id();
				}else{
						return -1;
				}
		}
			
		public function check_campaign_ambigus($start_date, $end_date){
					
				if(date_format(date_create($start_date),"Y-m-d") > date_format(date_create($end_date),"Y-m-d")){
						return -2;
					}
		
				$this -> db -> limit(1);
				$this -> db -> where('end_date >=', $start_date);
				$this -> db -> where('available_status', 1);
				$query = $this->db->get('create_campaign')->num_rows();
				if($query > 0){
						return -1;
				}
				return 1;
		}
		
		public function end_date_extends($end_date, $id){
		
				$this -> db -> limit(1);
				$this -> db -> where('start_date >=', $end_date);
				$this -> db -> where('id', $id);
				$this -> db -> where('available_status', 1);
				$query = $this->db->get('create_campaign')->num_rows();
				if($query > 0){
						return -1;
				}
				$this -> db -> limit(1);
				$this -> db -> where('end_date >=', $end_date);
				$this -> db -> where('id !=', $id);
				$this -> db -> where('available_status', 1);
				$query2 = $this->db->get('create_campaign')->num_rows();
				if($query2 > 0){
						return -1;
				}
				return 1;
		}
		public function fetch_data_pageination($limit, $start, $table, $search=NULL, $approveStatus=NULL, $user_id =NULL) {
				
				$this->db->limit($limit, $start);
	
			if($approveStatus!==NULL ){
						$this->db->where('approveStatus',$approveStatus);
				}
	
				if($user_id !== NULL ){
						$this->db->where('userId', $user_id);
				}
	
				if($search !== NULL){
						$this->db->like('title',$search);
						$this->db->or_like('body',$search);
						$this->db->or_like('date',$search);
				}
	
				$this->db->order_by('date','desc');
				$query = $this->db->get($table);
	
				if ($query->num_rows() > 0) {
						foreach ($query->result_array() as $row) {
								$data[] = $row;
						}
						return $data;
				}
				return false;
		}
		public function fetch_images($limit=18, $start=0, $table, $search=NULL,$where_data=NULL) {
				
				$this->db->limit($limit, $start);
	
				if($search !== NULL){
						$this->db->like('date',$search);
						$this->db->or_like('photoCaption',$search);
				}
				if($where_data !== NULL){
						$this->db->where($where_data);
				}
				$this->db->group_by('photo');
				$this->db->order_by('date','desc');
				$query = $this->db->get($table);
	
				if ($query->num_rows() > 0) {
						foreach ($query->result_array() as $row) {
								$data[] = $row;
						}
						return $data;
				}
				return false;
		}
		
		public function usersCategory($userId){
	
				$this->db->select('category.*');
				$this->db->join('category' , 'category_user.categoryId = category.id', 'left');
				$this->db->where('category_user.userId',$userId);
				return $this->db->get('category_user')->result_array();
		}
		
		
		public function get_user($user_id)
		{
			 $query = $this->db->select('user.*,tbl_upozilla.*')
							->where('user.id',$user_id)
							->from('user')
							->join('tbl_upozilla','user.address = tbl_upozilla.id', 'left')
							->get();
	
				return $query->row();
		}
		
		public function update_pro_info($update_data, $user_id)
		{
			 return $this->db->where('id',$user_id)->update('user',$update_data);
		}


		public function project_lists()
		{
			$this->db->select('tbl_project.id, tbl_project.name, tbl_project.remark, tbl_project.address, tbl_project.project_start_date');

         	$this->db->group_by('tbl_project.id'); 
         	$this->db->order_by('tbl_project.id', 'desc');

         	$result = $this->db->get('tbl_project'); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	}else {

         		return array();

         	} 
		}


		public function add_project($data)
		{
			return $this->db->insert('tbl_project',$data);
		}

		public function project_update($data,$id)
		{
			return $this->db->where('id',$id)->update('tbl_project',$data);
		}


		public function add_accounthead($data)
		{
			return $this->db->insert('tbl_account_head',$data);
		}

		public function accounthead_update($data, $id)
		{
			return $this->db->where('id',$id)->update('tbl_account_head',$data);
		}

		public function add_accounts($data)
		{
			return $this->db->insert('tbl_accounts',$data);
		}

		public function all_accounts($limit, $start, $data)
		{
			$this->db->select('tbl_accounts.id, tbl_accounts.project_id, tbl_accounts.date, tbl_accounts.account_head_id, tbl_accounts.description, tbl_accounts.quantity, tbl_accounts.rate, tbl_accounts.amount, tbl_accounts.status, tbl_project.name AS pname, tbl_account_head.name AS hname, tbl_account_head.id as head_id,tbl_project.id as pid')
			
				->limit($limit, $start)
				->from('tbl_accounts')
				->join('tbl_project','tbl_accounts.project_id = tbl_project.id','left')
				->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id','left')
				->group_by('tbl_accounts.id')
				->order_by('id','desc');

			if(($data['project_id']) != ''){

				$this->db->where('tbl_accounts.project_id', $data['project_id']);
			}

			if(($data['date']) != ''){

				$this->db->where('tbl_accounts.date', $data['date']);
			}

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	}else {

         		return array();

         	}
		}

		public function accounts_update($data,$id)
		{
			return $this->db->where('id',$id)->update('tbl_accounts',$data);
		}

		public function project_search($project_id)
		{
			return $this->db->select('*')
							->from('tbl_project')
							->where('id',$project_id)
							->get()
							->row();
		}


		public function get_account($project_id, $start_date='', $end_date='')
		{
			$this->db->select('tbl_accounts.id, tbl_accounts.project_id, tbl_accounts.date, tbl_accounts.account_head_id, tbl_accounts.description, tbl_accounts.quantity, tbl_accounts.rate, tbl_accounts.amount, tbl_accounts.status, tbl_account_head.name,tbl_account_head.id as head_id,tbl_account_head.category,tbl_project.name as pname,tbl_project.id as pid');
			$this->db->from('tbl_accounts');
			$this->db->where('tbl_accounts.project_id',$project_id);
			$this->db->join('tbl_project','tbl_accounts.project_id = tbl_project.id', 'left');
			$this->db->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id');

			if($start_date!='' && $end_date!=''){

				$this->db->where('tbl_accounts.date >=',$start_date);
				$this->db->where('tbl_accounts.date <=',$end_date);

			}
			
			$this->db->order_by('tbl_accounts.date', 'asc');
			$this->db->group_by('tbl_accounts.id');
			return	$this->db->get()->result();
				
		}

		public function income_expence_search($income_expance = '',$start_date='', $end_date='')
		{
			$this->db->select('tbl_accounts.id, tbl_accounts.project_id, tbl_accounts.date, tbl_accounts.account_head_id, tbl_accounts.description, tbl_accounts.quantity, tbl_accounts.rate, tbl_accounts.amount, tbl_accounts.status, tbl_account_head.name,tbl_account_head.id as head_id,tbl_account_head.category,tbl_project.name as pname,tbl_project.id as pid');
			$this->db->from('tbl_accounts');

			if ($income_expance!='') {
			$this->db->where('tbl_account_head.category',$income_expance);
			}

			$this->db->join('tbl_project','tbl_accounts.project_id = tbl_project.id', 'left');
			$this->db->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id', 'left');

			if($start_date!='' && $end_date!='') {

				$this->db->where('tbl_accounts.date >=',$start_date);
				$this->db->where('tbl_accounts.date <=',$end_date);

			}
			
			$this->db->group_by('tbl_accounts.id');
			return	$this->db->get()->result();
		}

		public function project_cost_analysis_search($project_id, $account_head_id, $start_date='', $end_date='')
		{
			$this->db->select('tbl_accounts.id, tbl_accounts.project_id, tbl_accounts.date, tbl_accounts.account_head_id, tbl_accounts.description, tbl_accounts.quantity, tbl_accounts.rate, tbl_accounts.amount, tbl_accounts.status,  tbl_accounts.description as account_desc,tbl_account_head.name as hname,tbl_account_head.id as head_id,tbl_account_head.category, tbl_project.id as pid');

			$this->db->join('tbl_project','tbl_accounts.project_id = tbl_project.id', 'left');
			$this->db->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id', 'left');

			$this->db->where('tbl_accounts.project_id', $project_id);
			if($account_head_id > 0) $this->db->where('tbl_accounts.account_head_id', $account_head_id);

			$this->db->from('tbl_accounts');


			if($start_date!='' && $end_date!=''){

				$this->db->where('tbl_accounts.date >=',$start_date);
				$this->db->where('tbl_accounts.date <=',$end_date);

			}
			
			$this->db->group_by('tbl_accounts.date', 'asc');
			$this->db->group_by('tbl_accounts.id');
			return	$this->db->get()->result();
		}
		
		

		public function search_project($accounthead_id, $project_id)
		{
			$this->db->select('tbl_accounts.id, tbl_accounts.project_id, tbl_accounts.date, tbl_accounts.account_head_id, tbl_accounts.description, tbl_accounts.quantity, tbl_accounts.rate, tbl_accounts.amount, tbl_accounts.status, tbl_account_head.name,tbl_account_head.id as head_id, tbl_account_head.category,tbl_project.name as pname');
			$this->db->from('tbl_accounts');
			$this->db->join('tbl_project','tbl_accounts.project_id = tbl_project.id', 'left');
			$this->db->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id', 'left');
			$this->db->where('tbl_accounts.project_id',$project_id);
			$this->db->where('tbl_accounts.account_head_id',$accounthead_id);
			return	$this->db->get()->result();
		}

		public function cash_in_withdraw_join_search($accounthead_id, $withraw_id, $project_id)
		{
			$this->db->select('tbl_accounts.id, tbl_accounts.project_id, tbl_accounts.date, tbl_accounts.account_head_id, tbl_accounts.description, tbl_accounts.quantity, tbl_accounts.rate, tbl_accounts.amount, tbl_accounts.status, tbl_account_head.id as head_id, tbl_account_head.name,tbl_account_head.category,tbl_project.name as pname');
			$this->db->from('tbl_accounts');
			$this->db->join('tbl_project','tbl_accounts.project_id = tbl_project.id', 'left');
			$this->db->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id', 'left');
			$this->db->where('tbl_accounts.project_id',$project_id);
			$this->db->group_start()
                    ->where('tbl_accounts.account_head_id',$accounthead_id)
                    ->or_where('tbl_accounts.account_head_id',$withraw_id)
                    ->group_end();
			$this->db->order_by('tbl_accounts.date', 'asc');
			return	$this->db->get()->result();
		}

		public function todays_income()
		{
			$date = date('Y-m-d');
			$category = 1;
			return $this->db->select('sum(tbl_accounts.amount) as income, tbl_account_head.category')
							->from('tbl_accounts')
							->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id','left')
							->where('DATE(tbl_accounts.date)', $date)
							->where('tbl_account_head.category',$category)
							->group_by('tbl_accounts.id')
							->get()
							->row();

		}

		public function todays_expance()
		{
			$date = date('Y-m-d');
			$category = 0;
			return $this->db->select('sum(tbl_accounts.amount) as expance, tbl_account_head.category')
							->from('tbl_accounts')
							->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id','left')
							->where('DATE(tbl_accounts.date)', $date)
							->where('tbl_account_head.category',$category)
							->group_by('tbl_accounts.id')
							->get()
							->row();
		}

		public function project_income_expense($project_id, $category)
		{

			return $this->db->select('SUM(tbl_accounts.amount) as amount, tbl_account_head.name,tbl_account_head.id')
							->from('tbl_accounts')
							->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id','left')
							->where('tbl_accounts.project_id',$project_id)
							->where('tbl_account_head.category',$category)
							->group_by('tbl_accounts.project_id')
							->group_by('tbl_accounts.account_head_id')
							->get()
							->result();
		}

		public function get_withdrawn_money($project_id, $withdraw_id)
		{

			$tempvar =  $this->db->select('SUM(tbl_accounts.amount) as amount')
							->from('tbl_accounts')
							->where('project_id',$project_id)
							->where('account_head_id',$withdraw_id)
							->group_by('project_id')
							->group_by('account_head_id')
							->get(); 
			if($tempvar->num_rows() > 0) return $tempvar->row()->amount;
			else return 0;
		}

		
		public function previous_accounts($project_id, $last_date, $category)
		{
			return $this->db->select('sum(tbl_accounts.amount) as amount')
							->from('tbl_accounts')
							->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id','left')
							->where('DATE(tbl_accounts.date) < ', $last_date)
							->where('tbl_accounts.project_id', $project_id)
							->where('tbl_account_head.category',$category)
							->get()
							->row();

		}

		public function todays_depostite($project_id,$start_date,$category = 1)
		{
			return $this->db->select('sum(tbl_accounts.amount) as income, tbl_account_head.category')
							->from('tbl_accounts')
							->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id','left')
							->where('DATE(tbl_accounts.date)', $start_date)
							->where('tbl_accounts.project_id', $project_id)
							->where('tbl_account_head.category', $category) 
							->get()
							->row();

		}

		public function todays_all_depostite($project_id,$start_date,$category = 1)
		{
			return $this->db->select('tbl_accounts.amount, tbl_account_head.category,tbl_account_head.name')
							->from('tbl_accounts')
							->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id','left')
							->where('DATE(tbl_accounts.date)', $start_date)
							->where('tbl_accounts.project_id', $project_id)
							->where('tbl_account_head.category', $category) 
							->get()
							->result();

		}

		public function todays_expenditure($project_id, $start_date)
		{
			$this->db->select('tbl_accounts.id, tbl_accounts.project_id, tbl_accounts.date, tbl_accounts.account_head_id, tbl_accounts.description, tbl_accounts.quantity, tbl_accounts.rate, tbl_accounts.amount, tbl_accounts.status, tbl_account_head.name,tbl_account_head.category');
			$this->db->from('tbl_accounts');
			$this->db->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id', 'left');
			$this->db->where('tbl_accounts.project_id',$project_id);
			$this->db->where('DATE(tbl_accounts.date)',$start_date);
			$this->db->where('tbl_account_head.category', 0);
			$this->db->order_by('tbl_accounts.date', 'asc');
			$this->db->group_by('tbl_accounts.id');
			return	$this->db->get()->result();
		}
		
		public function todays_withdraw($project_id, $start_date)
		{
			$this->db->select('tbl_accounts.id, tbl_accounts.project_id, tbl_accounts.date, tbl_accounts.account_head_id, tbl_accounts.description, tbl_accounts.quantity, tbl_accounts.rate, tbl_accounts.amount, tbl_accounts.status, tbl_account_head.name,tbl_account_head.category');
			$this->db->from('tbl_accounts');
			$this->db->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id', 'left');
			$this->db->where('tbl_accounts.project_id',$project_id);
			$this->db->where('DATE(tbl_accounts.date)',$start_date);
			$this->db->where('tbl_account_head.category', 2);
			$this->db->order_by('tbl_accounts.date', 'asc');
			$this->db->group_by('tbl_accounts.id');
			return	$this->db->get()->result();
		}

		public function get_all_report($project_id)
		{
			$this->db->select('tbl_accounts.id, tbl_accounts.project_id, tbl_accounts.date, tbl_accounts.account_head_id, tbl_accounts.description, tbl_accounts.quantity, tbl_accounts.rate, tbl_accounts.amount, tbl_accounts.status, tbl_account_head.name,tbl_account_head.id as head_id,tbl_account_head.category,tbl_project.name as pname,tbl_project.id as pid');
			$this->db->from('tbl_accounts');
			$this->db->where('tbl_accounts.project_id',$project_id);
			$this->db->join('tbl_project','tbl_accounts.project_id = tbl_project.id', 'left');
			$this->db->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id');
			$this->db->order_by('tbl_accounts.date', 'asc');
			$this->db->group_by('tbl_accounts.id');
			return	$this->db->get()->result();
				
		}

		//employee list
		

		public function employee_lists()
		{
			$this->db->select('tbl_employee.id, tbl_employee.name, tbl_employee.priority, tbl_employee.photo, tbl_employee.position, tbl_employee.join_date, tbl_employee.phone_number');

         	$this->db->group_by('tbl_employee.id'); 
         	$this->db->order_by('priority', 'asc');

         	$result = $this->db->get('tbl_employee'); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	}else {

         		return array();

         	} 
		}


		public function updateEmployee($updateEmployee, $param2)
		{
		 if (isset($updateEmployee['photo']) && file_exists($updateEmployee['photo'])) {
	
				$result = $this->db->select('photo')
								   ->from('tbl_employee')
								   ->where('id',$param2)
								   ->get()
								   ->row()->photo;

				if (file_exists($result)) {
				    unlink($result);
				}  
		 }
	
		 return $this->db->where('id',$param2)->update('tbl_employee',$updateEmployee);
		}
	
		public function delete_employee($param2)
		{
			$result = $this->db->select('photo')
							   ->from('tbl_employee')
							   ->where('id',$param2)
							   ->get()
							   ->row()->photo;

			if (file_exists($result)) {
			   unlink($result);
			}   
	
			return $this->db->where('id',$param2)->delete('tbl_employee'); 
		}

	//cow type update
	public function update_cow_type($updateData, $param2)
	{
	 
		return $this->db->where('id',$param2)->update('tbl_cow_type',$updateData);
	}

	//cow type delete
	public function delete_cow_type($param2)
	{
		
		return $this->db->where('id',$param2)->delete('tbl_cow_type'); 
	}

	//cow details search list
	public function get_cow_details_list($data)
	{
		$this->db->select('tbl_cow_details.id, tbl_cow_details.cow_no, tbl_cow_details.start_date, tbl_cow_details.purchase_cost,tbl_cow_details.color, tbl_cow_details.is_sold, tbl_cow_type.name')

         		
         		->from('tbl_cow_details')
         		->join('tbl_cow_type', 'tbl_cow_type.id = tbl_cow_details.cow_type_id', 'left')
         		->order_by('tbl_cow_details.cow_no', 'desc')
         		->group_by('tbl_cow_details.id');

         	if(($data['cow_no']) != ''){

				$this->db->where('tbl_cow_details.cow_no', $data['cow_no']);
			}

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	}else {

         		return array();

         	}
	}

	//cow details data by id
	public function get_cow_details_data($param2)
	{

		$this->db->select('tbl_cow_details.id, tbl_cow_details.cow_no, tbl_cow_details.start_date, tbl_cow_details.purchase_cost, tbl_cow_details.color, tbl_cow_details.is_sold,tbl_cow_details.is_death, tbl_cow_details.target_sale_cost, tbl_cow_details.cow_type_id, tbl_cow_type.name')

         		
         		->from('tbl_cow_details')
         		->join('tbl_cow_type', 'tbl_cow_type.id = tbl_cow_details.cow_type_id', 'left')
         		->where('tbl_cow_details.id', $param2);

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->row();

         	}else {

         		return array();

         	}
		
	}

	//cow details data update
	public function update_cow_details($updateData, $param2)
	{
	 
		return $this->db->where('id',$param2)->update('tbl_cow_details',$updateData);
	}

	//cow details delete
	public function delete_cow_details($param2)
	{
		
		return $this->db->where('id',$param2)->delete('tbl_cow_details'); 
	}

	//cow feeds update
	public function update_cow_feeds($updateData, $param2)
	{
	 
		return $this->db->where('id',$param2)->update('tbl_cow_feeds',$updateData);
	}

	//cow feeds delete
	public function delete_cow_feeds($param2)
	{
		
		return $this->db->where('id',$param2)->delete('tbl_cow_feeds'); 
	}

	//cow health test list
	public function get_cow_health_test_list($data)
	{
		$this->db->select('tbl_cow_health_test.id, tbl_cow_health_test.height, tbl_cow_health_test.width,tbl_cow_health_test.weight, tbl_cow_health_test.health_test_date, tbl_cow_details.cow_no')

         		->group_by('tbl_cow_health_test.id')
         		->order_by('tbl_cow_details.cow_no', 'DESC')
         		->from('tbl_cow_health_test')
         		->join('tbl_cow_details', 'tbl_cow_details.id = tbl_cow_health_test.cow_details_id', 'left');

         	if(($data['cow_no']) != ''){

				$this->db->where('tbl_cow_details.cow_no', $data['cow_no']);
			}

			if(($data['health_test_date']) != ''){

				$this->db->where('tbl_cow_health_test.health_test_date', $data['health_test_date']);
			}

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	}else {

         		return array();

         	}
	}

	//cow health test update
	public function update_cow_health_test($updateData, $param2)
	{
	 
		return $this->db->where('id',$param2)->update('tbl_cow_health_test',$updateData);
	}

	//cow health test delete
	public function delete_cow_health_test($param2)
	{
		
		return $this->db->where('id',$param2)->delete('tbl_cow_health_test'); 
	}

	//cow health test list
	public function get_cow_milk_collection_list($data)
	{
		$this->db->select('tbl_cow_milk_collection.id, tbl_cow_milk_collection.collection_date, tbl_cow_milk_collection.collection_amount, tbl_cow_details.cow_no, user.username, tbl_cow_milk_target.milk_target')

         		
         		->from('tbl_cow_milk_collection')
         		->join('user', 'user.id = tbl_cow_milk_collection.collection_by', 'left')
         		->join('tbl_cow_milk_target', 'tbl_cow_milk_target.cow_details_id = tbl_cow_milk_collection.cow_details_id', 'left')
         		->join('tbl_cow_details', 'tbl_cow_details.id = tbl_cow_milk_collection.cow_details_id', 'left')
         		->order_by('tbl_cow_details.cow_no', 'DESC')
         		->group_by('tbl_cow_milk_collection.id');

         	if(($data['cow_no']) != ''){

				$this->db->where('tbl_cow_details.cow_no', $data['cow_no']);
			}

			if(($data['collection_date']) != ''){

				$this->db->where('tbl_cow_milk_collection.collection_date', $data['collection_date']);
			}

			if(($data['collection_by']) != ''){

				$this->db->where('tbl_cow_milk_collection.collection_by', $data['collection_by']);
			}

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	} else {

         		return array();

         	}
	}

	//update cow pregnancy data
	public function update_cow_milk_collection($updateData, $param2)
	{
	 
		return $this->db->where('id',$param2)->update('tbl_cow_milk_collection',$updateData);
	}

	//delete cow milk collection
	public function delete_cow_milk_collection($param2)
	{
		
		return $this->db->where('id',$param2)->delete('tbl_cow_milk_collection'); 
	}

	//cow milk target list
	public function get_cow_milk_target_list($data)
	{
		$this->db->select('tbl_cow_milk_target.id, tbl_cow_milk_target.milk_target, tbl_cow_milk_target.start_date, tbl_cow_details.cow_no')

         		->from('tbl_cow_milk_target')
         		->join('tbl_cow_details', 'tbl_cow_details.id = tbl_cow_milk_target.cow_details_id', 'left')
         		->order_by('tbl_cow_milk_target.start_date', 'DESC')
         		->group_by('tbl_cow_milk_target.id');

         	if(($data['cow_no']) != ''){

				$this->db->where('tbl_cow_details.cow_no', $data['cow_no']);
			}

			if(($data['start_date']) != ''){

				$this->db->where('tbl_cow_milk_target.start_date', $data['start_date']);
			}

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	} else {

         		return array();

         	}
	}

	//cow details list all target for milk collection add
	public function get_target()
	{

		$today = date("Y-m-d");
		$this->db->select('tbl_cow_details.id, tbl_cow_details.cow_no, tbl_cow_milk_target.milk_target, tbl_cow_milk_target.start_date')

				->from('tbl_cow_details') 
         		->join('tbl_cow_milk_target', 'tbl_cow_details.id = tbl_cow_milk_target.cow_details_id ', 'left')
         		->order_by('tbl_cow_details.cow_no', 'desc')
         		->order_by('tbl_cow_milk_target.start_date', 'desc')
         		->where('tbl_cow_milk_target.start_date >=', $today)
         		->group_by('tbl_cow_details.id');

     	$result = $this->db->get(); 

     	if($result->num_rows() > 0){

     		return $result->result();


     	} else {

     		return array();

     	}
		
	}

	//cow details list all target for milk collection add
	public function get_total_target()
	{

		$today = date("Y-m-d");
		$this->db->select('tbl_cow_milk_target.milk_target')

				->from('tbl_cow_details') 
         		->join('tbl_cow_milk_target', 'tbl_cow_details.id = tbl_cow_milk_target.cow_details_id ', 'left')
         		->order_by('tbl_cow_details.cow_no', 'desc')
         		->order_by('tbl_cow_milk_target.start_date', 'desc')
         		->where('tbl_cow_milk_target.start_date >=', $today)
         		->group_by('tbl_cow_details.cow_no');

     	$result = $this->db->get(); 

     	if($result->num_rows() > 0){

     		return $result->result();


     	} else {

     		return array();

     	}
		
	}

	//update cow milk target data
	public function update_cow_milk_target($updateData, $param2)
	{
	 
		return $this->db->where('id',$param2)->update('tbl_cow_milk_target',$updateData);
	}

	//delete cow milk target delete
	public function delete_cow_milk_target($param2)
	{
		
		return $this->db->where('id',$param2)->delete('tbl_cow_milk_target'); 
	}

	//get pregnancy data list
	public function get_cow_pregnancy_list($data)
	{
		$this->db->select('tbl_cow_pregnancy.id, tbl_cow_pregnancy.semens_push_date, tbl_cow_pregnancy.pregnancy_start_date,tbl_cow_pregnancy.approximate_delivery_date, tbl_cow_pregnancy.is_success, tbl_cow_pregnancy.baby_cow_no, tbl_cow_pregnancy.notes, tbl_cow_details.cow_no')

         		->group_by('tbl_cow_pregnancy.id')
         		->from('tbl_cow_pregnancy')
         		->join('tbl_cow_details', 'tbl_cow_details.id = tbl_cow_pregnancy.cow_details_id', 'left');

         	if(($data['cow_no']) != ''){

				$this->db->where('tbl_cow_details.cow_no', $data['cow_no']);
			}

			if(($data['semens_push_date']) != ''){

				$this->db->where('tbl_cow_pregnancy.semens_push_date', $data['semens_push_date']);
			}

			if(($data['pregnancy_start_date']) != ''){

				$this->db->where('tbl_cow_pregnancy.pregnancy_start_date', $data['pregnancy_start_date']);
			}

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	} else {

         		return array();

         	}
	}

	//update cow pregnancy data
	public function update_cow_pregnancy($updateData, $param2)
	{
	 
		return $this->db->where('id',$param2)->update('tbl_cow_pregnancy',$updateData);
	}

	//delete cow pregnancy
	public function delete_cow_pregnancy($param2)
	{
		
		return $this->db->where('id',$param2)->delete('tbl_cow_pregnancy'); 
	}

	public function update_vaccine($updateData, $param2)
	{
	 
		return $this->db->where('id',$param2)->update('tbl_vaccine_list',$updateData);
	}

	public function delete_vaccine($param2)
	{
		
		return $this->db->where('id',$param2)->delete('tbl_vaccine_list'); 
	}


	public function get_cow_vaccine_list($data)
	{
		$this->db->select('tbl_cow_vaccine.id, tbl_cow_vaccine.push_date, tbl_cow_vaccine.next_push_date, tbl_cow_vaccine.notes, tbl_cow_vaccine.vaccine_id, tbl_cow_details.cow_no, tbl_vaccine_list.name AS vaccine_name')

         		
         		->from('tbl_cow_vaccine')
         		->join('tbl_cow_details', 'tbl_cow_details.id = tbl_cow_vaccine.cow_details_id', 'left')
         		->join('tbl_vaccine_list', 'tbl_vaccine_list.id = tbl_cow_vaccine.vaccine_id', 'left')
         		->order_by('tbl_cow_vaccine.push_date', 'DESC')
         		->group_by('tbl_cow_vaccine.id');

         	if(($data['cow_no']) != ''){

				$this->db->where('tbl_cow_details.cow_no', $data['cow_no']);
			}

			if(($data['push_date']) != ''){

				$this->db->where('tbl_cow_vaccine.push_date', $data['push_date']);
			}

			if(($data['next_push_date']) != ''){

				$this->db->where('tbl_cow_vaccine.next_push_date', $data['next_push_date']);
			}

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	} else {

         		return array();

         	}
	}

	public function get_single_cow_vaccine_list($id)
	{
		$this->db->select('tbl_cow_vaccine.id, tbl_cow_vaccine.push_date, tbl_cow_vaccine.next_push_date, tbl_cow_vaccine.notes, tbl_cow_vaccine.vaccine_id, tbl_vaccine_list.name AS vaccine_name')

         		
         		->from('tbl_cow_vaccine')
         		
         		->join('tbl_vaccine_list', 'tbl_vaccine_list.id = tbl_cow_vaccine.vaccine_id', 'left')
         		->where('tbl_cow_vaccine.cow_details_id', $id)
         		->order_by('tbl_cow_vaccine.push_date', 'DESC')
         		->group_by('tbl_cow_vaccine.id');

         	

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	} else {

         		return array();

         	}
	}



	public function update_cow_vaccine($updateData, $param2)
	{
	 
		return $this->db->where('id',$param2)->update('tbl_cow_vaccine',$updateData);
	}

	public function delete_cow_vaccine($param2)
	{
		
		return $this->db->where('id',$param2)->delete('tbl_cow_vaccine'); 
	}

	public function get_authors($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get('authors');

        return $query->result();
    }

    public function upcoming_vaccine_list()
    {

    	$today = date("Y-m-d");
    	
    	$this->db->select('tbl_cow_vaccine.id, tbl_cow_vaccine.next_push_date, tbl_cow_vaccine.notes, tbl_cow_vaccine.vaccine_id, tbl_vaccine_list.name AS vaccine_name, tbl_cow_details.cow_no, tbl_cow_details.id')

         		->limit('50')
         		->from('tbl_cow_vaccine')
         		->join('tbl_vaccine_list', 'tbl_vaccine_list.id = tbl_cow_vaccine.vaccine_id', 'left')
         		->join('tbl_cow_details', 'tbl_cow_details.id = tbl_cow_vaccine.cow_details_id', 'left')
         		->where('tbl_cow_vaccine.next_push_date >=', $today)
         		->order_by('tbl_cow_vaccine.next_push_date', 'DESC')
         		->group_by('tbl_cow_vaccine.id');

         	

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	} else {

         		return array();

         	}

    }

    public function get_cash_in_list()
    {

    	$this->db->select('tbl_accounts.id, tbl_accounts.date, tbl_accounts.description, tbl_accounts.amount, tbl_account_head.name')

         		->limit('50')
         		->from('tbl_accounts')
         		->join('tbl_account_head', 'tbl_account_head.id = tbl_accounts.account_head_id', 'left')
         		->where('tbl_account_head.category =', '1')
         		->order_by('tbl_accounts.date', 'DESC')
         		->group_by('tbl_accounts.id');

         	

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	} else {

         		return array();

         	}
    	
    }

    public function get_expense_list()
    {

    	$this->db->select('tbl_accounts.id, tbl_accounts.date, tbl_accounts.description, tbl_accounts.amount, tbl_account_head.name')

         		->limit('50')
         		->from('tbl_accounts')
         		->join('tbl_account_head', 'tbl_account_head.id = tbl_accounts.account_head_id', 'left')
         		->where('tbl_account_head.category !=', '1')
         		->order_by('tbl_accounts.date', 'DESC')
         		->group_by('tbl_accounts.id');

         	

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	} else {

         		return array();

         	}
    	
    }

    public function all_accounts_list($limit, $start)
	{
			$this->db->select('tbl_accounts.id, tbl_accounts.project_id, tbl_accounts.date, tbl_accounts.account_head_id, tbl_accounts.description, tbl_accounts.quantity, tbl_accounts.rate, tbl_accounts.amount, tbl_accounts.status, tbl_project.name AS pname, tbl_account_head.name AS hname, tbl_account_head.id as head_id,tbl_project.id as pid')
			
				->limit($limit, $start)
				->from('tbl_accounts')
				->join('tbl_project','tbl_accounts.project_id = tbl_project.id','left')
				->join('tbl_account_head','tbl_accounts.account_head_id = tbl_account_head.id','left')
				->group_by('tbl_accounts.id')
				->order_by('id','desc');

			

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	}else {

         		return array();

         	}
		}

		//12.04.2021
		public function salary_list($limit, $start)
		{

			$this->db->select('tbl_salary.id, tbl_salary.day, tbl_salary.month, tbl_salary.year, tbl_salary.amount, tbl_employee.name AS employee_name')

         		->limit($limit, $start)
         		->from('tbl_salary')
         		->join('tbl_employee', 'tbl_employee.id = tbl_salary.employee_id', 'left')
       
         		->order_by('tbl_salary.id', 'DESC')
         		->group_by('tbl_salary.id');

         	$result = $this->db->get(); 

         	if($result->num_rows() > 0){
         		
         		return $result->result();

         	}else {

         		return array();

         	}
			
		}

		public function updateSalary($update_salary_data, $param2)
		{
		 
			return $this->db->where('id',$param2)->update('tbl_salary',$update_salary_data);
		}

		public function delete_salary($param2)
		{
			
			return $this->db->where('id',$param2)->delete('tbl_salary'); 
		}


		

	}
	
?>

