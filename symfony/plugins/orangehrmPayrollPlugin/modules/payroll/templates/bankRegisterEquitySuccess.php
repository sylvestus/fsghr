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
        
            <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
     
          
            <p id="listActions">
                <b>BANK TRANSFERS SCHEDULE EQUITY-WB  FOR <?php $date=LoanAccountsDao::getMonthFromDate($month); ?><?=$date["month"].",".$date["year"]  ?> </b>
                <input type="hidden" id="filterurl" value="<?php echo url_for('payroll/register'); ?>">
                    <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
                   
                   <a href="#" class="addbutton" style="float:right !important" id="emailbtn"><img src="<?php echo "{$imagePath}/email.png";?>" alt="email"></a>    
                 <a href="#" class="addbutton" style="float:right !important" id="pdfbtn1"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>       
             <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
              <input type="button" class="addbutton print" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('Print') ?>"/>
     <br>
            </p>
            <div id="dvData">
            <table class="display exporttable dataTables tablestatic" id="recordsListTable">
                <thead>
                    
                    <tr> 
                             <th width="20%"><?php echo __('Debit Account No'); ?></th>
                        <th width=20%" ><?php echo __('Beneficiary Account No'); ?></th>
                        <th width="20%" ><?php echo __('Beneficiary Name'); ?></th>
                       <th width="5%" ><?php echo __('Transaction Currency'); ?></th>
                        <th ><?php echo __('Payment Amount'); ?></th>      
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                 
           foreach ($allslips as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    <tr>
                   <td class="tdName tdValue">
                       <?= '0180292394292'?>    
                        </td>
                        <td class="tdName tdValue">
                          <?php $employeedetail=  EmployeeDao::getEmployeeByNumber($record->getEmpNumber());
                        $bankdetails=EmpDirectdebitTable::getEmployeeBankAndBranch($record->getEmpNumber());?> 
                         
                           <?=strval($bankdetails["account_number"])?>
                        </td>
                        
                         <td class="tdName tdValue">
                       <?= strtoupper($record->getEmpname())?>    
                        </td>
                        <td class="tdName tdValue">
                       <?='KES'?>    
                        </td>
                       
                        <td class="tdName tdValue" width="12%">
                       <?= $record->getNetPay() ?>
                        </td>
                         
                        
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
       <table border="1" width="500" cellspacing="0" cellpadding="2" align="center" style="display:none" id="pdftable">
                <thead>
                    <tr><td></td><td class="boldText" colspan="3"> 
            <?php echo __(strtoupper($organisationinfo->getName())); ?><br><br>
  &nbsp;&nbsp; </h1></td><td><b>BANK TRANSFERS SCHEDULE <?=$monthyear?></b></td><td></td><td></td><td></td><td></td></tr>
                    <tr>
                             <td><?php echo __('National ID'); ?></td>
                        <td><?php echo __('Payroll No'); ?></td>
                        <td><?php echo __('Employee Names'); ?></td>
                        <td><?php echo __('Account #'); ?></td>
                        <td><?php echo __('BankName'); ?></td>
                        <td><?php echo __('Branch'); ?></td>
                        <td><?php echo __('Bank Code'); ?></td>
                        <td><?php echo __('Branch Code'); ?></td>

                                <td><?php echo __('Net Pay'); ?></td>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $allnetpay=array();
                    $row = 0;
                    $count=1;
           foreach ($allslips as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    <tr>
                   
                        <td class="tdName tdValue">
                          <?php $employeedetail=  EmployeeDao::getEmployeeByNumber($record->getEmpNumber());
                        echo $employeedetail->getEmpDriLiceNum();
                            ?>
                        </td>
                        <td class="tdName tdValue">
                       <?= $employeedetail->getEmployeeId();?>    
                        </td>
                        <td class="tdName tdValue">
                       <?= $record->getEmpname()?>    
                        </td>
                        <?php $bankdetails=EmpDirectdebitTable::getEmployeeBankAndBranch($record->getEmpNumber());?> 
                          <td class="tdName tdValue">'
                      <?= $bankdetails["account_number"]?>  
                        </td>
                         <td class="tdName tdValue">
                          
                             <?= $bankdetails["bankname"]?>
                        </td>
                         <td class="tdName tdValue">
                      <?= $bankdetails["branchname"]?>  
                        </td>
                        <td class="tdName tdValue">
                          
                             <?= $bankdetails["bankcode"]?>
                        </td>
                         <td class="tdName tdValue">
                      <?= $bankdetails["branchcode"]?>  
                        </td>
                        
                        <td class="tdValue"><?= number_format($record->getNetPay(),0) ?>
                        <?php array_push($allnetpay,$record->getNetPay());?>
                        </td>
                        
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
                <tfoot><tr><td></td><td></td><td class="boldText">ZTOTAL</td><td></td><td></td><td></td><td></td><td></td><td class="boldText"><?php echo number_format(array_sum($allnetpay),0)?></td></tr>   </tfoot> 
            </table>
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
     html=$("#recordsListTable").html();
     url=$("#pdfurl").val()+"?sendemail=true&report=Payroll Register";
$.ajax({
            url: url,
            type: 'post',
            data: {
                'data':html
                
            },
            dataType: 'html',
            success: function(success) {
               alert(success);
            }
        });  
   
   });
    $("#pdfbtn1").click(function(e){
       
     html=$("#recordsListTable").html();
     url=$("#pdfurl").val();
$.ajax({
            url: url,
            type: 'post',
            data: {
                'data':html
                
            },
            dataType: 'html',
            success: function(urll) {
                window.open(urll, '_blank');
            }
        });  
   
   });
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
    $(function() {
	
	$('.print').click(function() {
		var container = $(this).attr('rel');
		$('#' + container).printArea();
		return false;
	}); 
   });  
   
   
     
    
});

</script>