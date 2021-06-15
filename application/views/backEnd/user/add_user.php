

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-danger box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('add_user'); ?> </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>user/user_list" type="submit" class="btn bg-orange btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('user_list'); ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form action="<?php echo base_url("user/add_user");?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <br><br>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('first_name'); ?></label>
                                            <input name="first_name" placeholder="<?php echo $this->lang->line('first_name'); ?>" class="form-control" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('last_name') ?></label>
                                            <input name="last_name" placeholder="<?php echo $this->lang->line('last_name'); ?>" class="form-control" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('user_name'); ?></label>
                                            <input name="user_name" placeholder="<?php echo $this->lang->line('user_name'); ?>" class="form-control" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('email'); ?></label>
                                            <input name="email" placeholder="<?php echo $this->lang->line('email'); ?>" class="form-control" required="" type="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('phone'); ?></label>
                                            <input name="phone" placeholder="<?php echo $this->lang->line('phone'); ?>" class="form-control" type="tel" pattern="[0]{1}[1]{1}[5|6|7|8|9]{1}[0-9]{8}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('password') ?></label>
                                            <input name="password" placeholder="<?php echo $this->lang->line('password'); ?>" class="form-control" type="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('division'); ?></label>
                                            <select class="form-control select2" name="divission_id" id="division" required >
                                                <option value=""><?php echo $this->lang->line('select_a_division'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('district') ?></label>
                                            <select class="form-control select2" name="district" id="zilla">
                                                <option value=""><?php echo $this->lang->line('select_division_first'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('upozilla') ?></label>
                                            <select class="form-control select2" name="address" id="upozilla">
                                                <option value=""><?php echo $this->lang->line('select_district_first'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('road_house'); ?></label>
                                            <input name="road_house" placeholder="<?php echo $this->lang->line('road_house'); ?>" class="form-control" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('user_type'); ?></label>
                                            <select class="form-control select2" name="user_type" required >
                                                <option value="user"><?php echo $this->lang->line('user'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Profile Image -->
                                <div class="box box-danger">
                                    <div class="box-header"> <label> <?php echo $this->lang->line('user_photo') ?> </label> </div>
                                    <div class="box-body box-profile">
                                        <center>
                                            <img id="member_photo_change" class="img-responsive" src="//placehold.it/400x400" alt="profile picture" style="max-width: 120px;">
                                            <br>
                                            <p style="color: red"><?php echo $this->lang->line('user_photo_caption') ?></p>
                                        </center>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn bg-aqua"><?php echo $this->lang->line('reset') ?></button>
                                    <button type="submit" class="btn btn-danger"><?php echo $this->lang->line('save') ?></button>
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
<script type="text/javascript" >
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
</script>
<script>
    $(document).ready(function () {
    
        // this is for presend address change only
        $('#division').change(function () {
            $('#zilla').find('option').remove().end().append("<option value=''>Select Division First</option>");
            $('#upozilla').find('option').remove().end().append("<option value=''>Select District First</option>");
            loadZilla($(this).find(':selected').val() );
        });
    
        $('#zilla').change(function () {
            $('#upozilla').find('option').remove().end().append("<option value=''>Select District First</option>");
            loadUpozilla($(this).find(':selected').val() );
        });
    
        // init the divisions
        loadDivision();
    
    });
    
    
    function loadDivision() {
    
        $.post("<?php echo base_url() . "user/get_division"; ?>",
                {'asd': 'asd'},
                function (data2) {
    
                    var data = JSON.parse(data2);
                    $.each(data, function () {
    
                        $("#division").append($('<option>', {
                            value: this.id,
                            text: this.name,
                        }));
                    });
    
                });
    }
    
    function loadZilla(divisionId) {
    
        $.post("<?php echo base_url() . "user/get_zilla_from_division/"; ?>" + divisionId,
                {'nothing': 'nothing'},
                function (data2) {
                    var data = JSON.parse(data2);
                    $.each(data, function (i, item) {
    
                        $("#zilla").append($('<option>', {
                            value: this.id,
                            text: this.name,
                        }));
                    });
                });
    
    }
    function loadUpozilla(zillaId) {
        $.post("<?php echo base_url() . "user/get_upozilla_from_division_zilla/"; ?>" + zillaId,
                {'nothing': 'nothing'},
                function (data2) {
                    var data = JSON.parse(data2);
                    $.each(data, function (i, item) {
    
                        $("#upozilla").append($('<option>', {
                            value: this.id,
                            text: this.name,
                        }));
                    });
                });
    }
    
    
</script>

