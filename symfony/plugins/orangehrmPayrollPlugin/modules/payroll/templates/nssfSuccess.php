<?php use_javascript(plugin_web_path('orangehrmPayrollPlugin', 'web/js/updateNssfSuccess')); ?>

<div class="box">


    <div class="head">
        <h1><?php echo __('Nssf Contributions Configuration')?></h1>
    </div>

    <div class="inner" id="addEmployeeTbl">
        <div class="modal hide" id="successDialog">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3><?php echo __('TechSavannaHRM - '); ?></h3>
    </div>
            <div class="modal-body" id="messagediv">
            
            </div></div>

    <?php include_partial('global/flash_messages'); ?>
        
        <form id="frmupdatenssf" method="post" action="<?php echo url_for('payroll/UpdateNssf') ?>" >
            <fieldset>
                <table>
                    <tr>
                        <td>
                            <ol>
                    <li><label class="for">Employee Contribution(%)</label>
                                <input class="formInputText" maxlength="30" type="text" name="employee_contribution" value="<?=$configuration['employee_contribution']?>" id="employee_contribution" />
</li>
<li><label for="employeeId">Employers Contribution(%)</label>
  <input class="formInputText" maxlength="10" type="text" name="employer_contribution" value="<?=$configuration['employer_contribution']?>" id="employer_contributionf" />
</li>
<li><label for="employeeId">Total  Contribution(%)</label>
  <input class="formInputText" maxlength="10" type="text" name="total_contribution" value="<?=$configuration['employer_contribution']+$configuration['employee_contribution']?>" id="total_contribution" />
</li>
                 <li><label for="employeeId">Maximum Employee NSSF Amount</label>
  <input class="formInputText" maxlength="10" type="text" name="max_employee_nssf" value="<?=$configuration['max_employee_nssf']?>" id="employer_contributionf" />
</li>
</ol>

                </td><td>
                    <ol>
       
<li><label for="employeeId">Maximum Employer NSSF Amount</label>
  <input class="formInputText" maxlength="10" type="text" name="max_employer_nssf" value="<?=$configuration['max_employer_nssf']?>" id="employer_contributionf" />
</li>
                    <li><label for="employeeId">Nssf Lower Earning Limit</label>
  <input class="formInputText" maxlength="10" type="text" name="nssf_lower_earning" value="<?=$configuration['nssf_lower_earning']?>" id="employer_contributionf" />
</li>
<li><label for="employeeId">Nssf Upper Earning Limit</label>
  <input class="formInputText" maxlength="10" type="text" name="nssf_upper_earning" value="<?=$configuration['nssf_upper_earning']?>" id="employer_contributionf" />
</li>
<li><label for="employeeId">Employer NSSF Upper Earning Limit</label>
  <input class="formInputText" maxlength="10" type="text" name="employer_nssf_upper_earning" value="<?=$configuration['employer_nssf_upper_earning']?>" id="employer_contributionf" />
</li>
                    </ol>
                </td>
                </tr>
                </table>
               
                <p>
                    <input type="button" class="" id="btnSave" value="Update Nssf Configuration"  />
                </p>
            </fieldset>
        </form>
    </div>

    
</div> <!-- Box --> 

<script type="text/javascript">

$(document).ready(function() {
   
   $('#btnSave').click(function(e) {
         e.preventDefault();
       if($("#employee_contribution").val() !="" || $("#employer_contribution").val() !=""){
           $('#frmupdatenssf').submit();
       }
    });
    

    
    
});





</script>