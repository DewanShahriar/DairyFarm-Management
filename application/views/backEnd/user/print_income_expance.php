
<!DOCTYPE html>
<html>
   <head>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <title> </title>
      <style>
       body{
       	width: 960px;
       	margin: 0 auto;
         font-family: "Times New Roman", Times, serif;
       }
         table.table1,  .table1 th,  .table1 td {
         }
         .table1 th, .table1 td {
         padding: 5px;
         }
         .table1 th {
         text-align: left;
         }
          table.table2,  .table2 th,  .table2 td {
         border: 1px solid black;
         border-collapse: collapse;
         margin-top: 20px;
         }
         .table2 th, .table2 td {
         padding: 5px;
         }
         .table2 th {
         text-align: left;
         } 
         table.table3,  .table3 th,  .table3 td {
         border: 1px solid black;
         border-collapse: collapse;
         }
         .table3 th, .table3 td {
         padding: 5px;
         }
         .table3 th {
         text-align: left;
         } 
         table.table4,  .table4 th,  .table4 td {
         border: 1px solid black;
         border-collapse: collapse;
         margin-top: 20px;
         }
         .table4 th, .table4 td {
         padding: 5px;
         }
         .table4 th {
         text-align: justify;
         } 

         
         @media print {
           .print_hide {display: none;}
         }

         <?php if (isset($print_break) && $print_break == true) { ?>
 
         @media print {
           #printablearea {page-break-after: always;}
         }

         <?php } ?>
        
      </style>
   </head>
   <body>
      <div id="printablearea">
         <table style="width:100%;" class="table1">
            <tr>
       
               <td style="width:30%; position: relative;">
                  	<img src="<?php echo base_url('assets/logo.png'); ?>" alt="" width="150" height="150">
               </td>
                
               <td style="width: 40%; line-height: 20px; text-align: center;">
                  <span style="font-size: 30px; font-weight: bold;">M/S RASEL ENTERPRISE</span><br><br>
                  <span style="background-color: #c3d0ec; color: #000; width: 30%; border-radius: 20px; padding: 5px 15px; font-size: 25px; border: 1px solid #c3d0ec;">Pro. Md. Rabiul Alam</span><br>
                  <div style="padding-bottom: 10px;"></div>
                  <span style="font-weight: bold;font-size: 20px;">Address : Baromari, Nalitabari, Sherpur</span><br>
                  <span style="font-weight: bold;font-size: 20px;">Mobile : 01717-112739, 01913-743046</span><br>
                  <span style="font-weight: bold;font-size: 20px;">E-mail : rabiuls39@gmail.com</span>
               </td>
               <td style="width: 30%;"></td>
            </tr>
         </table>
         <table style="width:100%;">
            <tr>
               
               <td style="width: 70%; font-size: 19px;"><b>Start Date : </b><?php echo date("d M Y", strtotime($project_info->project_start_date)); ?></td>
            </tr>
            <tr>
               <td style="width: 30%; font-size: 19px;"><b>Name : </b> <?php echo $project_info->name; ?> </td>
               <td style="width: 30%; font-size: 19px;"><b>Report Date :</b> <?php echo date("d M Y", strtotime($start_date)); ?> </td>
               
            </tr>
            <tr>
               <td style="width: 70%; font-size: 19px;"><b>Address :</b> <?php echo $project_info->address; ?> </td>
            </tr>
         </table>
         <br>
         <table  style="width: 100%" class="table3">
            <tr style="font-size: 20px;">
               <th style="width: 5%;text-align: center; font-size: 20px;">SI</th>
               <th style="width: 27%;text-align: center; font-size: 20px;">Purpose</th>
               <th style="width: 38%;text-align: center; font-size: 20px;">Description</th>
               <th style="width: 5%;text-align: center; font-size: 20px;">Qty</th>
               <th style="width: 10%;text-align: center; font-size: 20px;">Rate</th>
               <th style="width: 15%;text-align: center; font-size: 20px;">Amount</th>
            </tr>
            <?php 
               $expense_Add = 0;

               foreach ($todays_expenditure as $key => $value) {
            ?>
               <tr>
                  <td style="font-size: 19px"> <?php echo ++$key; ?> </td>
                  <td style="font-size: 19px"> <?php echo $value->name; ?> </td>
                  <td style="font-size: 19px"> <?php echo $value->description; ?> </td>
                  <td style="font-size: 19px;text-align: center;"> <?php echo $value->quantity; ?> </td>
                  <td style="font-size: 19px;text-align: right;"> <?php echo number_format((float)$value->rate, 2, '.', ''); ?>  </td> 
                  <td style="font-size: 19px;text-align: right"> <?php echo number_format((float)$value->amount, 2, '.', ''); $expense_Add += $value->amount;  ?> </td>
               </tr>
            <?php } ?>
            <tr>
               <td colspan="4" style="font-size: 19px;">
                  <b>T<small>k</small> (In word) = </b><?= convert_number_to_words($expense_Add); ?> 
               </td> 
               <td>
                  <span style="float: right;font-size: 19px">Total: </span>  
               </td> 
               <td style="font-size: 19px;text-align: right">
                   <?php echo number_format((float)$expense_Add, 2, '.', ''); ?>
               </td> 
            </tr>
         </table>
         <br>

         <div style="width: 100%">  
            
            <div style="width: 49%; float: left">
               <button class="diposite_btn" type="button" style="padding: 6px 12px;background: #ebebeb;color: #;border: 1px solid #c3b8b8;border-radius: 5px;font-size: 14px;margin-bottom: 10px;cursor:pointer; "> Current Deposite </button><br>
               <table class="table3 diposite_tbl" style="width: 100%;">
                  <tr style="font-size: 20px;">
                     <th style="width:10%; text-align: center; font-size: 20px;">SI</th>
                     <th style="width:60%; text-align: center; font-size: 20px;">Name</th>
                     <th style="width:30%; text-align: center; font-size: 20px;">Deposite</th>
                  </tr>
                  <?php 
                     $todays_total_deposite = 0;

                     foreach ($todays_all_depostite as $key => $value) {
                  ?>
                     <tr>
                        <td style="font-size: 19px"> <?php echo ++$key; ?> </td>

                        <td style="font-size: 19px"> <?php echo $value->name; ?> </td>

                        <td style="font-size: 19px;text-align: right"> <?php echo number_format((float)$value->amount, 2, '.', ''); $todays_total_deposite += $value->amount;  ?> </td>
                     </tr>
                  <?php } ?>
                  <tr>
                     <td colspan="2" style="font-size: 19px; text-align: right;">
                        <b>Total Deposite = </b>  
                     </td> 
                     <td style="font-size: 19px;text-align: right">
                         <?php echo number_format((float)$todays_total_deposite, 2, '.', ''); ?>
                     </td> 
                  </tr>
               </table>
            </div>  
               
            <div style="width: 49%; float: right">
               
               <button class="withdraw_btn" type="button" style="padding: 6px 12px;background: #ebebeb;color: #;border: 1px solid #c3b8b8;border-radius: 5px;font-size: 14px;margin-bottom: 10px;cursor:pointer; "> Todays Withdraw </button><br>
               <table class="table3 withdraw_tbl" style="width: 100%;">
                  <tr style="font-size: 20px;">
                     <th style="width:10%; text-align: center; font-size: 20px;">SI</th>
                     <th style="width:60%; text-align: center; font-size: 20px;">Name</th>
                     <th style="width:30%; text-align: center; font-size: 20px;">Withdraw</th>
                  </tr>
                  <?php 
                     $todays_withdraw_total = 0;

                     foreach ($todays_withdraw as $key => $wid_value) {
                  ?>
                     <tr>
                        <td style="font-size: 19px"> <?php echo ++$key; ?> </td>

                        <td style="font-size: 19px"> <?php echo $wid_value->name; ?> </td>

                        <td style="font-size: 19px;text-align: right"> <?php echo number_format((float)$wid_value->amount, 2, '.', ''); $todays_withdraw_total += $wid_value->amount;  ?> </td>
                     </tr>
                  <?php } ?>
                  <tr>
                     <td colspan="2" style="font-size: 19px; text-align: right;">
                        <b>Total Withdraw = </b>  
                     </td> 
                     <td style="font-size: 19px;text-align: right">
                         <?php echo number_format((float)$todays_withdraw_total, 2, '.', ''); ?>
                     </td> 
                  </tr>
               </table>

            </div>


            
         </div>
         
         
         
         
         
         <table style="width:100%;">
            <tr >
               <td style="width: 40%;">
                  <table style="width: 100%;" class="table4">
                     <tr>
                        <th style="width: 50%; background-color: #c3d0ec; color: #000; font-size: 19px">B.F. T<small>k</small>  <span style="float: right;">= </span></th>
                        <td style="width: 50%; font-size: 19px;text-align: right">
                           <?php
                           $bff =  $previous_accounts_income->amount - $previous_accounts_expense->amount - ($previous_withdraw->amount);
                           echo number_format((float)$bff, 2, '.', '');
                           ?>
                        </td>
                     </tr>
                     <tr>
                        <th style="width: 50%;background-color: #c3d0ec; color: #000; font-size: 19px">Current Diposit<span style="float: right;">= </span> </th>

                        <td style="width: 50%; font-size: 19px;text-align: right">
                           <?php echo number_format((float)$todays_depostite->income, 2, '.', ''); ?>
                        </td>
                     </tr>
                     <tr>
                        <th style="width: 50%;background-color: #c3d0ec; color: #000; font-size: 19px">Total T<small>k</small> <span style="float: right;">= </span></th>

                        <td style="width: 50%; font-size: 19px;text-align: right"><?php  $total_income = $bff + $todays_depostite->income; echo number_format((float)$total_income, 2, '.', '');?></td>
                     </tr>
                     <tr>
                        <th style="width: 50%;background-color: #c3d0ec; color: #000; font-size: 19px">Expenditure<span style="float: right;">= </span> </th>

                        <td style="width: 50%; font-size: 19px;text-align: right">
                           <?php echo number_format((float)$expense_Add, 2, '.', ''); ?>
                        </td>
                     </tr>
                     <tr>
                        <th style="width: 50%;background-color: #c3d0ec; color: #000; font-size: 19px">Balance<span style="float: right;">= </span> </th>

                        <td style="width: 50%; font-size: 19px;text-align: right"><?php $balance = $total_income - $expense_Add - $todays_withdraw_total; echo number_format((float)$balance, 2, '.', '');?></td>
                     </tr>
                     <tr>
                        <th style="width: 50%;background-color: #c3d0ec; color: #000; font-size: 19px">Total Expance<span style="float: right;">= </span> </th>
                        
                        <td style="width: 50%; font-size: 19px;text-align: right"><?php (float)$expance = (float)$previous_accounts_expense->amount + (float)$expense_Add; echo number_format((float)$expance, 2, '.', '');?></td>
                     </tr>
                  </table>
               </td>
               <td style="width: 30%; text-align: center; padding-top: 150px;">
               <span  style="font-size: 20px;"><b>Checked by</b>
                </span>
               </td>
               <td style="width: 30%; text-align: center; padding-top: 150px;">
               <span style="font-size: 20px;"><b>M/S. Rasel Enterprise <br>Chairman</b><br><b>Md. Rabiul Alam</b>
                </span>
               </td>
            </tr>
         </table>
      </div>
      <br>
      <button type="button" class="print_hide" style="padding: 6px 12px;background: #ebebeb;color: #;border: 1px solid #c3b8b8;border-radius: 5px;font-size: 14px;margin-bottom: 10px;cursor:pointer; " onclick="printDiv()"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>

      <?php if (isset($print_break) && $print_break == true) { ?>
         <div class="print_hide">
            <center><br>
            ----------------------------------------------------------------------------------------------------------------------------------------------------------------
            <br></center>
         </div>

      <?php } ?>

      <script type="text/javascript">
         function printDiv(divName) {
            
           window.print();
            
         }
      </script>
      <script type="text/javascript">
         $(document).ready(function () {
            $('.diposite_tbl').hide();
             $(".diposite_btn").click(function () {
                 $(".diposite_tbl").toggle();
             });

             $('.withdraw_tbl').hide();
             $(".withdraw_btn").click(function () {
                 $(".withdraw_tbl").toggle();
             });
         });
      </script>
   </body>
</html>

