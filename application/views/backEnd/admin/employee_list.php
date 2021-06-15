

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('employee_list'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/employee/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i><?php echo $this->lang->line('employee_add'); ?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_info">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 25%;"><?php echo $this->lang->line('employee_name'); ?></th>
                                <th style="width: 25%;"><?php echo $this->lang->line('employee_number'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('position'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('image'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('join_date'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sl = 1;
                                foreach ($employee_list as $value) {
                                	?>
                            <tr>
                                <td> <?php echo $sl++ ; ?> </td>
                                <td> <?php echo $value->name; ?> </td>
                                <td> <?php echo $value->phone_number; ?> </td>
                                <td> <?php echo $value->position; ?> </td>
                                
                                <td>
                                    <img src="<?php echo base_url($value->photo) ?>" alt="" width="50px" height="50px">
                                </td>
                                <td> <?php echo date('d M Y ', strtotime($value->join_date)); ?> </td>
                                <td> 
                                    <a href="<?php echo base_url('admin/employee/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/employee/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                                </td>
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
        <!-- /.col -->
    </div>
</section>
<script type="text/javascript">
    $(function () {
      $("#userListTable").DataTable();
    });
    
</script>

