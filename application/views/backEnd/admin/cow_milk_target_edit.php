<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('cow_milk_target_edit'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/cow-milk-target/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('cow_milk_target_list'); ?>  </a>
                    </div>
                </div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <form action="<?php echo base_url("admin/cow-milk-target/edit/".$edit_info->id);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('milk_start_date'); ?>*</label>
                                            <input name="start_date" placeholder="<?php echo $this->lang->line('milk_start_date'); ?> " class="form-control inner_shadow_info date"  type="text" value="<?php if($edit_info->start_date ) echo date("d M Y ", strtotime($edit_info->start_date))?>" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('cow_no'); ?>*</label>
                                            <select class="form-control inner_shadow_info select2" name="cow_details_id">
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
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('milk_target'); ?>*</label>
                                            <input name="milk_target" placeholder="<?php echo $this->lang->line('milk_target'); ?> " class="form-control inner_shadow_info" value="<?php echo $edit_info->milk_target; ?>" type="text" required autocomplete="off">
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

