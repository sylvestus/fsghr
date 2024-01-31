 <?php include_partial('global/flash_messages'); ?>
<div class="box pimPane">
               
    <?php echo include_component('pim', 'pimLeftMenu', array('empNumber'=>$empNumber, 'form' => $form));?>
    <?php $employeedetail= EmployeeDao::getEmployeeByNumber($empNumber);
    $names=$employeedetail->getEmpFirstname()." ".$employeedetail->getEmpMiddleName()." ".$employeedetail->getEmpLastname();
    $address=  strtoupper($employeedetail->getEmpStreet1());
    $nationalid=$employeedetail->getEmpDriLiceNum();
     $organization=  new OrganizationDao();
         $organizationinfo=$organization->getOrganizationGeneralInformation();
         $company=$organizationinfo->getName();
    $joineddate=$employeedetail->getJoinedDate();
    $dob=$employeedetail->getEmpBirthday();
    $salary=HsHrEmpBasicsalaryTable::getEmpBasicSalary($empNumber);  
    $jobtitledao= new JobTitleDao();
    if($employeedetail->getJobTitleCode()){
    $title=$jobtitledao-> getJobTitleById($employeedetail->getJobTitleCode());
    $tile=$title->getJobTitle();
    }else{
        $title="Not Specified";
    }
    
    ?>
    
  <?php
  $root="http://".$_SERVER['HTTP_HOST']."/ohrm";
  $documents=array("academic_and_proffesional_certificates"=>"Academic and Proffessional Certificates","copy_of_id"=>"Copy Of ID Card","passport_photo"=>"2 Colored Passport Size Photos","nssf_card"=>"Copy Of NSSF Card","nhif_card"=>"Copy Of NHIF Card","kra_pin"=>"Copy Of KRA PIN","good_conduct"=>"Certificate Of Good Conduct","salary_details"=>"Salary Remittance Bank Account Details","guarantor"=>"Guarantors")
  ?>
  
    
    <div class="miniList" id="salaryMiniList">
        <div class="head">
            <h1><?php echo __("Employee Documents"); ?></h1>
        </div>
        
        <div class="inner">
            <input type="hidden" value="<?=$empNumber?>" id="empnumber">
              <input type="hidden" id="documentsaveurl" value="<?=  url_for("pim/saveDocument")?>">
           
               <!-- <table id="tblSalary" class="table hover">
                    <thead>
                        <tr>
                          
                            <th class="component"><?php echo __('#'); ?></th>
                            <th class="payperiod"><?php echo __('Document Name'); ?></th>
                             <th class="payperiod"><?php echo __('Remarks'); ?></th>
                                <th class="payperiod"><?php echo __('Current Status'); ?></th>
                            <th class="currency"><?php echo __('Action'); ?></th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count=1;
                          foreach ($documents as $key => $value) { 
                              $docchecklist=  DocumentsChecklistTable::getDocumentChecklist($key,$empNumber);
                              if($docchecklist->status==1){
                                  $status="Available";
                              }
 else {$status="Not Availabe";}
                              ?>
                              
                        <tr><td><?=$count?></td><td><?=$value?></td><td><textarea style="width:100%" name="remarks" id="remarks<?=$count?>"><?=$docchecklist->remarks?></textarea></td><td><?=$status?></td><td><a class="documentaccept" tabindex="<?=$count?>" id="document<?=$count?>" title="<?=$key?>" href="#" >Confirm</a>&nbsp;|&nbsp;<a class="documentrevoke" tabindex="<?=$count?>" id="document<?=$count?>" title="<?=$key?>" href="#" >Not Available</a></td></tr>  
          
                        <?php
                        
                                      $count++;
                          }
                        ?>
                        
                                            </tbody>
                                        </table> -->
                          
          
        </div>
       <?php
    echo include_component('pim', 'customFields', array('empNumber'=>$empNumber, 'screen' => CustomField::SCREEN_DEPENDENTS));
    echo include_component('pim', 'attachments', array('empNumber'=>$empNumber, 'screen' => EmployeeAttachment::SCREEN_DEPENDENTS));
    ?> 
        
        
    </div> <!-- miniList-salaryMiniList -->
    <script type="text/javascript">
        $(document).ready(function(e){
          $(".documentaccept").click(function(e){
              var count=$(this).attr("tabindex");
            var docname=$(this).attr("title"); 
            var employee=$("#empnumber").val();
           var remarks=$("#remarks"+count).val();
           
         url=$("#documentsaveurl").val();
$.ajax({
            url: url,
            type: 'post',
           
                data:{"document":docname,"remarks":remarks,"employee":employee,"status":1},
                
           
            dataType: 'html',
            success: function(success) {
               alert(success);
               window.location.reload();
            }
        });  
  
 });
 
   $(".documentrevoke").click(function(e){
              var count=$(this).attr("tabindex");
            var docname=$(this).attr("title"); 
            var employee=$("#empnumber").val();
           var remarks=$("#remarks"+count).val();
           
         url=$("#documentsaveurl").val();
$.ajax({
            url: url,
            type: 'post',
           
                data:{"document":docname,"remarks":remarks,"employee":employee,"status":0},
                
           
            dataType: 'html',
            success: function(success) {
               alert(success);
               window.location.reload();
            }
        });  
  
 });
   
          }); 
     
        
        </script>