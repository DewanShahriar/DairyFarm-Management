<?php 

 ?>

<section class="content">
	

	<div class="row">
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	        <!-- Horizontal Form -->
	        <div class="box box-info">
	            <div class="box-header with-border">
	                <h3 class="box-title">User Profile</h3>
	            </div>
	            <!-- /.box-header -->
	            <!-- form start -->
	            <form action="<?php echo base_url().$_SESSION['userType'].'/profile';?>" method="post" enctype="multipart/form-data" class="form-horizontal">
	                <div class="box-body">
		                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		                    <div class="form-group">
		                        <label class="col-sm-2 control-label">Name</label>
		                        <div class="col-sm-10">
		                            <p class="form-control"> <?php echo $user_info->firstname ." " . $user_info->lastname ;?> </p>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-sm-2 control-label">Email</label>
		                        <div class="col-sm-10">
		                            <p class="form-control"> <?php echo $user_info->email;?> </p>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-sm-2 control-label">Username</label>
		                        <div class="col-sm-10">
		                            <p class="form-control"> <?php echo $user_info->username ;?> </p>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-sm-2 control-label">User Type</label>
		                        <div class="col-sm-10">
		                            <p class="form-control"> <?php echo $user_info->userType ;?> </p>
		                        </div>
		                    </div>
		                </div>
		                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		                    <div class="form-group">
		                        <label class="col-sm-2 control-label">Address</label>
		                        <div class="col-sm-10">
		                            <p class="form-control"> <?php
		                            	
		                            	echo $user_info->roadHouse;
		                            	echo ", ".$this->db->get_where('tbl_upozilla',array('id'=>$user_info->address))->row()->name; 
		                            	echo ", ".$this->db->get_where('tbl_zilla',array('id'=>$this->db->get_where('tbl_upozilla',array('id'=>$user_info->address))->row()->zilla_id))->row()->name;
		                            	echo ", ".$this->db->get_where('tbl_divission',array('id'=>$this->db->get_where('tbl_upozilla',array('id'=>$user_info->address))->row()->division_id))->row()->name; 
		                             ?> </p>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-sm-2 control-label" style="color: red;">OLD Password</label>
		                        <div class="col-sm-10">
		                            <input type="password" class="form-control" name="old_password" placeholder="old password">
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-sm-2 control-label" style="color: red;">New Password</label>
		                        <div class="col-sm-10">
		                            <input type="password" class="form-control" name="new_password" placeholder="new password">
		                        </div>
		                    </div>
		                    <div class="form-group">
			                  	<label class="col-sm-2 control-label">Photo Change</label>
		                        <div class="col-sm-10">
		                        	<img src="<?php echo base_url().$user_info->photo;?>" width="100">
		                            <input name="userphoto" type="file" accept="image/*">
		                        </div>			                  	
			                </div>
		                </div>
		                <input type="hidden" name="user_id" value="<?php echo $user_info->id;?>">
	                </div>
	                <!-- /.box-body -->
	                <div class="box-footer">
	                    <button type="reset" class="btn btn-default">Cancel</button>
	                    <button type="submit" class="btn btn-primary pull-right">Update</button>
	                </div>
	                <!-- /.box-footer -->
	            </form>
	        </div>
	        <!-- /.box -->
	    </div>

	</div>
	<!-- /.row -->


</section>