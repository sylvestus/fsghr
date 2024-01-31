<?php
$imagePath = theme_path("images/login");
?>
<style type="text/css">

    body {
       
		background-image:url('employees.jpg') !important;
		background-repeat:no_repeat;
        height: 700px;
    }

    img {
        border: none;
    }
    #btnLogin {
        padding: 0;
    }
    input:not([type="image"]) {
        background-color: transparent;
        border: none;
    }

    input:focus, select:focus, textarea:focus {
        background-color: transparent;
        border: none;
    }

    .textInputContainer {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #666666;
    }

    #divLogin {
        background: transparent url(<?php echo "{$imagePath}/login.png"; ?>) no-repeat center top;
        height: 520px;
        width: 100%;
        border-style: hidden;
        margin: auto;
        padding-left: 10px;
    }

    #divUsername {
        padding-top: 153px;
        padding-left: 50%;
    }

    #divPassword {
        padding-top: 35px;
        padding-left: 50%;
    }

    #txtUsername {
        width: 240px;
        border: 0px;
        background-color: transparent;
    }

    #txtPassword {
        width: 240px;
        border: 0px;
        background-color: transparent;
    }

    #txtUsername, #txtPassword {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #666666;
        vertical-align: middle;
        padding-top:0;
    }
    
    #divLoginHelpLink {
        width: 270px;
        background-color: transparent;
        height: 20px;
        margin-top: 12px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 50%;
    }

    #divLoginButton {
        padding-top: 2px;
        padding-left: 49.3%;
        float: left;
        width: 350px;
    }

    #btnLogin {
        background: url(<?php echo "{$imagePath}/Login_button.png"; ?>) no-repeat;
        cursor:pointer;
        width: 94px;
        height: 26px;
        border: none;
        color:#FFFFFF;
        font-weight: bold;
        font-size: 13px;
    }

    #divLink {
        padding-left: 230px;
        padding-top: 105px;
        float: left;
    }

    #divLogo {
        padding-left: 30%;
        padding-top: 70px;
    }

    #spanMessage {
        background: transparent url(<?php echo "{$imagePath}/mark.png"; ?>) no-repeat;
        padding-left: 18px; 
        padding-top: 0px;
        color: #DD7700;
        font-weight: bold;
    }
    
    #logInPanelHeading{
        position:absolute;
        padding-top:100px;
        padding-left:49.5%;
        font-family:sans-serif;
        font-size: 15px;
        color: #544B3C;
        font-weight: bold;
    }
    
    .form-hint {
    color: #878787;
    padding: 4px 8px;
    position: relative;
    left:-254px;
}

.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
  display:none;
  position:absolute;
  top: 50%;
  left: 50%
  z-index:999;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
    
</style>

<div id="divLogin">
    <div id="divLogo">
        <!--<img src="<?php echo "{$imagePath}/logo.png"; ?>" />-->
        <br><br><br><br><br>
    </div>

    <form id="frmLogin" method="post" action="<?php echo url_for('auth/validateCredentials'); ?>">
        <input type="hidden" name="actionID"/>
        <input type="hidden" name="hdnUserTimeZoneOffset" id="hdnUserTimeZoneOffset" value="0" />
        <?php 
            echo $form->renderHiddenFields(); // rendering csrf_token 
        ?>
        <div id="logInPanelHeading"><?php
        //"katangi"=>"DIMITZI LTD","grandways"=>"Grandways Ventures Ltd","fulchand"=>"FULACHAND RASHI LTD"
        $companies=array("shiloah"=>"DEFAULT");
        //echo __('LOGIN Panel-SHILOAHMEGA'); ?>
            <select id="company" name="company" style="width:content-box">
                <!--<option selected="selected" value="">Select Company</option>-->
                <?php
                foreach ($companies as $key=>$value) { ?>
                <option value="<?=$key?>"><?=$value?></option>    
              <?php  }
                ?>
            </select>
        </div>

        <div id="divUsername" class="textInputContainer">
            <?php echo $form['Username']->render(); ?>
          <span class="form-hint" ><?php echo __('Username'); ?></span> 
        </div>
        <div id="divPassword" class="textInputContainer">
            <?php echo $form['Password']->render(); ?>
         <span class="form-hint" ><?php echo __('Password'); ?></span>
         <br>      <br>      <br>
         <select id="payrollmonth" name="payrollmonth" style="width:140px" >
             <option value="<?=date("m")?>" selected="selected"><?=date("m")?></option>      
                             <?php
                              $months= array("01"=>"01","02"=>"02","03"=>"03","04"=>"04","05"=>"05","06"=>"06","07"=>"07","08"=>"08","09"=>"09","10"=>"10","11"=>"11","12"=>"12");
                           foreach ($months as $month) {
                            
                                
                                 echo '<option value="'.$month.'">'.$month.'</option>';
                                 $month++;
                             }
                             
                             
                             ?>
                          </select>
         <select id="payrollyear" name="payrollyear" style="width:140px" >
                  <option value="<?=date("Y")?>" selected="selected"> <?=date("Y")?></option>  
                             <?php
                           $year=2000; $i=2030;
                             while ($year<=$i) {
                            
                                
                                 echo '<option value="'.$year.'">'.$year.'</option>';
                                 $year++;
                             }
                             
                             
                             ?>
                          </select>
        </div>
        <div id="payrollmonth" class="textInputContainer">
             
            
        </div>
        <div id="divLoginHelpLink"><?php
            include_component('core', 'ohrmPluginPannel', array(
                'location' => 'login-page-help-link',
            ));
            ?></div>
        <div id="divLoginButton">
            <input type="submit" name="Submit" class="button" id="btnLogin" value="<?php echo __('LOGIN'); ?>" />
            <?php if (!empty($message)) : ?>
            <span id="spanMessage"><?php echo __($message); ?></span>
            <?php endif; ?>
        </div>
    </form>

	
</div>
<div class="loader"></div>

<div style="text-align: center">
    <?php include_component('core', 'ohrmPluginPannel', array(
                'location' => 'other-login-mechanisms',
            )); ?>
</div>

<?php include_partial('global/footer_copyright_social_links'); ?>

<script type="text/javascript">
    
    function calculateUserTimeZoneOffset() {
        var myDate = new Date();
        var offset = (-1) * myDate.getTimezoneOffset() / 60;
        return offset;
    }
            
    function addHint(inputObject, hintImageURL) {
        if (inputObject.val() == '') {
            inputObject.css('background', "url('" + hintImageURL + "') no-repeat 10px 3px");
        }
    }
            
    function removeHint() {
       $('.form-hint').css('display', 'none');
    }
    
    function showMessage(message) {
        if ($('#spanMessage').size() == 0) {
            $('<span id="spanMessage"></span>').insertAfter('#btnLogin');
        }

        $('#spanMessage').html(message);
    }
    
    function validateLogin() {
        var isEmptyPasswordAllowed = false;
        
        if ($('#txtUsername').val() == '') {
            showMessage('<?php echo __('Username cannot be empty'); ?>');
            return false;
        }
        
        if (!isEmptyPasswordAllowed) {
            if ($('#txtPassword').val() == '') {
                showMessage('<?php echo __('Password cannot be empty'); ?>');
                return false;
            }
        }
        
        return true;
    }
    
    $(document).ready(function() {
        /*Set a delay to compatible with chrome browser*/
        setTimeout(checkSavedUsernames,100);
        
        $('#txtUsername').focus(function() {
            removeHint();
        });
        
        $('#txtPassword').focus(function() {
             removeHint();
        });
        
        $('.form-hint').click(function(){
            removeHint();
            $('#txtUsername').focus();
        });
        
        $('#hdnUserTimeZoneOffset').val(calculateUserTimeZoneOffset().toString());
        
        $('#frmLogin').submit(validateLogin);
        
    });

    function checkSavedUsernames(){
        if ($('#txtUsername').val() != '') {
            removeHint();
        }
    }

    if (window.top.location.href != location.href) {
        window.top.location.href = location.href;
    }
</script>