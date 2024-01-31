<?php
use_javascript(plugin_web_path('orangehrmAdminPlugin', 'js/systemUserSuccess')); 
use_javascript(plugin_web_path('orangehrmAdminPlugin', 'js/password_strength')); 
?>
<style>
    form ol li select {
    float: left;
    width: 239px;
    height:40px;
    margin-top: 1px;
    padding: 3px 6px;
}
    </style>
<div id="systemUser" class="box">
    <table><tr>
            <td width="60%">
    <div class="head">
        <h1 id="UserHeading"><?php echo __("Add User"); ?></h1>
    </div>
        
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>

        <form name="frmSystemUser" id="frmSystemUser" method="post" action="" >

            <fieldset>
                
                <ol>
                    <?php echo $form->render(); ?>
                    
                    <li class="required">
                        <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                    </li>
                </ol>
                
                <p>
                    <input type="button" class="addbutton" name="btnSave" id="btnSave" value="<?php echo __("Save"); ?>"/>
                    <input type="button" class="reset" name="btnCancel" id="btnCancel"value="<?php echo __("Cancel"); ?>"/>
                </p>
                
            </fieldset>

        </form>
        
    </div>
            </td><td>
                <div style="max-height:450px;overflow-y:scroll;overflow-x:no-display">
                <table width="100%">
                    <tr><td style="font-weight:bold">Screen</td><td style="font-weight:bold">View</td><td style="font-weight:bold">Create</td><td style="font-weight:bold">Update</td><td style="font-weight:bold">Delete</td></tr>
                    <?php foreach ($roles as $value) {
                        $screenname= OhrmScreenTable::getScreenName($value["screen_id"]);
                        if($value["can_read"]){$checkedcanread="checked='checked'";}else{$checkedcanread=0;}
                         if($value["can_create"]){$checkedcancreate="checked='checked'";}else{$checkedcancreate=0;}
                             if($value["can_update"]){$checkedcanupdate="checked='checked'";}else{$checkedcanupdate=0;}
                              if($value["can_delete"]){$checkedcandelete="checked='checked'";}else{$checkedcandelete=0;}
                        ?>
                    <tr><td><?=$screenname?></td><td><input class="can_read" title="<?=$value["id"]?>" type="checkbox" <?=$checkedcanread?>  value="<?=$value['can_read']?>"/></td><td><input class="can_create" title="<?=$value["id"]?>" type="checkbox" <?=$checkedcancreate?> value="<?=$value['can_create']?>"/></td><td><input class="can_update" title="<?=$value["id"]?>" <?=$checkedcanupdate?>  type="checkbox" value="<?=$value['can_update']?>"/></td><td><input class="can_delete" title="<?=$value["id"]?>" <?=$checkedcandelete?> type="checkbox" value="<?=$value['can_delete']?>"/></td></tr> 
                   <?php }?>
                    
                    
                </table>       
                </div>
                
            </td>
        </tr> </table>  
</div>

<script type="text/javascript">
	
    var user_UserNameRequired       = '<?php echo __(ValidationMessages::REQUIRED); ?>';
    var user_EmployeeNameRequired   = '<?php echo __(ValidationMessages::REQUIRED); ?>';
    var user_ValidEmployee          = '<?php echo __(ValidationMessages::INVALID); ?>';
    var user_UserPaswordRequired    = '<?php echo __(ValidationMessages::REQUIRED); ?>';
    var user_UserConfirmPassword    = '<?php echo __(ValidationMessages::REQUIRED); ?>';
    var user_samePassword           = "<?php echo __("Passwords do not match"); ?>";
    var user_Max20Chars             = '<?php echo __(ValidationMessages::TEXT_LENGTH_EXCEEDS, array('%amount%' => 20)); ?>';
    var user_editLocation           = "<?php echo __("Edit User"); ?>";
    var userId                      = "<?php echo $userId ?>";
    var user_save                   = "<?php echo __("Save"); ?>";
    var user_edit                   = "<?php echo __("Edit"); ?>";
    var user_typeForHints           = "<?php echo __("Type for hints").'...';?>";
    var user_name_alrady_taken      = '<?php echo __(ValidationMessages::ALREADY_EXISTS); ?>';
    var isUniqueUserUrl             = '<?php echo url_for('admin/isUniqueUserJson'); ?>';
    var viewSystemUserUrl           = '<?php echo url_for('admin/viewSystemUsers'); ?>';
    var user_UserNameLength         = '<?php echo __("Should have at least %number% characters", array('%number%' => 5)); ?>';
    var user_UserPasswordLength     = '<?php echo __("Should have at least %number% characters", array('%number%' => 4)); ?>';
    var password_user               = "<?php echo __("Very Weak").",".__("Weak").",".__("Better").",".__("Medium").",".
            __("Strong").",".__("Strongest")?>";
    var isEditMode                  = '<?php echo ($form->edited)?'true':'false'; ?>';
    var ldapInstalled               = '<?php echo ($sf_user->getAttribute('ldap.available'))?'true':'false'; ?>';
    var validator = null;
    var openIdEnabled = "<?php echo $openIdEnabled; ?>";
    
$('input[type=checkbox]').click(function() {
     var id=$(this).attr("title");
     var permission=$(this).attr("class");
     var status=0;
    if($(this).is(':checked')) 
    {
       status=1;
      
       } else{
       status=0;
       }
       
         $.ajax({
       type: "POST",
       url: '<?php echo url_for('admin/savePermission');?>',
       data: {"id":id,"permission":permission,"status":status},
       //dataType: 'json',       
         success: function(data) {
          alert(data);
      
         }
       });
       });
       

</script>
