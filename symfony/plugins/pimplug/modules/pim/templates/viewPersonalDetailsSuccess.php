<?php 
use_stylesheet(plugin_web_path('orangehrmPimPlugin', 'css/viewPersonalDetailsSuccess.css'));
use_stylesheet(plugin_web_path('orangehrmPimPlugin', 'css/select2.css'));
//use_stylesheet(plugin_web_path('orangehrmPimPlugin', 'css/bootstrap.min.css'));
use_javascript('select2/select2.min.js');
?>
<style>
    input[type="date"], input[type="time"], input[type="datetime-local"], input[type="month"] {
    /* line-height: 34px; */
    line-height:1;
}
.select2 {
    border:1px solid green;
}
.select2-results__options{
    background-color: lightgreen;
    line-height:1.5;
    font-family:roboto,arial;
    color:purple;
    font-weight:bold;
}
    </style>

<div class="box pimPane" id="employee-details">
    
    <?php echo include_component('pim', 'pimLeftMenu', array('empNumber'=>$empNumber, 'form' => $form));
    $configuration=  OhrmPayrollconfigTable::getConfig();
    ?>
    
    <div class="personalDetails" id="pdMainContainer">
        <div class="inner">
        

    </div>
        <div class="head">
            <h1><?php echo __('Personal Details')?> <?php if($employeestatus=="pending"){echo "<span style='color:orange'>&nbsp; New Employee approval ".$employeestatus."</span> <style> form ol li label{color:orange !important}</style>";}; ?>
                        <select name="userselect" id="select2"  style="display:none" > </select>
  
            </h1>
         <div id="notification" style="color:green;z-index:1000;margin-top:100px;position:absolute;text-align:center"></div>
               
        </div> <!-- head -->
    
        <div class="inner">

            <?php if ($personalInformationPermission->canRead()) : ?>

            <?php include_partial('global/flash_messages', array('prefix' => 'personaldetails')); ?>
<?php $empdetails=  EmployeeDao::getEmployeeByNumber($empNumber)?>
            <form id="frmEmpPersonalDetails" method="post" enctype="multipart/form-data" action="<?php echo url_for('pim/viewPersonalDetails'); ?>">

                <?php echo $form['_csrf_token']; ?>
                <?php echo $form['txtEmpID']->render(); ?>

                <fieldset>
                    <!--
                    <div class="helpLabelContainer">
                        <div><label>First Name</label></div>
                        <div><label>Middle Name</label></div>
                        <div><label>Last Name</label></div>
                    </div>
                    -->
                    <ol>
                        <li class="line nameContainer">
                            <label for="Full_Name" class="hasTopFieldHelp"><?php echo __('Full Name'); ?></label>
                            <ol class="fieldsInLine">
                                <li>
                                    <div class="fieldDescription"><em>*</em> <?php echo __('First Name'); ?></div>
                                    <?php echo $form['txtEmpFirstName']->render(array("class" => "block default editable", "maxlength" => 30, "title" => __('First Name'))); ?>
                                </li>
                                <li>
                                    <div class="fieldDescription"><?php echo __('Middle Name'); ?></div>
                                    <?php echo $form['txtEmpMiddleName']->render(array("class" => "block default editable", "maxlength" => 30, "title" => __('Middle Name'))); ?>
                                </li>
                                <li>
                                    <div class="fieldDescription"><em>*</em> <?php echo __('Last Name'); ?></div>
                                    <?php echo $form['txtEmpLastName']->render(array("class" => "block default editable", "maxlength" => 30, "title" => __('Last Name'))); ?>
                                </li>
                                 <li>
                                    <div class="fieldDescription"><em>*</em> <?php echo __('Signature ('.$empdetails->fingerprintype.')'); ?></div>
                                 <?php
                            echo '<img src="data:image/jpeg;base64,'.base64_encode($empdetails->getFingerprint()).'" alt="Employee fingerprint"   height="100" width="150"/>';
                                   ?>
                                </li>
                            </ol>    
                        </li>
                    </ol>
                    <ol>
                        <li>
                            <label for="personal_txtEmployeeId"><?php echo __('Employee ID/Payroll No'); ?></label>
                            <?php echo $form['txtEmployeeId']->render(array("maxlength" => 10, "class" => "editable")); ?>
                        </li>
                        <li>
                            <label for="personal_txtOtherID"><?php echo __('PIN NO'); ?></label>
                            <?php echo $form['txtOtherID']->render(array("maxlength" => 30, "class" => "editable")); ?>
                        </li>
                        <li class="long">
                            <label for="personal_txtLicenNo"><?php echo __("ID/Passport No"); ?></label>
                            <?php echo $form['txtLicenNo']->render(array("maxlength" => 30, "class" => "editable")); ?>
                        </li>
                        <li>
                            <label for="personal_txtLicExpDate"><?php echo __('ID/Passport  Expiry Date'); ?></label>
                            <?php echo $form['txtLicExpDate']->render(array("class"=>"calendar editable")); ?>
                        </li>
                        
                       <!-- <li class="push-right">
                            <label for="onprobation"><?php echo __('On Probation'); ?></label>
                            <select name="personal[on_probation]" class="editable" disabled="disabled">
                                <option value="1">YES</option>
                                           <option value="0">NO</option>
                            </select> -->
                        </li>
                 
                       <!-- <li class="new">
                            <label for="personal_txtNICNo"><?php echo __('NSSF Number'); ?></label>
                            <?php echo $form['txtNICNo']->render(array("class" => "editable", "maxlength" => 30)); ?>
                        </li>                    
                     
                      
                        <li class="<?php echo !($showSSN)?'new':''; ?>">
                            <label for="personal_txtSINNo"><?php echo __('NHIFNumber'); ?></label>
                            <?php echo $form['txtSINNo']->render(array("class" => "editable", "maxlength" => 30)); ?>
                        </li>  -->                  
                        
                    </ol>
                    <ol>
                        <li class="radio">
                            <label for="personal_optGender"><?php echo __("Gender"); ?></label>
                            <?php echo $form['optGender']->render(array("class"=>"editable")); ?>
                        </li>
                        <li>
                            <label for="personal_cmbMarital"><?php echo __('Marital Status'); ?></label>
                            <?php echo $form['cmbMarital']->render(array("class"=>"editable")); ?>
                        </li>
                        <li class="new">
                            <label for="personal_cmbNation"><?php echo __("Nationality"); ?></label>
                            <?php echo $form['cmbNation']->render(array("class"=>"editable")); ?>
                        </li>
                        <li>
                            <label for="personal_DOB"><?php echo __("Date of Birth"); ?></label>
                            <?php echo $form['DOB']->render(array("class"=>"editable")); ?>
                        </li>
                        <li>
                            <?php echo $form['emp_mobile']->renderLabel(__("Mobile")); ?>
                            <?php echo $form['emp_mobile']->render(array("class" => "editable", "maxlength" => 25,"value"=>$empdetails->emp_mobile)); ?>
                        </li>
                        <li>
                            <?php echo $form['emp_work_telephone']->renderLabel(__("Work Telephone")); ?>
                            <?php echo $form['emp_work_telephone']->render(array("class" => "editable", "maxlength" => 25,"value"=>$empdetails->emp_work_telephone)); ?>
                        </li>
                    </ol>
                    <ol>
                        <li>
                            <?php echo $form['emp_work_email']->renderLabel(__("Work Email")); ?>
                            <?php echo $form['emp_work_email']->render(array("class" => "editable", "maxlength" => 50,"value"=>$empdetails->emp_work_email)); ?>
                        </li>
                        <li>
                            <?php echo $form['emp_oth_email']->renderLabel(__("Other Email")); ?>
                            <?php echo $form['emp_oth_email']->render(array("class" => "editable", "maxlength" => 50,"value"=>$empdetails->emp_oth_email)); ?>
                        </li>
                         <li class="edit">
                            <label for="approvalfile"><?php echo __("Approval File"); ?></label>
                            <?php echo $form['fileApprove']->render(array("class"=>"editable")); ?>
                        </li>
                        <?php if(!$showDeprecatedFields) : ?>
                        <li class="required new">
                            <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                        </li>
                        <?php endif; ?>
                    </ol>    
                    <?php if($showDeprecatedFields) : ?>    
                    <ol>
                       <!-- <li>
                            <label for="personal_txtEmpNickName"><?php echo __("Nick Name"); ?></label>
                            <?php echo $form['txtEmpNickName']->render(array("maxlength" => 30, "class" => "editable")); ?>
                        </li>-->
                        <li>
                            <label for="personal_chkSmokeFlag"><?php echo __('Pensionable'); ?></label>
                            <?php echo $form['chkSmokeFlag']->render(array("class" => "editable")); ?>
                        </li>
                        
                        <li class="required new">
                            <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                        </li>     
                        
                    </ol>
                    <?php endif; ?>                        

                    <?php  if ($personalInformationPermission->canUpdate()) : ?>
                    <p><input type="button" id="btnSave" value="<?php echo __("Edit"); ?>" />
                   </p>
                   
                    <?php endif; ?>

                </fieldset>
            </form>
            <fieldset title="Print Card" style="float:right">
                <form action="<?=url_for('pim/employeeCard?id='.$empNumber)?>" method="GET" enctype="multipart/form-data" id="printcardform" > <label>Approve Card Printing<input id="printcardapprove" type="file" name="printapprove"></label>
                    <input type="date" name="issue_date" id="issue_date" value="<?=date("Y-m-d")?>" placeholder="Issue Date">
                    <input type="number" name="expiry_date" id="expiry_date" value="2" placeholder="Expiry Date">
                    <select name="color" id="color"><option value="green">Green</option><option value="yellow">Yellow</option><option value="blue">Blue</option></select> 
                    <select name="printmode" id="printmode"><option value="download">Download</option><option value="print"  <?php if($configuration->manual_cardprint){?> selected="selected"<?php }?>>Print</option></select> 
                        <?php if($empdetails->getFingerprint()&&$empdetails->employee_id &&$empdetails->fingerprint){?><input type="submit" class="btn btn-success push-right" id="printcard" value="Print Card"><?php } else{?><span style="color:red">Check Photo,Fingerprint,ID,Grade,MDA and Title </span> <?php }?>
                <?php if(!$configuration->manual_cardprint){?>
                    <input type="text" name="empids" id="empids" style="width:90%" placeholder="Selected Employees">      
                <?php }?>
                </form></fieldset>
            <?php else : ?>
            <div><?php echo __(CommonMessages::RESTRICTED_SECTION); ?></div>
            <?php endif; ?>

        </div> <!-- inner -->
        
    </div> <!-- pdMainContainer -->

    
    <?php echo include_component('pim', 'customFields', array('empNumber'=>$empNumber, 'screen' => CustomField::SCREEN_PERSONAL_DETAILS));?>
    <?php //echo include_component('pim', 'attachments', array('empNumber'=>$empNumber, 'screen' => EmployeeAttachment::SCREEN_PERSONAL_DETAILS));?>
    
</div> <!-- employee-details -->
 
<?php //echo stylesheet_tag('orangehrm.datepicker.css') ?>
<?php //echo javascript_include_tag('orangehrm.datepicker.js')?>

<script type="text/javascript">
    //<![CDATA[
    //we write javascript related stuff here, but if the logic gets lengthy should use a seperate js file
    var edit = "<?php echo __("Edit"); ?>";
    var save = "<?php echo __("Save"); ?>";
    var lang_firstNameRequired = "<?php echo __(ValidationMessages::REQUIRED); ?>";
    var lang_lastNameRequired = "<?php echo __(ValidationMessages::REQUIRED); ?>";
    var lang_selectGender = "<?php echo __(ValidationMessages::REQUIRED); ?>";
    var lang_processing = '<?php echo __(CommonMessages::LABEL_PROCESSING);?>';
    var lang_invalidDate = '<?php echo __(ValidationMessages::DATE_FORMAT_INVALID, array('%format%' => str_replace('yy', 'yyyy', get_datepicker_date_format($sf_user->getDateFormat())))) ?>';
    var datepickerDateFormat = '<?php echo get_datepicker_date_format($sf_user->getDateFormat()); ?>';

    var fileModified = 0;
    
    var readOnlyFields = <?php echo json_encode($form->getReadOnlyWidgetNames());?>
    
    
    var data =<?php echo file_get_contents(sfConfig::get("sf_web_dir")."/employees.json");?> //[{ id: 0, text: 'item1' }, { id: 1, text: 'item2' }];
  
          // Dump all data of the Object in the console
 // alert(data[0]["employee_id"]); // 
    $("#select2").select2({
  data: data
});
<?php if($configuration->manual_cardprint) { //if manual mode,reload page
    ?>
$("#select2").on("change", function (e) { 
  var select_val = $(e.currentTarget).val();
  //alert(select_val);
  window.location.replace("<?=url_for('pim/viewEmployee?empNumber=')?>"+select_val);
});
<?php } else{ //else append empid to input ?>
 $("#select2").on("change", function (e) { 
  var select_val = $(e.currentTarget).val();
  var currentvalue=$("#empids").val()
$("#empids").val(currentvalue+select_val+","); 
$("#notification").html("Employee ID# "+select_val+" queued");
 });
 //prevent default form action
 $("#printcard").click(function(e){
     e.preventDefault();
   $('#printcardform').submit(function (evt) {
    evt.preventDefault();
    //window.history.back();
});  
selectedemployees=$("#empids").val();
var array = selectedemployees.split(',');
array.forEach(function (empid, index) {
    if(empid){
  window.open('<?=url_for('pim/employeeCard')?>'+"?id="+empid+"&color="+$("#color").val()+"&issue_date="+$("#issue_date").val()+"&expiry_date="+$("#expiry_date").val()+"&printmode="+$("#printmode").val());
  }
});
 })
 
 
<?php }?>
    //]]>
</script>

<?php echo javascript_include_tag(plugin_web_path('orangehrmPimPlugin', 'js/viewPersonalDetailsSuccess')); ?>
