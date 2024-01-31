<?php

use payslipDao;

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
<?php use_javascript('jquery.PrintArea.js') ?>



<!-- Listi view -->

<div class="box searchForm toggableForm" id="employee-information">
    <div class="head">
        <h1><?php echo __('Payroll Register for  '.$month); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
    <div class="inner">
         <form id="search_form" name="frmEmployeeSearch" method="post" action="<?php echo url_for('payroll/registers'); ?>">

            <fieldset>

                <ol>
                    <?php echo $form->render(); ?>
                </ol>

                <input type="hidden" name="pageNo" id="pageNo" value="" />
                <input type="hidden" name="hdnAction" id="hdnAction" value="search" />                 

                <p>
                    <input type="button" id="searchBtn" value="<?php echo __("Search") ?>" name="_search" />
                    <input type="button" class="reset" id="resetBtn" value="<?php echo __("Reset") ?>" name="_reset" />                    
                </p>

            </fieldset>

        </form>
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
            <table width="100%" class="display dataTables tablestatic exporttables" cellpadding="2"   id="recordsListTable">
                <thead>
                    <tr><th class="boldText" colspan="13" style="font-weight:bold" text-align:left> 
            <?php echo __(strtoupper($organisationinfo->getName())); ?><br><br>
            <?php echo __(strtoupper('Payroll Register for  '.$month)); ?>&nbsp;&nbsp;<br> </th></tr>
                    
                    <tr>
                        <th  class="borderBottom" style="text-align:right" width="3%">#</th>
                        
                        <th  class="borderBottom" style="text-align:right" width="8%"><?php echo __('Emp #'); ?></th>
                        <th  class="borderBottom" style="text-align:right" width="20%"><?php echo __('Name'); ?></th>
                       
                                 <th  class="borderBottom" style="text-align:right" width="8%"><?php echo __('Basic Salary'); ?></th>
                                 <th  class="borderBottom" style="text-align:right" width="6%"><?php echo __('H/A'); ?></th>
                                <!-- <th  class="borderBottom" style="text-align:right"><?php //echo __('Absentee Pay'); ?></th>-->
                                
                                                                     
                                   <th  class="borderBottom" style="text-align:right" width="8%"><?php echo __('Gross Pay'); ?></th>
                             
                               
                                <th  class="borderBottom" style="text-align:right" width="6%"><?php echo __('NSSF'); ?></th>
                                <th  class="borderBottom" style="text-align:right" width="6%"><?php echo __('NHIF'); ?></th>
                                <th  class="borderBottom" style="text-align:right" width="8%"><?php echo __('PAYE'); ?></th>
                                <th  class="borderBottom" style="text-align:right" width="6%"><?php echo __('Loan Repaid'); ?></th>
                                   <th  class="borderBottom" style="text-align:right" width="5%"><?php echo __('Loan Intrst'); ?></th>
                                                                <th class=" borderBottom" width="8%"><?php echo __(' Deductions'); ?></th>
                                <th class=" borderBottom"><?php echo __('Breakdown'); ?></th>
                                <th  class="borderBottom" style="text-align:right" width="8%"><?php echo __('Net Pay'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 0;
                    $count=1;
                        $totalbasic=array();
                        $totalearnings=array();
                        $totalhouse=array();
                        $totalgross=array();
                        $totalnssf=array();
                        $totalnhif=array();
                        $totalpaye=array();
                        $totalloan=array();
                        $totaldeductions=array();
                        $totalnet=array();
                        $totalinterest=array();
                       $locations=array();
                       $locationids=array();
                       $repeats=array();
             $slipscountt=count($allslips);
           for( $i=0;$i<$slipscountt;$i++){ 
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
         
                    <tr>
                     <td  class="tdValue"  style="text-align:right;" width="3%">
                       <?= $count?>    
                        </td>
                       
                           <td class="tdValue" width="8%">
                            <?php $employeedetail=  EmployeeDao::getEmployeeByNumber($allslips[$i]->getEmpNumber());
                           $joineddate=$employeedetail->getJoinedDate();
                           $latedaysworked=EmployeeDao::checkJoinedDate($joineddate, $monthyear);
                             
                                    ?>
                          
                                    
                                    <?= $employeedetail->getEmployeeId();
                        
                            ?>
                        </td>
                        <td class="tdValue" width="20%" style="font-size:8px !important">
                       <?= $allslips[$i]->getEmpname()?>    
                        </td>
                        
                       
                        <td  class="tdValue"  style="text-align:right" width="8%">
                                                      <?php
            $basicpay=$allslips[$i]->getBasicPay();//  PayslipsTable::getEmpBasicSalary($allslips[$i]->getEmpNumber(),$monthyear);                                
 array_push($totalbasic,$basicpay);
?>
                            <?= number_format($basicpay,0) ?> 
                        </td>
                        <td  class="tdValue"  style="text-align:right" width="6%">
                             <?php
$hallowance=$allslips[$i]->getHouseAllowance();//PayslipsTable::getEmpHouseAllowance($allslips[$i]->getEmpNumber(),$monthyear); ?>
                            <?=number_format($hallowance,0) ?> 
                            <?php array_push($totalhouse,$hallowance)?>
                        </td>
                        <!-- <td  class="tdValue"  style="text-align:right"> -->
                          <?php
                         $absenteepay=PayslipItemsTable::getAbsenteePay($allslips[$i]->getPayslipNo());
                         //echo number_format($absenteepay,0)?> 
                       <!-- </td>-->
                        
                        
                        <td  class="tdValue"  style="text-align:right" width="8%"><?= number_format($allslips[$i]->getGrossPay(),0)?>
                          <?php array_push($totalgross,$allslips[$i]->getGrossPay())?>
                        </td>
                          <td  class="tdValue"  style="text-align:right" width="6%">
                            <?= number_format($allslips[$i]->getNssf(),0); ?> 
                              <?php array_push($totalnssf,$allslips[$i]->getNssf())?>
                        </td>
                          <td  class="tdValue"  style="text-align:right" width="6%">
                            <?=$allslips[$i]->getNhif() ?> 
                                <?php array_push($totalnhif,$allslips[$i]->getNhif())?>
                        </td>
                       <td  class="tdValue"  style="text-align:right" width="8%"><?= number_format($allslips[$i]->getNettaxPayable(),0)?>
                       <?php array_push($totalpaye,$allslips[$i]->getNettaxPayable())?>
                       </td>
                       <td  class="tdValue"  style="text-align:right" width="6%">  <?php
                         $loanpay=$allslips[$i]->getLoanDeduction(); ?>
                         <?= number_format($loanpay,0)?>
                              <?php array_push($totalloan,$loanpay)?>
                       </td>
                       <td  class="tdValue"  style="text-align:right" width="5%">  
                           <?php 
//                           $emploans=  LoanAccountsDao::getEmpLoanAccounts($employeedetail->getEmpNumber());
//                            $allinterests=0;
//                          if($loanpay){
//                           foreach ($emploans as $emploan){
//                           $loanaccount=$emploan;
//                           
//                          $interestrate=$loanaccount->getInterestRate();
//                           $interest=  LoanAccountsDao::getInterestForMonth($loanaccount->getId(), $monthyear);
//                    
//                          // echo $emploan->getAmountDisbursed()."--".$emploan->getId()."..".$interest;
//                        $allinterests=$allinterests+$interest;
                     
                         //  }
                           $allinterests=  PayslipTable::getLoanInterestFromPayslip($allslips[$i]->getPayslipNo());
                          
                       echo $allinterests;
                             array_push($totalinterest,$allinterests);
                          
                             
                         //}
                        ?>
                      
                       </td>
                        
                       <?php $totalss=(($allslips[$i]->getTotalDeductions()));?>
                        <td  class="tdValue"  style="text-align:right" width="8%"><?= number_format($totalss,0)?>
                         <?php
                        
                         
                         array_push($totaldeductions,$totalss)?>
                        </td>
                        <td  class="tdValue"  style="text-align:right">
                       <?php
                       $deductions= PayslipTable::getPayslipDeductions($allslips[$i]->getPayslipNo());    
                     foreach ($deductions as $deduc) {
                         ?>
                       <?=  ucwords($deduc['item_name'])?>:<?=$deduc['amount']?> 
                    <?php }     
                         //}
                        ?>
                       </td> 
                        <td  class="tdValue"  style="text-align:right" width="8%"><?= number_format($allslips[$i]->getNetPay(),0) ?>
                        <?php array_push($totalnet,$allslips[$i]->getNetPay())?>
                        </td>
                        <?php  unset($allinterest); ?>
                    </tr>                
                                     
           <?php
              $location=HsHrEmpLocationsTable::findEmployeeLocation($allslips[$i]->getEmpNumber());
                  $locationid=HsHrEmpLocationsTable::findEmployeeLocationId($allslips[$i]->getEmpNumber());
                  array_push($locationids, $locationid); //track locations being used
              $futurei=$i+1;
              if($futurei < count($allslips)){
              $location1=HsHrEmpLocationsTable::findEmployeeLocation($allslips[$futurei]->getEmpNumber());
              }
           if($location !=$location1){ 
               $subtotal=  payslipDao::getPayslipsForLocation($locationid, $monthyear);
                 $border="border-bottom:1px solid #000;border-top:1px solid #000;font-weight:bold;text-align:right"; 
               ?>
                    
                  
                    <tr><td class="boldText tdValue" style="<?=$border?>"></td><td class="boldText" style="<?=$border?>"><?=$location?></td><td class="boldText" style="<?=$border?>"></td><td class="boldText" style="<?=$border?>"><?=  number_format($subtotal["total_basic"])?></td><td class="boldText" style="<?=$border?>"><?=  number_format($subtotal["total_housing"])?></td><td class="boldText" style="<?=$border?>"><?=number_format($subtotal["total_gross"])?></td><td class="boldText" style="<?=$border?>"><?=  number_format($subtotal["total_nssf"])?></td><td class="boldText" style="<?=$border?>"><?=  number_format($subtotal["total_nhif"])?></td><td class="boldText" style="<?=$border?>"><?=  number_format($subtotal["total_payee"])?></td><td class="boldText" style="<?=$border?>"><?=  number_format($subtotal["total_loan"])?></td><td class="boldText" style="<?=$border?>"><?= number_format($subtotal["total_interest"])?></td><td class="boldText" style="<?=$border?>"><?=  number_format($subtotal["total_deductions"])?></td><td style="<?=$border?>"></td><td class="boldText" style="<?=$border?>"><?=  number_format($subtotal["total_net"])?></td></tr>       
                     <tr><td colspan="14"><br></td></tr>
                       <?php   
                       }
                     
                    
                       ?>         
                    <?php 
                    $row++;
                    $count++;
           }
                 ?>   
              <!--take care of last location -->
              <?php   
              $lastlocation=end(array_unique($locationids));
              $lastsubtotal=  payslipDao::getPayslipsForLocation($lastlocation, $monthyear);
              $location=new LocationDao();
              $locationname=$location->getLocationById($lastlocation);
              ?>
              <tr><td class="boldText" style="<?=$border?>"><br></td><td class="boldText" style="<?=$border?>"><?=$locationname?></td><td class="boldText" style="<?=$border?>"></td><td class="boldText" style="<?=$border?>"><?=  number_format($lastsubtotal["total_basic"])?></td><td class="boldText" style="<?=$border?>"><?=  number_format($lastsubtotal["total_housing"])?></td><td class="boldText" style="<?=$border?>"><?=number_format($lastsubtotal["total_gross"])?></td><td class="boldText" style="<?=$border?>"><?=  number_format($lastsubtotal["total_nssf"])?></td><td class="boldText" style="<?=$border?>"><?=  number_format($lastsubtotal["total_nhif"])?></td><td class="boldText" style="<?=$border?>"><?=  number_format($lastsubtotal["total_payee"])?></td><td class="boldText" style="<?=$border?>"><?=  number_format($lastsubtotal["total_loan"])?></td><td class="boldText" style="<?=$border?>"><?= number_format($lastsubtotal["total_interest"])?></td><td class="boldText" style="<?=$border?>"><?=  number_format($lastsubtotal["total_deductions"])?></td><td></td><td class="boldText" style="<?=$border?>"><?=  number_format($lastsubtotal["total_net"])?></td></tr>       
             
              <tr><td class="boldText" colspan="3" style="font-weight:bold">Total Employees: <?=$count-1?></td><td class="boldText" style="font-weight:bold;text-align:right"><?= number_format(array_sum($totalbasic),0)?></td><td class="boldText" style="font-weight:bold;text-align:right"><?=  number_format(array_sum($totalhouse),0)?></td><td class="boldText" style="font-weight:bold;text-align:right"><?=  number_format(array_sum($totalgross),0)?></td><td class="boldText" style="font-weight:bold;text-align:right"><?=  number_format(array_sum($totalnssf),0)?></td><td class="boldText" style="font-weight:bold;text-align:right" ><?=  number_format(array_sum($totalnhif),0)?></td><td class="boldText" style="font-weight:bold;text-align:right"><?=  number_format(array_sum($totalpaye),0)?></td><td class="boldText" style="font-weight:bold;text-align:right"><?=  number_format(array_sum($totalloan),0)?></td><td class="boldText" style="font-weight:bold;text-align:right"><?= number_format(array_sum($totalinterest),0)?></td><td class="boldText" style="font-weight:bold;text-align:right"><?=  number_format(array_sum($totaldeductions),0)?></td><td></td><td class="boldText" style="font-weight:bold;text-align:right"><?=number_format(array_sum($totalnet),0)?></td></tr>         
                </tbody>     
                  
                    <?php if (count($allslips) == 0) : ?>
                    <tr class="<?php echo 'even';?>">
                        <td>
                            <?php echo __(TopLevelMessages::NO_RECORDS_FOUND); ?>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <?php endif; ?>
                    
              

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
<input type="hidden"  id="tallyurl" value="<?=url_for('payroll/tally')?>">

<!-- Confirmation box HTML: Begins -->
<div class="modal hide" id="actionConfModal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo __('TechSavannaHRM - Confirmation Required'); ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo __("CONFIRM ACTION"); ?></p>
  </div>
  <div class="modal-footer">
    <input type="button" class="btn" data-dismiss="modal" id="dialogConfirmBtn" value="<?php echo __('Ok'); ?>" />
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

     //process payroll
             $('#btnAddSlabt').click(function() {
                           $('#actionConfModal').modal();
         $('#dialogConfirmBtn').click(function(e) {
         e.preventDefault();
         var url=$("#tallyurl").val();
         


      window.location.replace(url);
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
                'register':"true"
                
            },
            dataType: 'html',
            success: function(urll) {
                window.open(urll, '_blank');
            }
        });  
   
   });
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
     
    
});


$(document).ready(function() {
        
        var supervisors = <?php echo str_replace('&#039;', "'", $form->getSupervisorListAsJson()) ?>;

        $('#btnDelete').attr('disabled', 'disabled');

        $("#ohrmList_chkSelectAll").click(function() {
            if ($(":checkbox").length == 1) {
                $('#btnDelete').attr('disabled', 'disabled');
            }
            else {
                if ($("#ohrmList_chkSelectAll").is(':checked')) {
                    $('#btnDelete').removeAttr('disabled');
                } else {
                    $('#btnDelete').attr('disabled', 'disabled');
                }
            }
        });

        $(':checkbox[name*="chkSelectRow[]"]').click(function() {
            if ($(':checkbox[name*="chkSelectRow[]"]').is(':checked')) {
                $('#btnDelete').removeAttr('disabled');
            } else {
                $('#btnDelete').attr('disabled', 'disabled');
            }
        });

        // Handle hints
        if ($("#empsearch_id").val() == '') {
            $("#empsearch_id").val('<?php echo __("Type Employee Id") . "..."; ?>')
                    .addClass("inputFormatHint");
        }

        if ($("#empsearch_supervisor_name").val() == '') {
            $("#empsearch_supervisor_name").val('<?php echo __("Type for hints") . "..."; ?>')
                    .addClass("inputFormatHint");
        }

        $("#empsearch_id, #empsearch_supervisor_name").one('focus', function() {

            if ($(this).hasClass("inputFormatHint")) {
                $(this).val("");
                $(this).removeClass("inputFormatHint");
            }
        });

        $("#empsearch_supervisor_name").autocomplete(supervisors, {
            formatItem: function(item) {
                return $('<div/>').text(item.name).html();
            },
            formatResult: function(item) {
                return item.name;
            }
            , matchContains: true
        }).result(function(event, item) {
        }
        );

        $('#searchBtn').click(function() {
            $("#empsearch_isSubmitted").val('yes');
            $('#search_form input.inputFormatHint').val('');
            $('#search_form input.ac_loading').val('');
            $('#search_form').submit();
        });

        $('#resetBtn').click(function() {
            $("#empsearch_isSubmitted").val('yes');
            $("#empsearch_employee_name_empName").val('');
            $("#empsearch_supervisor_name").val('');
            $("#empsearch_id").val('');
            $("#empsearch_job_title").val('0');
            $("#empsearch_employee_status").val('0');
            $("#empsearch_sub_unit").val('0');
            $("#empsearch_termination").val('<?php echo EmployeeSearchForm::WITHOUT_TERMINATED; ?>');
            $("#hdnAction").val('reset');
            $('#search_form').submit();
        });

        $('#btnAdd').click(function() {
            location.href = "<?php echo url_for('pim/addEmployee') ?>";
        });
        $('#btnDelete').click(function() {
            $('#frmList_ohrmListComponent').submit(function() {
                $('#deleteConfirmation').dialog('open');
                return false;
            });
        });

        /* Delete confirmation controls: Begin */
        $('#dialogDeleteBtn').click(function() {
            document.frmList_ohrmListComponent.submit();
        });
        /* Delete confirmation controls: End */

    }); //ready

    function submitPage(pageNo) {
        document.frmEmployeeSearch.pageNo.value = pageNo;
        document.frmEmployeeSearch.hdnAction.value = 'paging';
        $('#search_form input.inputFormatHint').val('');
        $('#search_form input.ac_loading').val('');
        $("#empsearch_isSubmitted").val('no');
        document.getElementById('search_form').submit();
    }


$(function() {
	
	$('.print').click(function() {
		var container = $(this).attr('rel');
                 
  
		$('#' + container).printArea();
		return false;
	}); 
   });
</script>