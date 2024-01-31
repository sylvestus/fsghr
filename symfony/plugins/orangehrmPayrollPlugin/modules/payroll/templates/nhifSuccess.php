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


<?php use_javascript(plugin_web_path('orangehrmPayrollPlugin', 'js/listIncomeTaxSlabSuccess')); ?>




<!-- Listi view -->

<div id="recordsListDiv" class="box miniList">
    <div class="head">
            <h1><?php echo __('NHIF Rates'); ?></h1>
    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
        <form name="frmList" id="frmList" method="post" action="<?php echo url_for('admin/deleteSkills'); ?>">
          
            <p id="listActions">
                <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
                  <a href="#" class="addbutton" style="float:right !important" id="emailbtn"><img src="<?php echo "{$imagePath}/email.png";?>" alt="email"></a>   
                 <a href="#" class="addbutton" style="float:right !important" id="pdfbtn"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>   
                  <input type="hidden" id="addslab" value="<?php echo url_for('payroll/addNhifRatesSlab'); ?>">
                  <input type="hidden" id="deleteslab" value="<?php echo url_for('payroll/deleteNhifRatesSlab'); ?>">
                  <input type="hidden" id="updateslab" value="<?php echo url_for('payroll/updateNhifRatesSlab'); ?>">
                <input type="button" class="addbutton" id="btnAddSlab" value="<?php echo __('Add Nhif Rates Slab'); ?>"/>
                          <input type="button" class="addbutton" id="btnUpdateSlab" value="<?php echo __('Update Rates Slab'); ?>"/>
                <input type="button" class="delete" id="btnDelSlab" value="<?php echo __('Delete Rates Slab'); ?>"/>
      
            </p>
            
           <table class="table hover data-table displayTable exporttable tablestatic" id="recordsListTable">
                <thead>
                    <tr>
                        <th class="check" style="width:2%"></td>
                        <th width="32%" ><?php echo __('Min Gross Income'); ?></td>
                        <th width="32%"><?php echo __('Max Gross Income'); ?></td>
                                <th width="32%"><?php echo __('Contribution'); ?></td>
                                    
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 0;
           foreach ($pager->getResults() as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
                    ?>
                    
                    <tr class="<?php echo $cssClass;?>">
                        <td class="check">
                            <input type="checkbox" class="checkboxAtch" name="chkListRecord[]" value="<?php echo $record->getId(); ?>" />
                        </td>
                        <td class="tdName tdValue">
                            <?php echo $record->getMinfigure(); ?>
                        </td>
                        <td class="tdValue">
                            <?php echo $record->getMaxfigure(); ?> 
                        </td>
                        <td class="tdValue">
                            <?php echo $record->getAmount(); ?> 
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
                 'nssfnhif':"true"
                
            },
            dataType: 'html',
            success: function(urll) {
                window.open(urll, '_blank');
            }
        });  
   
   });
   
     $("#emailbtn").click(function(e){
     html=$("#pdftable").html();
     url=$("#pdfurl").val()+"?sendemail=true&report=NHIF Report";
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
    //add tax slab
     $('#btnAddSlab').click(function(e) {
         e.preventDefault();
         var url=$("#addslab").val();
        window.location.replace(url);
    });
    
    //update
    
         $('#btnUpdateSlab').click(function(e) {
         e.preventDefault();
         var id=$(".check .checkboxAtch:checked").val();
         var url=$("#updateslab").val();
       
        window.location.replace(url+'?id='+id);
    });
    
    
         $('#btnDelSlab').click(function(e) {
         e.preventDefault();
           if ($(".check .checkboxAtch:checked").length > 0) {
               var id=$(".check .checkboxAtch:checked").val();
         var url=$("#deleteslab").val();
       
        window.location.replace(url+'?id='+id);
         }
    });
    
});

</script>