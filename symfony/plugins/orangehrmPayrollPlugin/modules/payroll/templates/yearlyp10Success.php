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

<div id="recordsListDiv" class="box miniList">
    <div class="head">
        <h1><?php echo __('Yearly P10 ('.$year.')'); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
     
          
            <p id="listActions">
             
                   
           <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
                   <a href="#" class="addbutton" style="float:right !important" id="pdfbtn"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>                
        <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
              <input type="button" class="addbutton print" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('Print') ?>"/>
     <br>
            </p>
            <div id="dvData">
                <?php
              $payslipss=  PayslipTable::getPayslipsForYear($record,$year);
                $nettax=0;
                         
                             foreach ($payslipss as $payslipdata) {
                     
                            $nettax=$nettax+$payslipdata["nettax_payable"]; 
                            
                             }
                        
                         
                         
                ?>
                <table class="table hover  tablestatic" id="recordsListTable">
                
                    <tr><td style="font-weight:bold;font-size:20px;text-align:left;"><?php echo __('Yearly P10 ('.$year.')'); ?></td><td class="boldText"  colspan="4" style="text-align:left;font-size:16px;font-weight:bold;"><?=str_repeat("&nbsp;",15)?><img src="<?php echo "{$imagePath}/kra.png"; ?>" /><br>
                        
                           <?=str_repeat("&nbsp;",10) ?>P.A.Y.E-EMPLOYER'S CERTIFICATE <br><?=  str_repeat("&nbsp;",30).$year?>
                        </td></tr>
                    
                    
                   
                    <tr><td class="boldText">To Senior Assistant/Assistant Commissioner</td><td colspan="3"></td><td class="boldText" style="font-size:14px !important;">EMPLOYER'S PIN: <?=$organisationinfo->getTaxId()?></td></tr>
                    <tr><td colspan="5" class="boldText"><?php echo "We/I forward herewith______________Tax Deduction Cards (P9A/P9B) showing the total tax deducted(as listed on P.10A) amounting to Ksh ".number_format($nettax)?><br><br></td></tr>
                  
                    <tr><td class="boldText" colspan="5">The total tax has been paid as follows:</td></tr>
                    
                    <tr>
                       
                        <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('MONTH'); ?></td>
                        <td class="boldText borderBottom" style="font-weight:bold;text-align:right"><?php echo __('PAYE TAX (KSH)'); ?></td>
                        <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('AUDIT TAX,INTEREST/PENALTY (KSH)'); ?></td>
                                <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('FRINGE BENEFIT TAX'); ?></td>
                                <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('DATE PAID PER  (RECEIVING BANK STAMP)'); ?></td>
                                 
                    </tr>
               
                <tbody>
                   <?php 
                   
                   $alltax=array();
                   $months=array("01-".$year=>"January","02-".$year=>"February","03-".$year=>"March","04-".$year=>"April","05-".$year=>"May","06-".$year=>"June","07-".$year=>"July","08-".$year=>"August","09-".$year=>"September","10-".$year=>"October","11-".$year=>"November","12-".$year=>"December");
 foreach ($months as $key => $value) {?>
                    <tr>
                <td class="tdName tdValue">
                    
                    <?=$value?>
                </td><td class="tdName tdValue boldText" style="text-align:right">
                    <?php $monthlyslips= PayslipTable::getPayslipsForMonth($key);
foreach ($monthlyslips as $slipdata) {
$totaltax+=$slipdata->getNettaxPayable();

}
array_push($alltax, $totaltax);
echo number_format($totaltax);
unset($totaltax);
                    ?>
                </td><td class="tdName tdValue"></td><td class="tdName tdValue"></td><td class="tdName tdValue"></td>
     
     
  
                </tr>         
                    <?php
 }
                   ?>
                <tr><td class="tdName tdValue boldText" >TOTAL TAX</td><td class="tdName tdValue boldText" style="text-align:right" ><?= number_format(array_sum($alltax),0)?></td><td class="tdName tdValue"></td><td class="tdName tdValue"></td><td class="tdName tdValue"></td></tr>                 
                <tr><td class="boldText" colspan="2" style="border-top:1px solid #fff;border-bottom:1px solid #fff">NOTE:</td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff"></td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff"></td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff"></td></tr>    
                <tr><td class="boldText" colspan="2">(1) Attach photostat copies of ALL THE PAY-In Credit Slips (P11s) for the year</td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff"></td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff"></td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff"></td></tr>
                <tr><td class="boldText" style="border-top:1px solid #fff;border-bottom:1px solid #fff" colspan="2">(2) Complete this form in triplicate sending the two top copies with enclosure to your <u>Income Tax Office not later than 28TH FEBRUARY</u> </td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff"></td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff"></td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff"></td></tr>
<tr><td class="boldText" colspan="2">(3)Provide Statistical Information required by Central Bureau of Statistics </u> </td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td class="boldText"><br></td><td></td><td></td></tr>                    


<tr><td style="border-top:1px solid #fff;border-bottom:1px solid #fff" class="boldText" >NAME OF EMPLOYER</u> </td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff"><?=strtoupper($organisationinfo->getName())?></td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff" colspan="3"></td></tr>
<tr><td  style="border-top:1px solid #fff;border-bottom:1px solid #fff" class="boldText" >ADDRESS</u> </td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff"><?=$organisationinfo->getStreet1()." ".$organisationinfo->getZipCode()." ".$organisationinfo->getCity()?></td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff" colspan="3"></td></tr>
<tr><td style="border-top:1px solid #fff;border-bottom:1px solid #fff" class="boldText">SIGNATURE</u> </td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff"><u></u></td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff" colspan="3"></td></tr>
<tr><td style="border-top:1px solid #fff;border-bottom:1px solid #fff" class="boldText">DATE</u> </td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff"><u></u></td><td style="border-top:1px solid #fff;border-bottom:1px solid #fff" colspan="3"></td></tr>
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
       $("#pdfbtn").click(function(e){
     html=$("#recordsListTable").html();
     url=$("#pdfurl").val();
$.ajax({
            url: url,
            type: 'post',
            data: {
                'data':html,
                'nssfnhif':true
            },
            dataType: 'html',
            success: function(urll) {
                window.open(urll, '_blank');
            }
        });  
   
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