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

<div class="box searchForm toggableForm" id="employee-information">
    <div class="head">
        <h1><?php echo __('Leave Encashment'); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
        <div class="inner">
         <form id="search_form" name="frmEmployeeSearch" method="post" action="<?php echo url_for('payroll/leaveEncashment'); ?>">

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
                <input type="hidden" id="filterurl" value="<?php echo url_for('leave/leavereport'); ?>">
                   
                   
        <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
              <input type="button" class="addbutton print" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('Print') ?>"/>
     <br>
            </p>
            <div id="dvData">
            <table class="table hover data-table displayTable exporttable tablestatic" id="recordsListTable">
                <thead>
                    <tr><td></td><td></td><td></td><td class="boldText borderBottom">LEAVE USAGE AND ENCASHMENT FOR <?=$year?></td><td></td><td></td><td></td><td></td></tr>
                    <tr><td class="boldText borderBottom">#</td><td class="boldText borderBottom">Employee Number</td><td class="boldText borderBottom">Employee Name</td><td class="boldText borderBottom">Leave Entitlement(Days)</td><td class="boldText borderBottom">Leave Scheduled/Taken(Days)</td><td class="boldText borderBottom">Leave Balance(Days)</td><td class="boldText borderBottom">Daily Rate</td><td class="boldText borderBottom">Amount Entitled</td></tr>
                                      
                   
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 0;
                    $count=1;
           foreach ($allentitlements as $record):  
               if(count($record)>0){
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    <tr>
                        <td><?=$count?></td>
                        <td class="tdName tdValue">
                            
                         <?php 
                    foreach ($record as $value) {
                      $empno=$value["emp_number"]  ;
                    }
                    $salary = HsHrEmpBasicsalaryTable::getEmpBasicSalary($empno);
        $dailypay = round(($salary * 12) / 365);
                      
                         $employeedetail=  EmployeeDao::getEmployeeByNumber($empno); 
                         echo $employeedetail->getEmployeeId();
                         ?>
                     
                        </td>
                        <td class="tdName tdValue">
                        <?=$employeedetail->getEmpFirstname()." ".$employeedetail->getEmpMiddleName()." ".$employeedetail->getEmpLastname()?>
                        </td>
                 
                         <td class="tdName tdValue">
                         <?php  
                         $leaveentitlement=0;
                         $leavetaken=0;
                         foreach ($record as $value) {
                                 $leaveentitlement+=$value["no_of_days"];
                                 $leavetaken+=$value["days_used"];
                                
                             }
                         echo $leaveentitlement;         
                                  ?>
                        </td>
                        <td class="tdName tdValue">
                        <?=$leavetaken?>
                            <?php $balance=$leaveentitlement-$leavetaken; ?>
                        </td>
                       
                        
                       <td class="tdValue"><?=$balance?></td>
                       <td class="tdValue" style="text-align:right"><?=$dailypay?></td>
                       <td class="tdValue" style="text-align:right"><?=
                                                                number_format($dailypay*$balance)?></td>
                    </tr>
                    
                    <?php 
                    $row++;
                    $count++;
               }
                    endforeach; 
                    ?>
                    
                    <?php if (count($allentitlements) == 0) : ?>
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
                return item.name
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

</script>