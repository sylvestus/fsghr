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

<!-- Listi view -->

<div id="recordsListDiv" class="box miniList">
    <div class="head">
	<?php
	$date=date("d-m-Y");
	?>
        <h1><?php echo __('Employee Timesheets for '.$date); ?>&nbsp;&nbsp; </h1>
            
            

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
        <form name="frmList" id="frmList" method="post" action="<?php echo url_for('time/addInterview'); ?>">
          
            <p id="listActions">
                <input type="hidden" id="addearning" value="<?php echo url_for('time/addEmployeeTimesheet'); ?>">
                  
                  <input type="hidden" id="updateearning" value="<?php echo url_for('time/UpdateEmployeeTimeSheet'); ?>">
                  <input type="hidden" id="filterinterview" value="<?php echo url_for('time/viewEmployeeTimesheet'); ?>">
                  <input type="hidden" id="markregister" value="<?php echo url_for('attendance/markRegister'); ?>">
                <input type="button" class="addbutton" id="btnAddSlab" value="<?php echo __('Refresh'); ?>"/>
                          
                        <?php 
                        $year=  date("Y");
                        $months=array("01-".$year=>"01-".$year,"02-".$year=>"02-".$year,"03-".$year=>"03-".$year,"04-".$year=>"04-".$year,"05-".$year=>"05-".$year,"06-".$year=>"06-".$year,"07-".$year=>"07-".$year,"08-".$year=>"08-".$year,"09-".$year=>"09-".$year,"10-".$year=>"10-".$year,"11-".$year=>"11-".$year,"12-".$year=>"12-".$year); ?>
                          <select id="SelectInterview" class="greenselect">
                      <option value="">Filter Dates</option>
                       
                      <?php foreach ($months as $month) { 
                         echo '<option value="'.$month.'">'.$month.'</option>';
                   
                      } 
                      ?>                  </select>
                          
                         
             <?php $imagePath = theme_path("images");?>
                          <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
            </p>
            <div id="dvData">
         <table width="100%" class="display dataTables tablestatic exporttables" cellpadding="2"   id="recordsListTable">
                <thead>
                    <tr>
                     
                        <td ><?php echo __('#'); ?></td>
                        <td class="boldText borderBottom"><?php echo __('Employee No'); ?></td>
                                <td  class="boldText borderBottom"><?php echo __('Employee Name'); ?></td>
                                 <td class="boldText borderBottom" ><?php echo __('Date'); ?></td>
                             
                           <td class="boldText borderBottom" ><?php echo __('Status'); ?></td>
                            
                                   
                                    
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 1;
          
           foreach ($timesheets as $record):  
                    
           
                    ?>
                    
                    <tr class="<?php echo $cssClass;?>">
                       
                        <td class="tdName tdValue">
                         <?php echo $row; ?>
                        </td>
                        <td class="tdName tdValue">
                            
         <?=$record["tIdentification"]?>
                        </td>
                        <td class="tdName tdValue">
                            
         <?=$record["tFullName"]?>
                        </td>
                           <td class="tdName tdValue">
                            
         <?=$record["dateentered"]?>
                        </td>
						      <td class="tdName tdValue">
                            
         <?=$record["tDesc"]?>
                        </td>
                          
                    </tr>
                    
                    <?php 
                    $row++;
                    endforeach; 
                    ?>
                    
                    <?php if (count($timesheets ) == 0) : ?>
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
                <br>
             
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
       $("#checkAll").click(function() {
          if($("#checkAll").is(":checked")){
       $(".checkboxAtch").each(function(){
           $('.checkboxAtch').attr("checked","checked");
       });
          }
          else{
              $(".checkboxAtch").each(function(){
           $('.checkboxAtch').prop("checked",false);
       });   
          }
          });
       //update
       
      
   
    //add tax slab
     $('#btnAddSlab').click(function(e) {
         e.preventDefault();
         
            window.location.reload();
    });
    
    //update tax slab
         $('#btnUpdateSlab').click(function(e) {
         e.preventDefault();
         var id=$(".check .checkboxAtch:checked").val();
         var url=$("#updateearning").val();
             if(id !==null){
        window.location.replace(url+'?id='+id);
          }else{return;}
    });
    //filter by interview
      $('#SelectInterview').change(function(e) {
         e.preventDefault();
         var id=$(this).val();
         var url=$("#filterinterview").val();
             if(id !==null){
        window.location.replace(url+'?id='+id);
          }else{return;}
    });
    //mark register
      $('#markregisterselect').change(function(e) {
         e.preventDefault();
         var id=$(this).val();
         var url=$("#markregister").val();
             if(id !==null){
        window.location.replace(url+'?id='+id);
          }else{return;}
    });
    
    
    
         $('#btnDelSlab').click(function(e) {
         e.preventDefault();
           if ($(".check .checkboxAtch:checked").length > 0) {
               var id=$(".check .checkboxAtch:checked").val();
         var url=$("#deleteearning").val();
           
         window.location.replace(url+'?id='+id);
    
         }
    });
     
    
    
});

</script>