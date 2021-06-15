

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('project_list'); ?></h3>
                    <div class="box-tools pull-right">
                        <button data-toggle="modal" data-target="#modal-add-project" class="btn bg-maroon btn-sm"> <i class="fa fa-plus"> </i> <?php echo $this->lang->line('add_project'); ?></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_primary" >
                        <thead>
                            <tr>
                                <th width="5%"><?php echo $this->lang->line('sl'); ?></th>
                                <th width="40%"><?php echo $this->lang->line('name'); ?></th>
                                <th width="30%"><?php echo $this->lang->line('address'); ?></th>
                                
                                <th width="15%"><?php echo $this->lang->line('project_start_date'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sl = 1;
                                foreach ($projects as $value) {
                                	?>
                            <tr>
                                <td> <?php echo $sl++ ; ?> </td>
                                <td> <?php echo $value->name; ?> </td>
                                <td> <?php echo $value->address;?></td>
                                
                                <td> <?php echo date("d M Y", strtotime($value->project_start_date)); ?> </td>
                                <td> 
                                    <a href="#" data-toggle="modal" data-target="#modal-edit-project" data-projectid="<?= $value->id; ?>" data-projectname="<?= $value->name; ?>" data-projectdate="<?= $value->project_start_date; ?>" data-projectadd="<?= $value->address; ?>" data-projectremark="<?= $value->remark; ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>

                                    <a href="<?php echo base_url('admin/projects/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>

                                    
                                </td>
                            </tr>
                            <?php
                                }
                                ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- add modal -->
    <div class="modal fade" id="modal-add-project" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    <h4 class="modal-title"><?php echo $this->lang->line('new_projects'); ?></h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url() ?>admin/projects/add" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row" style="box-shadow: 1px 1px 5px 1px #605CA8; margin: 0px 20px 20px 20px; padding: 25px 0px 15px 0px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-12"><?php echo $this->lang->line('start_date'); ?></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="project_start_date" id="start_date" class="form-control inner_shadow_primary" required="" placeholder="<?php echo $this->lang->line('start_date'); ?>" autocomplete="off" onkeypress="return false;" value="<?= date('d-m-Y'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="col-sm-12"><?php echo $this->lang->line('station_name'); ?></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="name" class="form-control inner_shadow_primary" placeholder="<?php echo $this->lang->line('station_name'); ?>" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-12"><?php echo $this->lang->line('address'); ?></label>
                                    <div class="col-sm-12">
                                        <textarea name="address" class="form-control inner_shadow_primary" cols="25" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-12"><?php echo $this->lang->line('remark'); ?></label>
                                    <div class="col-sm-12">
                                        <textarea name="remark" class="form-control inner_shadow_primary" cols="25" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <center>
                                    <button type="submit" class="btn btn-success"><?php echo $this->lang->line('save') ?></button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- edit modal -->
    <div class="modal fade" id="modal-edit-project" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    <h4 class="modal-title"><?php echo $this->lang->line('update_projects'); ?></h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url() ?>admin/projects/edit" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row" style="box-shadow: 1px 1px 5px 1px #605CA8; margin: 0px 20px 20px 20px; padding: 25px 0px 15px 0px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-12"><?php echo $this->lang->line('start_date'); ?></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="project_start_date" id="date" class="form-control inner_shadow_primary" required="" placeholder="<?php echo $this->lang->line('start_date'); ?>" autocomplete="off" onkeypress="return false;" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="col-sm-12"><?php echo $this->lang->line('station_name'); ?></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="name" class="form-control inner_shadow_primary" placeholder="<?php echo $this->lang->line('station_name'); ?>" required="" id="pname">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-12"><?php echo $this->lang->line('address'); ?></label>
                                    <div class="col-sm-12">
                                        <textarea name="address" class="form-control inner_shadow_primary" cols="25" rows="2" id="padd"></textarea>
                                        <input type="hidden" name="project_id" id="pid">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="remark" class="col-sm-12"> <?php echo $this->lang->line('remark'); ?> </label>
                                    <div class="col-sm-12">
                                        <textarea type="text" name="remark" class="form-control inner_shadow_primary" placeholder="<?php echo $this->lang->line('remark'); ?>" rows="2" id="premark"> textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <center>
                                <button type="submit" class="btn btn-success"><?php echo $this->lang->line('update') ?></button>
                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modal-status-change -->
    <div class="modal fade" id="modal-status-change" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    <h4 class="modal-title"><?php echo $this->lang->line('project_note'); ?></h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url() ?>admin/projects/statuschange" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row" style="box-shadow: 1px 1px 5px 1px #605CA8; margin: 0px 20px 20px 20px; padding: 25px 0px 15px 0px;">
                            <input type="hidden" name="project_note_id" id="project_note_id">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project_status" class="col-sm-12"> <?php echo $this->lang->line('project_status'); ?> </label>
                                    <div class="col-sm-12">
                                        <label>
                                            <input type="radio" name="project_status" id="pstatus1" value="1"> 
                                            Completed 
                                        </label>
                                        <label>
                                            <input type="radio" name="project_status" id="pstatus2" value="2"> 
                                            Failed 
                                        </label>
                                        <label>
                                            <input type="radio" name="project_status" id="pstatus0" value="0"> 
                                          Running 
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="remark" class="col-sm-12"> <?php echo $this->lang->line('remark'); ?> </label>
                                    <div class="col-sm-12">
                                        <textarea name="remark_status" class="form-control inner_shadow_primary" placeholder="<?php echo $this->lang->line('remark'); ?>" id="remark_status"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <center>
                                <button type="submit" class="btn btn-success"><?php echo $this->lang->line('update') ?></button>
                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(function () {
      $("#userListTable").DataTable();
    });
    
</script>
<script>
    $(function () {
    	$('#start_date,#date').datepicker({
    		autoclose: true,
    		changeYear:true,
    		changeMonth:true,
    		dateFormat: "dd-mm-yy",
    		yearRange: "-100:+0"
    	});
    });
    
    
    $(".numberconvert").keypress(function(event){
        var ew = event.which;
        
        if(ew == 32) return true;
        if(48 <= ew && ew <= 57) return true;
        if(2534 <= ew && ew <= 2543){
            return false;
        }
        if(97 <= ew && ew <= 122) return false;
        
        //return false;
        
    });
    

</script>
<script type="text/javascript">
    $('#modal-edit-project').on("show.bs.modal", function(event){
    
    	var e              = $(event.relatedTarget);
    	var projectid      = e.data('projectid');
    	var projectname    = e.data('projectname');
    	var projectbudget  = e.data('projectbudget');
    	var projectcost    = e.data('projectcost');
    	var projectdate    = e.data('projectdate');
    	var projectdes     = e.data('projectdes');
        var projectadd     = e.data('projectadd');
        var projectpackage = e.data('projectpackage');
    	var project_id     = e.data('project_gov_id');
    	var projectremark  = e.data('projectremark');
    
    	$("#pid").val(projectid);
    	$("#pname").val(projectname);
    	$("#pbudget").val(projectbudget); 
    	$("#pcost").val(projectcost);
    	$("#date").val(projectdate); 
    	$("#pdes").val(projectdes);
        $("#padd").val(projectadd); 
        $("#ppac").val(projectpackage); 
    	$("#pp_id").val(project_id); 
    	$("#premark").val(projectremark); 
    
    });
</script>

<script type="text/javascript">
    $('#modal-status-change').on("show.bs.modal", function(event){
    
    	var e                   = $(event.relatedTarget);
    	var project_note_id     = e.data('project_note_id');
    	var remark_status       = e.data('remark_status'); 
    	var project_completed   = e.data('project_completed'); 
    	
    
    	$("#project_note_id").val(project_note_id);
    	$("#remark_status").val(remark_status);
    	
    	
    	if(project_completed == 1) $("#pstatus1").attr('checked', true);
    	if(project_completed == 2) $("#pstatus2").attr('checked', true);
    	if(project_completed == 0) $("#pstatus0").attr('checked', true);
    	
    	//$("#pstatus1").addClass( "flat-red" );
    	//$("#pstatus2").addClass( "flat-red" );
    	//$("#pstatus0").addClass( "flat-red" );
    
    });
</script>

<script>
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
    
</script>

