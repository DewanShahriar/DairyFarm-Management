<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('account_add'); ?> </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/accounts/list" type="submit" class="btn bg-green btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('account_list'); ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form action="<?php echo base_url('admin/accounts/add') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('project'); ?> </label>
                                            <select name="project_id" id="" class="form-control select2 inner_shadow_purple" required="">
                                                <option value=""> <?php echo $this->lang->line('select_project'); ?> </option>
                                                <?php foreach ($projects as $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>"> <?php echo $value->name; ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('date'); ?> </label>
                                            <input name="date" id="date" class="form-control inner_shadow_purple" placeholder="<?php echo $this->lang->line('date'); ?>" required="" type="text" autocomplete="off" onkeypress="return false;" value="<?= date('d-m-Y'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped table_th_primary" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                                    <th style="width: 20%;"><?php echo $this->lang->line('bill_type'); ?></th>
                                                    <th style="width: 20%;"><?php echo $this->lang->line('account_head'); ?></th>
                                                    <th style="width: 20%;"><?php echo $this->lang->line('description'); ?></th>
                                                    <th style="width: 10%;"><?php echo $this->lang->line('quantity'); ?></th>
                                                    <th style="width: 10%;"><?php echo $this->lang->line('rate'); ?></th>
                                                    <th style="width: 15%;"><?php echo $this->lang->line('amount'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" name="showrowid" id="showrowid" value="10">
                                                <?php
                                                    // 61 is the max limit, change to javascript also from botom of the code.
                                                    
                                                    for ($i=1; $i < 61 ; $i++) { ?>
                                                <tr id="trid<?= $i; ?>" style="<?php if($i > 10) echo 'display: none'; ?>">
                                                    <td><?php echo $i; ?></td>
                                                    <td>
                                                        <select name="parent_head" id="parent_head" class="form-control select2" onchange="loadChield(this.value, <?= $i; ?>)" style="width:100%" >
                                                            <option value=""><?php echo $this->lang->line('select_bill_type'); ?></option>
                                                            <?php foreach ($parent_head as $key => $parent_value): ?>
                                                            <option data-keyid="<?= $i; ?>" value="<?php echo $parent_value->id; ?>"><?php echo $parent_value->name; ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="account_head_id[]" id="account_head_id<?= $i; ?>" class="form-control select2" style="width:100%">
                                                            <option value=""><?php echo $this->lang->line('select_account_head'); ?></option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea name="description[]" id="" class="form-control inner_shadow_purple" cols="" rows="1"></textarea> 
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control inner_shadow_purple numberconvert" name="quantity[]" value="0" min="0" id="quantity<?= $i; ?>" placeholder="<?php echo $this->lang->line('quantity'); ?>" onkeyup="amountshow(<?= $i; ?>)">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.001" class="form-control inner_shadow_purple numberconvert" name="rate[]" value="0" id="rate<?= $i; ?>" min="0" placeholder="<?php echo $this->lang->line('rate'); ?>" onkeyup="amountshow(<?= $i; ?>)">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.001" class="form-control inner_shadow_purple numberconvert" name="amount[]" value="0" id="amount<?= $i; ?>" min="0" placeholder="<?php echo $this->lang->line('amount'); ?>" readonly>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold;"><?php echo $this->lang->line('total') ?>: </td>
                                                    <td>
                                                        <input type="text" readonly id="total_amount_id" style="border: none;">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="col-sm-12">
                                <center>
                                    <a href="<?php echo current_url(); ?>" class="btn bg-purple"><?php echo $this->lang->line('reset') ?></a>
                                    <button type="submit" class="btn btn-success"><?php echo $this->lang->line('save') ?></button>
                                    <a class="btn btn-info" onclick="makerowvisible();"><i class="fa fa-plus"></i> </a>
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
</section>
<script type="text/javascript">
    $(function () {
    
      $("#userListTable").DataTable();
    
    });
    
    
    
</script>
<script>
    $(function () {
    
        $('#date').datepicker({
    
            autoclose: true,
    
            changeYear:true,
    
            changeMonth:true,
    
            dateFormat: "dd-mm-yy",
    
            yearRange: "-100:+5"
    
        });
    
    });
    
    
    
    $(".numberconvert").keypress(function(event){
    
        var ew = event.which;
    
        
    
        if(ew == 32) return true;
    
        if(48 <= ew && ew <= 57) return true;
    
        if(2534 <= ew && ew <= 2543){
    
            return false;
    
        }
    
        if(97 <= ew && ew <= 122) return false;
    
        
    
        //return false;
    
        
    
    });
    
</script>
<script>
    function loadChield(parent_head, keyid) {
    
    
        $.post("<?php echo base_url() . "admin/get_account_head/"; ?>" + parent_head,
    
            {'nothing': 'nothing'},
    
            function (data2) {
    
                var data = JSON.parse(data2);
    
                $("#account_head_id"+keyid).find('option').remove().end();
    
                $.each(data, function (i, item) {
    
                        $("#account_head_id"+keyid).append($('<option>', {
    
                                value: this.id,
    
                                text: this.name,
    
                        }));
    
                });
    
            });
    
    }
    
</script>
<script>
    function amountshow(id) {
    
        var quantity = $('#quantity'+id).val();
        
        var rate     = $('#rate'+id).val();
    
        var amount =  quantity *  rate ;
    
        $('#amount'+id).val(amount); 
    
        var total_amount = 0;
    
        // same as php for loop from up.
    
        for(var i = 1; i < 61; i++){
    
            var tempamount = $('#amount'+i).val(); 
            total_amount+= Number(tempamount);
        }
    
        $('#total_amount_id').val(total_amount);
    }
    
    function makerowvisible(){
        
        var nextrownumber = $("#showrowid").val();
        $("#trid"+Number(nextrownumber)).show();
        $("#showrowid").val(Number(nextrownumber)+1);
    }
</script>