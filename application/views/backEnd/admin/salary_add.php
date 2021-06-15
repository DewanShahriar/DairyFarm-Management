<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('salary_add'); ?>  </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/salary/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('salary_list'); ?>  </a>
                    </div>
                </div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <form action="<?php echo base_url("admin/salary/add");?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12" id="daily" style="box-shadow: 0px 0px 10px 0px #00c0ef; margin: 8px 53px 20px 55px; padding:20px 4px 20px 4px; width:980px;">
                                <br>
                                <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('employee_name'); ?> </label>
                                            <select name="employee_id" class="form-control inner_shadow_info select2" required style="width: 100%;">
                                                <option value=""><?php echo $this->lang->line('select_one'); ?></option>
                                                <?php foreach($employee_list as $list){?>
                                                <option value="<?php echo $list->id?>"><?php echo $list->name?></option>
                                                <?php }?> 
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('type'); ?> </label>
                                            <select name="type" id="type" class="form-control inner_shadow_info select2" required style="width: 100%;">
                                                
                                                <option value="0" selected="">Daily</option>
                                                <option value="1">Monthly</option>    
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" id="day">
                                        <div class="col-sm-12" >
                                            <label><?php echo $this->lang->line('day'); ?></label>
                                            <input name="day" placeholder="1, 2-5, 29-30" class="form-control inner_shadow_info"  type="text">
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('month'); ?>*</label>
                                            <select name="month" class="form-control inner_shadow_info select2" required style="width: 100%;">
                                                <option value=""><?php echo $this->lang->line('select_month'); ?></option>
                                                
                                                <option value="1"><?php echo $this->lang->line('january'); ?></option>
                                                <option value="2"><?php echo $this->lang->line('february'); ?></option>
                                                <option value="3"><?php echo $this->lang->line('march'); ?></option>
                                                <option value="4"><?php echo $this->lang->line('april'); ?></option>
                                                <option value="5"><?php echo $this->lang->line('may'); ?></option>
                                                <option value="6"><?php echo $this->lang->line('june'); ?></option>
                                                <option value="7"><?php echo $this->lang->line('july'); ?></option>
                                                <option value="8"><?php echo $this->lang->line('august'); ?></option>
                                                <option value="9"><?php echo $this->lang->line('september'); ?></option>
                                                <option value="10"><?php echo $this->lang->line('october'); ?></option>
                                                <option value="11"><?php echo $this->lang->line('november'); ?></option>
                                                <option value="12"><?php echo $this->lang->line('december'); ?></option> 
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('year'); ?>*</label>
                                            <select name="year" class="form-control inner_shadow_info select2" required style="width: 100%;">
                                                <option value=""><?php echo $this->lang->line('select_year'); ?></option>
                                                <?php
                                                $year = 2021;
                                                for($i = 0; $i <10; $i++){
                                                 ?>
                                                <option value="<?= $year;?>"><?= $year;?></option>
                                                <?php $year--;}?> 
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('amount'); ?>*</label>
                                            <input name="amount" placeholder="<?php echo $this->lang->line('amount'); ?>" class="form-control inner_shadow_info"  type="text" required>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('notes');?></label>
                                            <textarea name="notes" class="form-control inner_shadow_info"></textarea>
                                        </div>
                                    </div>
                                </div>    
                                </div>
                            </div>

                            <div class="col-md-12">
                                <br>
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('save'); ?></button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    // profile picture change
    function readpicture(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
    
          reader.onload = function (e) {
            $('#employee_picture_change')
            .attr('src', e.target.result)
            .width(100)
            .height(100);
        };
    
        reader.readAsDataURL(input.files[0]);
    }
    }
    
</script>

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
<script type="text/javascript">

    $( document ).ready(function() {

        $('#type').on('change', function() {

          if (this.value == 0) {
            
            $('#day').show();
            
          } else if (this.value == 1) {

            
            $('#day').hide();
          }
        });
    });
    
    
</script>

