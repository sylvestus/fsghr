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
<?php use_javascript('jquery.PrintArea.js');
$columncount=4;
if(@$_REQUEST['paging']){
    $columncount=$_REQUEST["paging"];
}
 $imagePath = theme_path("images");
?>
<style>
    .miniList p {
   margin-bottom: 1px !important;
  padding-top: 0;
}
</style>
<div class="box searchForm toggableForm" id="employee-information">
    <div class="head">
        <?php
$STRINGMONTHS="";        
        if($months){ 
     foreach ($months as $value) {
         $STRINGMONTHS.=$value .",";
     }
            ?>
      <h1><?php echo __("Payslips for ").$STRINGMONTHS; ?></h1>
        <?php
        }
        else { ?>
   <h1><?php echo __("Payslips for ".$month) ?></h1>        
      <?php  }
        ?>
    </div>
    <div class="inner">
        <p id="listActions">
                  <input type="hidden" id="processpayroll" value="<?php echo url_for('payroll/processEmployeePayroll'); ?>">
               <input type="hidden" id="payrollurl" value="<?php echo url_for('payroll/processPayroll'); ?>">
                           <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
                   <a href="#" class="addbutton" style="float:right !important" id="emailbtn"><img src="<?php echo "{$imagePath}/email.png";?>" alt="email"></a>  
                 <a href="#" class="addbutton" style="float:right !important" id="pdfbtn"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>             
                          <select id="payslipcolumns" class="greenselect">
                              <option selected="selected" value="">Show Columns</option>
                             <?php
                            $columns=1; $i=4;
                             while ($columns<=$i) {
                                
                                 echo '<option value="'.$columns.'">'.$columns.'</option>';
                                 $columns++;
                             }
                             ?>
                          </select>
               
       <input type="button" class="addbutton print" id="btnAddSlab" rel="reportsdiv"  value="<?php echo __('Print Slips') ?>"/>
       <?php if($isAdmin){ ?><input type="button" class="reset"  id="btnBack"   value="<?php echo __('Back to Payroll') ?>"/> <?php }?>
            </p>

    </div> <!-- inner -->

    <a href="#" class="toggle tiptip" title="<?php echo __(CommonMessages::TOGGABLE_DEFAULT_MESSAGE); ?>">&gt;</a>

</div> <!-- employee-information -->
<div id="recordsListDiv" class="box miniList">
   
 <div class="inner">
     <div id="reportsdiv" class="printable">
        <?php include_partial('global/flash_messages'); ?>
         <table class="table hover" id="recordsList" style="font-size:12px"  cellpading="1"  >
          <tr>
    <?php
    $count=1;
   
                                     foreach ($allslips as $slipid) {
                                         ?>
              <td style="border-right:1px solid black;" >
                  <table>
                      <tr>
                         
                          <td colspan="2" style="text-align:center">
                              <h3  style="text-align:center"> <?=  strtoupper($organisationinfo->getName())?></h3>
                                            <h3 style="text-align:center"><?php echo __("PAYSLIP")?></h3>
                                            <?php $employeedao=new EmployeeDao();
                                            $slipdata=  PayslipTable::getPayslipById($slipid);
                                            $employeeinfo=$employeedao->getEmployee($slipdata->getEmpNumber());
                                           $salarycomponents=$employeedao->getEmployeeSalaries($slipdata->getEmpNumber());
                                        $payslipitems=  PayslipItemsTable::getItemsFromPayslipNo($slipdata->getPayslipNo());
                                         $code=HsHrEmpBasicsalaryTable::getSalaryCode($slipdata->getEmpNumber());
                                         $basic=HsHrEmpBasicsalaryTable::getEmpBasicSalary($slipdata->getEmpNumber());
                                            ?>
           <?php echo __(" DEPARTMENT:".$slipdata->getDepartment())?>
          <br>
          <?php echo __("MONTH: ".date("m-Y",  strtotime($slipdata->getPayslipdate())))?>&nbsp;&nbsp;
          <br>
          <?php echo __("PAYROLL# ".$employeeinfo->getEmployeeId())?><br>
           <center style="border-bottom:1px dotted black"><?php echo __("NAME:".strtoupper($employeeinfo->getEmpFirstname().' '.$employeeinfo->getEmpMiddleName().' '.$employeeinfo->getEmpLastname() ))?></center>
           <br>
         
                             
                          </td>
                         
                      </tr>
                      <tr><td style="text-align:left;font-weight:bold" colspan="2"><?php echo __("TIME UNITS")?>
         </td></tr>
                      <?php if($code==4){  //casual rate?>
                      <tr><td style="text-align:left;"><?php echo __("HOURS PAID")?>
                              <?php 
                              $payrollmonth=$_REQUEST["month"];
                              $formatted=str_replace("/","-", $payrollmonth);
                                     
                              $hours=getHoursWorkedMonth($slipdata->getEmpNumber(),$formatted);?>
                          </td><td style="text-align:right"><?=round($hours,2)?></td></tr>
                      <?php }
                      else{
                          ?>
                      <tr><td style="text-align:left;"><?php echo __("DAYS PAID")?>
                          </td><td style="text-align:right"><?=$slipdata->getPaidDays()?></td></tr>
                      <?php }?>
                             <tr><td style="text-align:left;font-weight:bold" colspan="2"><?php echo __("EARNINGS")?>
         </td></tr>
                             <tr>
                                  <?php //  foreach ($salarycomponents as $component) {
              //echo  '<td style="text-align:left">'.strtoupper($component->getSalaryComponent()).'</td><td style="text-align:right">'.number_format($component->getAmount(),2).'</td></tr>' ;
         
        //   }
                                  echo '<td style="text-align:left">BASIC PAY</td><td style="text-align:right">'.number_format($slipdata->basic_pay,2).'</td></tr>';
                                  echo '<td style="text-align:left">HOUSE ALLOWANCE/ALLOWANCES</td><td style="text-align:right">'.number_format($slipdata->house_allowance,2).'</td></tr>';
           ?>
                             </tr>
                               <tr>
                              <?php foreach ($payslipitems as $item) {
                if($item["is_earning"]==1){
                    ?>
 <?php echo  '<td style="text-align:left">'.strtoupper($item["item_name"]).'</td><td style="text-align:right">'.number_format($item["amount"],2).'</td></tr>' ?>
                  
           <?php      }
              
           }?>
                             </tr>
                              <tr><td style="text-align:left;font-weight:bold;border-bottom:1px dotted #000;border-top:1px dotted #000"><?php echo __("GROSS PAY")?>
                                                   </td><td style="text-align:right;font-weight:bold;border-bottom:1px dotted #000;border-top:1px dotted #000"><?=number_format($slipdata->getGrossPay(),2)?></td></tr>
                      <tr><td style="text-align:left;" colspan="2"><br></td></tr>
                              <tr><td style="text-align:left;font-weight:bold" colspan="2"> <?php echo __("DEDUCTIONS")?>
         </td></tr>
                             <tr>
                                 <?php foreach ($payslipitems as $item) {
                if($item["is_deduction"]==1){
                    ?>
 <?php echo  '<td style="text-align:left">'.strtoupper($item["item_name"]).'</td><td style="text-align:right">'.number_format($item["amount"],0).'</td></tr>' ?>
                  
           <?php      }
              
           }?>
                                 <?php foreach ($payslipitems as $item) {
                if($item["is_loan"]==1){ ?>
                  
     <?php echo  '<td style="text-align:left">'.strtoupper($item["item_name"]).'</td><td style="text-align:right">'.number_format($item["amount"],0).'</td></tr>' ?>
                   
           <?php      }
              
           }?> 
                             </tr>
                             <tr><td style="text-align:left;" colspan="2"><br></td></tr>
                                               <tr><td style="text-align:left;font-weight:bold"> <?php echo __("T.DEDUCTIONS")?>
                                                   </td><td style="text-align:right;font-weight:bold"><?=number_format($slipdata->getTotalDeductions(),0)?></td></tr>
                     
                                               <tr><td style="text-align:left;font-weight:bold" colspan="2"> <br> <?php echo __("RELIEFS")?></td></tr>
              <?php foreach ($payslipitems as $item) {
                if($item["item_type"]=="relief"){ ?>
                 
     <?php echo  '<td style="text-align:left">'.strtoupper($item["item_name"]).'</td><td style="text-align:right">'.$item["amount"].'</td></tr>' ?>
                  
           <?php      }
              
          
           }?> 
                                              
                                               <tr><td style="text-align:left;font-weight:bold;border-bottom:1px solid #000"><?php echo __("NET PAY:")?></td>  <td style="text-align:right;font-weight:bold;border-bottom:1px solid #000"><?=number_format($slipdata->getNetPay(),0)?></td></tr>                 
                                                       <tr><td style="text-align:left;" colspan="2"><br></td></tr>
                                               <tr><td style="text-align:left;font-weight:bold"><?php echo __("STAFF LOAN")?></td><td style="text-align:right;font-weight:bold">
                                                     <?php
                                                     $balance=0;
                           $emploans=  LoanAccountsDao::getEmpLoanAccounts($slipdata->getEmpNumber());
                            $allinterests=0;
                           foreach ($emploans as $emploan){
                           $loanaccount=$emploan;
                        $loantransactiondao=new LoanTransactionsDao();
           
             $loanbalance= $loantransactiondao->getLoanBalance($emploan->getId());
                     $balance=$loanbalance+$balance;
                           }
                           echo number_format($balance);
                           ?>
                                                             
                                                                     
                                                   </td></tr>  
                                                <tr><td style="text-align:left;" colspan="2"></td></tr>
                                               <tr><td style="text-align:left;font-weight:bold" colspan="2">
                                                      
                                                             
                <?php $employeedirectdebit=EmpDirectdebitTable::getEmployeeBankAndBranch($slipdata->getEmpNumber())?>                
                   <?=$employeedirectdebit["bankandbranch"]?>  </td>   </tr>
                                                            <tr><td style="text-align:left;font-weight:bold"> <?php echo __("ACCOUNT NO")?></td><td style="text-align:right;font-weight:bold" ><?=$employeedirectdebit["account_number"]?></td></tr>    
           <tr><td style="text-align:left;font-weight:bold" colspan="2">   <h3 style="border-bottom:1px dotted black;border-top:1px dotted black;text-align:left" >  <?php echo __("PIN #:")?><span>
          <?php $employee=EmployeeDao::getEmployeeByNumber($slipdata->getEmpNumber());
                        echo $employee->getEmpOtherId();?>
                 </span>
                   </h3>  </td></tr>
                  
                                                   </tr>                              
                  <tr><td style="text-align:left;font-weight:bold" colspan="2">SIGNATURE.............. <br>  <br>  <br>  <br>  <br><br>  <br>    </td> </tr>                              
                 
                  </table>
                   
     </td>
                                   <?php 
                                         if($count%$columncount==0 && $count !=0){
                                         ?>
          </tr>
         
                                        
   <?php                                  }
   $count++;
                                     }
    ?>
      </table>
 </div>
</div>
    </div>
<!-- Confirmation box HTML: Begins -->

<!-- Confirmation box HTML: Ends -->

<script type="text/javascript">
$(document).ready(function() {
   
     var empnumbers=[];
       $("#checkAll").click(function() {
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
         
          //pdf
           $("#pdfbtn").click(function(e){
      
     html=$("#recordsList").html();
     url=$("#pdfurl").val();
$.ajax({
            url: url,
            type: 'post',
            data: {
                'data':html,
                'payslip':"payslip"
               
            },
            dataType: 'html',
            success: function(urll) {
                window.open(urll, '_blank');
            }
        }); 
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
 //alert(searchids.get());

      window.location.replace(url+"?ids="+searchids.get());
    });
       
        });

//back to payroll
  $('#btnBack').click(function() {
     var url=$("#payrollurl").val(); 
          window.location.replace(url);
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
   
   
    //paginate payslips
    $("#payslipcolumns").change(function(e){
        paging=$(this).val();
        window.location.search += '&paging='+paging;
       
    })
 
   
         $('#btnDelSlab').click(function(e) {
         e.preventDefault();
           if ($(".check .checkboxAtch:checked").length > 0) {
               var id=$(".check .checkboxAtch:checked").val();
         var url=$("#deleteslab").val();
      
        window.location.replace(url+'?id='+id);
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
<?php
 function getHoursWorkedMonth($empno,$monthdashyear){
        $conn = Doctrine_Manager::connection();
   $query = "SELECT SUM(hours) as hours from casualhours WHERE emp_id=:emp_id and monthyear=:monthyear";
          // die($sql);
$stmt = $conn->prepare($query);           
$stmt->bindParam(':emp_id',$empno);
$stmt->bindParam(':monthyear',$monthdashyear);
$stmt->execute();
   $hoursworked= 0;
while ($row =$stmt->fetch()) {

      $hoursworked= $row['hours'];
}
return $hoursworked;
    }
    
    ?>