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
        <h1><?php echo __('MDA Report  '.$month); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
     
          
            <p id="listActions">
                <input type="hidden" id="filterurl" value="<?php echo url_for('pim/employeelist'); ?>">
                     <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
                     <select name="pageno" id="pagenumber" class="greenselect" style="float:right">
                         <option tabindex="0" value="0">Select Page</option> 
                         <option tabindex="0" value="500">Page 1</option>
                          <option tabindex="501" value="500">Page 2</option>
                         <option value="500" tabindex="1001">Page 3</option>
                         <option value="500" tabindex="1501">Page 4</option>
                         <option  tabindex="2001" value="500">Page 5</option>
                         <option tabindex="2501" value="500">Page 6</option>
                         <option tabindex="3001" value="500">Page 7</option>
                         <option tabindex="3501" value="500">Page 8</option>
                         <option tabindex="4001" value="500">Page 9</option>
                         <option tabindex="4501" value="500">Page 10</option>
                         <option tabindex="5001" value="500">Page 11</option>
                         <option tabindex="5501" value="500">Page 12</option>
                         <option tabindex="6001" value="500">Page 13</option>
                         <option tabindex="6501" value="500">Page 14</option>
                     </select> 
                     <form action="<?=  url_for('pim/gradeChange')?>">
                     
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
               <tr><td colspan="12" style="text-align:center;font-weight:bold"> MDA LIST REPORT-ALL MDAs
                
                    </td></tr> 
            <tr><td>#</td><td colspan="5">Number Of Entries: <?=count($employees)?></td><td colspan="4">Period: <?=date("F").",".date("Y")  ?></td><td colspan="2"><?=$page?></td></tr>
            
                  
                    <tr><td colspan="12" class="boldText" style="font-weight:bold"><center>Employer's Name: 
            <?php echo __(strtoupper($organisationinfo->getName())); ?><br><br>
            <?php echo __("P.O BOX ".strtoupper($organisationinfo->getStreet1()." ".$organisationinfo->getZipCode().", ".$organisationinfo->getCity())); ?>&nbsp;&nbsp; </center></td></tr>
                    <tr>
                       <td class="boldText borderBottom" style="font-weight:bold">#</td>
                       <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('MDA'); ?></td>
                        <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('ID/Payroll No'); ?></td>
                        <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('Magaca/Name'); ?></td>
                        <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('Job Title'); ?></td>
                         <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('Jinsi/Gender'); ?></td>
                         <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('Darajo/Grade'); ?></td>
                         <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('Department'); ?></td>
                       <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('Basic Salary'); ?></td>
                       <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('Tax'); ?></td>
                       <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('Allowances '); ?></td>
                       <td class="boldText borderBottom" style="font-weight:bold"><?php echo __('Net Salary '); ?></td>
                                                                       
                         
                               
                              
                    </tr>
               
                <tbody>
                    
                    <?php 
                    $row = 0;
                    $count=1;
           foreach ($employees as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    <tr>
                        <td class="tdName tdValue"><?=$count?>
                        <?php $employeedetail=  EmployeeDao::getEmployeeByNumber($record["emp_number"]);
               $location = HsHrEmpLocationsTable::findEmployeeLocation($record["emp_number"]);
                        if(empty($location)){
                            $location="N/A";
                        }
                        if($employeedetail->termination_id){$status="Terminated";}else { $status="Active";}
                        $empsalarycode= HsHrEmpBasicsalaryTable::getSalaryCode($record["emp_number"]);
                        $pg=new PayGradeDao();
                        $pgrade=$pg->getPayGradeById($empsalarycode);
                        
                                 ?></td>
                         <td class="tdName tdValue">
                        <?=$location?>
                        </td>
                        <td class="tdName tdValue">
                         
                          <?= $employeedetail->getEmployeeId();?>
                            
                        </td>
                        <td class="tdName tdValue">
                       <?= $employeedetail->getEmpFirstname()." ".$employeedetail->getEmpMiddleName()." ".$employeedetail->emp_lastname?>    
                        </td>
                        <?php $employee=EmployeeDao::getEmployeeByNumber($record["emp_number"]); ?>
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
                        <td class="tdName tdValue"><?=$pgrade->name?></td>
                  
                    <td class="tdValue" style="text-align:right"><?php
                    $dept=OhrmSubunitTable::getDepartment($employeedetail->work_station);
                    echo $dept->name;
                    ?></td>
                        <td class="tdValue" style="text-align:right">0</td>
                       <td class="tdValue" style="text-align:right">0</td>
                       <td class="tdValue" style="text-align:right">0</td>
                       <td class="tdValue" style="text-align:right">0</td>
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
                <tfoot>
                   <tr>
                       <td class="boldText borderBottom" style="font-weight:bold">No of Records </td>
                       <td class="boldText borderBottom" style="font-weight:bold"><?=count($employees)?></td>
                        <td class="boldText borderBottom" style="font-weight:bold"></td>
                        <td class="boldText borderBottom" style="font-weight:bold"></td>
                        <td class="boldText borderBottom" style="font-weight:bold">Total Payroll</td>
                         <td class="boldText borderBottom" style="font-weight:bold"></td>
                         <td class="boldText borderBottom" style="font-weight:bold"></td>
                       <td class="boldText borderBottom" style="font-weight:bold"></td>
                      <td class="tdValue" style="text-align:right;font-weight:bold">0</td>
                       <td class="tdValue" style="text-align:right;font-weight:bold">0</td>
                       <td class="tdValue" style="text-align:right;font-weight:bold">0</td>
                       <td class="tdValue" style="text-align:right;font-weight:bold">0</td>
                               
                              
                    </tr> 
                    
                     <tr><td colspan="12" style="text-align:center;font-weight:bold">SUMMARY
                
                    </td></tr>    
           
            <tr><td colspan="6" style="text-align:center;font-weight:bold">Grade/Rank</td>
                <td colspan="6" style="text-align:center;font-weight:bold">Number(Count)</td></tr>
            <?php 
            $totalcount=0;
            foreach($gradeslist as $grade) {?>
            <tr><td colspan="6" style="text-align:center;font-weight:bold"><?=$grade->name?></td>
                <td colspan="6" style="text-align:center;">
                    <?php 
 $empcount=HsHrEmpBasicsalaryTable::getEmployeeCountyBySalaryCode($grade->id);
 $totalcount+=$empcount;
 echo $empcount;
                    ?>
                    
                </td></tr>
            <?php } ?>
                <tr><td colspan="6" style="text-align:center;font-weight:bold">Total</td>
                <td colspan="6" style="text-align:center;"><?=$totalcount?></td></tr>
                
                      
                  
                
                
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
    <h3><?php echo __('SavannaHRM - Confirmation Required'); ?></h3>
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
		window.location.replace("<?=url_for('pim/mdaList')?>"+"?limit=500&start="+offset+"&page="+page);
	}); 
    
});

</script>



