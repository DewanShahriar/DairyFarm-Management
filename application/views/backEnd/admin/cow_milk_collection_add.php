<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('cow_milk_collection_add'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/cow-milk-collection/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('cow_milk_collection_list'); ?>  </a>
                    </div>
                </div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <form action="<?php echo base_url("admin/cow-milk-collection/add");?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('collection_date'); ?>*</label>
                                            <input name="collection_date" placeholder="<?php echo $this->lang->line('collection_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <table id="dataTable" class="table table-bordered table-striped table_th_primary" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%"><?php echo $this->lang->line('sl'); ?></th>
                                            <th style="width: 30%"><?php echo $this->lang->line('cow_no'); ?></th>
                                            <th style="width: 30%"><?php echo $this->lang->line('milk_target'); ?></th>
                                            <th style="width: 35%"><?php echo $this->lang->line('collection_amount'); ?>*</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php 
                                $sl = 1;
                                foreach ($cow_details_list as $value) {
                                    ?>
                                    <tr>
                                        <td> <?php echo $sl++; ?> </td>
                                        <td>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="hidden" name="cow_details_id[]" class="form-control inner_shadow_primary" value="<?php echo $value->id;?>">
                                                    <p class=""><?php echo $value->cow_no?></p>
                                                </div>
                                            </div>
                                            
                                        </td>
                                        <td>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    
                                                    <p class=""><?php echo $value->milk_target?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td> 
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input name="collection_amount[]" placeholder="<?php echo $this->lang->line('collection_amount'); ?> " class="form-control inner_shadow_primary"  type="text">
                                                </div>
                                            </div>
                                            
                                        </td>
                                          
                                    </tr>
                                <?php } ?>
                                    </tbody>
                                </table>
                                    
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('save'); ?></button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
</section>

<script>

    $(function(){

        $('.date').datepicker({

            autoclose: true,
            changeYear:true,
            changeMonth:true,
            dateFormat: "dd-mm-yy",
            yearRange: "-10:+10"
        });

        $('.timepicker').timepicker({
            
            showInputs: false
        });

    });
</script>



