<?php 
use_stylesheet(plugin_web_path('orangehrmPimPlugin', 'css/viewPersonalDetailsSuccess.css'));
?>

<div class="box" style="margin-top:0px !important" id="employee-details">
    
    
    
    <div class="personalDetails" id="pdMainContainer">
        
        <div class="head">
		<?php if($employeedetail) {?>
            <h1><?php echo __('Pending Approvals for '.$employeedetail->getEmpFirstname()." ".$employeedetail->getEmpMiddleName()." ".$employeedetail->emp_lastname.'('.$employeedetail->employee_id.')'    ); ?>&nbsp;&nbsp;</h1>
		<?php } else{?>
		<h1><?php echo __('Pending Approvals for new employee'); ?>&nbsp;&nbsp;</h1>
		<?php }?>
        </div> <!-- head -->
    
        <div class="inner">
            <table class="table hover data-table displayTable exporttable tablestatic" id="recordsListTable"><thead>
            <tr>
                        <td class="boldText borderBottom" style="font-weight:bold" >#</td>
                        <td class="boldText borderBottom" style="font-weight:bold" ><input type="checkbox" id="approvecheckall"></td>
                        <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Transaction'); ?></td>
                        <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Created On'); ?></td>
                        <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Created By'); ?></td>
                         <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Module Affected'); ?></td>
                         <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Previous Value'); ?></td>
                         <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Updated Value'); ?></td>
                         <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Approved By'); ?></td>
                         <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Date Approved/Updated'); ?></td>
                         <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Accompanying File'); ?></td>
                         
                         <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Status'); ?></td>
                         <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Comment'); ?></td>
            </tr></thead>
            <tbody>
                    
                    <?php 
                    $row = 0;
                    $count=1;
                     $systemUserService = new SystemUserService();
           foreach ($trails as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    <tr>
                        <td class="tdName tdValue"><?=$count?></td>
                        <td class="tdName tdValue"><?php if($record["status"]=="pending"){?><input type="checkbox" name="approve[]" class="approve" value="<?=$record['id']?>"><?php }?></td>
                        <td class="tdName tdValue"><?=  ucwords($record['transaction_type'])?></td>
                         <td class="tdValue"><?=date("d/m/Y H:ia",  strtotime($record['datecreated']))?></td>
                        <td class="tdValue"> <?php
                

        $systemUser = $systemUserService->getSystemUser($record['created_by']);
      echo ucwords($systemUser->getUserName());?></td>
                        <td class="tdValue"><?=  ucwords($record['module'])?></td>
                        <td class="tdValue"><?=  ucwords($record['previous_value'])?></td>
                        <td class="tdValue"><?=  ucwords($record['updated_value'])?></td>
                        <td class="tdValue"><?php
                
if($record['approved_by']){
        $systemUserr = $systemUserService->getSystemUser($record['approved_by']);
      echo ucwords($systemUserr->getUserName());
}?></td>
                         <td class="tdValue"><?=date("d/m/Y H:ia",  strtotime($record['dateupdated']))?></td>
                         <td class="tdValue"><a href='https://<?=$_SERVER['HTTP_HOST']?>/fgshr/symfony/web/uploads/<?=$record["file1"]?>' target="_blank">Ref</a></td>
                         
                         <td class="tdValue"><?php if($record['status']=="rejected"){echo '<span style="color:red">'.ucwords($record['status']).'</span>';} else if($record['status']=="approved"){echo '<span style="color:green">'.ucwords($record['status']).'</span>';} else{ echo ucwords($record['status']);}  ?></td>
                       <td class="tdValue"><?=  ucwords($record['comments'])?></td>
                       
                       
                    </tr>
                    
                    
                    <?php 
                    $count++;
                    $row++;
                    endforeach; 
                    ?>
                    
                    <?php if (count($trails) == 0) : ?>
                    <tr class="<?php echo 'even';?>">
                        <td>
                            <?php echo __(TopLevelMessages::NO_RECORDS_FOUND); ?>
                        </td>
                       
                    </tr>
                    <?php endif; ?>
                    
                </tbody>
            
            
            </table>
            
 
               
        
          

        </div> <!-- inner -->
       
<?php  
        
		if ($user->isAdmin()) {?>
<div style="float:right">
<?php if($employeedetail){ ?>
    <input type="hidden" value="<?=@$employeedetail->emp_number?>" id="employee" name="employeeapprove">
<?php }?>
    <textarea name="commentsapprove" id="commentsapprove" placeholder="Comments for approval" rows="3" cols="35"></textarea>
    <p><input type="button" id="btnSaveApprove" value="<?php echo __("Approve Transactions"); ?>" /></p>
            </div>       
              
<div style="float:right">
<?php if($employeedetail){ ?>
    <input type="hidden" value="<?=$employeedetail->getEmpNumber()?>" id="employeereject" name="employeereject">
	<?php }?>
    <textarea name="commentsreject" id="commentsreject" placeholder="Comments for rejection" rows="3" cols="35"></textarea>
                    <p><input type="button" id="btnSaveReject" style="background-color:chocolate !important" value="<?php echo __(" Reject Transactions"); ?>" /></p>
</div>
                    
                <?php }?>      

        
    </div> <!-- pdMainContainer -->

    
   
    
</div> <!-- employee-details -->
 


<script type="text/javascript">
function SaveToDisk(fileURL, fileName) {
    alert(fileURL);
    window.open(fileURL, fileName);
}

$(document).ready(function() {
    $("#approvecheckall").change(function() {
		if ($('#approvecheckall').attr('checked')) {
			$('.approve').attr('checked','checked');
		}else{
			$('.approve').removeAttr('checked');
		}
		
	});
    
   
    //When click Save Button 
	$("#btnSaveApprove").click(function(e) {
            e.preventDefault();
            confirm("Confirm approval?");
	var favorite = [];
$.each($("input[class='approve']:checked"), function(){
favorite. push($(this).val());
});
if(favorite.length==0){
    alert("Please select transaction");
    return 0;
}
$.ajax({
            url:"<?= url_for('admin/approve')?>",
            type: 'post',
            data: {'ids':favorite,'comment':$("#commentsapprove").val()},
            dataType: 'html',
            success: function(msg) {
                alert(msg);
               window.location.reload();
            }
        });  
   
   });
   });
   
   //reject
   $("#btnSaveReject").click(function(e) {
            e.preventDefault();
            confirm("Confirm Reject?");
	var favorite = [];
$.each($("input[class='approve']:checked"), function(){
favorite. push($(this). val());
});	
if(favorite.length==0){
    alert("Please select transaction");
    return 0;
}
$.ajax({
            url:"<?= url_for('admin/reject')?>",
            type: 'post',
            data: {'ids':favorite,'comment':$("#commentsreject").val()},
            dataType: 'html',
            success: function(msg) {
                alert(msg);
            //   window.location.reload();
            }
        });  
   
   });
   
   
	



</script>