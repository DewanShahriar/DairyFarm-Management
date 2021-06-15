
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-6a8d9d">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('daily_income_expence'); ?> </h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <div class="box-body">
                    <div class="row" style="box-shadow: 1px 1px 15px 5px #6a8d9d;margin: 10px 30px 40px 25px;padding: 30px 0px 30px 0px;">
                        <form action="<?php echo base_url('user/report/income_expance') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="control-label"> <?php echo $this->lang->line('income_expence'); ?> </label>
                                            <select name="income_expance" class="form-control select2" required="" >
                                                <option value=""> <?php echo $this->lang->line('select_income_expence'); ?> </option>
                                                <option value="0" <?php if (isset($income_expance) && $income_expance == 0) echo 'selected'; ?> ><?php echo $this->lang->line('expence'); ?> </option>
                                                <option value="1" <?php if (isset($income_expance) && $income_expance == 1) echo 'selected'; ?> ><?php echo $this->lang->line('income'); ?> </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('start_date'); ?> </label>
                                            <input name="start_date" class="form-control inner_shadow_6a8d9d" placeholder="<?php echo $this->lang->line('start_date'); ?>" type="text" id="start_date" autocomplete="off" onkeypress="return false" value="<?php echo set_value('start_date'); ?>" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('end_date'); ?> </label>
                                            <input name="end_date" class="form-control inner_shadow_6a8d9d" placeholder="<?php echo $this->lang->line('end_date'); ?>" type="text" id="end_date" autocomplete="off" onkeypress="return false" value="<?php echo set_value('end_date'); ?>" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <br> </label>
                                            <button type="submit" class="form-control btn btn-6a8d9d"><?php echo $this->lang->line('go'); ?></button>
                                        </div>
                                    </div>
                                </div>
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
            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12">
                    
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 30%; "> </td>
                            <td style="font-size: 32px;font-weight: bold;text-align: right;width: 40%;"> <center> M/S Rasel Enterprise </center> </td>
                            <td style="width: 30%;"> <span style="text-align: right;float: right; color: #333;"> Print Date: <?= date('d M Y'); ?>  </span> </td>
                        <tr>
                        <tr>
                            <td style="width: 30%; "> </td>
                            <td style="width: 40%; text-align: right;font-weight: bold;font-size: 20px; color: gray;"> <center> <?php if ($income_expance == 1) echo 'Deposit'; else echo 'Expense';  ?> Rerport  </center>  </td>
                            <td style="width: 30%; "> </td>
                        <tr>
                    </table>
                    
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped table_th_6A8D9D">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('date'); ?></th>
                                <th style="width: 25%;"><?php echo $this->lang->line('project'); ?></th>
                                <th style="width: 20%;"><?php echo $this->lang->line('account_head'); ?></th>
                                <th style="width: 20%;"><?php echo $this->lang->line('description'); ?></th>
                                <th style="width: 5%;text-align: right;"><?php echo $this->lang->line('quantity'); ?></th>
                                <th style="width: 5%;text-align: right;"><?php echo $this->lang->line('rate'); ?></th>
                                <th style="width: 10%; text-align: right;"><?php echo $this->lang->line('amount'); ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $amount = 0; $quantity = 0;                         
                                foreach ($search_data as $key => $value): ?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td><?php echo date('d-M-Y ',strtotime($value->date)); ?></td>
                                <td><?php echo $value->pname; ?></td>
                                <td><a target="_blank" href="<?= base_url('user/report/search?account_head_id='.$value->head_id.'&project_id='.$value->pid); ?>" style="text-decoration: none; color: #333;" ><?php echo $value->name; ?></a></td>
                                <td><?php echo $value->description; ?></td>
                                <td style="text-align: right;"><?php echo $value->quantity; $quantity += $value->quantity;?></td>
                                <td style="text-align: right;"><?php echo number_format((float)$value->rate, 2, '.', ''); ?></td>
                                <td style="text-align: right;"><?php echo number_format((float)$value->amount, 2, '.', ''); $amount += $value->amount; ?></td>
                            </tr>
                            <?php endforeach ?>
                            <tr>
                                <td colspan="5" style="text-align: right;padding-right: 5%;"> <b>  <?php echo $this->lang->line('total'); ?>  </b> </td>
                                <td style="text-align: right;"><?= $quantity; ?></td> 
                                <td></td> 
                                <td style="text-align: right;"><?= number_format((float)$amount, 2, '.', ''); ?></td> 
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
    		autoclose:   true,
    		changeYear:  true,
    		changeMonth: true,
    		dateFormat:  "dd-mm-yy",
    		yearRange:   "-100:+0"
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


