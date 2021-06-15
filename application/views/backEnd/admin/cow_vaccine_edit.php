<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('cow_vaccine_edit'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/cow-vaccine/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('cow_vaccine_list'); ?>  </a>
                    </div>
                </div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <form action="<?php echo base_url("admin/cow-vaccine/edit/".$edit_info->id);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('push_date'); ?>*</label>
                                            <input name="push_date" placeholder="<?php echo $this->lang->line('push_date'); ?> " class="form-control inner_shadow_primary date"  type="text" value="<?php if($edit_info->push_date ) echo date("d M Y ", strtotime($edit_info->push_date)) ?>" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('next_push_date'); ?>*</label>
                                            <input name="next_push_date" placeholder="<?php echo $this->lang->line('next_push_date'); ?> " class="form-control inner_shadow_primary date"  type="text" value="<?php if($edit_info->next_push_date ) echo date("d M Y ", strtotime($edit_info->next_push_date)) ?>" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('cow_no'); ?>*</label>
                                            <select class="form-control inner_shadow_primary select2" name="cow_details_id">
                                                <option value=""><?php echo $this->lang->line('select_cow_number'); ?></option>
                                                <?php foreach($cow_details_list as $list){ ?>
                                                <option value="<?php echo $list->id;?>" <?php if ($edit_info->cow_details_id == $list->id) echo 'selected' ; ?>><?php echo $list->cow_no;?></option>
                                                
            

                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('vaccine_name'); ?></label>
                                            <select class="form-control inner_shadow_primary select2" name="vaccine_id" style="width:100%;">
                                                            <option value=""><?php echo $this->lang->line('select_vaccine_name'); ?></option>
                                                            <?php foreach($vaccine_list as $list){?>
                                                            <option value="<?php echo $list->id?>" <?php if ($edit_info->vaccine_id == $list->id) echo 'selected' ; ?>><?php echo $list->name; ?></option>
                                                            <?php }?>
                                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('notes'); ?></label>
                                            <input name="notes" placeholder="<?php echo $this->lang->line('notes'); ?> " class="form-control inner_shadow_primary" value="<?php echo $edit_info->notes; ?>"  type="text">
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

