<?php echo stylesheet_tag(plugin_web_path('orangehrmDashboardPlugin', 'css/orangehrmDashboardPlugin.css')); ?>
<style type="text/css">
    .loadmask {
        top:0;
        left:0;
        -moz-opacity: 0.5;
        opacity: .50;
        filter: alpha(opacity=50);
        background-color: #CCC;
        width: 100%;
        height: 100%;
        zoom: 1;
        background: #fbfbfb url("<?php echo plugin_web_path('orangehrmDashboardPlugin', 'images/loading.gif') ?>") no-repeat center;
    }
</style>


<div class="box">
    <div class="head">
        <h1><?php echo __('Dashboard'); ?></h1>
    </div>
    <div class="inner">
        <?php if (count($settings) == 0): ?>
            <div id="messagebar" style="margin-left: 16px;width: 700px;">
                <span style="font-weight: bold;">No Groups are Assigned</span>
            </div>
        <?php endif; ?>
        <?php
        foreach ($settings->getRawValue() as $groupKey => $config):
            ?>
            <div class="outerbox no-border" style="<?php echo isset($config['attributes']['width']) ? "width:" . ($config['attributes']['width'] + 4) . "px;" : "width:auto" ?>">
                <div id="<?php echo "group_" . $groupKey ?>" class="maincontent group-wrapper">
                    <?php
                    if (!empty($config['attributes']['title'])):
                        ?>
                        <div class="mainHeading">
                            <h2 class="paddingLeft"><?php echo $config['attributes']['title']?></h2>
                        </div>
                        <?php
                    endif;
                    ?>
                    <div id="panel_wrapper_<?php echo $groupKey ?>" class="panel_wrapper" style="<?php echo isset($config['attributes']['width']) ? "width:" . ($config['attributes']['width']) . "px;" : "width:auto" ?> <?php echo isset($config['attributes']['height']) ? "height:" . ($config['attributes']['height']) . "px;" : "height:auto"; ?>">
                        <?php foreach ($config['panels'] as $panelKey => $panel): ?>
                            <?php $styleString = isset($panel['attributes']['width']) ? "width:" . $panel['attributes']['width'] . "px;" : ""; ?>
                            <div id="<?php echo "panel_draggable_" . $groupKey . "_" . $panelKey; ?>" class="panel_draggable panel-preview" style="margin:4px <?php echo isset($panel['attributes']['width']) ? "width:" . $panel['attributes']['width'] + 2 . "px;" : "width:auto"; ?> <?php echo isset($panel['attributes']['height']) ? "height:" . $panel['attributes']['height'] + 2 . "px;" : "height:auto"; ?>">
                                <fieldset id="<?php echo "panel_resizable_" . $groupKey . "_" . $panelKey; ?>" class="panel_resizable panel-preview" style="<?php echo $styleString; ?> <?php echo isset($panel['attributes']['height']) ? "height:" . $panel['attributes']['height'] . "px;" : "height:auto"; ?> ">
                                    <legend><?php echo __($panel['name']); ?></legend>
                                    <?php include_component('dashboard', 'ohrmDashboardSection', $panel['attributes']) ?>
                                </fieldset> 
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php
        endforeach;
        ?>
        <input type="hidden"  id="confirmurl" value="<?=  url_for("pim/confirmEmployee?empNumber=")?>">
        <input type="hidden"  id="rejecturl" value="<?=  url_for("pim/rejectEmployee?empNumber=")?>">
        <?php if($isAdmin){ ?>
        <div id="panel_draggable_1_3" class="panel_draggable panel-preview" style="margin:4px 2px; ">
                                <fieldset id="panel_resizable_1_3" class="panel_resizable panel-preview" style="width:350px; height:281px; ">
                                    <legend>Employees On probation</legend>
                                    
    <div class="" style="height: 100%;" id="dashboard__pendingLeaveRequests"><div id="task-list-group-panel-container" class="" style="height:100%; ">
    <div id="task-list-group-panel-menu_holder" class="task-list-group-panel-menu_holder" style="height:85%; overflow-x: hidden; overflow-y: auto;">
        <table class="table hover">
            <tbody>
                <?php if (count($employeesonprobation) <1) { ?>
                           <tr class="odd"><td>No Records are Available</td></tr> 
                      <?php  } else { 
                          foreach ($employeesonprobation as $employee){
                  ?>
                           <tr><td><a href="<?=  url_for('pim/viewEmployee?empNumber='.$employee->getEmpNumber())?>"><?=$employee->getEmpFirstname()." ".$employee->getEmpMiddleName()." ".$employee->getEmpLastname()?></a></td><td><a href="#" class="confirm" id="<?=$employee->getEmpNumber()?>">Confirm</a></td><td><a class="reject" href="#" id="<?=$employee->getEmpNumber()?>">Unsuccessful</a></td></tr>
              <?php }       }?>
                           
                                        
                            </tbody>  
        </table>
    </div>
    <div id="total">
        <table class="table">
            <tbody>
              
                
                <tr class="total">
                <td style="text-align:left;padding-left:20px; cursor: pointer"> 
                     <span title="">Last 6 month(s)</span>                </td>
                <td style="text-align:right;padding-right:20px;"> 
                    Total : <?=  count($employeesonprobation)?>                </td>                
            </tr>
        </tbody></table>
    </div>
</div>

</div>
   
                                </fieldset> 
                            </div>
        
        <div id="panel_draggable_1_3" class="panel_draggable panel-preview" style="margin:4px 2px; ">
                                <fieldset id="panel_resizable_1_3" class="panel_resizable panel-preview" style="width:350px; height:281px; ">
                                    <legend>Employees Probation Unsuccessful</legend>
                                    
    <div class="" style="height: 100%;" id="dashboard__pendingLeaveRequests"><div id="task-list-group-panel-container" class="" style="height:100%; ">
    <div id="task-list-group-panel-menu_holder" class="task-list-group-panel-menu_holder" style="height:85%; overflow-x: hidden; overflow-y: auto;">
            <input type="hidden"  id="terminateurl" value="<?=  url_for("pim/viewJobDetails?empNumber=")?>">
        <table class="table hover">
            <tbody>
                <?php if (count($employeesunsuccessfulprobation) <1) { ?>
                           <tr class="odd"><td>No Records are Available</td></tr> 
                      <?php  } else { 
                          foreach ($employeesunsuccessfulprobation as $employee){
                  ?>
                           <tr><td><a href="<?=  url_for('pim/viewEmployee?empNumber='.$employee->getEmpNumber())?>"><?=$employee->getEmpFirstname()." ".$employee->getEmpMiddleName()." ".$employee->getEmpLastname()?></a></td><td><a href="#" class="terminate" id="<?=$employee->getEmpNumber()?>">Terminate Employee</a></td></tr>
              <?php }       }?>
                           
                                        
                            </tbody>  
        </table>
    </div>
    <div id="total">
        <table class="table">
            <tbody>
              
                
                <tr class="total">
                <td style="text-align:left;padding-left:20px; cursor: pointer"> 
                     <span title="">Last 6 month(s)</span>                </td>
                <td style="text-align:right;padding-right:20px;"> 
                    Total : <?=  count($employeesunsuccessfulprobation)?>                </td>                
            </tr>
        </tbody></table>
    </div>
</div>

</div>
   
                                </fieldset> 
                            </div>
        
        <?php }?>
        <div id="panel_draggable_1_3" class="panel_draggable panel-preview" style="margin:4px 2px; ">
                                <fieldset id="panel_resizable_1_3" class="panel_resizable panel-preview" style="width:350px; height:281px; ">
                             <?php if(!$isAdmin){ ?>
                                    <legend>My Payslips
                                
                                    
                                    
                                    </legend>
                                    
    <div class="" style="height: 100%;" id="dashboard__pendingLeaveRequests"><div id="task-list-group-panel-container" class="" style="height:100%; ">
    <div id="task-list-group-panel-menu_holder" class="task-list-group-panel-menu_holder" style="height:85%; overflow-x: hidden; overflow-y: auto;">
            <input type="hidden"  id="terminateurl" value="<?=  url_for("pim/viewJobDetails?empNumber=")?>">
        <table class="table hover">
            <tbody>
           
                       
               <?php
                              $months= array("01"=>"01","02"=>"02","03"=>"03","04"=>"04","05"=>"05","06"=>"06","07"=>"07","08"=>"08","09"=>"09","10"=>"10","11"=>"11","12"=>"12");
                            
                           foreach ($months as $month) {
                            
                                ?>
                               
                           
                                <tr><td><a href="payroll/generatePayslips?id=<?=$_SESSION['empNumber']?>&month=<?=$month.'/'.date("Y")?>"><?=$month.'/'.date("Y")?>&nbsp;View Slip</a></td></tr>
                               <?php
                                $month++;
                             }
                             
                      
                             ?>
             
                                        
                            </tbody>  
        </table>
    </div>
    <div id="total">
        <table class="table">
            <tbody>
              
                
                <tr class="total">
                <td style="text-align:left;padding-left:20px; cursor: pointer"> 
                     <span title="">Last 6 month(s)</span>                </td>
                <td style="text-align:right;padding-right:20px;"> 
                    Total : <?=  count($employeesunsuccessfulprobation)?>                </td>                
            </tr>
        </tbody></table>
    </div>
            
                             <?php } else {?>
            
               <legend>Recently Vacated Positions</legend>
                                    
    <div class="" style="height: 100%;" id="dashboard__pendingLeaveRequests"><div id="task-list-group-panel-container" class="" style="height:100%; ">
    <div id="task-list-group-panel-menu_holder" class="task-list-group-panel-menu_holder" style="height:85%; overflow-x: hidden; overflow-y: auto;">
         
        <table class="table hover">
            <tbody>
                <?php 
                $count=1;
                                             foreach ($vacancies as $vacancy) { ?>
                <tr><td><?=$count?></td><td style="font-weight:bold"><a target="_blank" href="<?=  url_for('recruitment/addJobVacancy?Id='.$vacancy['id'])?>"><?=$vacancy["name"]?></a></td></tr>        
                                             <?php 
                                             
                                             $count++;
                                             }
                
                
                ?>
               
                       
                                        
                            </tbody>  
        </table>
    </div>
    <div id="total">
        <table class="table">
            <tbody>
              
                
                <tr class="total">
                <td style="text-align:left;padding-left:20px; cursor: pointer"> 
                     <span title="">Last 6 month(s)</span>                </td>
                <td style="text-align:right;padding-right:20px;"> 
                    Total : <?=  count($employeesunsuccessfulprobation)?>                </td>                
            </tr>
        </tbody></table>
    </div>
            
                             <?php }?>
</div>

</div>
   
                                </fieldset> 
                            </div>
        
    </div>
</div>
<div class="modal hide" id="ConfModal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo __('TechSavannaHRM - Confirmation Required'); ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo __("Process probation?"); ?></p>
  </div>
  <div class="modal-footer">
    <input type="button" class="btn" data-dismiss="modal" id="dialogConfirmBtn" value="<?php echo __('Ok'); ?>" />
    <input type="button" class="btn reset" data-dismiss="modal" value="<?php echo __('Cancel'); ?>" />
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".confirm").click(function(e){
            id=$(this).attr("id");
            $("#ConfModal").modal();
            $("#dialogConfirmBtn").click(function(e){
   window.location.replace($("#confirmurl").val()+id);
    }) });
$(".reject").click(function(e){
            id=$(this).attr("id");
            $("#ConfModal").modal();
            $("#dialogConfirmBtn").click(function(e){
   window.location.replace($("#rejecturl").val()+id);
    }); });

$(".terminate").click(function(e){
            id=$(this).attr("id");
            $("#ConfModal").modal();
            $("#dialogConfirmBtn").click(function(e){
   window.location.replace($("#terminateurl").val()+id+"?reason=unsuccessful");
    }) });

    })
    </script>