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
<?php use_javascript('jquery.PrintArea.js') ?>




<!-- Listi view -->

<div id="recordsListDiv" class="box miniList">
    <div class="head">
        <h1><?php echo __('Excess Deductions for  '.$month); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
     
          
            <p id="listActions">
                <input type="hidden" id="filterurl" value="<?php echo url_for('payroll/register'); ?>">
                   
       
     <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
      <input type="button" class="addbutton print" style="float:right !important" id="btnAddSlab" rel="reportsdiv"  value="<?php echo __('Print') ?>"/>           
     <br>
            </p>
            <div id="dvData">
         <table class="display exporttable dataTables tablestatic" id="recordsListTable">
                <thead>
                    <tr>
                       
                        <th><?php echo __('Employee No'); ?></th>
                        <th><?php echo __('Name'); ?></th>
                        <th><?php echo __('Days Paid'); ?></th>
                                <th><?php echo __('Absent Days'); ?></th>
                                <th><?php echo __('Absent Days Pay'); ?></th>
                                 <th><?php echo __('Basic Salary'); ?></th>
                                                                   <th><?php echo __('Earnings'); ?></th>
                                                                     <th><?php echo __('Housing Allowance'); ?></th>
                                   <th><?php echo __('Gross Pay'); ?></th>
                             
                               
                                <th><?php echo __('NSSF'); ?></th>
                                <th><?php echo __('NHIF'); ?></th>
                                <th><?php echo __('PAYE'); ?></th>
                              
                                <th><?php echo __('Total Deductions'); ?></th>
                                <th><?php echo __('Net Pay'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 0;
                    $count=1;
           foreach ($allslips as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    <tr>
                   
                        <td class="tdName tdValue">
                           <?php $employeedetail=  EmployeeDao::getEmployeeByNumber($record->getEmpNumber()) ?>
                          <?= $employeedetail->getEmployeeId();?>
                        </td>
                        <td class="tdName tdValue">
                       <?= $record->getEmpname()?>    
                        </td>
                        <td class="tdName tdValue">
                          <?=$record->getPaidDays();
                          ?>
                        </td>
                        <td class="tdName tdValue">
                          <?=$record->getWeekoff();
                          ?>
                        </td>
                        <td class="tdValue">
                          <?php
                         $absenteepay=PayslipItemsTable::getAbsenteePay($record->getPayslipNo());
                         echo number_format($absenteepay,0)?> 
                        </td>
                        <td class="tdValue">
                                                      <?php
$basicpay=HsHrEmpBasicsalaryTable::getEmpBasicSalary($record->getEmpNumber());
?>
                            <?= number_format($basicpay,0) ?> 
                        </td>
                        <td class="tdValue">
                            <?= number_format($record->getTotalEarnings(),0); ?> 
                        </td>
                        <td class="tdValue">
                             <?php
$hallowance=HsHrEmpBasicsalaryTable::getEmpHouseAllowance($record->getEmpNumber());?>
                            <?=number_format($hallowance,0) ?> 
                        </td>
                        <td class="tdValue"><?= number_format($record->getGrossPay(),0)?></td>
                          <td class="tdValue">
                            <?= number_format($record->getNssf(),0); ?> 
                        </td>
                          <td class="tdValue">
                            <?=$record->getNhif() ?> 
                        </td>
                       <td class="tdValue"><?= number_format($record->getNettaxPayable(),0)?></td>
                      
                        <td class="tdValue"><?= number_format($record->getTotalDeductions(),0)?></td>
                        <td class="tdValue"><?= number_format($record->getNetPay(),0) ?></td>
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

      
        $(function() {
	
	$('.print').click(function() {
		var container = $(this).attr('rel');
		$('#' + container).printArea();
		return false;
	}); 
   }); 
    
});

</script>

</script>