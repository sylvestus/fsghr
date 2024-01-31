<?php use_javascript(plugin_web_path('orangehrmPayrollPlugin', '/js/updateConfigurationSuccess')); ?>

<div class="box">


    <div class="head">
        <h1><?php echo __('Payroll Configuration')?>  <select id="payrollmonth" name="payrollmonth"  style="width:280px;float:right;" >
             <option value="" selected="selected">Change Payroll Month</option>      
                           <?php
                            
                           $months= array("01"=>"01","02"=>"02","03"=>"03","04"=>"04","05"=>"05","06"=>"06","07"=>"07","08"=>"08","09"=>"09","10"=>"10","11"=>"11","12"=>"12");
                           foreach ($months as $monthp) {
    

                                 $lastyear = date("Y",strtotime("-1 year", strtotime("Y")));
                                $dateyear=$monthp.'/'.$lastyear;
                                 echo '<option value="'.$dateyear.'">'.$dateyear.'</option>';
                                
                             }
                                foreach ($months as $month1) {
    
                                  $dateyear1=$month1.'/'.date("Y");
                                    echo '<option value="'.$dateyear1.'">'.$dateyear1.'</option>';
                                 $month1++;
                             }
                             
                             ?>
                          </select></h1>
    </div>
     <?php include_partial('global/flash_messages'); ?>
    <input type="hidden" value="<?=  url_for('payroll/changepayroll')?>" id="changepayrollmonth">
    <div class="inner" id="addEmployeeTbl">
        <div class="modal hide" id="successDialog">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3><?php echo __('TechSavannaHRM - '); ?></h3>
    </div>
            <div class="modal-body" id="messagediv"></div></div>


        
        <form id="frmupdatePayrollConfig" method="post" action="<?php echo url_for('payroll/UpdateConfiguration') ?>" 
              enctype="multipart/form-data">
            <fieldset>
                <table width="90%"> 
                    <tr><td>
                    <ol>
                    <li><label class="for">Personal Relief</label>
                                <input class="formInputText" maxlength="30" type="text" name="personal_relief" value="<?=$configuration['personal_relief']?>" id="personal_relief" />
</li>
<li><label for="employeeId">Insurance Relief</label>
  <input class="formInputText" maxlength="10" type="text" name="insurancerelief" value="<?=$configuration['insurance_relief']?>" id="insurance_relief" />
</li>
<li><label for="photofile">Spouse Relief</label>
    <input class="formInputText" maxlength="30" type="text" name="spouse_relief" value="<?=$configuration['spouse_relief']?>" id="spouse_relief" />
</li>
<li><label for="chkLogin">Qualifying Relief</label>
  <input type="text" name="qualifying_relief" value="<?=$configuration['qualifying_relief']?>" id="qualifying_relief" />
</li>

<li><label for="user_name">Other Relief<em> *</em></label>
 <input class="formInputText " maxlength="40" type="text" name="other_relief" value="<?=$configuration['other_relief']?>"  id="other_relief" />
</li>
<li><label for="user_name">Daily Rate<em> *</em></label>
 <input class="formInputText " maxlength="255" type="text" name="daily_rate" value="<?=$configuration['daily_rate']?>"  id="daily_rate" />
</li>
<li><label for="user_name">Hourly Rate<em> *</em></label>
 <input class="formInputText " maxlength="255" type="text" name="daily_rate" value="<?=$configuration['hourly_rate']?>"  id="hourly_rate" />
</li>
                            </ol</td><td>
                            <ol>
                    <li>
                            <?php
                             $payrollmonth=PayrollMonthTable::getActivePayrollMonth();
 $month=$payrollmonth->getPayrollmonth();
                            ?>
                        <h1 class="boldText"> CURRENT PAYROLL MONTH: <hr><?=$month?></h1>
                        <br><br><br><br><br><br><br><br><br>
                    </li></ol>  
                            
                        </td></tr>
                </table>
                <p>
                    <input type="button" class="" id="btnSave" value="Update Configuration"  />
                </p>
            </fieldset>
        </form>
    </div>

    
</div> <!-- Box --> 

<script type="text/javascript">
$(document).ready(function() {
  
    //manage
     $('#payrollmonth').change(function(e) {
         e.preventDefault();
          var value=$(this).val();
       var url=$("#changepayrollmonth").val();
      
       window.location.replace(url+'?month='+value);
   
    });
    
  
   
     
    
});

</script>