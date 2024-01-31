
<?php //use_javascript(plugin_web_path('orangehrmPayrollPlugin', '/js/updateConfigurationSuccess')); ?>

<div class="box">

<?php if (isset($credentialMessage)) { ?>

<div class="message warning">
    <?php echo __(CommonMessages::CREDENTIALS_REQUIRED) ?> 
</div>

<?php } else { ?>

    <div class="head">
        <h1><?php echo __('Add Nhif Rates Slab'); ?></h1>
    </div>
    <input type="hidden" value="<?php echo url_for('payroll/nhif'); ?>" id="cancelnhiftext">
    <div class="inner" id="addIncomeTaxSlabTbl">
        <?php include_partial('global/flash_messages'); ?>        
        <form id="frmAddTax" method="post" action="<?php echo url_for('payroll/addNhifRatesSlab'); ?>">
            <fieldset>
                <ol>
                    <?php echo $form->render(); ?>
                    <li class="required">
                        <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                    </li>
                </ol>
                <p>
                    <input type="submit" value="<?php echo __("Save Rates Slab"); ?>"/>
                    <input type="button" id="cancelnhif" class="delete" value="<?php echo __("Cancel"); ?>"/>
                </p>
            </fieldset>
        </form>
    </div>

<?php } ?>
    
</div> <!-- Box -->    

<script type="text/javascript">
$(document).ready(function() {
      
   
    //add tax slab
     $('#cancelnhif').click(function(e) {
         e.preventDefault();
         var url=$("#cancelnhiftext").val();
        window.location.replace(url);
    });
    
    
    
        
    
});

</script>
