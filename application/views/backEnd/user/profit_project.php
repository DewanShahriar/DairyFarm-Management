<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('profit_project'); ?> </h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_purple">
                        <thead>
                            <tr>
                                <th width="5%"><?php echo $this->lang->line('sl'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('name'); ?></th>
                                <th width="20%"><?php echo $this->lang->line('description'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('package_no'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('project_id'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('remark'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('budget'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('cost'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('profit'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sl = 0;
                                foreach ($profit_project as $key => $value) {

                                    if($value->budget <= $value->amount) continue;
                                    ?>
                            <tr>
                                <td> <?php echo ++$sl ; ?> </td>
                                <td> <?php echo $value->name; ?> </td>
                                <td> <?php echo $value->description; ?> </td>
                                <td> <?php echo $value->package_no; ?> </td>
                                <td> <?php echo $value->project_gov_id; ?> </td>
                                <td> <?php echo $value->remark; ?> </td>
                                <td> <?php echo number_format((float)$value->budget, 2, '.', '').'৳'; ?> </td>
                                <td> <?php echo number_format((float)$value->amount, 2, '.', '').'৳'; ?> </td>
                                <td> <?php echo number_format((float)$value->budget - $value->amount, 2, '.', '').'৳'; ?> </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>
<script type="text/javascript">
    $(function () {
      $("#userListTable").DataTable();
    });
    
</script>