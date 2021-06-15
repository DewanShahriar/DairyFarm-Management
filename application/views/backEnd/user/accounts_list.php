

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-danger box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('account_list'); ?> </h3>
                    <div class="box-tools pull-right">
                        
                        <a href="<?php echo base_url() ?>user/accounts/add" type="submit" class="btn bg-green btn-sm" style="color: white;"> <i class="fa fa-plus"></i> <?php echo $this->lang->line('account_add'); ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-8 col-md-offset-2">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                                <select class="form-control select2" name="project_id" id="project_id" aria-describedby="basic-addon1">
                                    <option value=""> <?php echo $this->lang->line('select_project'); ?> </option>
                                    <?php foreach ($all_project as $key => $value): ?>
                                        <option value="<?php echo $value->id ; ?>" <?php if($project_id == $value->id) echo 'selected'; ?> ><?php echo $value->name ; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="userListTable" class="table table-bordered table-striped table_th_purple">
                                <thead>
                                    <tr>
                                        <th style="width: 5%"><?php echo $this->lang->line('sl'); ?></th>
                                        <th style="width: 20%"><?php echo $this->lang->line('project'); ?></th>
                                        <th style="width: 15%"><?php echo $this->lang->line('account_head'); ?></th>
                                        <th style="width: 10%"><?php echo $this->lang->line('date'); ?></th>
                                        <th style="width: 25%"><?php echo $this->lang->line('description'); ?></th>
                                        <th style="width: 5%"><?php echo $this->lang->line('quantity'); ?></th>
                                        <th style="width: 5%"><?php echo $this->lang->line('rate'); ?></th>
                                        <th style="width: 5%"><?php echo $this->lang->line('amount'); ?></th>
                                        <th style="width: 10%"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($account as $key => $value) {
                                            ?>
                                    <tr>
                                        <td> <?= $key+1; ?> </td>
                                        <td> <?= $value->pname; ?> </td>
                                        <td><a target="_blank" href="<?= base_url('user/report/search?account_head_id='.$value->head_id.'&project_id='.$value->pid); ?>" style="text-decoration: none; color: #333;" > <?= $value->hname; ?></a> </td>
                                        <td> <?= date('d-M-Y',strtotime($value->date)); ?> </td>
                                        <td> <?= $value->description; ?> </td>
                                        <td> <?= $value->quantity; ?> </td>
                                        <td> <?=  number_format((float)$value->rate, 2, '.', ''); ?> </td>
                                        <td> <?=  number_format((float)$value->amount, 2, '.', ''); ?> </td>
                                        <td>
                                            <a href="<?= base_url('user/accounts/edit/'.$value->id); ?>" class="btn btn-sm bg-green"> <i class="fa fa-edit"></i> </a>
                                            <a href="<?= base_url('user/accounts/delete/'.$value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-orange"> <i class="fa fa-trash"></i> </a>
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

<script>
    $(function(){
      // bind change event to select
      $('#project_id').on('change', function () {
          var url = base_url+"user/accounts/list?project_id="+$(this).val(); // get selected value
          if (url) { // require a URL
            window.location = url; // redirect
          }
          return false;
      });
    });
</script>
