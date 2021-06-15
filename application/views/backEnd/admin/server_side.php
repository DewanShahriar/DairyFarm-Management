<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-purple box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('account_list'); ?> </h3>
                    <div class="box-tools pull-right">
                        
                        <a href="<?php echo base_url() ?>admin/accounts/add" type="submit" class="btn bg-green btn-sm" style="color: white;"> <i class="fa fa-plus"></i> <?php echo $this->lang->line('account_add'); ?> </a>
                    </div>
                </div>

                <div class="box-body">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" id="base" value="<?php echo base_url();?>">
                            <table id="userListTable" class="table table-bordered table-striped table_th_purple">
                                
                                
                            </table>                            
                        </div>
                    </div>
                </div> 
            </div>  
        </div>  
    </div>
</section>

<script src="<?php echo base_url(); ?>assets/bootstrap/js/serverside.js"></script>
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
    
    $(document).ready(function(){
        get_accounts_list();
    }); 
 
</script>