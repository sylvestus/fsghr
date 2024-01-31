
<?php use_javascript( 'js/repayloanSuccess.js'); ?>

<div class="box">

<?php if (isset($credentialMessage)) { ?>

<div class="message warning">
    <?php echo __(CommonMessages::CREDENTIALS_REQUIRED) ?> 
</div>

<?php } else { ?>

    <div class="head">
        <h1><?php echo __('Loan Repayment for '.$member->getFirstName().' '.$member->getMiddleName().' '.$member->getLastName()); ?></h1>
    </div>

    <div class="inner" id="addIncomeTaxSlabTbl">
        <?php include_partial('global/flash_messages'); ?>     
        <input type="hidden" value="<?php echo url_for('loans/viewloan?id='.$loanaccount->getId()); ?>"  id="cancelurl">
       
        <form id="frmAddTax" method="post" action="<?php echo url_for('loans/repayloan?id='.$loanaccount->getId()); ?>" 
              >
            <fieldset>
                <ol>
                    <?php echo $form->render(); ?>
                    <li class="required">
                        <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                         <input type="hidden" value="<?=$loanbalance?>" name="loanrepayment[loanbalance]"id="loanbalance">
                    </li>
                </ol>
                <p>
                    <input type="submit" value="<?php echo __("Repay Loan"); ?>"/>   <input type="button" id="cancel" class="cancel" value="<?php echo __("Cancel"); ?>"/>
                    
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
    

   
   $("#loanrepayment_repayment_date").datepicker();

    
    



    
    
});

    </script>

