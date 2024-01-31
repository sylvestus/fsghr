
<?php //use_javascript(plugin_web_path('orangehrmPayrollPlugin', '/js/updateConfigurationSuccess')); ?>

<div class="box">

<?php if (isset($credentialMessage)) { ?>

<div class="message warning">
    <?php echo __(CommonMessages::CREDENTIALS_REQUIRED) ?> 
</div>

<?php } else { ?>

    <div class="head">
        <h1><?php echo __('Loan Rejection for  '.$member->getFirstName().' '.$member->getMiddleName().' '.$member->getLastName()); ?></h1>
    </div>

    <div class="inner" id="addIncomeTaxSlabTbl">
        <?php include_partial('global/flash_messages'); ?>     
        <input type="hidden" value="<?php echo url_for('loans/newapplications'); ?>"  id="cancelurl">
        <form id="frmAddTax" method="post" action="<?php echo url_for('loans/reject?id='.$loanaccount->getId()); ?>" 
              >
            <fieldset>
                <table> 
                    <tr>
                        <td>
                        
                    <ol>
                    <?php echo $form->render(); ?>
                    <li class="required">
                        <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                    </li>
                    </ol>
                </td><td>
                           
                    <ol>
     
                    <li><label for="employeeId">Loan Period(Months)</label>
  <input class="formInputText" maxlength="10" type="text" name="nssf_lower_earning" value="<?=$loanaccount->getRepaymentDuration()?>" readonly="readonly" />
</li>
<li><label for="employeeId">Interest Rate</label>
  <input class="formInputText" maxlength="10" type="text" name="nssf_upper_earning" value="<?=$loanaccount->getInterestRate()?>"  readonly="readonly"/>
</li>


                    </ol>  
                    
                </td>         
                            
                            
             
                </tr>
                </table>
                <p>
                    <input type="submit" value="<?php echo __("Reject Loan Application"); ?>"/>   <input type="button" id="cancel" class="cancel" value="<?php echo __("Cancel"); ?>"/>
                    
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

