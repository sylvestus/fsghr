
<?php //use_javascript(plugin_web_path('orangehrmPayrollPlugin', '/js/updateConfigurationSuccess')); ?>

<div class="box">

<?php if (isset($credentialMessage)) { ?>

<div class="message warning">
    <?php echo __(CommonMessages::CREDENTIALS_REQUIRED) ?> 
</div>

<?php } else { ?>
 <?php include_partial('global/flash_messages'); ?>
  
    <div class="head">
        <h1><?php echo __('Member- '.$member->getFirstName().' '.$member->getMiddleName().' '.$member->getLastName()); ?>  <input type="hidden" id="repayloan" value="<?php echo url_for('loans/repayloan?id='.$loanaccount->getId()); ?>">
                  
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" class="addbutton" id="btnRepayLoan" value="<?php echo __('Repay Loan'); ?>"/>  <span style="float:right"><?php echo __('Loan Account- '.$loanaccount->getAccountNumber()); ?></span></h1>
     
    </div>

    <div class="inner" id="addIncomeTaxSlabTbl">
        <input type="hidden"  id="repayurl" value="<?=  url_for('loans/settleLoan')?>"
            <fieldset>
                <table border="1" style="width:100%;">
                    <tr>
                        <td>
                            <table class="table blackborderright">
                                <?php $loanproductdao= new LoanProductsDao(); 
                                $product=$loanproductdao->getLoanProductById($loanaccount->getLoanproductId());
                                ?>
                                <tr><td>Loan Type:</td><td></td><td><?=$product->getName()?></td></tr>
                                <tr><td>Date Disbursed</td><td></td><td><?=$loanaccount->getDateDisbursed()?></td></tr>
                                <tr><td>Amount Disbursed</td><td></td><td><?= number_format($loanaccount->getAmountDisbursed(),2)?></td></tr>
                                <tr><td>Interest Amount</td><td></td><td><?=  number_format($interest,2)?></td></tr>
                                <tr><td> Loan Amount</td><td></td><td><?= number_format($loanaccount->getAmountDisbursed() + $interest,2)?></td></tr>
                                
                            </table>      
                            
                            
                        </td>
                        
                        <td>
                            <!-- <table class="table blackborderright">-->
                                <!-- <tr><td>Principal paid</td><td></td><td><?=  number_format($principal_paid,2)?></td></tr>-->
                                <!--<tr><td>Interest paid</td><td></td><td><?=  number_format($interest_paid,2)?></td></tr>-->
                               
                              <!-- <tr><td>Principal Balance</td><td></td><td><?=  number_format($loanaccount->getAmountDisbursed() - $principal_paid,2)?></td></tr>-->
                           <!-- </table>     --> 
                            
                        </td><td>
                            
                            <input type="hidden" value="<?=$loanaccount->getId()?>" id="loanacctid">
                             <table class="table">
                                <tr><td>Loan Period</td><td></td><td><?=  $loanaccount->getRepaymentDuration()?></td></tr>
                                <tr><td>Interest Rate</td><td></td><td><?=  $loanaccount->getInterestRate()?>%</td></tr>
                                <tr><td>Repayment Duration</td><td></td><td><?=$loanaccount->getRepaymentDuration()?></td></tr>
<tr><td>Loan Balance</td><td></td><td><?=  number_format($loanbalance,2)?></td></tr>
                            </table>      
                            
                        </td>
                    </tr>
                    <tr>
                   
                     
                    <td>
                        <hr>
                        <table class="table table-condensed table-hover">

          <thead>

            <th>Installment #</th>
            <th>Date </th>
            <th>Principal </th>
            <th>Interest </th>
            <th>Total </th>
            <th>Loan Balance </th>
            <th>Monthly Payment </th>
 <th class="check" style="width:2%"><input type="checkbox" id="checkAll" class="checkboxAtch" /></th>
          </thead>
          <tbody>


            <tr>

              <td>0</td>
              <td><?=date("d-m-Y",  strtotime($loanaccount->getDateDisbursed()));?></td>
              <td><?= number_format($loanaccount->getAmountDisbursed() + $loanaccount->getTopUpAmount(),2)?></td>
              <td><?php number_format(LoanAccountsDao::getInterestAmount($loanaccount))?></td>
              <td><?= number_format(LoanAccountsDao::getLoanAmount($loanaccount))?></td>
              <td><?= number_format(LoanAccountsDao::getLoanAmount($loanaccount))?></td>
     
              <td><?='0'?></td>
              <td></td>
            </tr>


             <?php 

                $date = $loanaccount->getRepaymentStartDate();

                $interest = LoanAccountsDao::getInterestAmount($loanaccount);
                

                
                //$balance = Loanaccount::getLoanAmount($loanaccount);
                $days = 30;
                $totalint =0;


                if($loanaccount->getRepaymentDuration() !=null){

                    $period = $loanaccount->getRepaymentDuration();

                } else {

                  $period = $loanaccount->getRepaymentDuration();
                }


                $monthlyRate = (($loanaccount->getInterestRate())/100);  // interest rate in per month already
                $principal = $loanaccount->getAmountDisbursed() + $loanaccount->getTopUpAmount();
                           //   $monthlyPayment = ($monthlyRate /(1-(pow((1+$monthlyRate),-($period)))))* $principal ;
          
$loanschedules=  OhrmLoanrepaymentScheduleTable::getLoanSchedule($loanaccount->getId());
$i=1;
            foreach($loanschedules as $schedule) { 
               $interestForMonth = $principal* $monthlyRate;
$monthlyPayment=$schedule->getMp();
  $principalForMonth =$schedule->getMp();// $monthlyPayment - $interestForMonth;
  
  $principal -= $principalForMonth; 
                
                ?> 


                  
            <tr>

             

              <td><?= $i ?></td>
              <td>
      
                <?= date("m-Y",  strtotime($schedule->getDate())) ?>

              </td>

              <td> 

<?php //$total_principal = $total_principal + $principal_amount; ?>
                <?= number_format($principalForMonth);?> </td>
              <td> 
                <?php 

                if($product->getFormula() == 'SL'){

                  $interest_amount = $interest/$period;
                }

                if($product->getFormula() == 'RB'){
$interest_amount = $interest/$period;
                 // $interest_amount =((($principal - $total_principal) * ($loanaccount->interest_rate/100)));

                }

                

                ?>

                <?= number_format($interestForMonth)?> </td>
              <td> 
                <?php 
                $total=$principalForMonth+$interestForMonth;
                ?>

                <?= number_format($total)?> </td>
              <td>
             

                <?= number_format(abs($principal))?>

              </td>

               <td>
             

                <?= number_format($principalForMonth+$interestForMonth)?>




              </td>
 <td class="check">
     <?php $repaymentsfromonth=LoanTransactionsDao::getRepaymentsForMonth($loanaccount->getId(), date("m-Y",  strtotime($schedule->getDate()))); 
    // echo $repaymentsfromonth;
     if(round($repaymentsfromonth)>=round($principalForMonth)){
         echo "Paid:".round($total);
     }
     else{
     ?>
     
     <input type="checkbox" class="checkboxAtch" name="chkListRecord[]"  value="<?php echo date("m-Y",  strtotime($schedule->getDate())); ?>" />
     <?php }?>        
 </td>
            </tr>




            <?php
              $balance = $balance - $total; 

              $days = $days + 30;

             
                //$date = date('Y-m-d', strtotime($date) + $days);

                $date = date('Y-m-d', strtotime($date. ' + 30 days'));

                  //$date = date('Y-m-d', $date);
                
$i++;
          } ?>

         

          </tbody>


        </table>   
                        
                        
                        
                    </td>     <td></td><td></td>
                        
                    </tr>
                    
                </table>
            </fieldset>
       
    </div>

<?php } ?>
    <!-- Confirmation box HTML: Begins -->
<div class="modal hide" id="actionConfModal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo __('TechSavannaHRM - Confirmation Required'); ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo __("CONFIRM REPAYMENT ACTION ?"); ?></p>
  </div>
  <div class="modal-footer">
    <input type="button" class="btn" data-dismiss="modal" id="dialogConfirmBtn" value="<?php echo __('Ok'); ?>" />
    <input type="button" class="btn reset" data-dismiss="modal" value="<?php echo __('Cancel'); ?>" />
  </div>
</div>
<!-- Confirmation box HTML: Ends -->
</div> <!-- Box -->    
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
    
    
       $('#btnRepayLoan').click(function() {
                           $('#actionConfModal').modal();
         $('#dialogConfirmBtn').click(function(e) {
         e.preventDefault();
         var url=$("#repayurl").val();
         
    var searchids=$("input:checked").map(function(){
        return $(this).val();
    });
 if(searchids.get()==""){
     alert("Please select period");
     return 0;
 }
 else{

      window.location.replace(url+"?periods="+searchids.get()+"&loanrepayment=true"+"&loanacct="+$("#loanacctid").val());
  }
    });
        
        });
    
});

    </script>

