

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-6a8d9d">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('project_cost_analysis'); ?> </h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <div class="box-body">
                    <div class="row" style="box-shadow: 1px 1px 15px 5px #6a8d9d;margin: 10px 30px 40px 25px;padding: 30px 0px 30px 0px;">
                        <form action="<?php echo base_url('user/report/project_cost_analysis') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="control-label"> <?php echo $this->lang->line('project'); ?> </label>
                                            <select name="project_id" id="project_id" class="form-control select2" required="">
                                                <option value=""><?php echo $this->lang->line('select_project'); ?></option>
                                                <?php foreach ($projects as $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>" data-start_date="<?php echo date("d-m-Y", strtotime($value->project_start_date)); ?>" <?php echo set_select('project_id',$value->id, ( !empty($value) && $value == $value->id ? TRUE : FALSE )); ?>><?php echo $value->name; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="control-label"> <?php echo $this->lang->line('account_head'); ?> </label>
                                            <select name="account_head_id" class="form-control select2" required="">
                                                <option value=""><?php echo $this->lang->line('select_account_head'); ?></option>
                                                <?php foreach ($accounthead as $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>" <?php echo set_select('account_head_id',$value->id, ( !empty($value) && $value == $value->id ? TRUE : FALSE )); ?>><?php echo $value->name; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('start_date'); ?> </label>
                                            <input name="start_date" class="form-control inner_shadow_6a8d9d" placeholder="<?php echo $this->lang->line('start_date'); ?>" type="text" id="start_date" autocomplete="off" onkeypress="return false" value="<?php echo set_value('start_date'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('end_date'); ?> </label>
                                            <input name="end_date" class="form-control inner_shadow_6a8d9d" placeholder="<?php echo $this->lang->line('end_date'); ?>" type="text" id="end_date" autocomplete="off" onkeypress="return false" value="<?php if(isset($end_date)){ echo set_value('end_date');}else{echo date('d-m-Y') ;} ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" box-footer">
                                <center>
                                    <button type="submit" class="btn btn-6a8d9d"><?php echo $this->lang->line('search'); ?></button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class=" box-footer">
                </div>
                <!-- /.box-footer --> 
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
    <?php if(isset($search_data)) {?>
        <div class="invoice" id="printablearea">
            <style> 
                @media print {
                    a[href]:after {
                        content: none !important;
                    }
                }
            </style>
           <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-tasks"></i> M/S Rasel Enterprise
                        <small class="pull-right"><b><?php echo $this->lang->line('date'); ?></b>: <?php echo date('d-M-Y'); ?></small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <b><?php echo $this->lang->line('project'); ?></b> : <strong><?php echo $project_data->name; ?></strong><br>                
                        <b><?php echo $this->lang->line('location'); ?></b>: <?php echo $project_data->address; ?><br>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 ">
                    <h4>
                        <b><center> Project Cost Analysis </center></b>
                    </h4>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col pull-right">
                    <b><?php echo $this->lang->line('start_date'); ?>:</b> <?php echo date('d-M-Y',strtotime($project_data->project_start_date)); ?>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped table_th_6A8D9D">
                        <thead>
                            <tr>
                                <th style="width: 5%; "><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 15%; "><?php echo $this->lang->line('date'); ?></th> 
                                <th style="width: 20%; "><?php echo $this->lang->line('account_head'); ?></th>
                                <th style="width: 25%; "><?php echo $this->lang->line('description'); ?></th>
                                <th style="width: 5%;text-align: right;"><?php echo $this->lang->line('quantity'); ?></th>
                                <th style="width: 5%;text-align: right;"><?php echo $this->lang->line('rate'); ?></th>
                                <th style="width: 15%; text-align: right;"><?php echo $this->lang->line('amount'); ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $net_amount = 0; $quantity = 0;
                                foreach ($search_data as $key => $value): ?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td><?php echo date('d-M-Y',strtotime($value->date)); ?></td> 
                                <td><a target="_blank" href="<?= base_url('user/report/search?account_head_id='.$value->head_id.'&project_id='.$value->pid); ?>" style="text-decoration: none; color: #333;" ><?php echo $value->hname; ?></a></td>
                                <td><?php echo $value->account_desc; ?></td>
                                <td style="text-align: right;"><?php echo $value->quantity; $quantity += $value->quantity;?></td>
                                <td style="text-align: right;"><?php echo number_format((float)$value->rate, 2, '.', ''); ?></td>
                                <td style="text-align: right;"><?php echo number_format((float)$value->amount, 2, '.', ''); $net_amount += $value->amount;?></td> 
                            </tr>
                            <?php endforeach ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td> <b>  <?= $this->lang->line('total'); ?>  </b> </td>
                                <td style="text-align: right;"><?= $quantity; ?></td> 
                                <td></td>
                                <td style="text-align: right;"><?= number_format((float)$net_amount, 2, '.', ''); ?></td> 
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- /.row -->
            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">
                    <button type="button" onclick="printDiv('printablearea')" class="btn btn-default" style=" "><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                </div>
            </div> 
        </div>
    <?php } ?>
</section>
<script>
    $(function () {
    	$('#start_date,#end_date').datepicker({
    		autoclose: true,
    		changeYear:true,
    		changeMonth:true,
    		dateFormat: "dd-mm-yy",
    		yearRange: "-100:+2"
    	});
    });
</script>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

<script>
    $('#project_id').change(function(){

    var start_date = $(this).find(':selected').attr('data-start_date');
    $('#start_date').val(start_date);

});
</script>

