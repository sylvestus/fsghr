
<?php //use_javascript(plugin_web_path('orangehrmPayrollPlugin', '/js/updateConfigurationSuccess')); ?>

<div class="box">

<?php if (isset($credentialMessage)) { ?>

<div class="message warning">
    <?php echo __(CommonMessages::CREDENTIALS_REQUIRED) ?> 
</div>

<?php } else { ?>

    <div class="head">
        <h1><?php echo __('Add Timesheet Interval'); ?></h1>
    </div>

    <div class="inner" id="addIncomeTaxSlabTbl">
        <?php include_partial('global/flash_messages'); ?>     
        <input type="hidden" value="<?php echo url_for('time/viewEmployeeTimesheet'); ?>"  id="cancelurl">
        <form id="frmAddTax" method="post" action="<?php echo url_for('time/addEmployeeTimesheet'); ?>" 
              >
            <fieldset>
                <ol>
                    <?php echo $form->render(); ?>
                    <li class="required">
                        <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                    </li>
                </ol>
                <p>
                    <input type="submit" value="<?php echo __("Save Timesheet Interval"); ?>"/>   <input type="button" id="cancel" class="cancel" value="<?php echo __("Cancel"); ?>"/>
                    
                </p>
            </fieldset>
        </form>
    </div>

<?php } ?>
    
</div> <!-- Box -->    
<script type="text/javascript">
   $(document).ready(function() {
   
   $('#cancel').click(function(e) {
         e.preventDefault();
       window.location.replace($("#cancelurl").val());
    });
    

    
    
});

    </script>

