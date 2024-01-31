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
        
            <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
     
          
            <p id="listActions">
                <input type="hidden" id="filterurl" value="<?php echo url_for('payroll/register'); ?>">
                 <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
                   <a href="#" class="addbutton" style="float:right !important" id="pdfbtn"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>       
             <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
              <input type="button" class="addbutton print" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('Print') ?>"/>
     <br>
            </p>
            <div id="dvData">
            <table width="100%" class="display exporttables dataTables tablestatic" id="recordsListTable">
                <tr><td class="boldText"  colspan="4" style="text-align:center !important"><center><img src="<?php echo "{$imagePath}/kra.png"; ?>" /></center></td></tr>
                   
                 
                <tr><td style="font-size:16px !important;font-weight:bold">P.10A </td><td class="boldText" colspan="3" style="text-align:center;font-weight:bold"> PAYE SUPPORTING LIST FOR THE END OF YEAR CERTIFICATE:YEAR <u><?= $year?></td></tr>
                      
                

                    <tr><td class="boldText" style="text-align:center;font-size:16px !important;" colspan="3">
                            <br>
                            EMPLOYER'S NAME:
            <?php echo __(strtoupper($organisationinfo->getName())); ?><br></td><td class="boldText" style="font-size:16px !important;"><br> PIN: <?=$organisationinfo->getTaxId()?><br></td></tr>
                    <tr>
                       
                        <td style="width:25%"><?php echo __('EMPLOYEES PIN'); ?></td>
                     
                        <td style="width:25%"><?php echo __('EMPLOYEE\'S NAMES'); ?></td>
                        <td style="width:25%;text-align:right"><?php echo __('TOTAL EMOLUMENTS-KSH'); ?></td>
                        <td style="width:25%;text-align:right"><?php echo __('TAX DEDUCTED-KSH'); ?></td>
                      

                    </tr>
               
                <tbody>
                    
                    <?php 
                    $totalemoluments=array();
                            $totaltax=array();
                            $alldata=array();
                            $data=array();
                    $row = 0;
                    $count=1;
           foreach ($employees as $record): 
               $data["record"]=$record;
             $payslipss=  PayslipTable::getPayslipsForYear($record,$year);
            $employmentincome=0;
            $tax=0;
                         
                             foreach ($payslipss as $payslipdata) {
                   
                             $employmentincome=$employmentincome+$payslipdata["gross_pay"];
                             $tax=$tax+$payslipdata["nettax_payable"];
                            
                             }
                         $data["gross_pay"]=number_format($employmentincome,0);
                              $data["tax"]=number_format($tax,0);
                             if($tax>0) {
                            array_push($alldata,$data);  
                         array_push($totaltax, $tax);
                         array_push($totalemoluments,$employmentincome);
                             }
                          endforeach;     
                         
                          foreach ($alldata as $empdata):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    <tr>
                   
                        <td class="tdName tdValue" width="25%">
                          <?php $employeedetail=  EmployeeDao::getEmployeeByNumber($empdata["record"]);
                        echo $employeedetail->getEmpOtherId();
                            ?>
                        </td>
                        
                        <td class="tdName tdValue" width="25%">
                       <?= $employeedetail->getEmpFirstname()." ".$employeedetail->getEmpLastname();?>    
                        </td>
                        
                      
                         <td class="tdName tdValue" width="25%" style="text-align:right">
                         <?php 
                        
                         echo $empdata["gross_pay"];
                        
                         ?>
                            
                        </td>
                        <td class="tdName tdValue" width="25%" style="text-align:right">
                    <?php
                     echo $empdata["tax"];
                    ?>
                        </td>
                       
                        
                    </tr>
                    
                    <?php 
                    $row++;
                    endforeach; 
                    ?>
                    
                    <?php if (count($employees) == 0) : ?>
                    <tr class="<?php echo 'even';?>">
                        <td>
                            <?php echo __(TopLevelMessages::NO_RECORDS_FOUND); ?>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <?php endif; 
                    ?>
                    
                </tbody>
                <tfoot><tr><td class="boldText"></td><td class="boldText">TOTAL EMOLUMENTS</td><td class="boldText" style="text-align:right"><?= number_format(array_sum($totalemoluments),0)?></td><td></td></tr>
                    <tr><th class="boldText"></th><th class="boldText">TOTAL PAYE TAX</th><th></th><th class="boldText" style="text-align:right"><?= number_format(array_sum($totaltax),2)?></th></tr>
                    <tr><th colspan="4"></th></th></tr>
                </tfoot>
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
    //manage
     $('#btnfilter').click(function(e) {
         e.preventDefault();
           var startdate=$("#startdate").val();
           var enddate=$("#enddate").val();
       var url=$("#filterurl").val();
       if(startdate=="" || enddate==""){
           alert("please choose start/end dates");
           return 0;
       } else{
       window.location.replace(url+'?startdate='+startdate+"&enddate="+enddate);
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