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
        <h1><?php echo __('Candidate Interview Sessions'); ?>&nbsp;&nbsp; </h1>
            
            

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
        <form name="frmList" id="frmList" method="post" action="<?php echo url_for('recruitment/addInterview'); ?>">
          
            <p id="listActions">
                <input type="hidden" id="addearning" value="<?php echo url_for('recruitment/addCandidateInterview'); ?>">
                  
                  <input type="hidden" id="updateearning" value="<?php echo url_for('recruitment/UpdateCandidateInterview'); ?>">
                  <input type="hidden" id="filterinterview" value="<?php echo url_for('recruitment/candidateInterviews'); ?>">
                  <input type="hidden" id="markinterviewurl" value="<?php echo url_for('recruitment/UpdateInterview?id='.$id); ?>">
                <input type="button" class="addbutton" id="btnAddSlab" value="<?php echo __('Record Candidate Evaluation'); ?>"/>
                          <input type="button" class="addbutton" id="btnUpdateSlab" value="<?php echo __('Update Evaluation'); ?>"/>
                          <select id="SelectInterview" class="greenselect">
                      <option value="">Filter By Interview</option>
                        <option value="a">Select All</option>
                      <?php foreach ($interviews as $interview) { 
                         echo '<option value="'.$interview->getId().'">'.$interview->getCandidateFirstName()." ".$interview->getCandidateMiddleName().'-> '.$interview->getInterviewerName().'('.date("d-m-Y H:i",  strtotime($interview->getInterviewDate())).')'.'</option>';
                   
                      } 
                      ?>                  </select>
             <?php $imagePath = theme_path("images");?>
                          <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
            </p>
            <div id="dvData">
            <table class="table hover exporttable" id="recordsListTable">
                <thead>
                    <tr>
                        <td class="check" style="width:2%"></td>
                        <td ><?php echo __('#'); ?></td>
                        <td class="boldText borderBottom"><?php echo __('Candidate Name'); ?></th>
                                <td  class="boldText borderBottom"><?php echo __('Interviewer Name'); ?></td>
                                 <td class="boldText borderBottom" ><?php echo __('Interview Position'); ?></td>
                                 <td class="boldText borderBottom" ><?php echo __('Evaluation Criteria'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Response Weight'); ?></td>
                                 <td class="boldText borderBottom" ><?php echo __('Max Weight'); ?></td>
                                 <td class="boldText borderBottom"><?php echo __('Remarks'); ?></td>
                            
                                   
                                    
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $row = 1;
                    $totalresponseweight=array();
                    $totalmaxweight=array();
           foreach ($pager->getResults() as $record):  
                        $cssClass = ($row%2) ? 'even' : 'odd';
           $interviewdetails=  Ohrm_InterviewTable::getInstance()->find($record->getInterviewId());
           if(is_object($interviewdetails)){
               $name=$interviewdetails->getCandidateFirstName()." ".$interviewdetails->getCandidateMiddleName()." ".$interviewdetails->getCandidateLastName();
               $interviewer=$interviewdetails->getInterviewerName();
               $position=$interviewdetails->getInterviewPosition();
              $date=$interviewdetails->getInterviewDate();
              $interviewsetup= Ohrm_InterviewSetupTable::getInstance()->find($record->getQuestionId());
              $question=$interviewsetup->getQuestion();
              $maxweight=$interviewsetup->getWeight();
           }
                    ?>
                    
                    <tr class="<?php echo $cssClass;?>">
                        <td class="check">
                            <input type="checkbox" class="checkboxAtch" name="chkListRecord[]" value="<?php echo $record->getId(); ?>" />
                        </td>
                        <td class="tdName tdValue">
                         <?php echo $row; ?>
                        </td>
                    
                        <td class="tdName tdValue">
                         <?=$name?>
                        </td>
                        <td class="tdValue">
                            
                        </td>
                        <td class="tdValue">
                                <?php echo $interviewdetails->getInterviewPosition();?> 
                        </td>
                 
                        <td class="tdValue">
                                <?php echo $question ?> 
                        </td>
                        <td class="tdValue">
                            <?php array_push($totalresponseweight,$record->getResponseWeight())?>
                                <?php echo $record->getResponseWeight() ?> 
                        </td>
                        <td class="tdValue">
                              <?php array_push($totalmaxweight,$maxweight )?>
                                <?php echo $maxweight ?> 
                        </td>
                        <td class="tdValue">
                                <?php echo $record->getRemark()?> 
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
                 <tfoot>
                    
                     <tr ><td></td><td class="boldText">TOTAL</td><td></td><td></td><td></td><td></td><td class="boldText"><?php if(is_numeric($id)){echo array_sum($totalresponseweight);}?><input id="averagemark"  type="hidden" value="<?= urlencode(array_sum($totalresponseweight))?>"></td><td class="boldText"><?php if(is_numeric($id)){echo array_sum($totalmaxweight);}?></td><td></td></tr>
                     <?php
                   if(is_numeric($id))  {
                     ?>
                     <tr><td></td><td class="boldText">Interview Actions</td><td></td><td></td><td></td><td></td><td colspan="2" class="boldText">
                             <select id="markinterview" class="greenselect" style="float:right">
                      <option value="">Mark Interview  As</option>
                          <option value="conducted">Conducted</option>
                       <option value="passed">Passed</option>
                        <option value="failed">Failed</option>
                       
                                      </select>
                         </td><td></td></tr>        
                   <?php }?>
                </tfoot>
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
           var id=$(".check .checkboxAtch:checked").val();
         var url=$("#addearning").val();
            window.location.replace(url);
    });
    
    //update tax slab
         $('#btnUpdateSlab').click(function(e) {
         e.preventDefault();
         var id=$(".check .checkboxAtch:checked").val();
         var url=$("#updateearning").val();
             if(id !==""){
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
    //mark interview
      $('#markinterview').change(function(e) {
         e.preventDefault();
         var status=$(this).val();
         var url=$("#markinterviewurl").val();
             if(status!==null){
        window.location.replace(url+'?status='+status+"&catch="+$("#averagemark").val());
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