<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('vaccine_list'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/vaccine/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('vaccine_add'); ?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if(isset($edit_info)){ ?>
                    <div class="row" style="box-shadow: 0px 0px 10px 0px #f39c12;margin: 10px 30px 40px 25px;padding: 30px 0px 30px 0px;">
                        <form action="<?php echo base_url("admin/vaccine/edit/".$edit_info->id);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('vaccine_name'); ?>*</label>
                                            <input name="name" placeholder="<?php echo $this->lang->line('vaccine_name'); ?> " class="form-control inner_shadow_orange"  type="text" required value="<?php echo $edit_info->name;?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('vaccine_type'); ?>*</label>
                                          <select class="form-control inner_shadow_primary select2" name="type" required="">

                                             <option value=""><?php echo $this->lang->line('select_vaccine_type'); ?></option>
                                             <?php if($edit_info->type == 0):?>
                                             <option value="0" selected=""><?php echo $this->lang->line('monthly'); ?></option>
                                             <option value="1"><?php echo $this->lang->line('yearly'); ?></option>
                                             <option value="2"><?php echo $this->lang->line('ondemand'); ?></option>
                                             <option value="3"><?php echo $this->lang->line('other'); ?></option>
                                            <?php elseif($edit_info->type == 1):?>
                                                <option value="0" ><?php echo $this->lang->line('monthly'); ?></option>
                                             <option value="1" selected=""><?php echo $this->lang->line('yearly'); ?></option>
                                             <option value="2"><?php echo $this->lang->line('ondemand'); ?></option>
                                             <option value="3"><?php echo $this->lang->line('other'); ?></option>

                                             <?php elseif($edit_info->type == 2):?>
                                                <option value="0" ><?php echo $this->lang->line('monthly'); ?></option>
                                             <option value="1" ><?php echo $this->lang->line('yearly'); ?></option>
                                             <option value="2" selected=""><?php echo $this->lang->line('ondemand'); ?></option>
                                             <option value="3"><?php echo $this->lang->line('other'); ?></option>

                                             <?php else:?>

                                                <option value="0" ><?php echo $this->lang->line('monthly'); ?></option>
                                             <option value="1" ><?php echo $this->lang->line('yearly'); ?></option>
                                             <option value="2"><?php echo $this->lang->line('ondemand'); ?></option>
                                             <option value="3" selected=""><?php echo $this->lang->line('other'); ?></option>

                                         <?php endif ?>

                                          </select>
                                        </div>
                                    </div>
                                </div>
                                   
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-teal"><?php echo $this->lang->line('update'); ?></button>
                                </center>
                            </div>
                        </form>
                    </div>
                    <?php } else {?>
                        <div class="row" style="box-shadow: 0px 0px 10px 0px #f39c12;margin: 10px 30px 40px 25px;padding: 30px 0px 30px 0px;">
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
                    <?php } ?>
                    <table id="cowTypeList" class="table table-bordered table-striped table_th_orange">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 65%;"><?php echo $this->lang->line('vaccine_name'); ?></th>
                                <th style="width: 20%;"><?php echo $this->lang->line('vaccine_type'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sl = 1;
                                foreach ($vaccine_list as $value) {
                                	?>
                            <tr>
                                <td> <?php echo $sl++ ; ?> </td>
                                <td> <?php echo $value->name; ?> </td>
                                <td> <?php if($value->type == 0) echo "Monthly"; elseif ($value->type == 1) echo "Yearly"; elseif ($value->type == 2) echo "On Demand"; else echo "Other";

                                 ?> </td>
                                <td> 
                                    <a href="<?php echo base_url('admin/vaccine/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/vaccine/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
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
</section>

<script type="text/javascript">

    $(function () {

        $("#cowTypeList").DataTable();
    });
    
</script>

