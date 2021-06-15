<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('cash_in_withdraw'); ?> </h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <div class="box-body">
                    <?php if(isset($edit_info)){ ?>
                    <div class="row" style="box-shadow: 1px 1px 15px 5px #c99568; margin: 10px 30px 40px 25px; padding: 30px 0px 30px 0px;">
                        <form action="<?php echo base_url('admin/cashin_withdraw_join/edit/'.$edit_info->id) ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('cash_in'); ?> </label>
                                            <select name="cash_in_id" id="" class="form-control select2" required="">
                                                <option value=""><?php echo $this->lang->line('select_income'); ?></option>
                                                <?php foreach ($accounthead as $key => $value) {
                                                        if ($value->category == 1) {
                                                 ?>
                                                    <option value="<?php echo $value->id; ?>" 
                                                        <?php if ($edit_info->cash_in_id == $value->id) {
                                                            echo "selected";
                                                        } ?>
                                                        ><?php echo $value->name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('withdraw'); ?></label>
                                            <select name="withraw_id" id="" class="form-control select2" required="">
                                                <option value=""><?php echo $this->lang->line('select_withdraw'); ?></option>
                                                <?php foreach ($accounthead as $key => $value) {
                                                        if ($value->category == 2) {
                                                 ?>
                                                <option value="<?php echo $value->id; ?>"
                                                <?php if ($edit_info->withraw_id == $value->id) {
                                                        echo "selected";
                                                    } ?>
                                                    > <?php echo $value->name; ?> </option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <br> </label>
                                            <button type="submit" class="form-control btn bg-orange"> <?php echo $this->lang->line('update'); ?> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </form>
                    </div>
                    <?php }else {?>
                    <div class="row" style="box-shadow: 1px 1px 15px 5px #3c8dbc;margin: 10px 30px 40px 25px;padding: 30px 0px 30px 0px;">
                        <form action="<?php echo base_url('admin/cashin_withdraw_join/add/') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('cash_in'); ?> </label>
                                            <select name="cash_in_id" id="" class="form-control select2" required="">
                                                <option value=""><?php echo $this->lang->line('select_income'); ?></option>
                                                <?php foreach ($accounthead as $key => $value) {
                                                        if ($value->category == 1) {
                                                 ?>
                                                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('withdraw'); ?></label>
                                            <select name="withraw_id" id="" class="form-control select2" required="">
                                                <option value=""><?php echo $this->lang->line('select_withdraw'); ?></option>
                                                <?php foreach ($accounthead as $key => $value) {
                                                        if ($value->category == 2) {
                                                 ?>
                                                <option value="<?php echo $value->id; ?>"> <?php echo $value->name; ?> </option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <br> </label>
                                            <button type="submit" class="form-control btn bg-orange"> <?php echo $this->lang->line('join'); ?> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="userListTable" class="table table-bordered table-striped table_th_orange">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl'); ?></th>
                                        <th><?php echo $this->lang->line('cash_in_id'); ?></th>
                                        <th><?php echo $this->lang->line('withdraw_id'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($cash_in_withdraw as $key => $value) {
                                            ?>
                                    <tr>
                                        <td> <?= $key+1; ?> </td>
                                        <td> <?= $this->db->where('id', $value->cash_in_id)->get('tbl_account_head')->row()->name; ?> </td>
                                        <td> <?= $this->db->where('id', $value->withraw_id)->get('tbl_account_head')->row()->name; ?> </td>
                                        <td>
                                            <a href="<?= base_url('admin/cashin_withdraw_join/edit/'.$value->id); ?>" class="btn btn-sm bg-green"> <i class="fa fa-edit"></i> </a>
                                            <a href="<?= base_url('admin/cashin_withdraw_join/delete/'.$value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-orange"> <i class="fa fa-trash"></i> </a>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                        ?>
                                </tbody>
                            </table>
                        </div>
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