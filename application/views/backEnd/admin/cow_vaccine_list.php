<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('cow_vaccine_list'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/cow-vaccine/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('cow_vaccine_add'); ?></a>
                    </div>
                </div>
                <div class="row" style="box-shadow: 0px 0px 10px 0px #3c8dbc; margin: 8px 53px 20px 55px; padding:20px 4px 20px 4px;">
                   <form action="<?php echo base_url('admin/cow-vaccine/list') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label><?php echo $this->lang->line('push_date'); ?></label>
                                        <input name="push_date" placeholder="<?php echo $this->lang->line('push_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" value="<?= $search['push_date']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label><?php echo $this->lang->line('next_push_date'); ?></label>
                                        <input name="next_push_date" placeholder="<?php echo $this->lang->line('next_push_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" value="<?= $search['next_push_date']; ?>">
                                    </div>
                                </div>
                            </div>

                            

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label><?php echo $this->lang->line('cow_no'); ?></label>
                                        <select class="form-control inner_shadow_teal select2" name="cow_no">
                                            <option value=""><?php echo $this->lang->line('select_cow_number'); ?></option>
                                            <?php foreach($cow_details as $list){?>
                                            <option value="<?php echo $list->cow_no;?>" <?php if ($search['cow_no'] == $list->cow_no) echo 'selected' ; ?> ><?php echo $list->cow_no;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-12">
                            <br>
                         <center>
                            <button type="submit" class="btn btn-sm btn-info"><?php echo $this->lang->line('search'); ?></button>
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
                                <th style="width: 20%;"><?php echo $this->lang->line('cow_no'); ?></th>
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
                                        <td> <?php echo $value->cow_no; ?> </td>
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

