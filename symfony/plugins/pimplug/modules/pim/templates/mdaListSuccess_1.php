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
        <h1><?php echo __('MDA List '.$month); ?>&nbsp;&nbsp; </h1>
            
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
                         <option value="1001" tabindex="500">Page 3</option>
                         <option value="1501" tabindex="500">Page 4</option>
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
                     <form action="<?=  url_for('pim/mdaList')?>">
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
               <tr><td colspan="4" class="boldText" style="font-weight:bold;text-align:center">LIST OF THE MDAs OF FGS&nbsp;&nbsp;</td></tr>
            <tr><td>#</td><td >Number Of Entries: <?=count($mdas)?></td><td>Period: <?=date("F").",".date("Y")  ?></td><td><?=$page?></td></tr>
            
                  
                    
                    <tr>
                       <td class="boldText borderBottom" style="font-weight:bold">#</td>
                       <td class="boldText borderBottom" style="font-weight:bold" colspan="2"><?php echo __('Hay’adda'); ?></td>
                        
                        <td class="boldText borderBottom" style="font-weight:bold" ><?php echo __('Employee Count'); ?></td>                                                
                         
                               
                              
                    </tr>
               
                <tbody>
                    
                    <?php 
                    $row = 0;
                    $count=1;
           foreach ($mdas as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    <tr>
                        <td class="tdName tdValue"><?=$count?></td>
                        <td  class="tdName tdValue" colspan="2">
                        <?=$record->name?>
                        </td>
                        <?php  
                        $locationdao=new LocationDao();$locationcount=$locationdao->getNumberOfEmplyeesForLocation($record->id);
                        ?>
                        <td>
                            <?=$locationcount?>
                        </td>
                       
                       
                    </tr>
                    
                    
                    <?php 
                    $count++;
                    $row++;
                    endforeach; 
                    ?>
                    
                    <?php if (count($mdas) == 0) : ?>
                    <tr class="<?php echo 'even';?>">
                        <td>
                            <?php echo __(TopLevelMessages::NO_RECORDS_FOUND); ?>
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
                'nssfnhif':"true"
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