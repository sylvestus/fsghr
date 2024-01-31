<?php

/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
?>

<div class="box searchForm toggableForm" id="employee-information">
    <div class="head">
        <h1><?php echo __("Employee Deductions Information") ?></h1>
    </div>
  

    <a href="#" class="toggle tiptip" title="<?php echo __(CommonMessages::TOGGABLE_DEFAULT_MESSAGE); ?>">&gt;</a>

</div> <!-- employee-information -->
<div id="recordsListDiv" class="box miniList">
    
 <div class="inner">
           
            <p id="listActions">
                <input type="hidden" id="adddeduction" value="<?php echo url_for('earningsdeductions/AddEmployeeDeduction'); ?>">
                  <input type="hidden" id="deletededuction" value="<?php echo url_for('earningsdeductions/DeleteEmployeeDeduction'); ?>">
                   
                  <input type="hidden" id="updatededuction" value="<?php echo url_for('earningsdeductions/UpdateEmployeesDeduction'); ?>">
                <input type="button" class="addbutton" id="btnAddSlab" value="<?php echo __('Add Employee Deduction'); ?>"/>
                <select id="btnUpdateSlab" class="greenselect">
                      <option value="">Update Employee Deduction</option>
                      <?php foreach ($deductions as $deduction) { 
                         echo '<option value="'.$deduction->getId().'">'.$deduction->getName().'</option>';
                   
                      } 
                      ?>                  </select>
    
                <input type="button" class="delete" id="btnDelSlab" value="<?php echo __('Delete Deductions'); ?>"/>
      
            </p> 
        <?php include_partial('global/flash_messages'); ?>
         <table class="table hover" id="recordsListTable">
                <thead>
                    <tr>
                        <th class="check" style="width:2%"><input type="checkbox" id="checkAll" class="checkboxAtch" /></th>
                          <th ><?php echo __('ID'); ?></th>
                        <th ><?php echo __('Employee Name'); ?></th>
                        <th ><?php echo __('Job'); ?></th>
                                <th ><?php echo __('Employment Status'); ?></th>
                                 
                                    <?php
                                    foreach ($deductions as $deduction) { ?>
                                 <th><?=$deduction->getName();?></th>   
                            <?php        }
                                    ?>
                                    
                    </tr>
                </thead>
                <tbody>
                    <?php
        foreach ($pager->getResults() as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
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
                         <?php
                          $employedeductions= EmployeeDeductionsDao::getDeductionByEmpNumber($record->getEmpNumber());
                          $countitems=count($deductions);
                          //compare rows and columns
     for($i=0;$i<$countitems;$i++){
   echo '<td  id="'.$deductions[$i].'">';
            foreach ($employedeductions as $empearn) { 
                $deductiondetail= DeductionsDao::getDeductionById($empearn->getDeduction());
                   if(strtolower($deductiondetail->getName())==strtolower($deductions[$i])){
                             
                      echo $empearn->getAmount();
                      
                   }
                  
                                ?>
                               
                            <?php      
                               
                            }
                                    
      echo '</td>';
     }
     
                                 
                         
                   ?>   
                    </tr>
                    
                     <?php 
                    $row++;
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
                    
                </tbody>
            </table>
 </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
       $("#checkAll").click(function() {
          if($("#checkAll").is(":checked")){
       $(".checkboxAtch").each(function(){
           $('.checkboxAtch').attr("checked","checked");
       });
          }
          else{
              $(".checkboxAtch").each(function(){
           $('.checkboxAtch').prop("checked",false);
       });   
          }
          });
       //update
       
      
   
    //add tax slab
     $('#btnAddSlab').click(function(e) {
         e.preventDefault();
           var id=$(".check .checkboxAtch:checked").val();
         var url=$("#adddeduction").val();
            window.location.replace(url+'?id='+id);
    });
    
    //update deduction
         $('#btnUpdateSlab').change(function(e) {
         e.preventDefault();
         var id=$(this).val();
         var empno=$(".check .checkboxAtch:checked").val();
         var url=$("#updatededuction").val();
             if($.isNumeric(id) && $.isNumeric(empno)){
        window.location.replace(url+'?id='+id+"&empno="+empno);
          }else{
              alert("Select Deduction and affected employee")
              return;}
    });
    
         $('#btnDelSlab').click(function(e) {
         e.preventDefault();
           if ($(".check .checkboxAtch:checked").length > 0) {
               var id=$(".check .checkboxAtch:checked").val();
         var url=$("#deletededuction").val();
           
         window.location.replace(url+'?id='+id);
    
         }
    });
    
});

</script>
