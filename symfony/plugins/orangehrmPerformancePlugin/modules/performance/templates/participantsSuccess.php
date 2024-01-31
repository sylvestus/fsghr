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
        <h1><?php echo __('Participants for '.$session->title.' training'); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
        <form name="frmList" id="frmList" method="post" action="<?php echo url_for('loans/viewloan'); ?>">
          
            <p id="listActions">
                <input type="hidden" id="viewslab" value="<?php echo url_for('loans/viewloan'); ?>">
                   <input type="hidden" id="repayslab" value="<?php echo url_for('loans/repayloan'); ?>">
                    <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
                        <input type="hidden" id="addurl" value="<?php echo url_for('performance/addParticipant?session='.$session->id); ?>">
                   <a href="#" class="addbutton" style="float:right !important" id="emailbtn"><img src="<?php echo "{$imagePath}/email.png";?>" alt="email"></a>   
                 <a href="#" class="addbutton" style="float:right !important" id="pdfbtn"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>   
     <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
      <input type="button" class="addbutton" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('+ Add Participant') ?>"/>
     <br>
            </p>
            <div id="dvData">
                <table style="width:100%" class="display  dataTables tablestatic" id="recordsListTable">
                <thead>
               
                    <tr>
                        <td  class="boldText borderBottom" ><?php echo __('#'); ?></td>
                        <td class="boldText borderBottom"><?php echo __('Participant'); ?></td>
                        <td class="boldText borderBottom" ><?php echo __('Approved/Not'); ?></td>
                                <td class="boldText borderBottom" ><?php echo __('Approved By'); ?></td>
                                
                                 <td class="boldText borderBottom"><?php echo __('Reccommendation'); ?></td>
                         
                                  
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 0;
                   $count=1;
        foreach ($pager->getResults() as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                 
                    <tr class="<?php echo $cssClass;?>">
                       
                        <td class="tdName tdValue" width="7%">
                          <?php
                       echo $row+1;
                            ?>
                        </td>
                        <td class="tdName tdValue" width="26%">
                            <?php $employeedao=new EmployeeDao();
                        $employee=$employeedao->getEmployee($record->employee);
                              ?>
                            <a href="<?=  url_for('pim/viewEmployee?empNumber='.$record->employee)?>" target="_blank"><?php  echo $employee->getEmpFirstname().' '.$employee->getEmpMiddleName().' '.$employee->getEmpLastname()?></a>    
                        </td>
                        <td class="tdName tdValue" width="11%">
                            
                     <?php  
                    
                     
                     echo $record->approved;?>   
                        </td>
                            
                      <td class="tdName tdValue">
                          <?php
                        $employeedao=new EmployeeDao();
                        $employee=$employeedao->getEmployee($record->approved_by);
                            echo $employee->getEmpFirstname().' '.$employee->getEmpMiddleName().' '.$employee->getEmpLastname() ; ?>
                        </td>   
                      
                           <td class="tdName tdValue"  width="11%">
                       <?php 
                    
                       echo $record->recommendation;
                       
                       ?>  
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
                'data':html
                
            },
            dataType: 'html',
            success: function(urll) {
                window.open(urll, '_blank');
            }
        });  
        });
           $("#btnAddSlab").click(function(e){
       
   
     url=$("#addurl").val();
window.location.href=url; 
        });
        
        $("#emailbtn").click(function(e){
     html=$("#pdftable").html();
     url=$("#pdfurl").val()+"?sendemail=true&report=Disbursed Loans Report";
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
  
         $(function() {
	
	$('.print').click(function() {
		var container = $(this).attr('rel');
		$('#' + container).printArea();
		return false;
	}); 
   });  
   
     
    
});

</script>