
<?php //use_javascript(plugin_web_path('orangehrmPayrollPlugin', '/js/updateConfigurationSuccess')); ?>

<div class="box">

<?php if (isset($credentialMessage)) { ?>

<div class="message warning">
    <?php echo __(CommonMessages::CREDENTIALS_REQUIRED) ?> 
</div>

<?php } else { ?>

    <div class="head">
        <h1><?php echo __('Update loan product'); ?></h1>
    </div>

    <div class="inner" id="addIncomeTaxSlabTbl">
        <?php include_partial('global/flash_messages'); ?>     
        <input type="hidden" value="<?php echo url_for('loans/loanproducts'); ?>"  id="cancelurl">
        <form id="frmAddTax" method="post" action="<?php echo url_for('loans/updateLoanProduct?id='.$id); ?>" 
              >
           <fieldset>
                <ol>
                    <li><label for="loanproduct_name">Name</label>
                        <input type="text" name="loanproduct[name]" id="loanproduct_name" value="<?=$loanproduct->name?>">
</li>
<li><label for="loanproduct_short_name">Short name</label>
    <input type="text" name="loanproduct[short_name]" id="loanproduct_short_name" value="<?=$loanproduct->short_name?>">
</li>
<li><label for="loanproduct_formula">Formula</label>
  <select name="loanproduct[formula]" id="loanproduct_formula" value="<?=$loanproduct->formula?>">
<option value="RB">RB</option>
<option value="SL">SL</option>
</select>
</li>
<li><label for="loanproduct_interest_rate">Interest rate</label>
    <input type="text" name="loanproduct[interest_rate]" id="loanproduct_interest_rate" value="<?=$loanproduct->interest_rate?>">
</li>
<li><label for="loanproduct_amortization">Amortization</label>
<select name="loanproduct[amortization]" id="loanproduct_amortization" >

<option value="EP">EP</option>
</select>
<input type="hidden" name="loanproduct[_csrf_token]" value="82658fea1898ebec016613bf965cf830" id="loanproduct__csrf_token"></li>
                    <li class="required">
                        <em>*</em> Required field                    </li>
                </ol>
                <p>
                    <input type="submit" value="Save Loan Product">   <input type="button" id="cancel" class="cancel" value="Cancel">
                    
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

