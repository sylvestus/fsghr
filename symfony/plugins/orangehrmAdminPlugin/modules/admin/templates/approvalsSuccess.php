<div id="recordsListDiv" class="box miniList">
    <div class="head">
        <h1><?php echo __('Pending List Of Approvals '.date("Y")); ?>&nbsp;&nbsp; </h1>
            
            

    </div>
    
    <div class="inner">
	 <?php include_partial('global/flash_messages'); ?>
	<form name="frmSearchBox" id="frmSearchBox" method="post" action="">
	 	<input type="hidden" name="mode" value="search"></input>
		<div class="searchbox">
	        <label for="searchMode"><?php echo __("Search By")?></label>
	        <select name="searchMode" id="searchMode">
	            <option value="all"><?php echo __("--Select--")?></option>
	            <option value="module" <?php if($searchMode == 'module'){ echo "selected";}?>><?php echo __("Module")?></option>
	            <option value="createdby" <?php if($searchMode == 'createdby'){ echo "selected";}?>><?php echo __("Created By")?></option>
                    <option value="approvedby" <?php if($searchMode == 'approvedby'){ echo "selected";}?>><?php echo __("Approved By")?></option>
	        </select>
	
	        <label for="searchValue">Search For:</label>
	        <input type="text" size="20" name="searchValue" id="searchValue"  />
	        <input type="submit" class="plainbtn" 
	            value="<?php echo __("Search")?>" />
	        <input type="reset" class="plainbtn" 
	             value="<?php echo __("Reset")?>" />
	        <br class="clear"/>
	    </div>
    </form>
    
     <br class="clear" />
    
     <input type="hidden" name="mode" id="mode" value=""></input>
    	<table class="table hover data-table displayTable exporttable tablestatic" id="recordsListTable">
             
			<thead>
            <tr>
				 <td class="boldText borderBottom">
				
					<input type="checkbox" class="checkbox" name="allCheck" value="" id="allCheck" />
				
				</td>
				
					 <td class="boldText borderBottom">
				<?php echo __("Transaction")?>
					</td>
                                         <td class="boldText borderBottom">
						<?php echo __("Module Affected")?>
						 
					</td>  
                                        <td class="boldText borderBottom">
						<?php echo __("Employee")?>
						 
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
    		</thead>

            <tbody>
    		<?php 
    		 $row = 0;
    		foreach($trails as $customer){
    			$cssClass = ($row %2) ? 'even' : 'odd';
				$row = $row + 1;
                                 $systemUserService = new SystemUserService();
$employee= EmployeeDao::getEmployeeByNumber($customer->affected_user);
if(is_object($employee)){
    $names=$employee->getEmpFirstname()." ".$employee->getEmpLastname();
}else {$names="New Employee";}
        $systemUser = $systemUserService->getSystemUser($customer->created_by);
        if((@$customer->approved_by)){
      $systemUser2 = $systemUserService->getSystemUser($customer->approved_by);
      $approvaluser=$systemUser2->getUserName();
        }else{
       $approvaluser="";   
        }
        
    			?>
				<tr class="<?php echo $cssClass?>">
       				<td >
						<input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php echo $customer->getId()?>' />
					</td>
					<td class="tdValue">
		 				<a href="<?php echo url_for('admin/viewTransaction?id='.$customer->id)?>"><?php echo $customer->transaction_type?></a>
		 			</td>
                                        <td class="tdValue"><?php echo __($customer->module)?></td>
                                        <td class="tdValue" style="font-weight:bold"><?php echo __($names)?></td>
                                        <td class="tdValue"><?php echo __(date("d/m/Y H:ia",strtotime($customer->datecreated)))?></td>
                                       
                                        <td class="tdValue"><?php echo __(ucwords($systemUser->getUserName()))?></td>
                                        <td class="tdValue"><?php echo __(date("d/m/Y H:ia",strtotime($customer->dateupdated)))?></td>
                                        <td class="tdValue"><?php echo __(ucwords($approvaluser))?></td>
                                        <td class="tdValue"><?php echo __($customer->approved_by2)?></td>
                                        <td class="tdValue"><?php echo __($customer->previous_value)?></td>
                                        <td class="tdValue"><?php echo __($customer->updated_value)?></td>
                                        <td class="tdValue"><a target="_blank" href="file://<?=$customer->file1?>">File1</a>&nbsp;<a target="_blank" href="file://<?php echo __($customer->file2)?>">File2</a></td>
		 			<td class="tdValue" style="color:orange"><?php echo __($customer->status)?></td>
		 	</tr>
			 	<?php }?>
            </tbody>
 		</table>

</div>
</div>
<script type="text/javascript">

$(document).ready(function() {

	//When click add button 
	$("#buttonAdd").click(function() {
		location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/admin/saveCustomer')) ?>";

   });

	// When Click Main Tick box
	$("#allCheck").change(function() {
		if ($('#allCheck').attr('checked')) {
			$('.innercheckbox').attr('checked','checked');
		}else{
			$('.innercheckbox').removeAttr('checked');
		}
		
	});

	//When click remove button
	$("#buttonRemove").click(function() {
		$("#mode").attr('value', 'delete');
		$("#standardView").submit();
	});	

	//When click Save Button 
	$("#buttonRemove").click(function() {
		$("#mode").attr('value', 'save');
		$("#standardView").submit();
	});	


	  	
});


</script>

    