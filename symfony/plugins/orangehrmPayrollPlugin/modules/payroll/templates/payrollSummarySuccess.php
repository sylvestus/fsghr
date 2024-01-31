<?php use_javascript('jquery.PrintArea.js') ?>

<div class="box">


    <div class="head">
        <h1><?php echo __('Payroll Summary For '.$month)?></h1>
         
    </div>

    <div class="inner" id="addEmployeeTbl">
        <input type="button" class="addbutton print" style="float:right !important" id="btnAddSlab" rel="reportsdiv"  value="<?php echo __('Print') ?>"/>
        <div class="modal hide" id="successDialog">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3><?php echo __('TechSavannaHRM - '); ?></h3>
    </div>
            <div class="modal-body" id="messagediv"></div></div>

        <div id="reportsdiv">
            
            <table class="table-striped" width="100%">
                <tr><td colspan="3" ><h2><?= strtoupper($organisationinfo["name"])?></h2></td><td></td></tr>
                 <tr><td colspan="4"><br></td></tr>
                <tr><td colspan="3"><?=_("Salary Analysis for ".$month)?></td><td></td></tr>
                <tr><td colspan="4"><br></td></tr>
                <tr><td class="boldText">Payroll Acccount</td><td class="boldText">DR</td><td class="boldText">CR</td><td class="boldText">DR-CR</td></tr>
                <tr><td colspan="4"><hr></td></tr>
                <?php 
                $taxableincome=array();
               
                foreach ($allslips as $slip) {
     
     array_push($taxableincome, $slip->getTaxableIncome());
                }?>
                <tr><td>Basic Pay</td><td><?=  number_format(array_sum($taxableincome),0)?></td><td></td><td></td></tr>
               
                <tr><td colspan="4"><br></td></tr>
                <tr><td>Payee</td><td></td><td><?=  number_format($payee,0)?></td><td></td><td></td></tr>
                 <tr><td colspan="4"><br></td></tr>
                <tr><td>Nhif</td><td></td><td><?=  number_format($nhif,0)?></td><td></td></tr>
                 <tr><td colspan="4"><br></td></tr>
                <tr><td>Nssf</td><td></td><td><?=  number_format($nssf,0)?></td><td></td></tr>
                  <tr><td colspan="4"><br></td></tr>
                <tr><td>Loan Repayment</td><td></td><td><?=  number_format($loans,0)?></td><td></td><td></td></tr>
                  <tr><td colspan="4"><br></td></tr>
                <tr><td>Absentee Pay</td><td></td><td><?=  number_format($absenteepay,0)?></td><td></td></tr>
                <tr><td colspan="4"><br></td></tr>
                <tr><td>Other Deductions</td><td></td><td><?=  number_format($otherdeductions,0)?></td><td></td></tr>
             <tr><td colspan="4"><br></td></tr>
             <tr><td>Relief</td><td><?=  number_format($reliefs,0)?></td><td></td><td></td></tr>
            <tr><td colspan="4"><br></td></tr>
        <?php 
                $netpay=array();
                foreach ($allslips as $slip) {
     
     array_push($netpay, $slip->getEmploymentIncome());
                }
                $alldebits=array_sum($taxableincome)+$reliefs;
                $allcredits=$payee+$nssf+$nhif+$loans+$absenteepay+$otherdeductions+array_sum($netpay);
                ?>
                <tr><td>Net Pay</td><td></td><td><?=  number_format(array_sum($netpay),0)?></td><td></td></tr>  
                <tr><td colspan="4"><br></td></tr>
                <tr><td colspan="4"><hr></td></tr>
                  
               
                <tr><td></td><td><u><?=number_format($alldebits,0)?></u></td><td><u><?=  number_format($allcredits,0)?></u></td><td><u><?=number_format($alldebits-$allcredits,0)?></u></td></tr>    
                <tr><td colspan="4"><hr></td></tr>
            
            </table>
            
            
            
            
            
            
        </div>
            

        
    </div>

    
</div> <!-- Box -->

<script type="text/javascript">
$(document).ready(function() {

      
        $(function() {
	
	$('.print').click(function() {
		var container = $(this).attr('rel');
		$('#' + container).printArea();
		return false;
	}); 
   }); 
    
});

</script>