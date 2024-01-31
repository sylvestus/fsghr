
<?php //use_javascript(plugin_web_path('orangehrmPayrollPlugin', '/js/updateConfigurationSuccess')); ?>

<div class="box">

<?php if (isset($credentialMessage)) { ?>

<div class="message warning">
    <?php echo __(CommonMessages::CREDENTIALS_REQUIRED) ?> 
</div>

<?php } else { ?>

    <div class="head">
        <h1><?php echo __('Update Candidate Interview Response'); ?></h1>
    </div>

    <div class="inner" id="addIncomeTaxSlabTbl">
        <?php include_partial('global/flash_messages'); ?>     
        <input type="hidden" value="<?php echo url_for('recruitment/candidateInterviews'); ?>"  id="cancelurl">
        <form id="frmAddTax" method="post" action="<?php echo url_for('recruitment/UpdateCandidateInterview?id='.$candidateinterview->getId()); ?>" 
              >
            <fieldset>
                <ol>
                    <?php echo $form->render(); ?>
                    <li class="required">
                        <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                    </li>
                </ol>
                <table id="resultTable" class="table hover">
                    <thead><th>#</th><th>Evaluation Criteria</th><th>Score</th><th>Max Score</th><th>Remark</th></thead>
                <tbody>
               

                            
                    <tr><td>1</td><td><?=$interviewsetup->getQuestion()?><input type="hidden" name="candidateinterview[question_id]"  value="<?=$candidateinterview->getQuestionId()?>"></td><td><input type="text" name="candidateinterview[response_weight]"  value="<?=$candidateinterview->getResponseWeight()?>"></td><td><?=$interviewsetup->getWeight()?></td><td><textarea name="candidateinterview[remark]"><?=$candidateinterview->getRemark()?></textarea></td></tr>
                

                </table>
                
                <p>
                    <input type="submit" value="<?php echo __("Save Evaluation"); ?>"/>   <input type="button" id="cancel" class="cancel" value="<?php echo __("Cancel"); ?>"/>
                    
                </p>
            </fieldset>
        </form>
    </div>

<?php } ?>
    
</div> <!-- Box -->    
<script type="text/javascript">
   $(document).ready(function() {
   
   $('#cancel').click(function(e) {
         e.preventDefault();
       window.location.replace($("#cancelurl").val());
    });
    

    
    
});

    </script>

