

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('account_head'); ?> </h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <div class="box-body">
                    <?php if(isset($edit_info)){ ?>
                    <div class="row" style="box-shadow: 1px 1px 15px 5px #c99568; margin: 10px 30px 40px 25px; padding: 30px 0px 30px 0px;">
                        <form action="<?php echo base_url('user/accounthead/edit/'.$edit_info->id) ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('name'); ?> </label>
                                            <input name="name" class="form-control inner_shadow_orange" placeholder="<?php echo $this->lang->line('name'); ?>" required="" type="text" value="<?php echo $edit_info->name; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('category'); ?> </label>
                                            <select name="category" id="" class="form-control select2 inner_shadow_orange" >
                                                <option value="1" <?php if ($edit_info->category == 1) echo 'selected' ; ?> > <?php echo $this->lang->line('income'); ?> </option>
                                                <option value="0" <?php if ($edit_info->category == 0) echo 'selected' ; ?> > <?php echo $this->lang->line('expence'); ?> </option>
                                                <option value="2" <?php if ($edit_info->category == 2) echo 'selected' ; ?> > <?php echo $this->lang->line('withdraw'); ?> </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('parent'); ?></label>
                                            <select name="parent_id" id="" class="form-control select2 inner_shadow_orange" >
                                                <option value=""><?php echo $this->lang->line('select_parent'); ?></option>
                                                <?php foreach ($parent_zero as $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>" <?php if ($edit_info->parent_id == $value->id) echo 'selected'; ?>><?php echo $value->name; ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <br> </label>
                                            <button type="submit" class="form-control btn bg-orange"> <?php echo $this->lang->line('save'); ?> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php }else {?>
                    <div class="row" style="box-shadow: 1px 1px 15px 5px #3c8dbc;margin: 10px 30px 40px 25px;padding: 30px 0px 30px 0px;">
                        <form action="<?php echo base_url('user/accounthead/add/') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('name'); ?> </label>
                                            <input name="name" class="form-control" placeholder="<?php echo $this->lang->line('name'); ?>" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('category'); ?> </label>
                                            <select name="category" id="" class="form-control select2">
                                                <option value=""><?php echo $this->lang->line('select_category'); ?></option>
                                                <option value="1"><?php echo $this->lang->line('income'); ?></option>
                                                <option value="0"><?php echo $this->lang->line('expence'); ?></option>
                                                <option value="2"><?php echo $this->lang->line('withdraw'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('parent'); ?></label>
                                            <select name="parent_id" id="" class="form-control select2">
                                                <option value=""><?php echo $this->lang->line('select_parent'); ?></option>
                                                <?php foreach ($parent_zero as $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>"> <?php echo $value->name; ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <br> </label>
                                            <button type="submit" class="form-control btn bg-orange"> <?php echo $this->lang->line('save'); ?> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php } ?>
                    <br><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#income" data-toggle="tab"><?php echo $this->lang->line('income'); ?></a></li>
                                    <li><a href="#expance" data-toggle="tab"><?php echo $this->lang->line('expence'); ?></a></li>
                                    <li><a href="#withdraw" data-toggle="tab"><?php echo $this->lang->line('withdraw'); ?></a></li>
                                    <li><a href="<?php echo base_url('user/cashin_withdraw_join') ?>"><?php echo $this->lang->line('cash_in_withdraw') ?></a></li>
                                </ul>
                                <br>
                                <div class="tab-content">
                                    <div class="active tab-pane" id="income">
                                        <table id="userListTable" class="table table-bordered table-striped table_th_orange">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%; "><?php echo $this->lang->line('sl'); ?></th>
                                                    <th style="width: 30%; "><?php echo $this->lang->line('category'); ?></th>
                                                    <th style="width: 20%; "><?php echo $this->lang->line('name'); ?></th>
                                                    <th style="width: 30%; "><?php echo $this->lang->line('parent'); ?></th>
                                                    <th style="width: 15%; "><?php echo $this->lang->line('action'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sl = 1;
                                                    foreach ($account_head as $key => $value) {
                                                        
                                                        if ($value->category == 1) {
                                                        ?>
                                                <tr>
                                                    <td> <?= $sl++; ?> </td>
                                                    <td> <?php if ($value->category == 1 ) {
                                                        echo "Cash In";
                                                    } ?> </td>
                                                    <td> <?= $value->name ; ?> </td>
                                                    <td> <?= $value->name ; ?> </td>
                                                    <td>
                                                        <a href="<?= base_url('user/accounthead/edit/'.$value->id); ?>" class="btn btn-sm bg-green"> <i class="fa fa-edit"></i> </a>
                                                        <a href="<?= base_url('user/accounthead/delete/'.$value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-orange"> <i class="fa fa-trash"></i> </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                    } }
                                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="expance">
                                        <table id="userListTable2" class="table table-bordered table-striped table_th_orange">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%; "><?php echo $this->lang->line('sl'); ?></th>
                                                    <th style="width: 30%; "><?php echo $this->lang->line('category'); ?></th>
                                                    <th style="width: 20%; "><?php echo $this->lang->line('name'); ?></th>
                                                    <th style="width: 30%; "><?php echo $this->lang->line('parent'); ?></th>
                                                    <th style="width: 15%; "><?php echo $this->lang->line('action'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sl = 1;
                                                    foreach ($account_head as $key => $value) {
                                                         
                                                        if ($value->category == 0) {
                                                        ?>
                                                <tr>
                                                    <td> <?= $sl++; ?> </td>
                                                    <td> <?php if ($value->category == 0 ) {
                                                        echo "Expance";
                                                    } ?> </td>
                                                    <td> <?= $value->name ; ?> </td>
                                                    <td> <?= $value->name ; ?> </td>
                                                    <td>
                                                        <a href="<?= base_url('user/accounthead/edit/'.$value->id); ?>" class="btn btn-sm bg-green"> <i class="fa fa-edit"></i> </a>
                                                        <a href="<?= base_url('user/accounthead/delete/'.$value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-orange"> <i class="fa fa-trash"></i> </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                    } }
                                                    ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="tab-pane" id="withdraw">
                                        <table id="userListTable3" class="table table-bordered table-striped table_th_orange">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%; "><?php echo $this->lang->line('sl'); ?></th>
                                                    <th style="width: 30%; "><?php echo $this->lang->line('category'); ?></th>
                                                    <th style="width: 20%; "><?php echo $this->lang->line('name'); ?></th>
                                                    <th style="width: 30%; "><?php echo $this->lang->line('parent'); ?></th>
                                                    <th style="width: 15%; "><?php echo $this->lang->line('action'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sl = 1;
                                                    foreach ($account_head as $key => $value) {
                                                         
                                                        if ($value->category == 2) {
                                                        ?>
                                                <tr>
                                                    <td> <?= $sl++; ?> </td>
                                                    <td> <?php if ($value->category == 2 ) {
                                                        echo "Withdraw";
                                                    } ?> </td>
                                                    <td> <?= $value->name ; ?> </td>
                                                    <td> <?= $value->name ; ?> </td>
                                                    <td>
                                                        <a href="<?= base_url('user/accounthead/edit/'.$value->id); ?>" class="btn btn-sm bg-green"> <i class="fa fa-edit"></i> </a>
                                                        <a href="<?= base_url('user/accounthead/delete/'.$value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-orange"> <i class="fa fa-trash"></i> </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                    } }
                                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        
                            
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
      $("#userListTable2").DataTable();
      $("#userListTable3").DataTable();
    });
    
</script>

