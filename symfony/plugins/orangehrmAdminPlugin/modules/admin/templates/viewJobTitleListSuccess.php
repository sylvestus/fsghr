<?php
/**
 * TechSavannaHRM Enterprise is a closed sourced comprehensive Human Resource Management (HRM)
 * System that captures all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 TechSavannaHRM Inc., http://www.techsavanna.technology
 *
 * TechSavannaHRM Inc is the owner of the patent, copyright, trade secrets, trademarks and any
 * other intellectual property rights which subsist in the Licensed Materials. TechSavannaHRM Inc
 * is the owner of the media / downloaded TechSavannaHRM Enterprise software files on which the
 * Licensed Materials are received. Title to the Licensed Materials and media shall remain
 * vested in TechSavannaHRM Inc. For the avoidance of doubt title and all intellectual property
 * rights to any design, new software, new protocol, new interface, enhancement, update,
 * derivative works, revised screen text or any other items that TechSavannaHRM Inc creates for
 * Customer shall remain vested in TechSavannaHRM Inc. Any rights not expressly granted herein are
 * reserved to TechSavannaHRM Inc.
 *
 * You should have received a copy of the TechSavannaHRM Enterprise  proprietary license file along
 * with this program; if not, write to the TechSavannaHRM Inc. 538 Teal Plaza, Secaucus , NJ 0709
 * to get the file.
 *
 */
?>

<?php 
use_javascript(plugin_web_path('orangehrmAdminPlugin', 'js/viewJobTitleListSuccess')); 
?>
<?php if($jobTitlePermissions->canRead()){?>
<div id="jobTitleList">
    <form name="jotitlesearch" style="padding-top:5px;margin-left:30px;float:right;z-index:999;position:fixed" method="post" action="<?php echo url_for('admin/viewJobTitleList'); ?>">
        <input type="text" name="jobTitle" value="<?=$_POST["jobTitle"]?>" placeholder="Job Title">
        <input type="text" name="jobDescription" value="<?=$_POST["jobDescriptio"]?>" placeholder="Job Description">
        <input type="submit" value="Search" class="greenselect">
    </form>
    <?php include_component('core', 'ohrmList', $parmetersForListCompoment); ?>
</div>
<?php }?>
<!-- comment dialog -->

<div id="commentDialog" title="<?php echo __('Job Description'); ?>" style="display: none">
    <form action="updateComment" method="post" id="frmCommentSave">
        <input type="hidden" id="leaveId" />
        <input type="hidden" id="leaveOrRequest" />
        <textarea name="leaveComment" id="leaveComment" cols="40" rows="10" class="commentTextArea"></textarea>
        <br class="clear" />
        <div><input type="button" id="commentCancel" class="plainbtn" value="<?php echo __('Cancel'); ?>" /></div>
    </form>
</div>

<form name="frmHiddenParam" id="frmHiddenParam" method="post" action="<?php echo url_for('admin/viewJobTitleList'); ?>">
    <input type="hidden" name="pageNo" id="pageNo" value="<?php //echo $form->pageNo;   ?>" />
  
    <input type="button" class="greenselect" name="hdnAction" id="hdnAction" value="search" />
</form>

<!-- end of comment dialog-->

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
    var addJobTitleUrl = '<?php echo url_for('admin/saveJobTitle'); ?>';
    function submitPage(pageNo) {

                    document.frmHiddenParam.pageNo.value = pageNo;
                    document.frmHiddenParam.hdnAction.value = 'paging';
                    document.getElementById('frmHiddenParam').submit();

                }
</script>
