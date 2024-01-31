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


<?php use_javascript(plugin_web_path('orangehrmLoansPlugin', 'js/newapplicationsSuccess')); ?>




<!-- Listi view -->

<div id="recordsListDiv" class="box miniList">
    <div class="head">
        <h1><?php echo __('*Approved Applications '.date("Y")); ?>&nbsp;&nbsp; </h1>
            
            

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
        <form name="frmList" id="frmList" method="post" action="<?php echo url_for('admin/deleteSkills'); ?>">
          
            <p id="listActions">
                <input type="hidden" id="disburseslab" value="<?php echo url_for('loans/disburse'); ?>">
                  
                <input type="button" class="addbutton" id="btnAddSlab" value="<?php echo __('Disburse Loan'); ?>"/>
                      
      
            </p>
            
            <table class="table hover" id="recordsListTable">
                <thead>
                    <tr>
                        <th class="check" style="width:2%"><input type="checkbox" id="checkAll" class="checkboxAtch" /></td>
                        <th ><?php echo __('Member'); ?></th>
                        <th ><?php echo __('Loan Type'); ?></th>
                                <th ><?php echo __('Date Approved'); ?></th>
                                 <th ><?php echo __('Amount Approved'); ?></th>
                                  <th ><?php echo __('Period (Months)'); ?></th>
                                   <th ><?php echo __('Interest Rate (Monthly)'); ?></th>
                                    
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 0;
           foreach ($pager->getResults() as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    
                    <tr class="<?php echo $cssClass;?>">
                        <td class="check">
                            <input type="checkbox" class="checkboxAtch" name="chkListRecord[]" value="<?php echo $record->getId(); ?>" />
                        </td>
                        <td class="tdName tdValue">
                          <?php
                        $employeedao=new EmployeeDao();
                        $employee=$employeedao->getEmployee($record->getEmpNumber());
                            echo $employee->getEmpFirstname().' '.$employee->getEmpMiddleName().' '.$employee->getEmpLastname() ; ?>
                        </td>
                        <td class="tdName tdValue">
                          <?php 
                          $loanproductdao=new LoanProductsDao();
                          $loanproduct=$loanproductdao->getLoanProductById($record->getLoanproductId());
                          echo $loanproduct->getName(); 
                          
                          ?>
                        </td>
                        <td class="tdValue">
                            <?php echo $record->getDateApproved(); ?> 
                        </td>
                        <td class="tdValue">
                            <?php echo $record->getAmountApproved(); ?> 
                        </td>
                        <td class="tdValue">
                            <?php echo $record->getRepaymentDuration(); ?> 
                        </td>
                          <td class="tdValue">
                            <?php echo $record->getInterestRate(); ?> 
                        </td>
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
         var url=$("#disburseslab").val();
         window.location.replace(url+'?id='+id);
    });
    
    //update tax slab
         $('#btnUpdateSlab').click(function(e) {
         e.preventDefault();
         var id=$(".check .checkboxAtch:checked").val();
         var url=$("#ammendslab").val();
       
        window.location.replace(url+'?id='+id);
    });
    
         $('#btnDelSlab').click(function(e) {
         e.preventDefault();
           if ($(".check .checkboxAtch:checked").length > 0) {
               var id=$(".check .checkboxAtch:checked").val();
         var url=$("#rejectslab").val();
       
        window.location.replace(url+'?id='+id);
         }
    });
    
});

</script>