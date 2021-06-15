<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('account_update'); ?> </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/accounts/list" type="submit" class="btn bg-green btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('account_list'); ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form action="<?php echo base_url('admin/accounts/edit/'.$edit_info->id) ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('project'); ?> </label>
                                            <select name="project_id" id="" class="form-control select2 inner_shadow_purple" required="">
                                                <option value=""> <?php echo $this->lang->line('select_project'); ?> </option>
                                                <?php foreach ($projects as $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>"
                                                    <?php if ($edit_info->project_id == $value->id){
                                                        echo "selected"; 
                                                        
                                                        } ?>
                                                    > <?php echo $value->name; ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('date'); ?> </label>
                                            <input name="date" id="date" class="form-control inner_shadow_purple" placeholder="<?php echo $this->lang->line('date'); ?>" required="" type="text" autocomplete="off" onkeypress="return false;" value="<?= $edit_info->date; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('description'); ?> </label>
                                            <textarea name="description" id="" class="form-control inner_shadow_purple" cols="" rows="1"><?= $edit_info->description; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('bill_type'); ?> </label>
                                            <select name="parent_head" id="parent_head" class="form-control select2" onchange="loadChield(this.value)" >
                                                <option value=""><?php echo $this->lang->line('select_bill_type'); ?></option>
                                                <?php foreach ($parent_head as $key => $parent_value): ?>
                                                <option value="<?php echo $parent_value->id; ?>"><?php echo $parent_value->name; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('account_head'); ?> </label>
                                            <select name="account_head_id" id="account_head_id" class="form-control select2">
                                                <?php foreach ($account_head as $key => $value) {?>
                                                <option value="<?php echo $value->id; ?>"
                                                    <?php if ($edit_info->account_head_id == $value->id) {echo "selected";} ?>
                                                    ><?php echo $value->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('quantity'); ?> </label>
                                            <input type="number" class="form-control inner_shadow_purple numberconvert" name="quantity" min="0" id="quantity" placeholder="<?php echo $this->lang->line('quantity'); ?>" onkeyup="amountshow()" value="<?php echo $edit_info->quantity; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('rate'); ?> </label>
                                            <input type="number" step="0.001" class="form-control inner_shadow_purple numberconvert" name="rate" id="rate" min="0" placeholder="<?php echo $this->lang->line('rate'); ?>" onkeyup="amountshow()" value="<?= $edit_info->rate; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('amount'); ?> </label>
                                            <input type="number" step="0.001" class="form-control inner_shadow_purple numberconvert" name="amount" id="amount" min="0" placeholder="<?php echo $this->lang->line('amount'); ?>" value="<?= $edit_info->amount; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <center>
                                    <button type="reset" class="btn bg-purple"><?php echo $this->lang->line('cancel') ?></button>
                                    <button type="submit" class="btn btn-success"><?php echo $this->lang->line('update') ?></button>
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
    function loadChield(parent_head) {
    
    
        $.post("<?php echo base_url() . "admin/get_account_head/"; ?>" + parent_head,
    
            {'nothing': 'nothing'},
    
            function (data2) {
    
                var data = JSON.parse(data2);
    
                $("#account_head_id").find('option').remove().end();
    
                $.each(data, function (i, item) {
    
                        $("#account_head_id").append($('<option>', {
    
                                value: this.id,
    
                                text: this.name,
    
                        }));
    
                });
    
            });
    
    
    }
    
</script>
<script>
    function amountshow() {
    
        var quantity = $('#quantity').val();
    
        var rate     = $('#rate').val();
    
        var amount =  quantity *  rate ;
    
        $('#amount').val(amount);
    
    }
    
</script>