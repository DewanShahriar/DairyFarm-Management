
<section class="invoice" id="printablearea">
    
    <style> 
        @media print {
            a[href]:after {
                content: none !important;
            }

            .print_hide {display: none;}
        }
    </style>

    <div class="row">

        <div class="col-xs-12">
 

            <table style="width: 100%;">

                <tr>

                    <td style="width: 30%; "> </td>

                    <td style="font-size: 25px;font-weight: 600;text-align: right;width: 40%;text-decoration: underline;"> <center> <b>M/S Rasel Enterprise</b><br> <span style="font-size: 25px;"><b><?= $search_info[0]->name; ?></b>  </span> </center></td>

                    <td style="width: 30%;"> <span style="text-align: right;float: right; color: #333;"> Print Date: <?= date('d M Y'); ?>  </span> </td>

                </tr>

            </table>

            

            <br>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12 table-responsive">

            <table class="table table-striped table_th_6A8D9D">

                <thead>

                    <tr>

                        <th style="width: 5%;"> <?php echo $this->lang->line('sl'); ?> </th>
                        <th style="width: 10%;"> <?php echo $this->lang->line('date'); ?> </th>
                        <th style="width: 25%;"> <?php echo $this->lang->line('project'); ?> </th>
                        <th style="width: 17%;"> <?php echo $this->lang->line('account_head'); ?> </th>
                        <th style="width: 18%;"> <?php echo $this->lang->line('description'); ?> </th>
                        <th style="width: 5%;text-align: right;"> <?php echo $this->lang->line('quantity'); ?> </th>
                        <th style="width: 5%;text-align: right;"> <?php echo $this->lang->line('rate'); ?> </th>
                        
                        <?php if($is_withdraw == true) { ?>
                            
                            <th style="width: 7%; text-align: right;"> <?php echo $this->lang->line('withdraw'); ?> </th>  
                            <th style="width: 8%; text-align: right;"> <?php echo $this->lang->line('amount'); ?> </th>  
                            
                        <?php }else { ?> 
                            
                            <th style="width: 15%; text-align: right;"> <?php echo $this->lang->line('amount'); ?> </th>  
                            
                        <?php } ?>
                        

                    </tr>

                </thead>

                <tbody>

                    <?php 

                        $amount = 0; $quantity = 0; $withdraw = 0;

                        foreach ($search_info as $key => $value): 
                    ?>

                            <tr>

                                <td><?php echo ++$key; ?></td>

                                <td><?php echo date('d-M-Y ',strtotime($value->date)); ?></td>

                                <td><?php echo $value->pname; ?></td>

                                <td><?php echo $value->name;?></td>

                                <td><?php echo $value->description; ?></td>

                                <td style="text-align: right;"><?php echo $value->quantity; $quantity += $value->quantity;?></td>
                                <td style="text-align: right;"><?php echo number_format((float)$value->rate, 2, '.', ''); ?></td>
                                
                                <?php if($accounthead_id != $value->head_id) { ?>
                            
                                    <td style="text-align: right;"> <?php echo number_format((float)$value->amount, 2, '.', ''); $withdraw += $value->amount; ?> </td>  
                                    <td style="text-align: right;">  </td>  
                                    
                                <?php }else { ?> 
                                    
                                    <?php if($is_withdraw == true) { ?>
                            
                                           <td style="text-align: right;">  </td>  
                                        
                                    <?php } ?> 
                                    
                                    <td style="text-align: right;"> <?php echo number_format((float)$value->amount, 2, '.', ''); $amount += $value->amount; ?> </td>  
                                    
                                <?php } ?>

                            </tr>

                    <?php endforeach ?>

                    <tr>
                        
                        <?php if($is_withdraw == true) { ?>
                            
                            <td colspan="5" style="text-align: right;padding-right: 5%;"> <b>  <?php echo $this->lang->line('total'); ?>  </b> </td>

                            <td style="text-align: right;"><?= $quantity; ?></td> 
                            <td></td> 
                            <td style="text-align: right;"><?= number_format((float)$withdraw, 2, '.', ''); ?></td>
                            <td style="text-align: right;"><?= number_format((float)$amount, 2, '.', ''); ?></td>
                            
                        <?php }else { ?> 
                            
                            <td colspan="5" style="text-align: right;padding-right: 5%;"> <b>  <?php echo $this->lang->line('total'); ?>  </b> </td>

                            <td style="text-align: right;"><?= $quantity; ?></td> 
                            <td></td> 
                            <td style="text-align: right;"><?= number_format((float)$amount, 2, '.', ''); ?></td>
                            
                        <?php } ?>

                        

                    </tr>
                    
                    <?php if($is_withdraw == true) { ?>
                        
                        <tr>    
                            <td colspan="8" style="text-align: right; padding-right: 5%;"> <b>  <?php echo $this->lang->line('grand_total'); ?>  </b> </td>
                            <td style="text-align: right;"><?= number_format((float)$amount-$withdraw, 2, '.', ''); ?></td>
                        </tr>
                        
                    <?php }  ?> 

                </tbody>

            </table>

        </div>

        <!-- /.col -->

    </div>

    <div class="row no-print">

        <div class="col-xs-12">

            <button type="button" class="print_hide" target="_blank" onclick="printDiv('printablearea')" class="btn btn-default" style="padding: 3px 10px;"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>

        </div>

    </div>

</section>



<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>