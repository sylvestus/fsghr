<?php
/**
 * TechSavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 TechSavannaHRM Inc., http://www.techsavanna.technology
 *
 * TechSavannaHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * TechSavannaHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 *
 */
?>


<?php use_javascript(plugin_web_path('orangehrmLoansPlugin', 'js/newapplicationsSuccess')); ?>




<!-- Listi view -->

<div id="recordsListDiv" class="box miniList">
    <div class="head">
        <h1><?php echo __('P10 Monthly '.$month); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
     
          
            <p id="listActions">
                <input type="hidden" id="filterurl" value="<?php echo url_for('payroll/register'); ?>">
                   
                   
     <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
     <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
     <br>
            </p>
            <div id="dvData">
            <table class="table hover data-table displayTable exporttable tablestatic" id="recordsListTable">
                <thead>
                    <tr>
                       
                        <td class="boldText borderBottom"><?php echo __('PIN # '); ?></td>
                        <td class="boldText borderBottom"><?php echo __('Name'); ?></td>
                        <td class="boldText borderBottom"><?php echo __('Residential Status'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Employee Type '); ?></td>
                             
                                 <td class="boldText borderBottom"><?php echo __('Basic Salary'); ?></td>
                                  
                                <td class="boldText borderBottom"><?php echo __('Housing Allowance'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Transport Allowance'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Leave Pay'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Overtime Allowance'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Directors Fee'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Lump Sum Payment'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Other Allowance'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Total Cash Pay(A)'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Value Of Car Benefit'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Other Non Cash Benefits'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Total Non Cash Pay'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Global Income'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Type Of Housing'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Rent Of House/Market Value'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Computed Rent Of House'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Rent Of House/Market Value'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Net Value Of Housing'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Total Gross Pay'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('30% Of Cash Pay'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Actual Contribution'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Permissable Limit'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Mortgage Interest'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Deposit Of House Ownership Plan'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Amount Of Benefit'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Taxable Pay'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Taxable Pay'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Monthly Personal Relief'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Amount Of Insurance Relief'); ?></td>
                             
                               
                                <td class="boldText borderBottom"><?php echo __('PAYE Tax (KSH)'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Self Assesed PAYE Tax (KSH)'); ?></td>
                                
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 0;
                    $count=1;
           foreach ($allslips as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                     <?php $employee=EmployeeDao::getEmployeeByNumber($record->getEmpNumber()); ?>
                   
                        <td class="tdName tdValue">
                          <?php 
                        echo $employee->getEmpOtherId();
                            ?>
                        
                         
                        </td>
                        <td class="tdName tdValue">
                       <?= $record->getEmpname()?>    
                        </td>
                        <td class="tdName tdValue">
                         Resident
                        </td>
                        <td class="tdName tdValue">
                          Primary Employee
                          
                        </td>
                        
                        <td class="tdValue">
                                                      <?php
//$basicpay=HsHrEmpBasicsalaryTable::getEmpBasicSalary($record->getEmpNumber());
?>
                            <?= number_format($record->basic_pay,0) ?> 
                        </td>
                     
                        <td class="tdValue">
                             <?php
//$hallowance=HsHrEmpBasicsalaryTable::getEmpHouseAllowance($record->getEmpNumber());?>
                            <?=number_format($record->house_allowance,0) ?> 
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?=$record->getTotalEarnings()-$employee->getVehicleBenefit()?></td>
                        <td></td>
                        <td><?=$employee->getVehicleBenefit()?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Benefit not given</td
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?= number_format($record->getNssf(),0)?></td>
                        
                         <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?=$record->getPersonalRelief()?></td>
                        <td></td>
                        <td></td>
                       <td class="tdValue"><?= number_format($record->getNettaxPayable(),0)?></td>
                    
                    </tr>
                    
                    <?php 
                    $row++;
                    endforeach; 
                    ?>
                    
                    <?php if (count($allslips) == 0) : ?>
                    <tr class="<?php echo 'even';?>">
                        <td>
                            <?php echo __(TopLevelMessages::NO_RECORDS_FOUND); ?>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <?php endif; ?>
                    
                </tbody>
            </table>
            </div>
        </form>
    </div>
    
</div> <!-- recordsListDiv -->    

<!-- Confirmation box HTML: Begins -->
<div class="modal hide" id="deleteConfModal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo __('TechSavannaHRM - Confirmation Required'); ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo __(CommonMessages::DELETE_CONFIRMATION); ?></p>
  </div>
  <div class="modal-footer">
    <input type="button" class="btn" data-dismiss="modal" id="dialogDeleteBtn" value="<?php echo __('Ok'); ?>" />
    <input type="button" class="btn reset" data-dismiss="modal" value="<?php echo __('Cancel'); ?>" />
  </div>
</div>
<!-- Confirmation box HTML: Ends -->


<script type="text/javascript">
$(document).ready(function() {
  
    //manage
     $('#btnfilter').click(function(e) {
         e.preventDefault();
           var startdate=$("#startdate").val();
           var enddate=$("#enddate").val();
       var url=$("#filterurl").val();
       if(startdate=="" || enddate==""){
           alert("please choose start/end dates");
           return 0;
       } else{
       window.location.replace(url+'?startdate='+startdate+"&enddate="+enddate);
   }
    });
    
  
   
     
    
});

</script>