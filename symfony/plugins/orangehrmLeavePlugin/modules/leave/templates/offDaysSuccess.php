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

<div class="box searchForm toggableForm" id="employee-information">
    <div class="head">
        <h1><?php echo __('Off Days Assignment'); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
        <div class="inner">
         <form id="search_form" name="frmEmployeeSearch" method="post" action="<?php echo url_for('leave/leavereport'); ?>">

            <fieldset>

                <ol>
                    <?php echo $form->render(); ?>
                </ol>

                <input type="hidden" name="pageNo" id="pageNo" value="" />
                <input type="hidden" name="hdnAction" id="hdnAction" value="search" />                 

                <p>
                    <input type="button" id="searchBtn" value="<?php echo __("Search") ?>" name="_search" />
                    <input type="button" class="reset" id="resetBtn" value="<?php echo __("Reset") ?>" name="_reset" />    
                    <input type="hidden" value="<?=url_for('leave/setOffDay')?>" id="offdayurl">
                </p>

            </fieldset>

        </form>
    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
     
          
            <p id="listActions">
                <input type="hidden" id="filterurl" value="<?php echo url_for('leave/leavereport'); ?>">
                   
                   
        <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
              <input type="button" class="addbutton print" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('Print') ?>"/>
              <input type="hidden" id="currentyear" value="<?=date("Y")?>">
     <br>
            </p>
            <div class="calendar">
</div>
       
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


$(function() {
	
	$('.print').click(function() {
		var container = $(this).attr('rel');
                 
  
		$('#' + container).printArea();
		return false;
	}); 
   });
   
 $('.calendar').calendar();
 $(".day").click(function(e){
       var employee=$("#empsearch_employee_name_empId").val();
       if(employee !=''){
   var day=$(this).children('.day-content').html();
 var month=$(this).parents("table:first").find('th.month-title').text();//children('.month-title').html();
   var year=$('#currentyear').val()
   //alert('Mark Off day for '+day+'/'+month+'/'+year+ ' for employee?'+employee);
   var url=$("#offdayurl").val();
   var jqxhr=$.post(url,{emp:employee,day:day+'/'+month+'/'+year,status:1}, function() {
  alert( "assigning off day..." );
})
  .done(function(message) {
    alert(message);
  })
  .fail(function() {
    alert( "error in processing!" );
  });
   
   
   }
   else{
       alert('Please select employee!');
   }
 });
  
  
</script>

</script>