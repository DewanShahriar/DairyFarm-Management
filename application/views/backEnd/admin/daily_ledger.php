<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-6a8d9d">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('daily_ledger'); ?> </h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <div class="box-body">
                    <div class="row" style="box-shadow: 1px 1px 15px 5px #6a8d9d;margin: 10px 30px 40px 25px;padding: 30px 0px 30px 0px;">
                        <form action="<?php echo base_url('admin/print_income_expance') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="control-label"> <?php echo $this->lang->line('project'); ?> </label>
                                            <select name="project_id" class="form-control select2" required="">
                                                <option value=""><?php echo $this->lang->line('project_search'); ?></option>
                                                <?php foreach ($projects as $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>" <?php echo set_select('project_id',$value->id, ( !empty($value) && $value == $value->id ? TRUE : FALSE )); ?>><?php echo $value->name; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('date'); ?> </label>
                                            <input name="start_date" class="form-control inner_shadow_6a8d9d" placeholder="<?php echo $this->lang->line('date'); ?>" type="text" id="start_date" autocomplete="off" value="<?php echo date('d-m-Y'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <br> </label>
                                            <button type="submit" formtarget="_blank" class="form-control btn btn-6a8d9d"><?php echo $this->lang->line('print'); ?></button>
                                        </div>
                                    </div>
                                </div>
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

<script>
    $(function () {
        $('#start_date').datepicker({
            autoclose: true,
            changeYear:true,
            changeMonth:true,
            dateFormat: "dd-mm-yy",
            yearRange: "-100:+0"
        });
    });
</script>