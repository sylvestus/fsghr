
<?php //use_javascript(plugin_web_path('orangehrmPayrollPlugin', '/js/updateConfigurationSuccess')); ?>

<style>
    form ol li textarea {
    float: left;
    width: 400px;
    height: 80px;
}
    </style>
<div class="box">

<?php if (isset($credentialMessage)) { ?>

<div class="message warning">
    <?php echo __(CommonMessages::CREDENTIALS_REQUIRED) ?> 
</div>

<?php } else { ?>

    <div class="head">
        <h1><?php echo __('New Application for '.$member->getFirstName().' '.$member->getMiddleName().' '.$member->getLastName()); ?></h1>
    </div>

    <div class="inner" id="addIncomeTaxSlabTbl">
        <?php include_partial('global/flash_messages'); ?>     
        <input type="hidden" value="<?php echo url_for('loans/members'); ?>"  id="cancelurl">
        <form id="frmAddTax" method="post" action="<?php echo url_for('loans/apply?id='.$member->getEmpNumber()); ?>" 
              >
            <fieldset>
                <ol>
                    <?php echo $form->render(); ?>
                    <li class="required">
                        <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                    </li>
                </ol>
                <p>
                    <input type="submit" value="<?php echo __("Apply Loan"); ?>"/>   <input type="button" id="cancel" class="cancel" value="<?php echo __("Cancel"); ?>"/>
                    
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
    
  
          $("#loanapplication_monthly_principle").change(function(e){ 
              appliedamount=$("#loanapplication_amount_applied").val();
              mp=$(this).val();
          $("#loanapplication_repayment_duration").val(appliedamount/mp);
        });
      

    
    
});

    </script>

