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
                                foreach ($salary_list as $value) {
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
                        </tbody>
                    </table>
                    <p><?php if(count($salary_list) > 0) echo $links; ?></p>
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

