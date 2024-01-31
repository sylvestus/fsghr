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
                    <tr><th></th><th class="boldText" colspan="9" style="text-align:center"> 
            <?php echo __(strtoupper($organisationinfo->getName())); ?><br><br>
            &nbsp;&nbsp;<br><b>BANK TRANSFERS SCHEDULE FOR <?php $date=LoanAccountsDao::getMonthFromDate($month); ?><?=$date["month"].",".$date["year"]  ?> </b></th></tr>
                    <tr> 
                             <th width="8%"><?php echo __('National ID'); ?></th>
                        <th width="8%" ><?php echo __('Payroll No'); ?></th>
                        <th width="8%" ><?php echo __('Dept'); ?></th>
                        <th width="20%" ><?php echo __('Employee Names'); ?></th>
                        <th width="12%" ><?php echo __('Account #'); ?></th>
                        <th width="22%" ><?php echo __('BankName'); ?></th>
                        <th width="10%" ><?php echo __('Branch'); ?></th>
                        <th width="6%" ><?php echo __('Bank Code'); ?></th>
                        <th width="6%" ><?php echo __('Branch Code'); ?></th>

                        <th style="text-align:right" width="8%"><?php echo __('Net Pay'); ?></th>
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
                   
                        <td class="tdName tdValue" width="8%" >
                          <?php $employeedetail=  EmployeeDao::getEmployeeByNumber($record->getEmpNumber());
                        echo $employeedetail->getEmpDriLiceNum();
                            ?>
                        </td>
                        <td class="tdName tdValue" width="8%" >
                       <?= $employeedetail->getEmployeeId();?>    
                        </td>
                             <td class="tdName tdValue" width="20%" >
                       <?= $record->department?>    
                        </td>
                        <td class="tdName tdValue" width="20%" >
                       <?= $record->getEmpname()?>    
                        </td>
                        <?php $bankdetails=EmpDirectdebitTable::getEmployeeBankAndBranch($record->getEmpNumber());?> 
                        <td class="tdName tdValue" width="12%">
                      '<?= strval($bankdetails["account_number"])?>
                        </td>
                         <td class="tdName tdValue" width="22%"  >
                          
                             <?= strtoupper($bankdetails["bankname"])?>
                        </td>
                         <td class="tdName tdValue" width="10%" >
                      <?= $bankdetails["branchname"]?>  
                        </td>
                        <td class="tdName tdValue" width="6%" >
                          
                             <?= $bankdetails["bankcode"]?>
                        </td>
                         <td class="tdName tdValue" width="6%" >
                      <?= $bankdetails["branchcode"]?>  
                        </td>
                        
                        <td class="tdValue" width="8%" style="text-align:right;font-weight:bold"><?= number_format($record->getNetPay(),0) ?>
                        <?php array_push($allnetpay,$record->getNetPay());?>
                        </td>
                        
                    </tr>
                    
                    <?php 
                    $row++;
                    endforeach; 
                    ?>
                    <tr><td></td><td></td><td class="boldText" style="font-weight:bold">TOTAL</td><td></td><td></td><td></td><td></td><td></td><td></td><td class="boldText" style="text-align:right;font-weight:bold"><?php echo number_format(array_sum($allnetpay),0)?></td></tr>   
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