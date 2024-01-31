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
use_javascript(plugin_web_path('orangehrmAdminPlugin', 'js/viewCustomersSuccess')); 
?>
<?php if($customerPermissions->canRead()){?>
<div id="customerList">
    <?php include_component('core', 'ohrmList', $parmetersForListCompoment); ?>
</div>
<?php }?>
<form name="frmHiddenParam" id="frmHiddenParam" method="post" action="<?php echo url_for('admin/viewCustomers'); ?>">
                <input type="hidden" name="pageNo" id="pageNo" value="<?php //echo $form->pageNo;   ?>" />
                <input type="hidden" name="hdnAction" id="hdnAction" value="search" />
</form>

<!-- Confirmation box HTML: Begins -->
<div class="modal hide" id="deleteConfModal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo __('TechSavannaHRM - Confirmation Required'); ?></h3>
  </div>
  <div class="modal-body">
      <p><?php echo __("Projects under selected customer will also be deleted"); ?></p>
      <br/>
    <p><?php echo __(CommonMessages::DELETE_CONFIRMATION); ?></p>
  </div>
  <div class="modal-footer">
    <input type="button" class="btn" data-dismiss="modal" id="dialogDeleteBtn" value="<?php echo __('Ok'); ?>" />
    <input type="button" class="btn reset" data-dismiss="modal" value="<?php echo __('Cancel'); ?>" />
  </div>
</div>
<!-- Confirmation box HTML: Ends -->

<script type="text/javascript">
	function submitPage(pageNo) {

                    document.frmHiddenParam.pageNo.value = pageNo;
                    document.frmHiddenParam.hdnAction.value = 'paging';
                    document.getElementById('frmHiddenParam').submit();

                }
	var addCustomerUrl = '<?php echo url_for('admin/addCustomer'); ?>';
</script>
