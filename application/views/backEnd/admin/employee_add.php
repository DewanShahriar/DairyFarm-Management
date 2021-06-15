<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('employee_add'); ?>  </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/employee/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('employee_list'); ?>  </a>
                    </div>
                </div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <form action="<?php echo base_url("admin/employee/add");?>" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <div class="col-md-9">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('employee_name'); ?> </label>
                                            <input name="name" placeholder="<?php echo $this->lang->line('employee_name'); ?> " class="form-control inner_shadow_info"  type="text" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('employee_number'); ?> </label>
                                            <input name="phone_number" placeholder="<?php echo $this->lang->line('employee_number'); ?> " class="form-control inner_shadow_info"  type="text" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('employee_password'); ?> </label>
                                            <input name="password" placeholder="<?php echo $this->lang->line('employee_password'); ?> " class="form-control inner_shadow_info"  type="text" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('position'); ?> </label>
                                            <input name="position" placeholder="<?php echo $this->lang->line('position'); ?> " class="form-control inner_shadow_info"  type="text" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('join_date'); ?> </label>
                                            <input name="join_date" placeholder="<?php echo $this->lang->line('join_date'); ?> " class="form-control inner_shadow_info date"  type="text" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('expire_date'); ?> </label>
                                            <input name="expire_date" placeholder="<?php echo $this->lang->line('expire_date'); ?> " class="form-control inner_shadow_info date"  type="text" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('active'); ?> </label>
                                            <select name="active" class="form-control inner_shadow_info select2" required style="width: 100%;">
                                                <option value=""><?php echo $this->lang->line('select_one'); ?></option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                                option
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('priority'); ?> </label>
                                            <input name="priority" placeholder="<?php echo $this->lang->line('priority'); ?> " class="form-control inner_shadow_info"  type="text" required autocomplete="off"> 
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="col-md-3">
                                <!-- Profile Image -->
                                <div class="box box-info box-solid">
                                    <div class="box-header"> <label><?php echo $this->lang->line('employee_photo'); ?></label> </div>
                                    <div class="box-body box-profile">
                                        <center>
                                            <img id="employee_picture_change" class="img-responsive" src="//placehold.it/400x400" alt="profile picture" style="max-width: 120px;"><small style="color: gray">width : 400px, Height : 400px</small>
                                            <br>
                                            <input type="file" name="photo" onchange="readpicture(this);">
                                        </center>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>

                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('save'); ?></button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
</section>
<script>
    // profile picture change
    function readpicture(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
    
          reader.onload = function (e) {
            $('#employee_picture_change')
            .attr('src', e.target.result)
            .width(100)
            .height(100);
        };
    
        reader.readAsDataURL(input.files[0]);
    }
    }
    
</script>

<script>
    $(function(){
    
        $('.date').datepicker({
            autoclose: true,
            changeYear:true,
            changeMonth:true,
            dateFormat: "dd-mm-yy",
            yearRange: "-10:+10"
        });

        $('.timepicker').timepicker({
            showInputs: false
        });

    });
</script>

