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
                             <a href="#" class="addbutton" style="float:right !important" id="emailbtn"><img src="<?php echo "{$imagePath}/email.png";?>" alt="email"></a>  
                 <a href="#" class="addbutton" style="float:right !important" id="pdfbtn"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>   
                   
        <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
              <input type="button" class="addbutton print" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('Print') ?>"/>
     <br>
            </p>
            <div id="dvData">
            <table class="display exporttable dataTables tablestatic" id="recordsListTable">
                <thead>
                    <tr><th colspan="3" class="boldText"> <center>
            <?php echo __(strtoupper($organisationinfo->getName())); ?><br><br>
            <?php echo __(strtoupper('Employee Earnings for  '.$month)); ?></center></th></tr>
                   
                    <tr>
                       
                        <th><?php echo __('Employee No'); ?></th>
                        <th><?php echo __('Name'); ?></th>
                   
                        <th><?php echo __('Amount'); ?></th>
                           
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 0;
                    $count=1;
                    $totaldeductions=array();
           foreach ($allearnings as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    <tr>
                   
                        <td class="tdName tdValue">
                               <?php $employeedetail=  EmployeeDao::getEmployeeByNumber($record["empnumber"]) ?>
                          <?= $employeedetail->getEmployeeId();?>
                    
                        </td>
                        <td class="tdName tdValue">
                       <?php
                       $employeedao=new EmployeeDao();
                       $employee=$employeedao->getEmployee($record["empnumber"]);
                    ?>
                            <?=$employee->getEmpFirstname()." ".$employee->getEmpMiddleName()." ".$employee->getEmpLastname();?>
                        </td>
                        
                        
                        <td class="tdValue"><?= number_format($record["amount"],0) ?>
                        <?php array_push($totaldeductions,$record["amount"]); ?>
                        </td>
                    </tr>
                    
                    <?php 
                    $row++;
                    endforeach; 
                    ?>
                    
                    <?php if (count($allearnings) == 0) : ?>
                    <tr class="<?php echo 'even';?>">
                        <td>
                            <?php echo __(TopLevelMessages::NO_RECORDS_FOUND); ?>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <?php endif; ?>
                    
                </tbody>
                <tfoot>
                <th>TOTALS</th><th></th><th><?=  number_format(array_sum($totaldeductions),0)?></th>
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
    
       $("#emailbtn").click(function(e){
     html=$("#pdftable").html();
     url=$("#pdfurl").val()+"?sendemail=true&report=Month Earnings";
$.ajax({
            url: url,
            type: 'post',
            data: {
                'data':html
                
            },
            dataType: 'html',
            success: function(success) {
               alert(success);
            }
        });  
   
   });
   $("#pdfbtn").click(function(e){
       
     html=$("#recordsListTable").html();
     url=$("#pdfurl").val();
$.ajax({
            url: url,
            type: 'post',
            data: {
                'data':html
                
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