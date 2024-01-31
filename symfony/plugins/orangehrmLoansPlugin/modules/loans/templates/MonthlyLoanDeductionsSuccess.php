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
        <h1><?php echo __('Loan Repayments Report  '); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
        <form name="frmList" id="frmList" method="post" action="<?php echo url_for('loans/viewloan'); ?>">
          
            <p id="listActions">
                <input type="hidden" id="filterurl" value="<?php echo url_for('loans/loanTransactions'); ?>">
                   
                
     <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
     <br>
            </p>
            <div id="dvData">
            <table class="table hover exporttable" id="recordsListTable">
                <thead>
                    <tr>
                        <td  class="boldText borderBottom"><?php echo __('Trans.ID'); ?></td>
                        <td class="boldText borderBottom"><?php echo __('Date'); ?></td>
                          <td class="boldText borderBottom"><?php echo __('Emp #'); ?></td>
                        <td class="boldText borderBottom"><?php echo __('Loan Acccount'); ?></td>
                         <td class="boldText borderBottom"><?php echo __('Loan Type'); ?></td>
                        <td class="boldText borderBottom"><?php echo __('Description'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Amount'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Transaction'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Payment Mode'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Cheque Date'); ?></td>
                                   <td class="boldText borderBottom"><?php echo __('Cheque No'); ?></td>
                               <td class="boldText borderBottom"><?php echo __('Cheque Det'); ?></td>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 0;
           foreach ($pager->getResults() as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                     <?php
                    
                        ?>
                    <tr class="<?php echo $cssClass;?>">
                       
                        <td class="tdName tdValue">
                          <?=$record->getId();
                        
                            ?>
                        </td>
                        <td class="tdName tdValue">
                       <?= date("d-m-Y",  strtotime($record->getDate()))?>    
                        </td>
                           <td class="tdName tdValue">
                                <?php 
                            $loanaccountdao= new LoanAccountsDao();
                            $loanaccount=$loanaccountdao->getAccountById($record->getLoanaccountId());
                            $employee=EmployeeDao::getEmployeeByNumber($loanaccount->emp_number)?>
                          <?=$employee->emp_number
                          ?>
                        </td>
                        <td class="tdName tdValue">
                           
                            <a href="<?=  url_for('loans/viewloan?id='.$record->getLoanaccountId())?>"><?=$employee->emp_firstname." ".$employee->emp_middle_name." ".$employee->emp_lastname?></a>
                        </td>
                         <td class="tdName tdValue">
                          <?php $loanproduct=new LoanProductsDao();
                          $product=$loanproduct->getLoanProductById($loanaccount->loanproduct_id);
                          echo $product->name;
                          ?>
                        </td>
                        <td class="tdName tdValue">
                          <?=$record->getDescription();
                          ?>
                        </td>
                        <td class="tdValue">
                         <?=  number_format($record->getAmount(),2) ?> 
                        </td>
                        <td class="tdValue">
                            <?php echo $record->getType() ?> 
                        </td>
                        <td class="tdValue">
                            <?php echo $record->getPaymentMode(); ?> 
                        </td>
                          <td class="tdValue">
                            <?php if($record->getChequeDate()){echo  date("d-m-Y",  strtotime($record->getChequeDate()));} ?> 
                        </td>
                       
                        <td class="tdValue"><?= $record->getChequeNo()?></td>
                        <td class="tdValue"><?= $record->getChequeDetails()?></td>
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


