
<style>
    form ol li select {
    float: left;
    width:180px;
    height: 25px;
    margin-top: 1px;
    padding: 3px 6px;
}
    </style>

<div class="box">

<?php if (isset($credentialMessage)) { ?>

<div class="message warning">
    <?php echo __(CommonMessages::CREDENTIALS_REQUIRED) ?> 
</div>

<?php } else { ?>

    <div class="head">
        <h1><?php echo __('Loan Disbursement for  '.$member->getFirstName().' '.$member->getMiddleName().' '.$member->getLastName()); ?></h1>
    </div>

    <div class="inner" id="addIncomeTaxSlabTbl">
        <?php include_partial('global/flash_messages'); ?>     
        <input type="hidden" value="<?php echo url_for('loans/newapplications'); ?>"  id="cancelurl">
        <form id="frmAddTax" method="post" action="<?php echo url_for('loans/disburse?id='.$loanaccount->getId()); ?>" 
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
     
                    <li><label for="employeeId">Period Approved (Months)</label>
  <input class="formInputText" maxlength="10" type="text" name="nssf_lower_earning" value="<?=$loanaccount->getRepaymentDuration()?>" readonly="readonly" />
</li>
<li><label for="employeeId">Interest Rate</label>
  <input class="formInputText" maxlength="10" type="text" name="nssf_upper_earning" value="<?=$loanaccount->getInterestRate()?>"  readonly="readonly"/>
</li>
<div id="cheque" style="display:none">
<li><label for="chequedate">Cheque Date</label>
    <input class="formInputText" maxlength="10" type="text" name="loandisbursal[cheque_date]" placeholder="YYYY-mm-dd"  class="datepicker" />
</li>
<li><label for="chequeno">Cheque No</label>
  <input class="formInputText" maxlength="20" type="text" name="loandisbursal[cheque_no]"  >
</li>
<li><label for="chequedetails">Cheque Details</label>
  <input class="formInputText" maxlength="50" type="text" name="loandisbursal[cheque_details]"  >
</li>
</div>

                    </ol>  
                    
                </td>         
                            
                            
             
                </tr>
                </table>
                <p>
                    <input type="submit" value="<?php echo __("Disburse Loan"); ?>"/>   <input type="button" id="cancel" class="cancel" value="<?php echo __("Cancel"); ?>"/>
                    
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
    
    $("#loandisbursal_payment_mode").change(function(e){
      value=$(this).val();
if(value ==="cheque"){
$("#cheque").css("display","block");
}
else{
    $("#cheque").css("display","none");
}

  })  
    
});

    </script>

