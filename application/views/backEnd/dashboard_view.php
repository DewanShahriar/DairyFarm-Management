<section class="content">
	<!-- Info boxes -->
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-aqua"><i class="fa fa-database"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><?php echo $this->lang->line('total_cow'); ?></span>
					<span class="info-box-number"> <?php echo $total_cow; ?> </span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"> <?php echo $this->lang->line('total_account_head'); ?> </span>
					<span class="info-box-number"> <?php echo $total_account_head; ?> </span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-red"><i class="fa fa-list-ol"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"> <?php echo $this->lang->line('today_income'); ?> </span>
					<span class="info-box-number"> <?php if (isset($today_income->income)) {
						echo number_format((float)$today_income->income, 2, '.', '');;
					}else{echo "0.00";}?> </span> 

				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->

		<!-- fix for small devices only -->
		<div class="clearfix visible-sm-block"></div>

		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-green"><i class="fa fa-group "></i></span>

				<div class="info-box-content">
					<span class="info-box-text"> <?php echo $this->lang->line('today_expance'); ?></span>
					<span class="info-box-number"> 
						<?php if (isset($today_expance->expance)) {
									echo number_format((float)$today_expance->expance, 2, '.', '');
								}else{echo "0.00";}
						?> 
					</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->

		<!-- /.col -->
	</div>
	<!-- /.row -->

	<!-- //upcoming vaccine and milk collection -->
	<div class="row">
		<div class="col-xs-8">
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('vaccine_push_date'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/cow-vaccine/list') ?>" class="btn bg-purple btn-sm"><i class="fa fa-list"></i> <?php echo $this->lang->line('select_all'); ?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="overflow: scroll; overflow-x:auto; height: 300px;">
                    <table id="cowTypeList" class="table table-bordered table-striped table_th_orange">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 30%;"><?php echo $this->lang->line('next_push_date'); ?></th>
                                <th style="width: 30%;"><?php echo $this->lang->line('cow_no'); ?></th>
                                <th style="width: 35%;"><?php echo $this->lang->line('vaccine_name'); ?></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                        	<?php 
                                $sl = 1;
                                foreach ($upcoming_vaccine_list as $value) {
                                	?>
                                	
                            <tr>
                                <td> <?php echo $sl++ ; ?> </td>
                                <td> <?php echo date('d M Y', strtotime($value->next_push_date)); ?> </td>
                                <td><a href="<?php echo base_url('admin/cow-details/edit/'.$value->id); ?>" > <?php echo $value->cow_no; ?> </a></td>
                                <td> <?php echo $value->vaccine_name; ?> </td>
                               
                                
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
        <div class="col-xs-4">
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-circle-o-notch"></i><h3 class="box-title"><?php echo $this->lang->line('cow_milk_collection'); ?></h3>
                    <div class="box-tools pull-right">
                        
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" >
                	<ul>
                		<li><p>Today collection   : <strong><?php if($today_milk > 0) echo $today_milk; else echo '0';?> (ltr) </strong>| Target : <strong><?php if($today_milk > 0) echo $total_target_sum; else echo '0';?> (ltr)</strong></p></li>
                		<li><p>Lastday collection : <strong><?php echo $lastday_milk;?> (ltr)</strong></p></li>
                		
                	</ul>
                    
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <!-- income expense -->
	
    <div class="row">
		<div class="col-xs-6">
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('cash_in'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/accounts/list') ?>" class="btn bg-purple btn-sm"><i class="fa fa-list"></i> <?php echo $this->lang->line('all'); ?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="overflow: scroll; overflow-x:auto; height: 300px;">
                    <table id="cowTypeList" class="table table-bordered table-striped table_th_orange">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 30%;"><?php echo $this->lang->line('date'); ?></th>
                                <th style="width: 30%;"><?php echo $this->lang->line('purpose'); ?></th>
                                <th style="width: 35%;"><?php echo $this->lang->line('amount'); ?></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                        	<?php 
                                $sl = 1;
                                $total_cash = 0;
                                foreach ($cash_in_list as $value) {
                                	$total_cash += $value->amount;
                                	?>
                                	
                            <tr>
                                <td> <?php echo $sl++ ; ?> </td>
                                <td> <?php echo date('d M Y', strtotime($value->date)); ?> </td>
                                <td> <?php echo $value->name; ?></td>
                                <td> <?php echo $value->amount; ?> </td>
                               
                                
                            </tr>
                        
                            <?php
                                }
                                ?>
                                <tr>
                                	<td colspan="3" style="text-align: right; font-size: 15px; font-weight: bold;">Total</td>
                                	<td><strong><?php echo $total_cash;?> Tk.</strong></td>
                                </tr>
                        </tbody>
                        
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-xs-6">
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('expence'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/accounts/list') ?>" class="btn bg-purple btn-sm"><i class="fa fa-list"></i> <?php echo $this->lang->line('all'); ?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="overflow: scroll; overflow-x:auto; height: 300px;">
                    <table id="cowTypeList" class="table table-bordered table-striped table_th_orange">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 30%;"><?php echo $this->lang->line('date'); ?></th>
                                <th style="width: 30%;"><?php echo $this->lang->line('purpose'); ?></th>
                                <th style="width: 35%;"><?php echo $this->lang->line('amount'); ?></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                        	<?php 
                                $sl = 1;
                                $total_expense = 0;
                                foreach ($expense_list as $value) {
                                	$total_expense += $value->amount;
                                	?>
                                	
                            <tr>
                                <td> <?php echo $sl++ ; ?> </td>
                                <td> <?php echo date('d M Y', strtotime($value->date)); ?> </td>
                                <td> <?php echo $value->name; ?> </td>
                                <td> <?php echo $value->amount; ?> </td>
                               
                                
                            </tr>
                        
                            <?php
                                }
                                ?>
                                <tr>
                                	<td colspan="3" style="text-align: right; font-size: 15px; font-weight: bold;">Total</td>
                                	<td><strong><?php echo $total_expense;?> Tk.</strong></td>
                                </tr>
                        </tbody>
                        
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

</section>

<script>
	

$(document).ready(function(){
   $('select[name="income_project_id"]').change(function(){
       $(".expense_income_submit1").submit();
    });
   $('select[name="expense_project_id"]').change(function(){
       $(".expense_income_submit2").submit();
    });
});
</script>