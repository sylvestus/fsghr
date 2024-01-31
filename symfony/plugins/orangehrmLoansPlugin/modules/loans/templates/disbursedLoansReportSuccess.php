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
        <h1><?php echo __('Disbursed loans Report  '.date("Y")); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
        <form name="frmList" id="frmList" method="post" action="<?php echo url_for('loans/viewloan'); ?>">
          
            <p id="listActions">
                <input type="hidden" id="viewslab" value="<?php echo url_for('loans/viewloan'); ?>">
                   <input type="hidden" id="repayslab" value="<?php echo url_for('loans/repayloan'); ?>">
                    <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
                   <a href="#" class="addbutton" style="float:right !important" id="emailbtn"><img src="<?php echo "{$imagePath}/email.png";?>" alt="email"></a>   
                 <a href="#" class="addbutton" style="float:right !important" id="pdfbtn"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>   
     <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
      <input type="button" class="addbutton print" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('Print') ?>"/>
     <br>
            </p>
            <div id="dvData">
            <table class="display exporttable dataTables tablestatic" id="recordsListTable">
                <thead>
                    <tr><th class="boldText" colspan="9" style="font-weight:bold;text-align:center"> 
            <center><?php echo __(strtoupper($organisationinfo->getName())); ?><br><br>
            <?php echo __(strtoupper('LOAN BALANCES AS OF ')); ?><?php $date=LoanAccountsDao::getMonthFromDate($month); ?><?=$date["month"].",".$date["year"]  ?>&nbsp;&nbsp;<br> </center></th></tr>
                    <tr>
                        <td  class="boldText borderBottom" width="7%"><?php echo __('Staff No'); ?></td>
                        <td class="boldText borderBottom" width="26%"><?php echo __('Member'); ?></td>
                        <td class="boldText borderBottom" width="11%"><?php echo __('Loan Type'); ?></td>
                                <td class="boldText borderBottom" width="11%"><?php echo __('Date Disbursed'); ?></td>
                                 <td class="boldText borderBottom" width="11%"><?php echo __('Amount Disbursed'); ?></td>
                                  <td class="boldText borderBottom" width="11%"><?php echo __('Period (Months)'); ?></td>
                           
                                   <td class="boldText borderBottom" width="11%">Monthly Installment</td>
                                   <td class="boldText borderBottom" width="12%">Loan Balance</td>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 0;
                    $disbursements=array();
                    $allbalances=array();
                    $allinstallments=array();
           foreach ($pager->getResults() as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                     <?php
                        $loanaccountdao=new LoanAccountsDao();
        $loantransactiondao=new LoanTransactionsDao();
             $interest=$loanaccountdao->getInterestAmount($record->getId());
             $loanbalance= $loantransactiondao->getLoanBalance($record->getId());
               $principal_paid =OhrmLoanrepayments::getPrincipalPaid($record->getId());
        $interest_paid = OhrmLoanrepayments::getInterestPaid($record->getId());
            // $balance=($record->getAmountDisbursed()-$record->getAmountRepaid());
        $balance=$loanbalance;
             $period=$record->getRepaymentDuration();
             $installments=round($record->getAmountDisbursed()/$period);
			 if($loanbalance>0){
                        ?>
                    <tr class="<?php echo $cssClass;?>">
                       
                        <td class="tdName tdValue" width="7%">
                          <?php
                        $employeedao=new EmployeeDao();
                        $employee=$employeedao->getEmployee($record->getEmpNumber());
                       echo  $employee->getEmployeeId();
                            ?>
                        </td>
                        <td class="tdName tdValue" width="26%">
                       <?php  echo $employee->getEmpFirstname().' '.$employee->getEmpMiddleName().' '.$employee->getEmpLastname() ; ?>    
                        </td>
                        <td class="tdName tdValue" width="11%">
                          <?php 
                          $loanproductdao=new LoanProductsDao();
                          $loanproduct=$loanproductdao->getLoanProductById($record->getLoanproductId());
                          echo $loanproduct->getName(); 
                          
                          ?>
                        </td>
                             <td class="tdName tdValue" width="11%">
                         <?php echo date("d-m-Y",  strtotime($record->getDateDisbursed())); ?> 
                        </td>
                             <td class="tdName tdValue" style="text-align:right" width="11%">
                            <?php echo number_format($record->getAmountDisbursed(),2); ?> 
                                <?php                      array_push($disbursements,$record->getAmountDisbursed())?>
                        </td>
                             <td class="tdName tdValue" width="11%">
                            <?php echo number_format($record->getRepaymentDuration(),2); ?> 
                        </td>
                             
                       
                             <td class="tdName tdValue" width="11%" style="text-align:right"><?=  number_format($installments,2);?></td>
                          <?php                      array_push($allinstallments,$installments)?>
                             <td class="tdName tdValue" width="12%" style="text-align:right"><?= number_format($balance,2);?></td>
                        <?php                      array_push($allbalances,$balance)?>
                    </tr>
                    
                    <?php 
                    $row++;
			 }
                    endforeach; 
                    ?>
                    
                    <?php if (count($pager->getResults() ) == 0) : ?>
                    <tr class="<?php echo 'even';?>">
                        <td>
                            <?php echo __(TopLevelMessages::NO_RECORDS_FOUND); ?>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr><td class="boldText"></td><td style="font-weight:bold">TOTALS</td><td></td><td></td><td class="boldText" style="font-weight:bold;text-align:right"><?= number_format(array_sum($disbursements),2)?></td><td></td><td style="font-weight:bold;text-align:right"><?= number_format(array_sum($allinstallments),2)?></td><td class="boldText" style="font-weight:bold;text-align:right"><?= number_format(array_sum($allbalances),2)?></td></tr>    
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
     $("#pdfbtn").click(function(e){
       
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
        
        $("#emailbtn").click(function(e){
     html=$("#pdftable").html();
     url=$("#pdfurl").val()+"?sendemail=true&report=Disbursed Loans Report";
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
  
         $(function() {
	
	$('.print').click(function() {
		var container = $(this).attr('rel');
		$('#' + container).printArea();
		return false;
	}); 
   });  
   
     
    
});

</script>