<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('cow_pregnancy_add'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/cow-pregnancy/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('cow_pregnancy_list'); ?>  </a>
                    </div>
                </div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <form action="<?php echo base_url("admin/cow-pregnancy/add");?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('semens_push_date'); ?>*</label>
                                            <input name="semens_push_date" placeholder="<?php echo $this->lang->line('semens_push_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('pregnancy_start_date'); ?>*</label>
                                            <input name="pregnancy_start_date" placeholder="<?php echo $this->lang->line('pregnancy_start_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('approximate_delivery_date'); ?></label>
                                            <input name="approximate_delivery_date" placeholder="<?php echo $this->lang->line('approximate_delivery_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('cow_no'); ?>*</label>
                                            <select class="form-control inner_shadow_primary select2" name="cow_details_id" style="width: 100%;">
                                                <option value=""><?php echo $this->lang->line('select_cow_number'); ?></option>
                                                <?php foreach($cow_details_list as $list){?>
                                                <option value="<?php echo $list->id;?>"><?php echo $list->cow_no;?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('is_success'); ?></label>
                                            <select class="form-control inner_shadow_teal select2" name="is_success" style="width: 100%;">
                                                <option value="1" selected=""><?php echo $this->lang->line('yes'); ?>
                                                </option>
                                                <option value="0"><?php echo $this->lang->line('no'); ?>
                                                </option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('baby_cow_no'); ?></label>
                                            <input name="baby_cow_no" placeholder="<?php echo $this->lang->line('baby_cow_no'); ?> " class="form-control inner_shadow_primary"  type="text" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('notes'); ?></label>
                                            <input name="notes" placeholder="<?php echo $this->lang->line('notes'); ?> " class="form-control inner_shadow_primary"  type="text" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

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

