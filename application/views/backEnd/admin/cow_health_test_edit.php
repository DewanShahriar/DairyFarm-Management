<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('cow_health_test_edit'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/cow-health-test/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('cow_health_test_list'); ?>  </a>
                    </div>
                </div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <form action="<?php echo base_url("admin/cow-health-test/edit/".$edit_info->id);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('cow_no'); ?>*</label>
                                            <select class="form-control inner_shadow_teal select2" name="cow_details_id" style="width: 100%;">
                                                <option value=""><?php echo $this->lang->line('select_cow_number'); ?></option>
                                                <?php foreach($cow_details_list as $list){ if($edit_info->cow_details_id == $list->id){?>
                                                <option value="<?php echo $list->id;?>" selected><?php echo $list->cow_no;?></option>
                                                <?php }else{?>
                                                <option value="<?php echo $list->id;?>"><?php echo $list->cow_no;?></option>

                                                <?php } }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <br>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('health_test_date'); ?></label>
                                            <input name="health_test_date" placeholder="<?php echo $this->lang->line('health_test_date'); ?> " class="form-control inner_shadow_teal date"  type="text" autocomplete="off" value="<?php if($edit_info->health_test_date ) echo date("d M Y ", strtotime($edit_info->health_test_date)) ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('height'); ?>*</label>
                                            <input name="height" placeholder="<?php echo $this->lang->line('height'); ?> " class="form-control inner_shadow_teal"  type="text" required value="<?php echo $edit_info->height?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('width'); ?>*</label>
                                            <input name="width" placeholder="<?php echo $this->lang->line('width'); ?> " class="form-control inner_shadow_teal"  type="text" required value="<?php echo $edit_info->width?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('weight'); ?>*</label>
                                            <input name="weight" placeholder="<?php echo $this->lang->line('weight'); ?> " class="form-control inner_shadow_teal"  type="text" required value="<?php echo $edit_info->weight?>">
                                        </div>
                                    </div>
                                </div>   
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('update'); ?></button>
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

