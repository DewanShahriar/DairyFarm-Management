<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('cow_details_list'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/cow-details/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('cow_details_add'); ?></a>
                    </div>
                </div>
                <div class="row" style="box-shadow: 0px 0px 10px 0px #008080; margin: 8px 53px 20px 55px; padding:20px 4px 20px 4px;">
                   <form action="<?php echo base_url('admin/cow-details/list') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-12">
                            <div class="col-md-4">
                            </div>

                            <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('cow_no'); ?></label>
                                            <select class="form-control inner_shadow_primary select2" name="cow_no">
                                                <option value=""><?php echo $this->lang->line('select_cow_number'); ?></option>
                                                <?php foreach($cow_details as $list){?>
                                                <option value="<?php echo $list->cow_no;?>" <?php if ($search['cow_no'] == $list->cow_no) echo 'selected' ; ?>><?php echo $list->cow_no;?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <br>
                         <center>
                            <button type="submit" class="btn btn-sm btn bg-purple"><?php echo $this->lang->line('search'); ?></button>
                         </center>
                        </div>
                   </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="cowDetailsList" class="table table-bordered table-striped table_th_primary">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('cow_no'); ?></th>
                                <th style="width: 20%;"><?php echo $this->lang->line('cow_type_name'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('start_date'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('purchase_cost'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('color'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('is_sold'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sl = 1;
                                foreach ($cow_details_list as $value) {
                                	?>
                                    <tr>
                                        <td> <?php echo $sl++; ?> </td>
                                        <td> <?php echo $value->cow_no; ?> </td>
                                        <td> <?php echo $value->name; ?> </td>
                                        <td> <?php echo date("d M Y ", strtotime($value->start_date)); ?></td>
                                        <td> <?php echo $value->purchase_cost; ?> </td>
                                        <td> <?php echo $value->color; ?> </td>
                                        <td> <?php if($value->is_sold == 1): echo '<span class="badge bg-red"> Sold</span>'; else: echo '<span class="badge bg-light-blue"> Unsold</span>'; endif ?> </td>
                                        <td> 
                                            <a href="<?php echo base_url('admin/cow-details/edit/'.$value->id); ?>" class="btn btn-sm bg-primary"><i class="fa fa-edit"></i></a>
                                            <a href="<?php echo base_url('admin/cow-details/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
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

        $("#cowDetailsList").DataTable();
    });
    
</script>

