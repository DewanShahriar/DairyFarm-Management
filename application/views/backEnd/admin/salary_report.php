<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('salary_list'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/salary/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('salary_add'); ?></a>
                    </div>
                </div>
                <div class="row" style="box-shadow: 0px 0px 10px 0px #00c0ef; margin: 8px 53px 20px 55px; padding:20px 4px 20px 4px;">
                   <form action="<?php echo base_url('admin/salary/report') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                      <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('employee_name'); ?></label>
                                    <select name="employee_id" class="form-control inner_shadow_info select2">
                                        <option value=""><?php echo $this->lang->line('select_one'); ?></option>
                                    <?php foreach($employee_list as $list){?>
                                        
                                        <option value="<?php echo $list->id;?>" <?php if ($search['employee_id'] == $list->id) echo 'selected' ; ?> ><?php echo $list->name;?></option>
                                    <?php }?>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('start_date'); ?></label>
                                    <input name="start_date" placeholder="<?php echo $this->lang->line('start_date'); ?> " class="form-control inner_shadow_info date"  type="text" autocomplete="off" value="<?= $search['start_date']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('end_date'); ?></label>
                                    <input name="end_date" placeholder="<?php echo $this->lang->line('end_date'); ?> " class="form-control inner_shadow_info date"  type="text" autocomplete="off" value="<?= $search['end_date']; ?>">
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
                    <table id="salesReportTable" class="table table-bordered table-striped table_th_info">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 20%;"><?php echo $this->lang->line('employee_id'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('day'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('month'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('year'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('amount'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('action'); ?></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sl = 1;
                                $total = 0;
                                foreach ($salary_data as $value) {
                                    $total += $value->amount;
                                    ?>
                            <tr>
                                <td> <?php echo $sl++ ; ?> </td>
                                <td> <?php echo $value->employee_name; ?> </td>
                                <td> <?php echo $value->day; ?> </td>
                                <td> <?php 

                                if($value->month == 1){
                                    echo "January";
                                } elseif ($value->month == 2) {
                                    echo "February";
                                } elseif ($value->month == 3) {
                                    echo "March";
                                } elseif ($value->month == 4) {
                                    echo "April";
                                } elseif ($value->month == 5) {
                                    echo "May";
                                } elseif ($value->month == 6) {
                                    echo "June";
                                } elseif ($value->month == 7) {
                                    echo "july";
                                } elseif ($value->month == 8) {
                                    echo "August";
                                } elseif ($value->month == 9) {
                                    echo "September";
                                } elseif ($value->month == 10) {
                                    echo "October";
                                } elseif ($value->month == 11) {
                                    echo "November";
                                } elseif ($value->month == 12) {
                                    echo "January";
                                }
                                ?> 
                                </td>
                                <td> <?php echo $value->year; ?> </td>
                                <td> <?php echo $value->amount; ?> </td>
                                <td> 
                                    <a href="<?php echo base_url('admin/salary/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/salary/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                                }
                                ?>
                                <tr>
                            <td colspan="5" style="text-align: right; font-size: 15px; font-weight: bold;">Total</td>
                            <td><strong><?php echo $total;?></strong></td>
                            <td></td>
                        </tr>
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

