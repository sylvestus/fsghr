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
        <h1><?php echo __('List Of Incidents  '.date("Y")); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
        <form name="frmList" id="frmList" method="post" action="<?php echo url_for('performance/disciplinary'); ?>">
          
            <p id="listActions">
           
                    <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
                        <input type="hidden" id="addurl" value="<?php echo url_for('performance/addIncident'); ?>">
                   <a href="#" class="addbutton" style="float:right !important" id="emailbtn"><img src="<?php echo "{$imagePath}/email.png";?>" alt="email"></a>   
                 <a href="#" class="addbutton" style="float:right !important" id="pdfbtn"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>   
     <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
      <input type="button" class="addbutton" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('+ Add Incident') ?>"/>
     <br>
            </p>
            <div id="dvData">
            <table class="display exporttable dataTables tablestatic" id="recordsListTable">
                <thead>
               
                    <tr>
                        <td  class="boldText borderBottom" width="7%"><?php echo __('#'); ?></td>
                        <td class="boldText borderBottom" width="26%"><?php echo __('Employee'); ?></td>
                        <td class="boldText borderBottom" width="11%"><?php echo __('Location/B.Unit'); ?></td>
                                <td class="boldText borderBottom" width="11%"><?php echo __('Department'); ?></td>
                                <td class="boldText borderBottom" width="11%"><?php echo __('Violation'); ?></td>
                                 <td class="boldText borderBottom" width="11%"><?php echo __('Date Of Occurence'); ?></td>
                                    <td class="boldText borderBottom" width="11%"><?php echo __('Appealed'); ?></td>
                                      <td class="boldText borderBottom" width="11%"><?php echo __('Verdict'); ?></td>
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
                       <?php  echo $employee->getEmpFirstname().' '.$employee->getEmpMiddleName().' '.$employee->getEmpLastname()?> 
                        </td>
                         <td class="tdName tdValue" width="11%">
                      <?php  
                          $loc=OhrmLocationTable::getLocation($record->branch);
                      echo $loc->name?>   
                        </td>
                        <td class="tdName tdValue" width="11%">
                            
                     <?php  
                     $su=OhrmSubunitTable::getDepartment($record->subunit);
                     
                     echo ucwords($su->name)?>   
                        </td>
                             <td class="tdName tdValue" width="11%">
                      <?php
                      $violation=  OhrmViolationTypeTable::getViolation($record->violation);
                       echo $violation->violation_type;?>
                        </td>
                        
                        <td class="tdName tdValue" width="11%">
                      <?php  echo $record->date?>   
                        </td>
                             <td class="tdName tdValue"  width="11%">
                       <?php  echo $record->appealed?>  
                        </td>
                          <td class="tdName tdValue"  width="11%">
                       <?php  echo $record->verdict?>  
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