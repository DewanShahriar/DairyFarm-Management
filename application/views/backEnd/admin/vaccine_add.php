<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('vaccine_add'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/vaccine/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('vaccine_list'); ?>  </a>
                    </div>
                </div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <form action="<?php echo base_url("admin/vaccine/add");?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('vaccine_name'); ?>*</label>
                                            <input name="name" placeholder="<?php echo $this->lang->line('vaccine_name'); ?> " class="form-control inner_shadow_orange"  type="text" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('vaccine_type'); ?>*</label>
                                          <select class="form-control inner_shadow_primary select2" name="type" required="" style="width: 100%;">
                                             <option value=""><?php echo $this->lang->line('select_vaccine_type'); ?></option>
                                             
                                             <option value="0"><?php echo $this->lang->line('monthly'); ?></option>
                                             <option value="1"><?php echo $this->lang->line('yearly'); ?></option>
                                             <option value="2"><?php echo $this->lang->line('ondemand'); ?></option>
                                             <option value="3"><?php echo $this->lang->line('other'); ?></option>
                                          </select>
                                        </div>
                                    </div>
                                </div>
                                   
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-teal"><?php echo $this->lang->line('save'); ?></button>
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

