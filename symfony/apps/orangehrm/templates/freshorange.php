<?php 

// Allow header partial to be overridden in individual actions
// Can be overridden by: slot('header', get_partial('module/partial'));
include_slot('header', get_partial('global/header'));
?>

    </head>
    <body style="background:url('employees.jpg');background-repeat:no_repeat">
      
        <div id="wrapper">
          
            <div id="branding">
                <a href="<?php echo url_for('dashboard/index') ?>"><img src="<?php echo theme_path('images/logo.png')?>"  height="56" alt="TechSavannaHRM "/></a>
                <!--<a href="http://www.techsavanna.technology/user-survey-registration.php" class="subscribe" target="_blank"><?php echo __('Join TechSavannaHRM Community'); ?></a>-->
                <?php
                $organisationdao=new OrganizationDao();
               $organisationinfo= $organisationdao->getOrganizationGeneralInformation();
                $payrollmonth=PayrollMonthTable::getActivePayrollMonth();
        
 $activemonth=@$payrollmonth->getPayrollmonth();?>
                <center ><?=  strtoupper($organisationinfo["name"])?>&nbsp;|&nbsp;<a class="success" href="<?=url_for('payroll/configuration')?>"><?="Payroll Month:&nbsp;".$activemonth;?></a></center> <a href="#" id="welcome" class="panelTrigger"><?php echo __("Welcome %username%", array("%username%" => $sf_user->getAttribute('auth.firstName'))); ?></a>
                <div id="welcome-menu" class="panelContainer">
                    <ul>
                        <li><?php include_component('communication', 'beaconAbout'); ?></li>
                         <li><a href="<?php echo url_for('pim/approvals?pending=true'); ?>"><?php echo __('Pending Approvals'); ?></a></li>
                        <li><a href="<?php echo url_for('admin/changeUserPassword'); ?>"><?php echo __('Change Password'); ?></a></li>
                       
                        <li><a href="<?php echo url_for('auth/logout'); ?>"><?php echo __('Logout'); ?></a></li>
                    </ul>
                </div>
                  <?php include_component('communication', 'beaconNotification'); ?>
<!--                <a href="#" id="help" class="panelTrigger"><?php echo __("Help & Training"); ?></a>
                <div id="help-menu" class="panelContainer">
                    <ul>
                        
                        <li><a href="http://www.techsavanna.technology/support-plans.php?utm_source=application_support&amp;utm_medium=app_url&amp;utm_campaign=orangeapp" target="_blank"><?php echo __('Support'); ?></a></li>
                        <li><a href="http://www.techsavanna.technology/training.php?utm_source=application_traning&amp;utm_medium=app_url&amp;utm_campaign=orangeapp" target="_blank"><?php echo __('Training'); ?></a></li>
                        <li><a href="http://www.techsavanna.technology/addon-plans.shtml?utm_source=application_addons&amp;utm_medium=app_url&amp;utm_campaign=orangeapp" target="_blank"><?php echo __('Add-Ons'); ?></a></li>
                        <li><a href="http://www.techsavanna.technology/customizations.php?utm_source=application_cus&amp;utm_medium=app_url&amp;utm_campaign=orangeapp" target="_blank"><?php echo __('Customizations'); ?></a></li>
                        <li><a href="http://forum.techsavanna.technology/" target="_blank"><?php echo __('Forum'); ?></a></li>
                        <li><a href="http://blog.techsavanna.technology/" target="_blank"><?php echo __('Blog'); ?></a></li>
                        <li><a href="http://sourceforge.net/apps/mantisbt/orangehrm/view_all_bug_page.php" target="_blank"><?php echo __('Bug Tracker'); ?></a></li>                        
                    </ul>
                </div>-->
            </div> <!-- branding -->      
            
            <?php include_component('core', 'mainMenu'); ?>
   <ul id="tabs">
            <!-- Tabs go here -->
        </ul>
            <div id="content">

                  <?php echo $sf_content ?>

            </div> <!-- content -->
          
        </div> <!-- wrapper -->
        
        <div id="footer">
            <?php include_partial('global/copyright');?>
        </div> <!-- footer -->        
        
        
<?php include_slot('footer', get_partial('global/footer'));?>