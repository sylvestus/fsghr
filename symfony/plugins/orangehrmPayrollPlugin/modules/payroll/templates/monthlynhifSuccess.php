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
        <h1><?php echo __('Monthly Nhif Report for  '.$month); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
     
          
            <p id="listActions">
                <input type="hidden" id="filterurl" value="<?php echo url_for('payroll/register'); ?>">
                   <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
                   
                   <a href="#" class="addbutton" style="float:right !important" id="emailbtn"><img src="<?php echo "{$imagePath}/email.png";?>" alt="email"></a>   
                 <a href="#" class="addbutton" style="float:right !important" id="pdfbtn"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>   
                   
        <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
              <input type="button" class="addbutton print" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('Print') ?>"/>
     <br>
            </p>
            <div id="dvData">
            <table class="table hover data-table displayTable exporttables tablestatic" id="recordsListTable">
                
                <tr><td class="boldText" colspan="6" style="font-weight:bold;text-align:center" > <span style="text-align:center"><?php echo __(strtoupper($organisationinfo->getName())); ?></span><br><br>
                        <span style="text-align:left"><?php echo __(strtoupper('NHIF Contribution for the month of  '.$month)); ?></span>
                        <br>
                        EMPLOYER NUMBER:<?=$organisationinfo->getStreet2()?>
                        <br>
                    </td></tr>
                    <tr>
                       
                        <td class="boldText borderBottom" width="16%" style="font-weight:bold"><?php echo __('Payroll No'); ?></td>
                        <td class="boldText borderBottom" width="17%" style="font-weight:bold"><?php echo __('Last Name'); ?></td>
                        <td class="boldText borderBottom" width="27%" style="font-weight:bold"><?php echo __('First Name'); ?></td>
                           <td class="boldText borderBottom" width="14%" style="font-weight:bold"><?php echo __('National ID'); ?></td>
                         <td class="boldText borderBottom" width="16%" style="font-weight:bold"><?php echo __('NHIF NO'); ?></td>
                                 
                                              
                                <td class="boldText borderBottom" width="10%" style="font-weight:bold"><?php echo __('Amount'); ?></td>
                               
                              
                    </tr>
                
                <tbody>
                    
                    <?php 
                    $row = 0;
                    $count=1;
                    $allnhif=array();
                    $allemployees=array();
           foreach ($allslips as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    <tr>
                   
                        <td class="tdName tdValue">
                           <?php $employeedetail=  EmployeeDao::getEmployeeByNumber($record->getEmpNumber()) ?>
                          <?= $employeedetail->getEmployeeId();?>
                        </td>
                        <td class="tdName tdValue">
                       <?= $employeedetail->getEmpLastname()?>    
                        </td>
                        <td class="tdName tdValue">
                       <?= $employeedetail->getEmpFirstname()." ".$employeedetail->getEmpMiddleName()?>    
                        </td>
                        <?php $employee=EmployeeDao::getEmployeeByNumber($record->getEmpNumber()); 
 array_push($allemployees,$record->getEmpNumber());
                        ?>
                         <td class="tdName tdValue">
                          <?php 
                        echo $employee->getEmpDriLiceNum();
                            ?>
                        </td>
                       <td class="tdName tdValue">
                          <?php 
                        echo $employee->getEmpSinNum();
                            ?>
                        </td>
                   
                        <td class="tdValue" style="text-align:right"><?= number_format($record->getNhif(),0)?></td>
                       <?php array_push($allnhif,$record->getNhif()) ?>
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
                       
                    </tr>
                    <?php endif; ?>
                    
                </tbody>
                <tfoot>
                    <tr><td class="boldText" style="font-weight:bold">ZTOTAL</td><td style="font-weight:bold" style="font-weight:bold">Number of employees(<?=  count($allemployees)?>)</td><td></td><td></td><td></td><td class="boldText" style="font-weight:bold;text-align:right" ><?=  number_format(array_sum($allnhif),0)?></td></tr>
                    
                </tfoot>
                
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
       $("#emailbtn").click(function(e){
     html=$("#pdftable").html();
     url=$("#pdfurl").val()+"?sendemail=true&report=Monthly NHIF";
$.ajax({
            url: url,
            type: 'post',
            data: {
                'data':html,
                'nssfnhif':"true"
                
                
            },
            dataType: 'html',
            success: function(success) {
               alert(success);
            }
        });  
   
   });
      $("#pdfbtn").click(function(e){
       
     html=$("#recordsListTable").html();
     url=$("#pdfurl").val();
$.ajax({
            url: url,
            type: 'post',
            data: {
                'data':html,
                'nssfnhif':"true"
            },
            dataType: 'html',
            success: function(urll) {
                window.open(urll, '_blank');
            }
        });  
        });
       $(function() {
	
	$('.print').click(function() {
		var container = $(this).attr('rel');
		$('#' + container).printArea();
		return false;
	}); 
   }); 
  
   
     
    
});

</script>