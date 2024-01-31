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
        <h1><?php echo __('Monthly Paye Report for  '.$month); ?>&nbsp;&nbsp; </h1>
            
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
                <table class="display exporttables dataTables tablestatic" id="recordsListTable" width="100%">
               
                    <tr><td colspan="4" class="boldText" style="font-weight:bold;font-size:16px;text-align:center"> <center>
            <?php echo __(strtoupper($organisationinfo->getName())); ?><br><br>
            <?php echo __(strtoupper('PAYE Summary  '.$month)); ?>&nbsp;&nbsp;</center></td></tr>
            <tr><td colspan="4" class="boldText" style="font-size:12px; text-align:left;font-weight:bold">For the month of <?=$month?></td></tr>
                 
                                  <tr>
                       
                                      <td width="15%" style="font-weight:bold;font-size:14px"><?php echo __('Payroll No'); ?></td>
                        <td width="40%" style="font-weight:bold;font-size:14px"><?php echo __('Employee Names'); ?></td>
                                          <td width="25%"style="font-weight:bold;font-size:14px" ><?php echo __('PIN NO'); ?></td>
                                
                                              
                                <td width="20%" style="font-weight:bold;font-size:14px"><?php echo __('PAYE'); ?></td>
                               
                              
                    </tr>
                
                <tbody>
                    
                    <?php 
                    $row = 0;
                    $count=1;
                    $allemployees=array();
                    $totalpaye=array();
           foreach ($allslips as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                     <?php
                    if($record->getNettaxPayable()>0){
                        ?>
                    <tr>
                        <td class="tdName tdValue">
                             <?php $employee=EmployeeDao::getEmployeeByNumber($record->getEmpNumber());
 array_push($allemployees, $employee->getEmpNumber());
                             ?>
                          <?=$employee->getEmployeeId(); ?>
                            
                        </td>
                        <td class="tdName tdValue">
                       <?= $record->getEmpname()?>    
                        </td>
                        
                       
                        <td class="tdName tdValue">
                          <?php 
                        echo $employee->getEmpOtherId();
                            ?>
                        </td>
                       
                        
                        <td class="tdValue" style="text-align:right"><?= number_format($record->getNettaxPayable(),0)?></td>
                       <?php array_push($totalpaye,$record->getNettaxPayable()); ?>
                    </tr>
                    
                    <?php 
                    }
                    $row++;
                    endforeach; 
                    ?>
                    <tr><th class="boldText">TOTAL</th>Number Of Employees(<?=count($allemployees)?>)  <th></th><th></th><th class="boldText" style="text-align:right;font-weight:bold"><?=  number_format(array_sum($totalpaye),2)?></th></tr> 
                    <?php if (count($allslips) == 0) : ?>
                    <tr class="<?php echo 'even';?>">
                        <td>
                            <?php echo __(TopLevelMessages::NO_RECORDS_FOUND); ?>
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
      $("#emailbtn").click(function(e){
     html=$("#pdftable").html();
     url=$("#pdfurl").val()+"?sendemail=true&report=Monthly Paye Report";
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
  
    //manage
      $(function() {
	
	$('.print').click(function() {
		var container = $(this).attr('rel');
		$('#' + container).printArea();
		return false;
	}); 
   }); 
   
  
   
     
    
});

</script>