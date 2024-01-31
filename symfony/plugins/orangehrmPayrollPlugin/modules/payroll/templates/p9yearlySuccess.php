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


<style>
    table { border-collapse: collapse; }

    td + td,
    //th + th { border-left: 1px solid; }
    tr + tr { border-top: 1px solid; }
    
    .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 2px;
    line-height: 1.42857;
    vertical-align: top;
    border-top: 1px solid #DDD;
}

</style>

<!-- Listi view -->

<div id="recordsListDiv" class="box miniList">
    <div class="head">
        <h1><?php echo __('P9 Yearly '); ?>&nbsp;&nbsp; </h1>

        <?php $imagePath = theme_path("images"); ?>     

    </div>

    <div class="inner">

        <?php include_partial('global/flash_messages'); ?>



        <p id="listActions">
  <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
   <?php $imagePath = theme_path("images");?>
    
        </p>
        <?php
        $emps = explode(",", $_REQUEST['ids']);
        $month = $_REQUEST["month"];
        $multiplying=  substr($month,0,2);
        foreach ($employees as $empno) {
            ?>
        <a href="#" class="addbutton pdfbtn" style="float:right !important"  tabindex="<?=$empno?>"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>
<a href="#" class="addbutton" style="float:right !important" id="emailbtn"><img src="<?php echo "{$imagePath}/email.png";?>" alt="email"></a>    
            <div id="dvData">
    <?php $employee = EmployeeDao::getEmployeeByNumber($empno); ?>
                <input type="hidden" class="carbenefit" value="<?=round($multiplying*$employee->getVehicleBenefit())?>">
                <input type="hidden" class="workemail" value="<?=$employee->emp_work_email?>">
                <table class="table hover data-table displayTable  tablestatic" style="font-size:10px;" id="recordsList<?=$empno?>">
                  
                        <tr>

                            <td class="boldText borderBottom"></td>
                            <td class="boldText borderBottom" style="font-weight:bold;font-size:20px">P9A</td>
                            <td class="boldText borderBottom"></td>
                   

                           

                            <td class="boldText borderBottom" colspan="8" style="text-align:center;font-weight:bold;"><img src="<?php echo "{$imagePath}/kra.png"; ?>"><br>Kenya Revenue Authority<br><?=strtoupper("Domestic Tax Department")?><br><span style="color:red"><?=strtoupper("Income Tax Deduction Card") ?>
    <?php
    $date = LoanAccountsDao::getMonthFromDate($month);
    echo $date["year"];
    ?>
                            </span></td>


                             <td class="boldText borderBottom"></td>
                            
                            <td class="boldText borderBottom"></td>
                            <td class="boldText borderBottom"></td>


                        </tr>

                        <tr><td colspan="3" style="font-weight:bold">Employers Name</td><td colspan="4"><?= strtoupper($organisationinfo->getName()) ?></td><td colspan="4" style="font-weight:bold">Employer's P.I.N</td><td colspan="3"><?= $organisationinfo->getTaxId() ?></td></tr>
                  
                        <tr><td colspan="3" style="font-weight:bold">Employee's Main Name</td><td colspan="4"><?= $employee->getEmpFirstname() . "&nbsp;" . $employee->getEmpMiddleName() . "&nbsp;" . $employee->getEmpLastname() ?></td><td colspan="4" style="font-weight:bold">Employee's P.I.N</td><td colspan="3"><?= $employee->getEmpOtherId() ?></td></tr>
                        <tr >

                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;"><?php echo __('MONTH '); ?></td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;"><?php echo __('BASIC SALARY'); ?></td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;"><?php echo __('BENEFITS NON-CASH'); ?></td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;"><?php echo __('VALUE OF QUARTERS'); ?></td>

                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;"><?php echo __('TOTAL GROSS PAY'); ?></td>

                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;" colspan="3"><?php echo __('DEFINED CONTRIBUTION RETIREMENT SCHEME'); ?></td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;"><?php echo __('OWNER OCCUPIED INTEREST'); ?></td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;"><?php echo __('RETIREMENT CONTRIBUTION&OWNER OCCUPIED INTEREST'); ?></td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;"><?php echo __('CHARGEABLE PAY KSHS'); ?></td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;"><?php echo __('TAX ON (H) KSH'); ?></td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;font-size:9px;"><?php echo __('MONTHLY RELIEF KSHS'); ?></td>
                            <td class="boldText borderBottom" style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;font-size:10px  !important;border-right:1px solid #000;font-size:9px;"><?php echo __('PAYE TAX (J-K) KSHS'); ?></td>


                        </tr>
                    
                    <tbody >
                        <tr><td style="border-bottom:1px solid #000;border-left:1px solid #000"></td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">A</td><td style="border-bottom:1px solid #000;border-left:1px solid #000" class="boldText">B</td><td style="border-bottom:1px solid #000;border-left:1px solid #000" class="boldText">C</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">D</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:center" colspan="3">E</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">F</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">G</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">H</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">I</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000">J</td><td class="boldText" style="border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000">K</td></tr>
                        <tr><td style="border-left:1px solid #000;border-bottom:1px solid #000;"></td><td style="border-left:1px solid #000;border-bottom:1px solid #000;"></td><td style="border-left:1px solid #000;border-bottom:1px solid #000;"></td><td style="border-left:1px solid #000;border-bottom:1px solid #000;"></td><td style="border-left:1px solid #000;border-bottom:1px solid #000;"></td><td style="border-right:1px solid #000;border-left:1px solid #000;border-bottom:1px solid #000;">E1</td><td style="border-right:1px solid #000;border-bottom:1px solid #000;">E2</td><td style="border-right:1px solid #000;border-bottom:1px solid #000;">E3</td><td style="border-bottom:1px solid #000;font-size:8px">AMOUNT OF INTEREST</td><td style="border-bottom:1px solid #000;border-left:1px solid #000;font-size:8px ">THE LOWEST E <br> ADDED TO F</td><td style="border-bottom:1px solid #000;border-left:1px solid #000;"></td><td style="border-bottom:1px solid #000;border-left:1px solid #000;"></td><td style="border-bottom:1px solid #000;border-left:1px solid #000;"></td><td style="border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000"></td></tr>
                       <?php
    foreach ($monthsyear as $monthyear) {
        $slip = PayslipTable::getPayslipForMonth($empno, $monthyear);
        if (is_object($slip)) {
            echo $monthyear;
            ?>
                        <tr><td style="font-size:10px;border-left:1px solid #000;border-bottom:1px solid #000;"><?php
                                $eachdate = LoanAccountsDao::getMonthFromDate($monthyear);
                                echo $eachdate["month"] 
                                ?>
                            <?php
                                $basicpay =$slip->basic_pay;// HsHrEmpBasicsalaryTable::getEmpBasicSalary($empno);
            $hallowance =$slip->house_allowance;// HsHrEmpBasicsalaryTable::getEmpHouseAllowance($empno);

            $grosspay = $hallowance + $basicpay;
            $totalgross+=$grosspay;
            $totalbasic+=$totalbasic;
            ?>
                            </td>   <td  style="border-bottom:1px solid #000;border-left:1px solid #000">
                                       
                                        <?= number_format($grosspay) ?> 
                                
                                        <?php //$employee->getEmpFirstname()?>    
                                    </td>
                                    <td  style="border-bottom:1px solid #000;border-left:1px solid #000">
                                        0
                                    </td>
                                    <td  style="border-bottom:1px solid #000;border-left:1px solid #000">
                                        0

                                    </td>

                                    <td  style="border-bottom:1px solid #000;border-left:1px solid #000">
            


                                        <?= number_format($grosspay) ?> 
                                    </td>
                                    
                                    <td style="border-bottom:1px solid #000;border-left:1px solid #000"><?= number_format(ceil(0.3 * $grosspay)) ?></td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000"><?= number_format($slip->nssf) ?></td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:right;">20,000</td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:right;">0</td><td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000"> <?= number_format($slip->getNssf()) ?></td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000"><?= number_format($slip->getTaxableIncome()) ?></td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000"><?= number_format(($slip->getNettaxPayable() + $slip->getPersonalRelief()), 0) ?></td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000"><?= number_format($slip->getPersonalRelief()) ?></td>
                            <td style="border-right:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;text-align:right"><?= number_format($slip->getNettaxPayable()) ?></td>
                        
                        </tr>
                                        <?php
                                        $totalnssf+=$slip->nssf;
                                        $totaltaxable+=$slip->getTaxableIncome();
                                        $totalrelief+=$slip->getPersonalRelief();
                                        $totaltaxpayable+=$slip->getNettaxPayable();
                                    }
                                }
                                ?> 
                        <tr><td style="font-weight:bold;border-bottom:1px solid #000;border-left:1px solid #000 ">TOTALS</td>   
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000">

                                <?= number_format($totalgross, 0) ?> 
                                <?php //$employee->getEmpFirstname()?>    
                            </td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000">
                                0
                            </td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000">
                                0

                            </td>

                            <td style="border-bottom:1px solid #000;border-left:1px solid #000">


                                <?= number_format($totalgross, 0) ?> 
                            </td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000"><?= round(ceil(0.3 * $totalgross)) ?></td>
                            <td  style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000">&nbsp;<?= number_format($totalnssf, 0) ?>&nbsp;</td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:right;">0</td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000">0</td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000"> <?= number_format($totalnssf, 0) ?></td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000"><?= number_format($totaltaxable, 0) ?></td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000"><?= number_format(($totaltaxpayable + $totalrelief), 0) ?></td>
                            <td style="text-align:right;border-bottom:1px solid #000;border-left:1px solid #000"><?= number_format($totalrelief, 0) ?></td>
                            <td style="border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;text-align:right"><?= number_format($totaltaxpayable, 0) ?></td></tr>
                        
                       
                        <tr><td colspan="4" style="font-weight:bold">To be completed by employer at the end of the year</td><td colspan="3"></td><td colspan="6">&nbsp;TOTAL TAX COL (J)&nbsp;&nbsp;Kshs.<?= number_format($totaltaxpayable, 0) ?> </td></tr>
                        <tr><td colspan="8" style="font-weight:bold">TOTAL CHARGEABLE PAY (COL H)&nbsp;KSHS.&nbsp;<?= number_format($totaltaxable, 0) ?> </td><td colspan="6">(b)Attach <br>(i)Photostat copy of interest certificate and statement of account from financial institution<br>(ii)The declaration duly signed by the employee</td></tr>
                        <tr><td colspan="8" style="font-weight:bold">IMPORTANT</td><td colspan="6"></td></tr>
                        <tr><td colspan="8" style="font-weight:bold">1)Use P9A (a)For all liable employees and where director/employee receives<br>benefits in addition to cash emoluments<br>
                                (b)Where an employee is eligible to deduction and owner occupier interest </td>
                            <td colspan="6">NAMES OF FINANCIAL INSTITUTION ADVANCING MORTGAGE LOAN----------------------------------------------------------------<br>
                                L.R NO OF OWNER OCCUPIED PROPERTY---------------------------------<br>
                            DATE OF OCCUPATION OF HOUSE----------------------------------</td></tr>

                       <!-- <tr><td></td><td colspan="13"><br><img src="<?php echo "{$imagePath}/p9back.png"; ?>"></td></tr>-->
                    </tbody>
                </table><br>
                
                
                
            </div>
            <?php
            unset($totalbasic);
            unset($totalgross);
            unset($totalnssf);
            unset($totalrelief);
            unset($totaltaxable);
            unset($totaltaxpayable);
        }
        ?>
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
    $(document).ready(function () {
        
          $("#emailbtn").click(function(e){
              alert("Sending email to "+$(".workemail").val()+" please wait...");
     html=$(".tablestatic").html();
     url=$("#pdfurl").val()+"?sendemail=true&report=p9";
$.ajax({
            url: url,
            type: 'post',
            data: {
                'data':html,
                'email':$(".workemail").val()
                
            },
            dataType: 'html',
            success: function(success) {
               alert(success);
            }
        });  
   
   });

   //pdf
           $(".pdfbtn").click(function(e){
               $(".pdfbtn").each(function(index,value){
       emp=$(this).attr("tabindex");
     html=$("#recordsList"+emp).html();
     url=$("#pdfurl").val();
$.ajax({
            url: url,
            type: 'post',
            data: {
                'data':html,
                'p9':"p9",
                'carbenefit':$(".carbenefit").val()
            },
            dataType: 'html',
            success: function(urll) {
                window.open(urll, '_blank');
            }
        });  
               });
        })


    });

</script>