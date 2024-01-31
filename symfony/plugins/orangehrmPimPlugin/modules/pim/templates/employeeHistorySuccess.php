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
                <input type="hidden" id="filterurl" value="<?php echo url_for('pim/employeelist'); ?>">
                     <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
                     <select name="pageno" id="pagenumber">
                         <option tabindex="0" value="0">Select Page</option> 
                         <option tabindex="0" value="500">Page 1</option>
                         <option tabindex="501" value="500">Page 2</option>
                         <option value="500" tabindex="1001">Page 3</option>
                         <option value="500" tabindex="1501">Page 4</option>
                         <option  tabindex="2001" value="500">Page 5</option>
                         <option tabindex="2501" value="500">Page 6</option>
                         <option tabindex="3001" value="500">Page 7</option>
                        
                     </select> 
                <a href="#" class="addbutton" style="float:right !important" id="emailbtn"><img src="<?php echo "{$imagePath}/email.png";?>" alt="email"></a>   
                     <a href="#" class="addbutton" style="float:right !important" id="pdfbtn"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>   
                   
                   
        <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
              <input type="button" class="addbutton print" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('Print') ?>"/>
     <br>
            </p>
            <div id="dvData">
                  <?php $employeedetail=  EmployeeDao::getEmployeeByNumber($employeeid) ?>
                          
            <table class="table hover data-table displayTable exporttables tablestatic" id="recordsListTable">
                <tr><td colspan="12" style="font-weight:bold;text-align:center"> TRANSACTION HISTORY FOR   <?= strtoupper($employeedetail->getEmpFirstname()." ".$employeedetail->getEmpMiddleName()." ".$employeedetail->emp_lastname)?> 
                
                    </td></tr>
            
            
                  
                    <tr><td colspan="12" class="boldText" style="font-weight:bold;text-align:center">Employer's Name: 
            <?php echo __(strtoupper($organisationinfo->getName())); ?><br><br>
           </td></tr>
                    <tr>
                       <td class="boldText borderBottom" >#</td>
                         <td class="boldText borderBottom">
				<?php echo __("Transaction")?>
					</td>
                                         <td class="boldText borderBottom" >
						<?php echo __("Module Affected")?>
						 
					</td>  
                                      
					 <td class="boldText borderBottom">
						<?php echo __("Created")?>
						 
					</td>   <td class="boldText borderBottom">
						<?php echo __("Created By")?>
						 
					</td>  	  
                                         <td class="boldText borderBottom">
						<?php echo __("Appproved/Rejected On")?>
						 
					</td>  
                                        <td class="boldText borderBottom">
						<?php echo __("Approved/Rejected By")?>
						 
					</td>  
                                         <td class="boldText borderBottom">
						<?php echo __("2nd Approved/Rejected By")?>
						 
					</td>  
                                        <td class="boldText borderBottom">
						<?php echo __("Previous Value")?>
						 
					</td>  
                                        <td class="boldText borderBottom">
						<?php echo __("New Value")?>
						 
					</td>  
                                         <td class="boldText borderBottom">
						<?php echo __("Supporting Docs")?>
						 
					</td>
                                        <td class="boldText borderBottom">
						<?php echo __("Status")?>
						 
					</td>  
                               
                              
                    </tr>
               
                <tbody>
                    
                    <?php 
                    $row = 0;
                    $count=1;
           foreach ($employeehistory as $customer):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
             $systemUserService = new SystemUserService();

        $systemUser = $systemUserService->getSystemUser($customer["created_by"]);
        if((@$customer["approved_by"])){
      $systemUser2 = $systemUserService->getSystemUser($customer["approved_by"]);
      $approvaluser=$systemUser2->getUserName();
        }else{
       $approvaluser="";   
        }
                    ?>
                    <tr>
                        <td class="tdName tdValue"><?=$count?></td>
                       <td class="tdValue">
                           <a href="<?php echo url_for('admin/viewTransaction?id='.$customer['id'])?>"><?php echo ucwords($customer['transaction_type'])?></a>
		 			</td>
                                        <td class="tdValue" ><?php echo __($customer['module'])?></td>
                                 
                                        <td class="tdValue"><?php echo __(date("d/m/Y",  strtotime($customer['datecreated'])))?></td>
                                       
                                        <td class="tdValue"><?php echo __(ucwords($systemUser->getUserName()))?></td>
                                        <td class="tdValue" ><?php echo __(date("d/m/Y",strtotime($customer['dateupdated'])))?></td>
                                        <td class="tdValue"><?php echo __(ucwords($approvaluser))?></td>
                                        <td class="tdValue"><?php echo __($customer['approved_by2'])?></td>
                                        <td class="tdValue"><?php echo __($customer['previous_value'])?></td>
                                        <td class="tdValue"><?php echo __($customer['updated_value'])?></td>
                                        <td class="tdValue"><a target="_blank" href="http://<?=$_SERVER['HTTP_HOST']?>/fgshr/symfony/web/uploads/<?=$customer['file1']?>">File1</a></td>
		 			<td class="tdValue"><?php if($customer['status']=="rejected"){echo '<span style="color:red">'.ucwords($customer['status']).'</span>';} else if($customer['status']=="approved"){echo '<span style="color:green">'.ucwords($customer['status']).'</span>';} else{ echo ucwords($customer['status']);}  ?></td>
                       
                    </tr>
                    
                    
                    <?php 
                    $count++;
                    $row++;
                    endforeach; 
                    ?>
                    
                    <?php if (count($employeehistory) == 0) : ?>
                    <tr class="<?php echo 'even';?>">
                        <td>
                            <?php echo __(TopLevelMessages::NO_RECORDS_FOUND); ?>
                        </td>
                       
                    </tr>
                    <?php endif; ?>
                    
                </tbody>
                        <tr><td colspan="12" style="text-align:left">
                                Certified Correct by Organisations' Authorised Officer.<br><br>
                                    
                                Name:.................................. &nbsp;&nbsp; &nbsp;  Signature ........................... &nbsp;&nbsp; &nbsp; Designation.....................&nbsp;&nbsp; &nbsp; Date: /<?=$month?>   <br>
                                <br>
                              
                              
                                
              
                                
                    </td></tr>
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
               
            },
            dataType: 'html',
            success: function(urll) {
                window.open(urll, '_blank');
            }
        });  
   
   });
    //manage
        $(function() {
	
	$('.print').click(function() {
		var container = $(this).attr('rel');
		$('#' + container).printArea();
		return false;
	}); 
   });  
   
     $('#pagenumber').change(function() {
		var value = $(this).val();
                var offset= $("#pagenumber :selected").attr("tabindex");
                var page=$("#pagenumber :selected").text();
		window.location.replace("<?=url_for('pim/employeeHistory')?>"+"?limit=500&start="+offset+"&page="+page);
	}); 
    
});

</script>