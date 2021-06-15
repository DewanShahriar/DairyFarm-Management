<section class="content">
   <div class="row">
      <div class="col-md-12">
         <!-- Horizontal Form -->
         <div class="box box-primary box-solid">
            <div class="box-header with-border">
               <h3 class="box-title"><?php echo $this->lang->line('cow_details_add'); ?></h3>
               <div class="box-tools pull-right">
                  <a href="<?php echo base_url() ?>admin/cow-details/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('cow_details_list'); ?>  </a>
               </div>
            </div>
            <div class="box-body">
               <br>
               <div class="row">
                  <form action="<?php echo base_url("admin/cow-details/add");?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                     <div class="col-md-12">
                        <center style="margin-top: 0px;margin-bottom: 15px;">
                           <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;"><?php echo $this->lang->line('cow_details'); ?></span>
                        </center>
                        <div class="col-md-3">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('start_date'); ?>*</label>
                                 <input name="start_date" placeholder="<?php echo $this->lang->line('start_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" required>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('cow_no'); ?>*</label>
                                 <input name="cow_no" placeholder="<?php echo $this->lang->line('cow_no'); ?> " class="form-control inner_shadow_primary" type="text" required autocomplete="off">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('cow_type'); ?>*</label>
                                 <select class="form-control inner_shadow_primary select2" name="cow_type_id" style="width: 100%;">
                                    <option value=""><?php echo $this->lang->line('select_cow_type'); ?></option>
                                    <?php foreach($cow_type_list as $list){?>
                                    <option value="<?php echo $list->id;?>"><?php echo $list->name;?></option>
                                    <?php }?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('purchase_cost'); ?>*</label>
                                 <input name="purchase_cost" placeholder="<?php echo $this->lang->line('purchase_cost'); ?> " class="form-control inner_shadow_primary"  type="text" required>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('target_sale_cost'); ?></label>
                                 <input name="target_sale_cost" placeholder="<?php echo $this->lang->line('target_sale_cost'); ?> " class="form-control inner_shadow_primary"  type="text">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('color'); ?></label>
                                 <input name="color" placeholder="<?php echo $this->lang->line('color'); ?> " class="form-control inner_shadow_primary"  type="text">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('is_sold'); ?></label>
                                 <select class="form-control inner_shadow_primary select2" name="is_sold" style="width: 100%;">
                                    <option value="0" selected=""><?php echo $this->lang->line('no'); ?>
                                    </option>
                                    <option value="1" ><?php echo $this->lang->line('yes'); ?>
                                    </option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('is_death'); ?></label>
                                 <select class="form-control inner_shadow_primary select2" name="is_death" style="width: 100%">
                                    <option value="0" selected=""><?php echo $this->lang->line('no'); ?>
                                    </option>
                                    <option value="1" ><?php echo $this->lang->line('yes'); ?>
                                    </option>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <br>
                        <center style="margin-top: 0px;margin-bottom: 15px;">
                           <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;"><?php echo $this->lang->line('health_info'); ?></span>
                        </center>
                        <div class="col-md-3">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('health_test_date'); ?></label>
                                 <input name="health_test_date" placeholder="<?php echo $this->lang->line('health_test_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('height'); ?></label>
                                 <input name="height" placeholder="<?php echo $this->lang->line('height'); ?> " class="form-control inner_shadow_primary"  type="text">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('width'); ?></label>
                                 <input name="width" placeholder="<?php echo $this->lang->line('width'); ?> " class="form-control inner_shadow_primary"  type="text">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('weight'); ?></label>
                                 <input name="weight" placeholder="<?php echo $this->lang->line('weight'); ?> " class="form-control inner_shadow_primary"  type="text">
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