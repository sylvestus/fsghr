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
        <h1><?php echo __('Disbursed loans '.date("Y")); ?>&nbsp;&nbsp; </h1>
            
            

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
        <form name="frmList" id="frmList" method="post" action="<?php echo url_for('loans/viewloan'); ?>">
          
            <p id="listActions">
                <input type="hidden" id="viewslab" value="<?php echo url_for('loans/viewloan'); ?>">
                   <input type="hidden" id="repayslab" value="<?php echo url_for('loans/settleLoan'); ?>">
                   
    <input type="hidden" id="topupurl" value="<?php echo url_for('loans/topup'); ?>">
      
            </p>
            
            <table class="table hover display dataTable" id="recordsListTable">
                <thead>on
                    <tr>
                      
                        <th ><?php echo  __('Member'); ?></th>
                        <th ><?php echo __('Loan Type'); ?></th>
                                <th ><?php echo __('Date Disbursed'); ?></th>
                                 <th ><?php echo __('Amount Disbursed'); ?></th>
                                  <th ><?php echo __('Period (Months)'); ?></th>
                                   <th ><?php echo __('Interest Rate (Monthly)'); ?></th>
                                    <th>Top Up</th>
                                   <th>Manage</th>
                                   <th>Repay</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 0;
           foreach ($pager->getResults() as $record):  
               $balance=  LoanTransactionsDao::getLoanBalance($record->getId());
        
           if($balance>0){
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    
                    <tr class="<?php echo $cssClass;?>">
                       
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
                            <?php echo date("d-m-Y",  strtotime($record->getDateDisbursed())); ?> 
                        </td>
                        <td class="tdValue">
                            <input type="text" readonly="readonly" class="disbursed" value="<?php echo $record->getAmountDisbursed(); ?>" id="<?=$record->getId()?>"> 
                        </td>
                        <td class="tdValue">
                            <?php echo number_format($record->getRepaymentDuration(),2); ?> 
                        </td>
                          <td class="tdValue">
                              <input type="text" readonly="readonly" class="interest" value=" <?php echo $record->getInterestRate(); ?>" tabindex="<?=$record->getId()?>"  id="interest<?=$record->getId()?>">
                    
                        </td>
                        <!--<td class="tdValue"><a href="<?=  url_for("loans/apply?id=".$record->getEmpNumber())?>" style="text-decoration:none" class="btn btn-success" ><?php echo __('Top Up'); ?></a></td>-->
                           <td class="tdValue"><input type="button" class="topup" id="<?=$record->getId()?>" value="<?php echo __('Top Up'); ?>"/></td>
                        <td class="tdValue"><input type="button" class="manageloan" id="<?=$record->getId()?>" value="<?php echo __('Manage'); ?>"/></td>
                        <td class="tdValue"><input type="button" class="repayloan cancel" id="<?=$record->getId()?>" value="<?php echo __('Settle'); ?>"/></td>
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
    <p><?php echo __("Confirm Action?"); ?></p>
  </div>
  <div class="modal-footer">
    <input type="button" class="btn" data-dismiss="modal" id="dialogDeleteBtn" value="<?php echo __('Ok'); ?>" />
    <input type="button" class="btn reset"  data-dismiss="modal" value="<?php echo __('Cancel'); ?>" />
  </div>
</div>
<!-- Confirmation box HTML: Ends -->


<script type="text/javascript">
$(document).ready(function() {
  
  $(".disbursed").click(function(){
      $(this).removeAttr("readonly");
  });
  $(".interest").click(function(){
      $(this).removeAttr("readonly");
  });
    //manage
     $('.manageloan').click(function(e) {
         e.preventDefault();
           var id=$(this).attr("id");
       var url=$("#viewslab").val();
       window.location.replace(url+'?id='+id);
    });
    
    //repay
     $('.repayloan').click(function(e) {
         e.preventDefault();
           var id=$(this).attr("id");
       var url=$("#repayslab").val();
       window.location.replace(url+'?id='+id);
    });
    //change interest
    $(".interest").change(function(e){
       var url=$("#topupurl").val();
       var id=$(this).attr("tabindex");
        var interest=$("#interest"+id).val();
    
       $("#deleteConfModal").show();
        $(".reset").click(function(e){ 
              $("#deleteConfModal").hide();
        });
      $("#dialogDeleteBtn").click(function(e){
           $("#deleteConfModal").hide();
       $.ajax({
            url: url,
            type: 'get',
            data: {
                'interest':interest,
                'id':id
            },
            dataType: 'json',
            success: function(obj) {
              alert(obj.message);
            }
        });
    });   
    });
    
     //topup
     $('.topup').click(function(e) {
         e.preventDefault();
           var id=$(this).attr("id");
              var amount=$("#"+id+".disbursed").val();

       var url=$("#topupurl").val();
       $("#deleteConfModal").show();
        $(".reset").click(function(e){ 
              $("#deleteConfModal").hide();
        });
      $("#dialogDeleteBtn").click(function(e){
           $("#deleteConfModal").hide();
       $.ajax({
            url: url,
            type: 'get',
            data: {
                'amount':amount,
                'id':id
            },
            dataType: 'json',
            success: function(obj) {
              alert(obj.message);
              window.location.reload();
            }
        });
        
    });
    });
    
    //update tax slab
     
    
});

</script>