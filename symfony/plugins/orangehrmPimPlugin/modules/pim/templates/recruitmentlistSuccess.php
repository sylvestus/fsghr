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
        <h1><?php echo __('Recruitment List'); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
     
          
            <p id="listActions">
                <input type="hidden" id="filterurl" value="<?php echo url_for('pim/employeelist'); ?>">
                     <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
                     <select name="pageno" id="pagenumber">
                          <option tabindex="0" value="0">Select Page</option> 
                         <option tabindex="0" value="2000">Page 1</option>
                          <option tabindex="2001" value="2000">Page 2</option>
                         <option tabindex="4001" value="2000">Page 3</option>
                         <option  tabindex="6001" value="2000">Page 4</option>
                         <option  tabindex="8001" value="2000">Page 5</option>
                         <option tabindex="10001" value="2000">Page 6</option>
                         <option tabindex="12001" value="2000">Page 7</option>
                         <option tabindex="14001" value="2000">Page 8</option>
                         <option tabindex="16001" value="2000">Page 9</option>
                         <option tabindex="18001" value="2000">Page 10</option>
                         <option tabindex="20001" value="2000">Page 11</option>
                         <option tabindex="22001" value="2000">Page 12</option>
                         <option tabindex="24001" value="2000">Page 13</option>
                         <option tabindex="26001" value="2000">Page 14</option>
                     </select>
                      <form action="<?=  url_for('pim/recruitmentlist')?>">
                     <select name="location" id="location" class="greenselect"><option tabindex="0" value="0">Select MDA/Location</option> 
                         <?php $locationdao=new LocationDao();$list=$locationdao->getLocationList();
                         foreach($list as $location){?>
                          <option value="<?=$location->id?>"><?=$location->name?></option>
                         
                         <?php }?>
                     </select>
                <input type="date" class="datepicker required" name="fromdate"  placeholder="From Date">
                <input type="date" class="datepicker required" name="todate"  placeholder="To Date">
                <input type="submit" class="button" value="Search">
                
            </form>
                <a href="#" class="addbutton" style="float:right !important" id="emailbtn"><img src="<?php echo "{$imagePath}/email.png";?>" alt="email"></a>   
                     <a href="#" class="addbutton" style="float:right !important" id="pdfbtn"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>   
                   
                   
        <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
              <input type="button" class="addbutton print" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('Print') ?>"/>
     <br>
            </p>
            <div id="dvData">
            <table class="table hover data-table displayTable exporttables tablestatic" id="recordsListTable">
			<?php 
			
			$path= "https://".$_SERVER["HTTP_HOST"].'/fgshr/symfony/web/uploads/letterhead.png';
						?>
			
			<tr><td colspan="11" style="text-align:center"><?php echo '<img src="'.$path.'">'?></td></tr>
			<tr><td colspan="11" style="text-align:center"></td></tr>
                <tr><td colspan="11" style="text-align:center"> <u style="font-weight:bold">RECRUITMENT LIST <?=  strtoupper($locationd)?> FOR <?=$dates?></u>
                
                    </td></tr>
            <tr><td>#</td><td colspan="5">Number Of Entries: <?=count($employees)?></td><td colspan="3">Period: <?=date("F").",".date("Y")  ?></td><td colspan="3"><?=$page?></td></tr>
            
                  
                    <tr><td colspan="12" class="boldText" style="font-weight:bold"><center>Employer's Name: 
            <?php echo __(strtoupper($organisationinfo->getName())); ?> </center></td></tr>
                    <tr>
                        <td class="boldText borderBottom" style="font-weight:bold" >#</td>
                         <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('MDA Code'); ?></td>
                        <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Hay\'adda/MDA'); ?></td>
                        <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Payroll No'); ?></td>
                        <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('Magaca/Name'); ?></td>
                        <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('Job Title'); ?></td>
                        <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('Gender'); ?></td>
                      
                       <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('T.La Qoray/Rec Date'); ?></td>
                       <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('T. Dalacay/pro Date'); ?></td>
                        <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('Ref/Reference'); ?></td>       
                              
                    </tr>
               
                <tbody>
                    
                    <?php 
                    $row = 0;
                    $count=1;
           foreach ($employees as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    <tr>
                        <td class="tdName tdValue"><?=$count?></td>
                        
                         <?php
                        
                         $employeedetail=  EmployeeDao::getEmployeeByNumber($record["affected_user"]);
                           if(!$record["affected_user"]){  $employeedetail=EmployeeDao::getEmployeeByNumber(130);}
               $location = HsHrEmpLocationsTable::findEmployeeLocation($record["affected_user"]);
               $locationid=HsHrEmpLocationsTable::findEmployeeLocationId($record["affected_user"]);
                        if(empty($location)){
                            $location="N/A";
                        }
                        if($employeedetail->termination_id){$status="Terminated";}else { $status="Active";}
                                 ?>
                           
                         
                            
                        <td class="tdName tdValue"><?=$locationid?></td>
                        <td class="tdName tdValue"><?=$location?></td>
                                               <td class="tdName tdValue"> <?= @$employeedetail->getEmployeeId();?></td>
                                               <td class="tdValue"><?=  ucwords($record['updated_value'])?></td>
                         <td class="tdName tdValue">
                          <?php 
                        $jb=new JobTitleDao();
                        $title=$jb->getJobTitleOnly($employee->job_title_code);
                         if($title){echo $title;} else{echo "N/A";}
                            ?>
                        </td>
                         <td class="tdName tdValue">
                       <?php if($employeedetail->emp_gender==2){echo "Female";}else{echo "Male";}?>    
                        </td>
                       
         
                        
                         <td class="tdValue"><?=date("d/m/Y",strtotime($record['datecreated']))?></td>
                         <td class="tdValue"><?=date("d/m/Y",strtotime($record['dateupdated']))?></td>
                         <td class="tdValue"><a href='https://<?=$_SERVER['HTTP_HOST']?>/fgshr/symfony/web/uploads/<?=$record["file1"]?>' target="_blank">Ref</a></td>
                        
                       
                       
                       
                    </tr>
                    
                    
                    <?php 
                    $count++;
                    $row++;
                    endforeach; 
                    ?>
                    
                    <?php if (count($employees) == 0) : ?>
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
                                <span style="font-weight:bold">NB:THIS FORM IS INVALID WITHOUT THE OFFICIAL STAMP/SEAL OF THE EMPLOYER </span>
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
       
     // html=$("#recordsListTable").html();
     // url=$("#pdfurl").val();
// $.ajax({
            // url: url,
            // type: 'post',
            // data: {
                // 'data':html,
                // 'nssfnhif':"true"
            // },
            // dataType: 'html',
            // success: function(urll) {
                // window.open(urll, '_blank');
            // }
        // });  
   
   // });
   $("#pdfbtn").click(function(e){
    $(".loader").css("display","block");
	          window.location.replace("<?=url_for('pim/recruitmentlist')?>"+"?location=0&fromdate=&todate=&pdf=true"); 
  
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
		window.location.replace("<?=url_for('pim/recruitmentlist')?>"+"?limit=500&start="+offset+"&page="+page);
	}); 
    
});

</script>