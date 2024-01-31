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

<div class="box searchForm toggableForm" id="employee-information">
    <div class="head">
        <h1><?php echo __("Process Payroll") ?></h1>
    </div>
    <div class="inner">
         <form id="search_form" name="frmEmployeeSearch" method="post" action="<?php echo url_for('payroll/processPayroll'); ?>">

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
        
        <p id="listActions">
            <input id="payrollmonth" value="<?=$activemonth?>" type="hidden">
                  <input type="hidden" id="processpayroll" value="<?php echo url_for('payroll/processEmployeePayroll'); ?>">
                  <input type="hidden" id="rollbackpayrollurl" value="<?php echo url_for('payroll/rollBackPayroll'); ?>">
                  <input type="hidden" id="updateslab" value="<?php echo url_for('payroll/generatePayslips'); ?>">
               <input type="hidden" id="emailslipsurl" value="<?php echo url_for('payroll/emailPayslips'); ?>">
                <input type="hidden" id="emailp9url" value="<?php echo url_for('payroll/emailp9yearly'); ?>">
               <input type="hidden" id="generatep9" value="<?= url_for('payroll/p9yearly')."?month=".$activemonth?>">
                
               <input type="button" class="addButton" id="btnAddSlab" value="<?php echo __('Process Payroll for '.$activemonth); ?>"/>
               
               <select id="payslipmonth" class="greenselect">
                              <option selected="selected" value="">Generate Payslips For</option>
                             <?php
                             $months= array("01"=>"01","02"=>"02","03"=>"03","04"=>"04","05"=>"05","06"=>"06","07"=>"07","08"=>"08","09"=>"09","10"=>"10","11"=>"11","12"=>"12");
                             foreach ($months as $month) {
                            
                               $lastyear = date("Y",strtotime("-1 year", strtotime("Y")));
                                $dateyear=$month.'/'.$lastyear;
                                 echo '<option value="'.$dateyear.'">'.$dateyear.'</option>';
                                
                             }
                            
                              foreach ($months as $month) {
                            
                               $dateyear1=$month.'/'.date("Y");
                                    echo '<option value="'.$dateyear1.'">'.$dateyear1.'</option>';
                                
                             }
                           
                             
                             ?>
                          </select>
              
                  <select id="emailpayslips" class="greenselect">
                              <option selected="selected" value="">Email Payslips For</option>
                             <?php
                           foreach ($months as $month) {
                            
                               $lastyear = date("Y",strtotime("-1 year", strtotime("Y")));
                                $dateyear=$month.'/'.$lastyear;
                                 echo '<option value="'.$dateyear.'">'.$dateyear.'</option>';
                                
                             }
                            
                              foreach ($months as $month) {
                            
                               $dateyear1=$month.'/'.date("Y");
                                    echo '<option value="'.$dateyear1.'">'.$dateyear1.'</option>';
                                
                             }
                             
                             ?>
                          </select>
                     <select id="emailp9" class="greenselect">
                              <option selected="selected" value="">Email P9 as of</option>
                             <?php
                           foreach ($months as $month) {
                            
                               $lastyear = date("Y",strtotime("-1 year", strtotime("Y")));
                                $dateyear=$month.'/'.$lastyear;
                                 echo '<option value="'.$dateyear.'">'.$dateyear.'</option>';
                                
                             }
                            
                              foreach ($months as $month) {
                            
                               $dateyear1=$month.'/'.date("Y");
                                    echo '<option value="'.$dateyear1.'">'.$dateyear1.'</option>';
                                
                             }
                             
                             ?>
                          </select>
                <input type="button" class="delete" id="btnDelSlab" value="<?php echo __('Roll back payroll for '.$activemonth); ?>"/>
       <input type="button" class="addButton" id="samplepayslip" value="<?php echo __('Sample Payslip'); ?>"/>
            </p>

    </div> <!-- inner -->

    <a href="#" class="toggle tiptip" title="<?php echo __(CommonMessages::TOGGABLE_DEFAULT_MESSAGE); ?>">&gt;</a>

</div> <!-- employee-information -->
<div id="recordsListDiv" class="box miniList">
    
 <div class="inner">
       
        <?php include_partial('global/flash_messages'); ?>
         <table class="table hover" id="recordsListTable">
                <thead>
                    <tr>
                        <th class="check" style="width:2%"><input type="checkbox" id="checkAll" class="checkboxAtch" /></th>
                          <th ><?php echo __('ID'); ?></th>
                        <th ><?php echo __('Employee Name'); ?></th>
                        <th ><?php echo __('Job'); ?></th>
                                <th ><?php echo __('Employment Status'); ?></th>
                                 <th ><?php echo __('Department'); ?></th>
                                 <th ><?php echo __('Actions'); ?>|<a href="#" style="text-decoration:underline;float:right"  id="p9">P9 Form</a></th>
                                 <th>Hours Worked</th>
                                    
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 0;
           foreach ($employees  as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                        $code=HsHrEmpBasicsalaryTable::getSalaryCode($record->getEmpNumber());
                        $conn = Doctrine_Manager::connection();
                        $monthyear=  str_replace("/","-", $activemonth);
                        $query = "SELECT SUM(hours) as hours from casualhours WHERE emp_id=:emp_id and monthyear=:monthyear";
          // die($sql);
$stmt = $conn->prepare($query);           
$stmt->bindParam(':emp_id',$record->getEmpNumber());
$stmt->bindParam(':monthyear', $monthyear);
$stmt->execute();
   $hoursworked= 0;
while ($row =$stmt->fetch()) {

      $hoursworked= $row['hours'];
}

  
                    ?>
                    
                    <tr class="<?php echo $cssClass;?>">
                        <td class="check">
                            <input type="checkbox" class="checkboxAtch" name="chkListRecord[]" value="<?php echo $record->getEmpNumber(); ?>" />
                        </td>
                        <td class="tdName tdValue">
                          <?php echo $record->getEmployeeId(); ?>
                        </td>
                        <td class="tdValue">
                            <?php echo $record->getEmpFirstname().' '.$record->getEmpMiddleName().' '.$record->getEmpLastname() ; ?> 
                        </td>
                        <td class="tdValue">
                            <?php 
                            $jobsdao=new JobTitleDao();
                            $job=$jobsdao->getJobTitleOnly($record->getOhrmJobTitle());
                            echo $job;
                          ?> 
                        </td>
                        <td class="tdValue">
                            <?php echo $record->getOhrmEmploymentStatus(); ?> 
                        </td>
                        
                           <td class="tdValue">
                            <?php echo $record->getOhrmSubunit() ; ?> 
                        </td>
                         <td class="tdValue">
                             
                             <a href="<?=url_for('payroll/generatePayslips')."?id=".$record->getEmpNumber()."&month=".$activemonth?>">Payslips(<?=$activemonth?>)</a>&nbsp;|<a href="#" id="<?=$record->getEmpNumber()?>" class="multi">Multi-Slip</a>&nbsp;
                        </td>
                        <td class="tdValue">
                            <?php if($code==4){ //casual ?>
                            <input type="text" class="hoursworked" title="<?=$record->getEmpNumber()?>" name="casual<?=$record->getEmpNumber()?>" value="<?=$hoursworked?>" placeholder="Hours Worked"  >
                            <?php }?>
                        </td>
                        
                    </tr>
                    
                    <?php 
                    $row++;
                    endforeach; 
                    ?>
                    
                    <?php if (count($employees) == 0) : ?>
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
</div>


<div class="modal hide" id="actionMultiPayslips">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo __('TechSavannaHRM -Multi Payslips'); ?></h3>
  </div>
  <div class="modal-body">
    <p> <select id="payrollmonthfrom" name="payrollmonthfrom"  >
             <option value="" selected="selected">From</option>      
                             <?php
                              $months= array("01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");
                           foreach ($months as $month=>$value) {
                            
                                
                                 echo '<option value="'.$month.'">'.$value.'</option>';
                                 $month++;
                             }
                             
                             
                             ?>
                          </select>
         <select id="payrollyearfrom" name="payrollyearfrom"  >
                  <option value="<?=date("Y")?>" selected="selected"> <?=date("Y")?></option>  
                             <?php
                           $year=2000; $i=2030;
                             while ($year<=$i) {
                            
                                
                                 echo '<option value="'.$year.'">'.$year.'</option>';
                                 $year++;
                             }
                             
                             
                             ?>
                          </select>
          </p>
          <p>
        <select id="payrollmonthto" name="payrollmonthto"  >
             <option value="" selected="selected">To</option>      
                             <?php
                              $months= array("01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");
                           foreach ($months as $month=>$value) {
                            
                                
                                 echo '<option value="'.$month.'">'.$value.'</option>';
                                 $month++;
                             }
                             
                             
                             ?>
                          </select>
              <select id="payrollyearto" name="payrollyearto"  >
                  <option value="<?=date("Y")?>" selected="selected"> <?=date("Y")?></option>  
                             <?php
                           $year=2000; $i=2030;
                             while ($year<=$i) {
                            
                                
                                 echo '<option value="'.$year.'">'.$year.'</option>';
                                 $year++;
                             }
                             
                             
                             ?>
                          </select>
              
          </p>
      
  </div>
  <div class="modal-footer">
    <input type="button" class="btn" data-dismiss="modal" id="confirmOkButton" value="<?php echo __('Ok'); ?>" />
    <input type="button" class="btn reset" data-dismiss="modal" value="<?php echo __('Cancel'); ?>" />
  </div>
</div>
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


<div class="modal hide" id="actionSamplePayslip">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo __('TechSavannaHRM - Sample Payslip Calculator'); ?></h3>
  </div>
  <div class="modal-body">
      <p>
               <form id="frmPaye" name="frmPaye" method="post">
            <table align="center" cellpadding="5" cellspacing="5" rules="none" class="calculator">
               <tbody><tr>
                  <th height="30" colspan="3" valign="top">PAYE CALCULATOR </th>
               </tr>
               <tr valign="top">
                  <td height="30" align="right" valign="top">Use Net Pay Instead? </td>
                  <td align="left"><input name="chkWorking" type="checkbox" id="netpayworking" value="1"></td>
               </tr>
               <tr>
                  <td align="right">Year </td>
                  <td><select name="selYear">
                        <option value="0" selected="selected">2022</option>
                        <option value="1">2021</option>
                        <option value="2">2020</option>
                        <option value="3">2019</option>
                        <option value="4">2018</option>
                        <option value="5">2017</option>
                     </select>
                  </td>
                  <td><input id="btncompute" type="button" value="Calculate" class="addButton"></td>
               </tr>
               <tr>
                  <td align="right">Pay Period<br>
                     in Months <br>
                  </td>
                  <td><input name="txtPayPeriod" type="text" class="numField" id="txtPayPeriod" value="1" size="5"></td>
                  <td><input name="reset" type="reset" value="Clear All"></td>
               </tr>
              <!-- <tr>
                  <td align="right">Net Pay</td>
                  <td><input name="txtNetPay" type="text" class="numField" size="15" maxlength="10">
                  </td>
                  <td>&nbsp;</td>
               </tr>-->
                <tr>
                  <td align="right">Non Cash Benefits</td>
                  <td><input name="txtCashBenefits" type="text" class="numField" value="0.00" size="15" maxlength="10">
                  </td>
                  <td>&nbsp;</td>
               </tr>
                 <tr>
                  <td align="right">Other Deductions</td>
                  <td><input name="txtDeductions" type="text" class="numField" value="0.00" size="15" maxlength="10">
                  </td>
                  <td>&nbsp;</td>
               </tr>
                <tr>
                  <td align="right">Gross Pay </td>
                  <td><input id="grosspaysection" name="txtGrossPay" type="text" class="numField" size="15" maxlength="10">
                  </td>
                  <td>&nbsp;</td>
               </tr>
                <tr >
                  <td align="right">Net Pay</td>
                  <td><input id="netpaysection" name="txtNetPay" disabled="disabled" type="text" class="numField" size="15" maxlength="10">
                  </td>
                  <td>&nbsp;</td>
               </tr>
            
               <tr>
                  <td align="right">Insurance Relief </td>
                  <td><input name="txtInsureRelief" type="text" class="numField" value="0.00" size="15" maxlength="10">
                  </td>
                  <td>&nbsp;</td>
               </tr>
               
            </tbody></table>
         </form>   
          
      </p>
  </div>
  <div class="modal-footer">

    <input type="button" class="btn reset" data-dismiss="modal" value="<?php echo __('Close'); ?>" />
  </div>
</div>
<div class="modal hide" id="actionSamplePayslip1">
    <div id="actionSamplePayslip1contents"></div>
  <div class="modal-footer">

      <input type="button" id="closesamplepayslip" class="btn reset"  value="<?php echo __('Close'); ?>" />
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
     var empnumbers=[];
       $("#checkAll").click(function(e) {
           
          if($("#checkAll").is(":checked")){
             
       $(".checkboxAtch").each(function(){
           empnumbers.push($(this).val());
                      $('.checkboxAtch').attr("checked","checked");
                      
       });
          }
          else{
              $(".checkboxAtch").each(function(){
           $('.checkboxAtch').prop("checked",false);
           
              });   
          }
          });
          
          //process payroll
             $('#btnAddSlab').click(function() {
                           $('#actionConfModal').modal();
         $('#dialogConfirmBtn').click(function(e) {
         e.preventDefault();
         var url=$("#processpayroll").val();
         
    var searchids=$("input:checked").map(function(){
        return $(this).val();
    });
    
    var hours=$(".hoursworked").map(function(){
        return $(this).attr("title")+"*"+$(this).val();
    });
 //alert(searchids.get());

      window.location.replace(url+"?ids="+searchids.get()+"&monthyear="+$('#payrollmonth').val()+"&hours="+hours.get());
    });
        
        });
        
        //p9
         $('#p9').click(function() {
                           $('#actionConfModal').modal();
         $('#dialogConfirmBtn').click(function(e) {
         e.preventDefault();
         var url=$("#generatep9").val();
         
    var searchids=$("input:checked").map(function(){
        return $(this).val();
    });
 //alert(searchids.get());

      window.location.replace(url+"&ids="+searchids.get());
    });
        
        });
        
               //process payroll
             $('#samplepayslip').click(function() {
                           $('#actionSamplePayslip').modal();
         $('#dialogCalculate').click(function(e) {
         e.preventDefault();
        alert('action for calculation')
    });
 //alert(searchids.get());

$("#netpayworking").click(function(e){
     if($(this).is(":checked")){
    $("#netpaysection").removeAttr("disabled");
     $("#grosspaysection").attr("disabled","disabled");
 }
 else{
     $("#grosspaysection").attr("disabled","disabled");
     $("#netpaysection").removeAttr("disabled");
     
 }
});
    });
        
        
        
            $('.multi').click(function() { var url=$("#emailslipsurl").val();
                $empno=$(this).attr("id");
  $('#actionMultiPayslips').modal();
         $('#confirmOkButton').click(function(e) {
         e.preventDefault();
         var url=$("#updateslab").val();
         from=$("#payrollmonthfrom :selected").val();
        to=$("#payrollmonthto :selected").val();
        fromyear=$("#payrollyearfrom").val();
        toyear=$("#payrollyearto").val();
    var searchids=$("input:checked").map(function(){
        return $(this).val();
    });
 //alert(searchids.get());

      window.location.replace(url+"?monthfrom="+from+"&monthto="+to+"&fromyear="+fromyear+"&toyear="+toyear+"&ids="+$empno+"&multi=true");
    });
        
        });


//rollback
  $('#btnDelSlab').click(function() {
                           $('#actionConfModal').modal();
         $('#dialogConfirmBtn').click(function(e) {
         e.preventDefault();
         var url=$("#rollbackpayrollurl").val();
 
 //alert(searchids.get());
if($(".checkboxAtch").is(":checked")){
    value=$(".checkboxAtch:checked").val();
     var searchids=$("input:checked").map(function(){
        return $(this).val();
    });
 //alert(searchids.get());

      window.location.replace(url+"?empNumber="+searchids.get()+"&monthyear="+$('#payrollmonth').val());
    
  }
  else{
  window.location.replace(url+"?monthyear="+$('#payrollmonth').val());    
  }
    });
        
        });
    
    
    //update
    
         $('#payslipmonth').change(function(e) {
         e.preventDefault();
         var monthyear=$('#payslipmonth').val();
        var searchids=$("input:checked").map(function(){
        return $(this).val();
    });
         var url=$("#updateslab").val();
       if(searchids.get()=="" || monthyear==""){
           alert("Select at least one employee and payroll month");
           return 0;
       }
       else{
        window.location.replace(url+'?id='+searchids.get()+"&month="+monthyear);
    }
    });
    //email
    
    $('#emailpayslips').change(function(e) {
         e.preventDefault();
         var monthyear=$('#emailpayslips').val();
        var searchids=$("input:checked").map(function(){
        return $(this).val();
    });
         var url=$("#emailslipsurl").val();
       if(searchids.get()=="" || monthyear==""){
           alert("Select at least one employee and payroll month");
           return 0;
       }
       else{
        window.location.replace(url+'?id='+searchids.get()+"&month="+monthyear);
    }
    });
    
   $('#emailp9').change(function(e) {
         e.preventDefault();
         var monthyear=$('#emailp9').val();
        var searchids=$("input:checked").map(function(){
        return $(this).val();
    });
         var url=$("#emailp9url").val();
       if(searchids.get()=="" || monthyear==""){
           alert("Select at least one employee and payroll month");
           return 0;
       }
       else{
        window.location.replace(url+'?id='+searchids.get()+"&month="+monthyear);
    }
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
    
    
    // Validates the Net Pay Form

$("#btncompute").click(function(e) {
e.preventDefault();
	// Capture gross pay, non-cash benefits and allowable deductions
	var grosspay = parseFloat($('input[name="txtGrossPay"]').val());
         var netpay=parseFloat($('input[name="txtNetPay"]').val());
	var insurancerelief = parseFloat($('input[name="txtInsureRelief"]').val());
	var benefits = parseFloat($('input[name="txtCashBenefits"]').val());
        var deductions=parseFloat($('input[name="txtDeductions"]').val());
	
	// Validate gross pay
//	if	(isNaN(grosspay))
//	{
//		alert("Please enter a valid number for gross pay.");
//		return false;
//	}
//	
//	if (grosspay < 0) 
//	{
//		alert("Gross pay cannot be less than zero.");
//		return false;
//	}
	
	// Validate non-cash benefits
	if (isNaN(benefits)) 
	{
		alert("Please enter a valid number for non-cash benefits.");
		return false;
	}

	if (benefits < 0) 
	{
		alert("Non-cash benefits cannot be less than zero.");
		return false;
	}
	
	// Validate allowable deductions
	if (isNaN(deductions)) 
	{
		alert("Please enter a valid number for allowable deductions.");
		return false;
	}
		
	if (deductions < 0) 
	{
		alert("Allowable deductions cannot be less than zero.");
		return false;
	}
	
        //post request
            // url='process';
$.ajax({
            url:'processSampleEmployeePayroll',
            type: 'post',
            data: {
                grosspay:grosspay,
                insurancerelief:insurancerelief,
                benefits:benefits,
                deductions:deductions,
                netpay:netpay
               },
            dataType: 'json',
            success: function(data) {
               var htmldata='<a href="#" class="addbutton" style="float:right !important;color:white" id="export">Export and Print</a><br><table style="background-color:white;width:100%" class="exporttable"><tr><td colspan="2" style="text-align:center">\n\
       <h3 style="text-align:center"><?php echo __("PAYSLIP") ?></h3><?php echo __("MONTH:".date('m/Y')) ?>&nbsp;&nbsp;'+
'\n'+'<br>'+
           '\n'+' <?php echo __("PAYROLL#SMP001") ?><br>'+
    +'\n'+'<center style="border-bottom:1px dotted black"><?php echo __("SAMPLE EMPLOYEE") ?></center>'
   + '\n'+'<br></td></tr>'
  + '\n'+' <tr><td style="text-align:left;font-weight:bold;border-bottom:1px dotted #000;border-top:1px dotted #000"><?php echo __("BENEFITS") ?>'
      + '\n'+' </td><td style="text-align:right;font-weight:bold;border-bottom:1px dotted #000;border-top:1px dotted #000">'+data.earnings_benefits+'</td></tr>'
   + '\n'+'<tr><td style="text-align:left;" colspan="2"><br></td></tr>'
  + '\n'+' <tr><td style="text-align:left;font-weight:bold;border-bottom:1px dotted #000;border-top:1px dotted #000"><?php echo __("GROSS PAY") ?>'
    + '\n'+'   </td><td style="text-align:right;font-weight:bold;border-bottom:1px dotted #000;border-top:1px dotted #000">'+data.grosspay+'</td></tr>'

  + '\n'+' <tr><td style="text-align:left;font-weight:bold" colspan="2"> <?php echo __("DEDUCTIONS") ?>'
     + '\n'+'  </td></tr>'
   + '\n'+' <tr><td style="text-align:left;"> <?php echo __("PAYE") ?>'
    + '\n'+'   </td><td style="text-align:right;">'+data.paye+'</td></tr>'
      + '\n'+' <tr><td style="text-align:left;"> <?php echo __("NSSF") ?>'
      + '\n'+' </td><td style="text-align:right;">'+data.nssf+'</td></tr>'
      + '\n'+'    <tr><td style="text-align:left;"> <?php echo __("NHIF") ?>'
      + '\n'+' </td><td style="text-align:right;">'+data.nhif+'</td></tr>'
   + '\n'+' <tr><td style="text-align:left;font-weight:bold"> <?php echo __("T.DEDUCTIONS") ?>'
      + '\n'+' </td><td style="text-align:right;font-weight:bold">'+data.deductions+'</td></tr>'

   + '\n'+'<tr><td style="text-align:left;font-weight:bold" colspan="2"> <br> <?php echo __("RELIEFS") ?></td></tr>'
          + '\n'+' <tr><td style="text-align:left">PERSONAL RELIEF</td><td style="text-align:right">'+data.personal_relief+'</td></tr>'
         + '\n'+'  <tr><td style="text-align:left">INSURANCE RELIEF</td><td style="text-align:right">'+data.insurance_relief+'</td></tr>'
   + '\n'+'<tr><td style="text-align:left;font-weight:bold;border-bottom:1px solid #000"><?php echo __("NET PAY:") ?></td>  <td style="text-align:right;font-weight:bold;border-bottom:1px solid #000">'+data.netpay+'</td></tr>'
   + '\n'+'<tr><td style="text-align:left;" colspan="2"><br></td></tr>'
'\n'+'<tr><td style="text-align:left;font-weight:bold" colspan="2">SIGNATURE.............. <br>  <br>  <br>  <br>  <br><br>  <br>    </td> </tr>'

'\n'+'</table>';
               $("#actionSamplePayslip1contents").html(htmldata);
               $("#actionSamplePayslip1").show();
             $("#actionSamplePayslip").hide();
             
             
               $("#export").on('click', function (event) {
//          event.preventDefault();
//        
//          var csv_value=$('.exporttable').table2CSV({delivery:'value'});
//          
//        
//  $("#csv_text").val(csv_value); 
//  $("#csvform").submit();

$(".exporttable").table2excel({
					//exclude: ".noExl",
					name: "Exported File",
					filename: "exportedList"
				});
                                $(".exporttables").table2excel({
					//exclude: ".noExl",
					name: "Exported File",
					filename: "exportedList"
				});
    });
            },
            error:function(data){
               console.log(data);
            }
           
        }); 
	
  $("#closesamplepayslip").click(function(e){
  $("#actionSamplePayslip1").css("display","none");
    });      
});

// Initialise Net Pay form from cookie settings

function getCookie()
{
	if (document.cookie == "") return;	// no cookies
	
	// look for deduCalc cookie
	var cookieArray = document.cookie.split(";");
	for (var i=0; i<cookieArray.length; i++)
	{
		// extract cookie name
		var cookieValue = cookieArray[i].split("=");
		var cookieName = cookieValue[0];
		while (cookieName.charAt(0)==' ')
			cookieName = cookieName.substring(1, cookieName.length);			
			
		if (cookieName.indexOf("deduCalc") == 0)
		{
			// cookie found, initialise form
			var showOldRates = cookieValue[1].split("&")[0];			
			var chkOldRates = document.frmNetPay.chkOldRates;
			if (showOldRates == "true")
				chkOldRates.checked = true; 
			else
				chkOldRates.checked = false; 						
			return;
		}
	}
}
	
// Update cookie with Net Pay form settings	
	
function setCookie()
{
	var expiryDate = new Date();
	expiryDate.setTime(expiryDate.getTime() + 180*24*60*60*1000);	// 180 days from now
	
	// show working
	var oldRates = "";
	var chkOldRates = document.frmNetPay.chkOldRates;
	
	if (chkOldRates.checked)
		showOldRates="true";
	else
		showOldRates="false";
		
	// update cookie
	document.cookie = "deduCalc=" + showOldRates + ";expires=" + 
		expiryDate.toUTCString() + ";path=/";
}

</script>
