
<style>
  .table_custom{
    overflow-x: scroll!important;
  }
  .table_custom .table{
    width: 1000px!important;
    max-width: none!important;
  }
</style>
<section class="content">
   <div class="row">
      <div class="col-md-3">
         <!-- Profile Image -->
         <div class="box box-primary">
            <div class="box-body box-profile">
               <!-- <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture"> -->
               <h1 class="profile-username text-center" style="font-weight: bold;"><?php echo $edit_info->cow_no;?></h1>
               <!-- <p class="text-muted text-center"><?php echo $edit_info->name;?></p> -->
               <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                     <b><?php echo $this->lang->line('cow_no');?></b> <a class="pull-right"><?php echo $edit_info->cow_no;?></a>
                  </li>
                  <li class="list-group-item">
                     <b><?php echo $this->lang->line('start_date');?></b> <a class="pull-right"><?php echo date("d M Y ", strtotime($edit_info->start_date));?></a>
                  </li>
                  <li class="list-group-item">
                     <b><?php echo $this->lang->line('cow_type');?></b> <a class="pull-right"><?php echo $edit_info->name;?></a>
                  </li>
                  <li class="list-group-item">
                     <b><?php echo $this->lang->line('purchase_cost');?></b> <a class="pull-right"><?php echo $edit_info->purchase_cost;?></a>
                  </li>
                  <li class="list-group-item">
                     <b><?php echo $this->lang->line('target_sale_cost');?></b> <a class="pull-right"><?php echo $edit_info->target_sale_cost;?></a>
                  </li>
                  <li class="list-group-item">
                     <b><?php echo $this->lang->line('color');?></b> <a class="pull-right"><?php echo $edit_info->color;?></a>
                  </li>
                  <li class="list-group-item">
                     <b><?php echo $this->lang->line('is_sold');?></b> <a class="pull-right"><?php if($edit_info->is_sold == 0): echo "No";
                        else: echo "Yes";
                        endif ;?></a>
                  </li>
                  <li class="list-group-item">
                     <b><?php echo $this->lang->line('is_death');?></b> <a class="pull-right"><?php if($edit_info->is_death == 0): echo "No";
                        else: echo "Yes";
                        endif ;?></a>
                  </li>
                  <li class="list-group-item">
                     <b><?php echo $this->lang->line('total_milk_collected');?></b> <a class="pull-right"><?php echo $total_milk_collected->collection_amount;?> ( ltr)</a>
                  </li>
                  <li class="list-group-item">
                     <b><?php echo $this->lang->line('total_vaccine_pushed');?></b> <a class="pull-right"><?php echo count($cow_vaccine_list);?></a>
                  </li>
               </ul>
            </div>
            <!-- /.box-body -->
         </div>
         <!-- /.box -->
         <!-- About Me Box -->
         <!-- /.box -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
         <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
               <li class="active"><a href="#edit" data-toggle="tab" aria-expanded="false"><?php echo $this->lang->line('details');?></a></li>
               <li class=""><a href="#cow_health_test" data-toggle="tab" aria-expanded="false"><?php echo $this->lang->line('cow_health_test');?></a></li>
               <li class=""><a href="#cow_milk_target" data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('cow_milk_target');?></a></li>
               <li class=""><a href="#cow_milk_collection" data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('cow_milk_collection');?></a></li>
               <li class=""><a href="#cow_pregnancy" data-toggle="tab" aria-expanded="false"><?php echo $this->lang->line('cow_pregnancy');?></a></li>
               <li class=""><a href="#cow_vaccine" data-toggle="tab" aria-expanded="false"><?php echo $this->lang->line('vaccine');?></a></li>
            </ul>
            <div class="tab-content">
               <div class="tab-pane active" id="edit">
                  <form class="form-horizontal" action="<?php echo base_url("admin/cow-details/edit/".$edit_info->id);?>" method="post" enctype="multipart/form-data">
                     <div class="col-md-12">
                        <div class="col-md-6">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('start_date'); ?>*</label>
                                 <input name="start_date" placeholder="<?php echo $this->lang->line('start_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" value="<?php if($edit_info->start_date ) echo date("d M Y ", strtotime($edit_info->start_date)) ?>" required>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('cow_no'); ?>*</label>
                                 <input name="cow_no" placeholder="<?php echo $this->lang->line('cow_no'); ?> " class="form-control inner_shadow_primary" type="text" required value="<?php echo $edit_info->cow_no?>" autocomplete="off">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('cow_type'); ?>*</label>
                                 <select class="form-control inner_shadow_primary select2" name="cow_type_id" style="width:100%;">
                                    <option value=""><?php echo $this->lang->line('select_cow_type'); ?></option>
                                    <?php foreach($cow_type_list as $list){
                                       if($edit_info->cow_type_id == $list->id){?>
                                    <option value="<?php echo $list->id;?>" selected><?php echo $list->name;?></option>
                                    <?php } else {?>
                                    <option value="<?php echo $list->id;?>"><?php echo $list->name;?></option>
                                    <?php } }?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('purchase_cost'); ?>*</label>
                                 <input name="purchase_cost" placeholder="<?php echo $this->lang->line('purchase_cost'); ?> " class="form-control inner_shadow_primary"  type="text" value="<?php echo $edit_info->purchase_cost?>" required>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('target_sale_cost'); ?></label>
                                 <input name="target_sale_cost" placeholder="<?php echo $this->lang->line('target_sale_cost'); ?> " class="form-control inner_shadow_primary" value="<?php echo $edit_info->target_sale_cost?>" type="text">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('color'); ?></label>
                                 <input name="color" placeholder="<?php echo $this->lang->line('color'); ?> " class="form-control inner_shadow_primary" value="<?php echo $edit_info->color?>" type="text">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('is_sold'); ?></label>
                                 <select class="form-control inner_shadow_primary select2" name="is_sold" style="width:100%;">
                                    <?php if($edit_info->is_sold == 0):?>
                                    <option value="0" selected=""><?php echo $this->lang->line('no'); ?>
                                    </option>
                                    <option value="1" ><?php echo $this->lang->line('yes'); ?>
                                    </option>
                                    <?php else:?>
                                    <option value="0"><?php echo $this->lang->line('no'); ?>
                                    </option>
                                    <option value="1" selected="" ><?php echo $this->lang->line('yes'); ?>
                                    </option>
                                    <?php endif?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <label><?php echo $this->lang->line('is_death'); ?></label>
                                 <select class="form-control inner_shadow_primary select2" name="is_death" style="width:100%;">
                                    <?php if($edit_info->is_death == 0):?>
                                    <option value="0" selected=""><?php echo $this->lang->line('no'); ?>
                                    </option>
                                    <option value="1" ><?php echo $this->lang->line('yes'); ?>
                                    </option>
                                    <?php else:?>
                                    <option value="0"><?php echo $this->lang->line('no'); ?>
                                    </option>
                                    <option value="1" selected="" ><?php echo $this->lang->line('yes'); ?>
                                    </option>
                                    <?php endif?>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                           <br>
                           <center>
                              <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                              <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('update'); ?></button>
                           </center>
                        </div>
                     </div>
                  </form>
               </div>
               <!-- /.tab-pane -->
               <div class="tab-pane" id="cow_health_test">
                  <div class="row" style="box-shadow: 0px 0px 10px 0px #3c8dbc; margin: 8px 8px 8px 8px; padding:20px 4px 20px 4px;">
                     <form id="health_test_submit" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-12">
                           <div class="col-md-3">
                              <div class="form-group">
                                 <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('health_test_date'); ?>*</label>
                                    <input name="health_test_date" placeholder="<?php echo $this->lang->line('health_test_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" required>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('height'); ?>*</label>  
                                    <input name="height" placeholder="<?php echo $this->lang->line('height'); ?> " class="form-control inner_shadow_primary"  type="text">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('width'); ?>*</label>  
                                    <input name="width" placeholder="<?php echo $this->lang->line('width'); ?> " class="form-control inner_shadow_primary"  type="text"> 
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('weight'); ?>*</label>  
                                    <input name="weight" placeholder="<?php echo $this->lang->line('weight'); ?> " class="form-control inner_shadow_primary"  type="text"> 
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <br>
                           <center>
                              <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('save'); ?></button>
                           </center>
                        </div>
                        <center>
                           <span id="health_test_preview" ></span>
                        </center>
                     </form>
                  </div>
                  <div class="box-body">
                     <table id="healthTestTable" class="table table-bordered table-striped table_th_primary">
                        <thead>
                           <tr>
                              <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                              <th style="width: 25%;"><?php echo $this->lang->line('health_test_date'); ?></th>
                              <th style="width: 10%;"><?php echo $this->lang->line('height'); ?></th>
                              <th style="width: 10%;"><?php echo $this->lang->line('width'); ?></th>
                              <th style="width: 10%;"><?php echo $this->lang->line('weight'); ?></th>
                              <th style="width: 15%;"><?php echo $this->lang->line('action'); ?></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                              $sl = 1;
                              foreach ($health_test_list as $value) {
                                ?>
                           <tr>
                              <td> <?php echo $sl++; ?> </td>
                              <td> <?php if($value->health_test_date) echo date("d M Y ", strtotime($value->health_test_date)) ?> </td>
                              <td> <?php echo $value->height; ?> </td>
                              <td> <?php echo $value->width; ?> </td>
                              <td> <?php echo $value->weight; ?> </td>
                              <td> 
                                 <a href="<?php echo base_url('admin/cow-health-test/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                 <a href="<?php echo base_url('admin/cow-health-test/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                              </td>
                           </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
               <!-- /.tab-pane -->
               <div class="tab-pane" id="cow_milk_target">
                  <div class="row" style="box-shadow: 0px 0px 10px 0px #3c8dbc; margin: 8px 8px 8px 8px; padding:20px 4px 20px 4px;">
                     <form id="milk_target_submit" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-12">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('milk_start_date'); ?>*</label>
                                    <input name="start_date" placeholder="<?php echo $this->lang->line('milk_start_date'); ?> " class="form-control inner_shadow_primary date"  type="text" required autocomplete="off">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('milk_target'); ?>*</label>  
                                    <input name="milk_target" placeholder="<?php echo $this->lang->line('milk_target'); ?> " class="form-control inner_shadow_primary"  type="text" autocomplete="off">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <br>
                           <center>
                              <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('save'); ?></button>
                           </center>
                        </div>
                        <center>
                           <span id="milk_target_preview" ></span>
                        </center>
                     </form>
                  </div>
                  <div class="box-body">
                     <table id="milkTargetTable" class="table table-bordered table-striped table_th_primary">
                        <thead>
                           <tr>
                              <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                              <th style="width: 25%;"><?php echo $this->lang->line('milk_start_date'); ?></th>
                              <th style="width: 25%;"><?php echo $this->lang->line('milk_target'); ?></th>
                              <th style="width: 15%;"><?php echo $this->lang->line('action'); ?></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                              $sl = 1;
                              foreach ($milk_target_list as $value) {
                                ?>
                           <tr>
                              <td> <?php echo $sl++; ?> </td>
                              <td> <?php if($value->start_date) echo date("d M Y ", strtotime($value->start_date)) ?> </td>
                              <td> <?php echo $value->milk_target; ?> </td>
                              <td> 
                                 <a href="<?php echo base_url('admin/cow-health-test/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                 <a href="<?php echo base_url('admin/cow-health-test/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                              </td>
                           </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
               <!-- /.tab-pane -->
               <div class="tab-pane" id="cow_milk_collection">
                  <div class="row" style="box-shadow: 0px 0px 10px 0px #3c8dbc; margin: 8px 8px 8px 8px; padding:20px 4px 20px 4px;">
                     <form id="milk_collection_submit" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-12">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('collection_date'); ?>*</label>
                                    <input name="collection_date" placeholder="<?php echo $this->lang->line('collection_date'); ?> " class="form-control inner_shadow_primary date"  type="text" required autocomplete="off">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('collection_amount'); ?>*</label>  
                                    <input name="collection_amount" placeholder="<?php echo $this->lang->line('collection_amount'); ?> " class="form-control inner_shadow_primary"  type="text" autocomplete="off">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <br>
                           <center>
                              <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('save'); ?></button>
                           </center>
                        </div>
                        <center>
                           <span id="milk_collection_preview" ></span>
                        </center>
                     </form>
                  </div>
                  <div class="box-body">
                     <table id="milkCollectionTable" class="table table-bordered table-striped table_th_primary">
                        <thead>
                           <tr>
                              <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                              <th style="width: 25%;"><?php echo $this->lang->line('collection_date'); ?></th>
                              <th style="width: 25%;"><?php echo $this->lang->line('collection_amount'); ?></th>
                              <th style="width: 15%;"><?php echo $this->lang->line('action'); ?></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                              $sl = 1;
                              foreach ($milk_collection_list as $value) {
                                ?>
                           <tr>
                              <td> <?php echo $sl++; ?> </td>
                              <td> <?php if($value->collection_date) echo date("d M Y ", strtotime($value->collection_date)) ?> </td>
                              <td> <?php echo $value->collection_amount; ?> </td>
                              <td> 
                                 <a href="<?php echo base_url('admin/cow-health-test/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                 <a href="<?php echo base_url('admin/cow-health-test/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                              </td>
                           </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
               <!-- /.tab-pane -->
               <div class="tab-pane" id="cow_pregnancy">
                  <div class="box-body table_custom">
                     <table id="cowPregnancyTable" class="table table-bordered table-striped table_th_primary">
                        <thead>
                           <tr>
                              <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                              <th style="width: 10%;"><?php echo $this->lang->line('semens_push_date'); ?></th>
                              <th style="width: 10%;"><?php echo $this->lang->line('pregnancy_start_date'); ?></th>
                              <th style="width: 15%;"><?php echo $this->lang->line('approximate_delivery_date'); ?></th>
                              <th style="width: 15%;"><?php echo $this->lang->line('baby_cow_no'); ?></th>
                              <th style="width: 5%;"><?php echo $this->lang->line('is_success'); ?></th>
                              <th style="width: 15%;"><?php echo $this->lang->line('notes'); ?></th>
                              <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                              $sl = 1;
                              foreach ($pregnancy_list as $value) {
                                  ?>
                           <tr>
                              <td> <?php echo $sl++; ?> </td>
                              <td> <?php if($value->semens_push_date) echo date("d M Y ", strtotime($value->semens_push_date)) ?> </td>
                              <td> <?php if($value->pregnancy_start_date) echo date("d M Y ", strtotime($value->pregnancy_start_date)) ?> </td>
                              <td> <?php if($value->approximate_delivery_date) echo date("d M Y ", strtotime($value->approximate_delivery_date)) ?> </td>
                              <td> <?php echo $value->baby_cow_no; ?> </td>
                              <td> <?php if($value->is_success== 1): echo '<span class="badge bg-green"> Yes</span>'; else: echo '<span class="badge bg-light-red"> No</span>'; endif ?> </td>
                              <td> <?php echo $value->notes; ?> </td>
                              <td> 
                                 <a href="<?php echo base_url('admin/cow-pregnancy/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                 <a href="<?php echo base_url('admin/cow-pregnancy/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                              </td>
                           </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
               <!-- /.tab-pane -->
               <div class="tab-pane" id="cow_vaccine">
                  <div class="row" style="box-shadow: 0px 0px 10px 0px #3c8dbc; margin: 8px 8px 8px 8px; padding:20px 4px 20px 4px;">
                     <form id="vaccine_submit" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-12">
                           <div class="col-md-3">
                              <div class="form-group">
                                 <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('push_date'); ?>*</label>
                                    <input name="push_date" placeholder="<?php echo $this->lang->line('push_date'); ?> " class="form-control inner_shadow_primary date"  type="text" required autocomplete="off">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('next_push_date'); ?>*</label>  
                                    <input name="next_push_date" placeholder="<?php echo $this->lang->line('next_push_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('vaccine_name'); ?>*</label>  
                                    <select class="form-control inner_shadow_primary select2" name="vaccine_id" style="width:100%;" id="select_vaccine">
                                       <option value=""><?php echo $this->lang->line('select_vaccine_name'); ?></option>
                                       <?php foreach($vaccine_list as $list){?>
                                       <option value="<?php echo $list->id?>"><?php echo $list->name; ?></option>
                                       <?php }?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('notes'); ?>*</label>  
                                    <input name="notes" placeholder="<?php echo $this->lang->line('notes'); ?> " class="form-control inner_shadow_primary"  type="text">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <br>
                           <center>
                              <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('save'); ?></button>
                           </center>
                        </div>
                        <center>
                           <span id="vaccine_preview" ></span>
                        </center>
                     </form>
                  </div>
                  <div class="box-body">
                     <table id="vaccineTable" class="table table-bordered table-striped table_th_primary">
                        <thead>
                           <tr>
                              <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                              <th style="width: 20%;"><?php echo $this->lang->line('push_date'); ?></th>
                              <th style="width: 15%;"><?php echo $this->lang->line('next_push_date'); ?></th>
                              <th style="width: 15%;"><?php echo $this->lang->line('vaccine_name'); ?></th>
                              <th style="width: 15%;"><?php echo $this->lang->line('notes'); ?></th>
                              <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                              $sl = 1;
                              foreach ($cow_vaccine_list as $value) {
                                ?>
                           <tr>
                              <td> <?php echo $sl++; ?> </td>
                              <td> <?php if($value->push_date) echo date("d M Y ", strtotime($value->push_date)) ?> </td>
                              <td> <?php if($value->next_push_date) echo date("d M Y ", strtotime($value->next_push_date)) ?> </td>
                              <td> <?php echo $value->vaccine_name; ?> </td>
                              <td> <?php echo $value->notes; ?> </td>
                              <td> 
                                 <a href="<?php echo base_url('admin/cow-vaccine/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                 <a href="<?php echo base_url('admin/cow-vaccine/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                              </td>
                           </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
               <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
         </div>
         <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.col -->
   </div>
   <!-- /.row -->
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
<script type="text/javascript">
   // $(function () {
   
   //     $("#healthTestTable").DataTable();
   
   // });
   
   // $(function () {
   
   //     $("#milkTargetTable").DataTable();
   
   // });
   
   // $(function () {
   
   //     $("#milkCollectionTable").DataTable();
   
   // });
   
   // $(function () {
   
   //     $("#cowPregnancyTable").DataTable();
   
   // });
   
   // $(function () {
   
   //     $("#vaccineTable").DataTable();
   
   // });
   
</script>
<script>  
   $(document).ready(function(){  
        $('#health_test_submit').on('submit', function(e){ 
   
             e.preventDefault();  
   
             if(false) { 
   
                  alert("Please Fillup Input Field"); 
   
             } else {  
   
                  $("#health_test_preview").html('<img src="loader.gif" alt="Uploading...."/>');
   
                  $.ajax({  
                       url:"<?php echo base_url('admin/health_test_add/'). $edit_info->id;?>",
                       method:"POST",  
                       data:new FormData(this),
                       dataType: "json",  
                       contentType: false,  
                       cache: false,  
                       processData:false,  
                       success:function(res)
                       {  
                            $('#health_test_preview').html(res.message);
                            $('.inner_shadow_primary').val('');
                            
                            $('#healthTestTable').prepend('<tr><td>#</td><td>'+res.data.health_test_date+'</td><td>'+res.data.height+'</td><td>'+res.data.width+'</td><td>'+res.data.weight+'</td><td></td></tr>');
                       }  
                  });  
             }  
        });  
   });  
</script>
<script>  
   $(document).ready(function(){  
        $('#milk_target_submit').on('submit', function(e){ 
   
             e.preventDefault();  
   
             if(false) { 
   
                  alert("Please Fillup Input Field"); 
   
             } else {  
   
                  $("#milk_target_preview").html('<img src="loader.gif" alt="Uploading...."/>');
   
                  $.ajax({  
                       url:"<?php echo base_url('admin/milk_target_add/'). $edit_info->id;?>",
                       method:"POST",  
                       data:new FormData(this),
                       dataType: "json",  
                       contentType: false,  
                       cache: false,  
                       processData:false,  
                       success:function(res)
                       {  
                             
                          $('#milk_target_preview').html(res.message);
                          $('.inner_shadow_primary').val('');
                          $('#milkTargetTable').prepend('<tr><td>#</td><td>'+res.data.start_date+'</td><td>'+res.data.milk_target+'</td><td></td></tr>');
   
                       }  
                  });  
             }  
        });  
   });  
</script>
<script>  
   $(document).ready(function(){  
        $('#milk_collection_submit').on('submit', function(e){ 
   
             e.preventDefault();  
   
             if(false) { 
   
                  alert("Please Fillup Input Field"); 
   
             } else {  
   
                  $("#milk_collection_preview").html('<img src="loader.gif" alt="Uploading...."/>');
   
                  $.ajax({  
                       url:"<?php echo base_url('admin/milk_collection_add/'). $edit_info->id;?>",
                       method:"POST",  
                       data:new FormData(this),  
                       contentType: false,
                       dataType: "json", 
                       cache: false,  
                       processData:false,  
                       success:function(res)
                       {  
                            $('#milk_collection_preview').html(res.message);
                            $('.inner_shadow_primary').val('');
                            $('#milkCollectionTable').prepend('<tr><td>#</td><td>'+res.data.collection_date+'</td><td>'+res.data.collection_amount+'</td><td></td></tr>');
                       }  
                  });  
             }  
        });  
   });  
</script>
<script>  
   $(document).ready(function(){  
        $('#vaccine_submit').on('submit', function(e){ 
   
             e.preventDefault();  
   
             if(false) { 
   
                  alert("Please Fillup Input Field"); 
   
             } else {  
   
                  $("#vaccine_preview").html('<img src="loader.gif" alt="Uploading...."/>');
   
                  $.ajax({  
                       url:"<?php echo base_url('admin/vaccine_add/'). $edit_info->id;?>",
                       method:"POST",  
                       data:new FormData(this),  
                       contentType: false,
                       dataType: "json",  
                       cache: false,  
                       processData:false,  
                       success:function(res)
                       {  
                            console.log(res.data);

                            $('#vaccine_preview').html(res.message);
                            $('.inner_shadow_primary').val('');
                            $('#select_vaccine').prop('selectedIndex',0);
                            $('#vaccineTable').prepend('<tr><td>#</td><td>'+res.data.push_date+'</td><td>'+res.data.next_push_date+'</td><td>'+res.data.vaccine_name+'</td><td>'+res.data.notes+'</td><td></td></tr>');
   
                       }  
                  });  
             }  
        });  
   });  
</script>