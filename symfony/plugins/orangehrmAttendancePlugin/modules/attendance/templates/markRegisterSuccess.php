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
<style>
    table thead tr{
    display:block;
}

table th,table td{
    width:100px;//fixed width
}


table  tbody{
  display:block;
  height:500px;
  overflow:auto;//set tbody to auto
}
    
</style>

<div id="recordsListDiv" class="box miniList">
    <div class="head">
        <h1><?php echo __('Mark Register for '.$location." :".$date); ?>&nbsp;&nbsp; </h1>
            
            

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
        
          
            <p id="listActions">
                <input type="hidden" id="addearning" value="<?php echo url_for('time/addEmployeeTimesheet'); ?>">
                <input id="monthyear"  type="hidden" value="<?=$date?>">
                  <input type="hidden" id="updateearning" value="<?php echo url_for('time/UpdateEmployeeTimeSheet'); ?>">
                  <input type="hidden" id="filterinterview" value="<?php echo url_for('time/viewEmployeeTimesheet'); ?>">
                  <input type="hidden" id="markregister" value="<?php echo url_for('attendance/markRegister'); ?>">
                    <input type="hidden" id="addmissedattendance" value="<?php echo url_for('attendance/addMissedAttendance'); ?>">
                    <input type="hidden" id="deletemissedattendance" value="<?php echo url_for('attendance/deleteMissedAttendance'); ?>">
                     <input type="hidden" id="deletemissedattendancehalf" value="<?php echo url_for('attendance/deleteMissedAttendance'); ?>">
                     <input type="hidden" id="deletemissedattendanceall" value="<?php echo url_for('attendance/deleteMissedAttendanceAll'); ?>">
                <input type="button" class="addbutton" id="btnAddSlab" value="<?php echo __('Add TimeSheet'); ?>"/>
                        
                        <?php 
                        $year=  date("Y");
                        $months=array("01-".$year=>"01-".$year,"02-".$year=>"02-".$year,"03-".$year=>"03-".$year,"04-".$year=>"04-".$year,"05-".$year=>"05-".$year,"06-".$year=>"06-".$year,"07-".$year=>"07-".$year,"08-".$year=>"08-".$year,"09-".$year=>"09-".$year,"10-".$year=>"10-".$year,"11-".$year=>"11-".$year,"12-".$year=>"12-".$year); ?>
                          <select id="SelectInterview" class="greenselect">
                      <option value="">Filter Dates</option>
                       
                      <?php foreach ($months as $month) { 
                         echo '<option value="'.$month.'">'.$month.'</option>';
                   
                      } 
                      ?>                  </select>
                          
                      
                <?php $locations=OhrmLocationTable::getAllLocations();?>
                   <select id="filterlocation" class="greenselect">
                      <option value="">Filter By Location</option>
                        <option value="all">All Locations</option>
                      <?php foreach ($locations as $location) { 
                         echo '<option value="'.$location->getId().'">'.$location->getName().'</option>';
                   
                      } 
                      ?>                  </select>
                  <input type="button" class="addbutton" id="savemarks" value="<?php echo __('Save Marked List'); ?>"/>
                  <a class="addbutton btn-success" id="markallpresent"><?php echo __('Mark All Present'); ?></a>
             <?php $imagePath = theme_path("images");?>
                          <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
            </p>
            <div id="dvData" style="max-width:1500px;overflow-x:scroll;overflow-y:no-display">
            <table class="table hover" border="1" style="border:1px solid #000" id="recordsListTable">
                <thead>
                    <tr> <td  class="boldText borderBottom" style="width:100px"><?php echo __('Payroll #'); ?></td>
                                    
                        <td class="boldText borderBottom" style="border-right:1px solid #ccc;width:90px"><?php echo __('Employee Name'); ?></td>
                                <?php
                                $i=1;
                      while ($i<=$daysinmonth) {
    echo "<td class='daysinmonth'  id='".$i."'></td>";
    $i++;
} 
                                ?>
                                
                            
                                   
                                    
                    </tr>
                </thead>
                <tbody>
               
                   <form action="<?=  url_for('attendance/markRegister')?>" method="POST">   
                    <?php 
                    $row = 1;
          
           foreach ($employees as $record=>$value):  
                    
           
                    ?>
                    
                    <tr class="<?php echo $cssClass;?>">
                        <?php $employeedetail=  EmployeeDao::getEmployeeByNumber($record) ?>
                         
                        <td style="width:50px" class="tdName tdValue"> <?= $employeedetail->getEmployeeId();?></td>
                        <td style="width:100px" class="tdName tdValue">
                            <input type="hidden" value="<?=$record?>" class="emp_number">
                         <?php echo $value; ?>
                        </td>
              
                        <?php
                        $j=1;
                      while ($j<=$daysinmonth) {
                          
    echo "<td class='employeeattendance' style='border-right:1px solid #ccc;width:30px' id='".$j."'>"?>
       
      <?php $missedday=  OhrmMissedAttendanceTable::getMissedDayOfMonth($j, $record, $date);
     $missedattendance=  OhrmMissedAttendanceTable::getMissedDay($j, $record, $date);
      if($missedattendance->half_day >0){
          //half day
        echo '<div style="border:1px solid green;border-radius:3px"><input style="border:1px solid red" type="checkbox"  id="'.$j.'" class="employeecheckhalf" title="'.$record.'" name="employeeattendedcheckhalf[]"  checked="checked">h/d</div>';
      ?>                     
                          
    <input type="checkbox"  id="<?=$j?>" class="employeecheck" title="<?=$record?>" name="employeeattendedcheck[]"  unchecked>
      <?php }
      else{
          echo "<span style='font-size:9px'>".$j."</span>";
      ?>
   <input type="checkbox"  id="<?=$j?>" class="employeecheck" title="<?=$record?>" name="employeeattendedcheck[]"  checked="checked">
                            <?php 
     echo '<div style="border:1px solid green;border-radius:3px"><input type="checkbox"  id="'.$j.'" class="employeecheckhalf" title="'.$record.'" name="employeeattendedcheckhalf[]"  > h/d</div>';
                            }
      
                            echo "</td>";
    $j++;
} 
     unset($j);               
           ?>             
                          
                    </tr>
                    
                    <?php 
                    $row++;
                    endforeach; 
                    ?>
                    
                    <?php if (count($employees ) == 0) : ?>
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
       
       $(".employeecheck").click(function() {
          if($(this).is(":checked")){
        empnumber=$(this).attr("title");
        day=$(this).attr("id");
        
         $.ajax({
    url: $("#deletemissedattendance").val()+"?empnumber="+empnumber+"&day="+day+"&monthyear="+$("#monthyear").val()+"&is_half=0",
    cache: false,
    type: "POST",
    data:{},
    dataType: "json",
    timeout:3000,
    success : function (data1) {
        if(data1.status=="true"){

            
        }
        else{
            //alert("Could not process attendance,Please retry");
        }

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
    }   
 })
        
          }
          else if($(this).is(":unchecked")){
                 empnumber=$(this).attr("title");
        day=$(this).attr("id")
        
           $.ajax({
    url: $("#addmissedattendance").val()+"?empnumber="+empnumber+"&day="+day+"&monthyear="+$("#monthyear").val()+"&is_half=0",
    cache: false,
    type: "POST",
    data:{},
    dataType: "json",
    timeout:3000,
    success : function (data1) {
        if(data1.status==true){
                     
        }
        else{
            //alert("Could not process attendance,Please retry");
        }

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
    }   
 })
        
          }
          })
      
   
   $(".employeecheckhalf").click(function() {
          if($(this).is(":checked")){
        empnumber=$(this).attr("title");
        day=$(this).attr("id");
        
         $.ajax({
    url: $("#deletemissedattendance").val()+"?empnumber="+empnumber+"&day="+day+"&monthyear="+$("#monthyear").val()+"&is_half=1",
    cache: false,
    type: "POST",
    data:{},
    dataType: "json",
    timeout:3000,
    success : function (data1) {
        if(data1.status=="true"){

            
        }
        else{
            //alert("Could not process attendance,Please retry");
        }

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
    }   
 })
        
          }
          else if($(this).is(":unchecked")){
                 empnumber=$(this).attr("title");
        day=$(this).attr("id")
        
           $.ajax({
    url: $("#addmissedattendance").val()+"?empnumber="+empnumber+"&day="+day+"&monthyear="+$("#monthyear").val()+"&is_half=1",
    cache: false,
    type: "POST",
    data:{},
    dataType: "json",
    timeout:3000,
    success : function (data1) {
        if(data1.status==true){
                     
        }
        else{
            //alert("Could not process attendance,Please retry");
        }

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
    }   
 })
        
          }
          })
    //add tax slab
     $('#btnAddSlab').click(function(e) {
         e.preventDefault();
           var id=$(".check .checkboxAtch:checked").val();
         var url=$("#addearning").val();
            window.location.replace(url);
    });
    
    //update tax slab
         $('#savemarks').click(function(e) {
         e.preventDefault();
       
        window.location.reload();
       
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
//      $('#markregisterselect').change(function(e) {
//         e.preventDefault();
//         var id=$(this).val();
//         var url=$("#markregister").val();
//             if(id !==null){
//        window.location.replace(url+'?id='+id);
//          }else{return;}
//    });
    
    //filter by location
     $('#filterlocation').change(function(e) {
         e.preventDefault();
         var id=$(this).val();
         var url=$("#markregister").val();
         var date=$("#monthyear").val();
             if(id !=="" && date !==""){
        window.location.replace(url+'?monthyear='+date+"&location="+id);
          }else{
            alert("select date and location");  
            return;}
    });
    
    
         $('#btnDelSlab').click(function(e) {
         e.preventDefault();
           if ($(".check .checkboxAtch:checked").length > 0) {
               var id=$(".check .checkboxAtch:checked").val();
         var url=$("#deleteearning").val();
           
         window.location.replace(url+'?id='+id);
    
         }
    });
     
     
     //mark all present
     $("#markallpresent").click(function(e){
         var confirmed=confirm("Mark all present?");
         
         if(confirmed){
         var date=$("#monthyear").val();
        var url=$("#deletemissedattendanceall").val();
        window.location.replace(url+'?monthyear='+date);      
         }
         else{
            return false; 
         }
         
     });
     
    
    
});

</script>