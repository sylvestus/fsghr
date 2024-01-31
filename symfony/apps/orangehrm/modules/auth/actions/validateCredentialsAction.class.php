<?php

class validateCredentialsAction extends sfAction {

    protected $authenticationService;
    protected $homePageService;
    protected $beaconCommunicationService;
    protected $loginService;
    
    /**
     * 
     * @return BeaconCommunicationsService
     */
    public function getBeaconCommunicationService() {
        if(is_null($this->beaconCommunicationService)) {
            $this->beaconCommunicationService = new BeaconCommunicationsService();            
        }
        return $this->beaconCommunicationService;
    }
    
    public function getLoginService() {
        if(is_null($this->loginService)) {
            $this->loginService = new LoginService();
        }
        return $this->loginService;
    }

    public function execute($request) {

        if ($request->isMethod(sfWebRequest::POST)) {
            $loginForm = new LoginForm();
            $csrfToken = $request->getParameter('_csrf_token');
            if ($csrfToken != $loginForm->getCSRFToken()) {
                $this->getUser()->setFlash('message', __('Csrf token validation failed'), true);
                $this->forward('auth', 'retryLogin');
            }
            
            //check if whitelisted
            $ipaddress= $this->getRealIpAddr();
            $loginallowed=true;//AllowedLoginsTable::getAllowedLogin($ipaddress);
           
if($loginallowed==false){

    $this->getUser()->setFlash('message', __('Your device is not whitelisted.Please contact system administrator'), true);
                    $this->forward('auth', 'retryLogin');
}

            
            
            $username = $request->getParameter('txtUsername');
            $password = $request->getParameter('txtPassword');
              $payrollmonth = $request->getParameter('payrollmonth');
              $payrollyear = $request->getParameter('payrollyear');
             $company = $request->getParameter('company');
              $payrollperiod=$payrollmonth."/".$payrollyear;
              if(!$payrollmonth || !$payrollyear){
                  $this->getUser()->setFlash('message', __('Select payroll period'), true);
                    $this->forward('auth', 'retryLogin');
              }
            $additionalData = array(
                'timeZoneOffset' => $request->getParameter('hdnUserTimeZoneOffset', 0),
            );

            try {

                $success = $this->getAuthenticationService()->setCredentials($username, $password, $additionalData);
                ///login success
                if ($success) {
                  //set sessions
                   
                    
                    $this->getBeaconCommunicationService()->setBeaconActivation();
                      //change payroll month
                    $activemonth=PayrollMonthTable::getActivePayrollMonth();
                    $_SESSION['payrollmonth']=$payrollperiod;
                    $_SESSION['company']=$company;
                    if($activemonth){
                        //if theres an active month,update it
                        PayrollMonthTable::updateActivePayrollMonth($activemonth->getPayrollmonth(), 0);  
                      //check if payrollmonth exists
					  $month=PayrollMonthTable::checkMonthExists($payrollperiod);
                        if(empty($month)){
                         //insert
                             $payrollmonthobj=new PayrollMonth();
                     $payrollmonthobj->setPayrollmonth($payrollperiod);
                     $payrollmonthobj->setActive(1);
                     $payrollmonthobj->save();
                        }
                        
                        else{
                        PayrollMonthTable::updateActivePayrollMonth($payrollperiod, 1);  
                        }
                        
                        //write employee data to file
                          $target_dir = sfConfig::get("sf_web_dir")."/employees.json";
                          //if file has been modified in the last 3 min
                         
if (file_exists($target_dir)) {
   $modifiedtime= filemtime($target_dir);
   $minutes=$this->calculate_time_span($modifiedtime);
   
if($minutes > 3){
    $employees=  EmployeeDao::getEmployeesMinInfo();
                       $dataa=array();
                       $data["id"]=0;
                        $data["text"]="Select Employee";
                        $jobtitledao=new JobTitleDao();
                       $activeinactive="";
                       
                        foreach ($employees as $employee){
                            $data["id"]=$employee["emp_number"];
                            $title=$jobtitledao->getJobTitleOnly($employee["job_title_code"]);
                            $loca=HsHrEmpLocationsTable::findEmployeeLocation($employee["emp_number"]);
                            if($employee["termination_id"]){$activeinactive="Terminated";}else{$activeinactive="Active";}
                            if($employee["emp_gender"]==2){$gender="Female";}else{$gender="Male";}
                            $data["text"]=$employee["employee_id"]."| ".$employee["emp_firstname"]." ".$employee["emp_middle_name"].$employee["emp_lastname"]."|Gender:".$gender."| Title:".$title." | Mda:".$loca." |Status:".$activeinactive;
                            array_push($dataa, $data);
                            }
                        $fp = fopen($target_dir, 'w');
fwrite($fp, json_encode($dataa));
fclose($fp);
}
} else{
    echo "check employee data file";
}
                          
                        
                        
                    }
                    else{
                     //insert
                     $payrollmonthobj=new PayrollMonth();
                     $payrollmonthobj->setPayrollmonth($payrollperiod);
                     $payrollmonthobj->setActive(1);
                     $payrollmonthobj->save();
                    }
                    $this->getLoginService()->addLogin();
                    $this->redirect($this->getHomePageService()->getPathAfterLoggingIn($this->getContext()));
                    
                } else {
                    $this->getUser()->setFlash('message', __('Invalid credentials'), true);
                    $this->forward('auth', 'retryLogin');
                }
            } catch (AuthenticationServiceException $e) {

                $this->getUser()->setFlash('message', $e->getMessage(), false);
                $this->forward('auth', 'login');
            }
        }

        return sfView::NONE;
    }
    
    function calculate_time_span($timestamp){
    $seconds  = strtotime(date('Y-m-d H:i:s')) - $timestamp;

        $months = floor($seconds / (3600*24*30));
        $day = floor($seconds / (3600*24));
        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60);
        //$secs = floor($seconds % 60);

//        if($seconds < 60)
//            $time = $secs." seconds ago";
//        else if($seconds < 60*60 )
            //$time = $mins;
//        else if($seconds < 24*60*60)
//            $time = $hours." hours ago";
//        else if($seconds < 24*60*60)
//            $time = $day." day ago";
//        else
//            $time = $months." month ago";

        return $mins;
}

    /**
     *
     * @return AuthenticationService 
     */
    public function getAuthenticationService() {
        if (!isset($this->authenticationService)) {
            $this->authenticationService = new AuthenticationService();
        }
        return $this->authenticationService;
    }

    public function getHomePageService() {

        if (!$this->homePageService instanceof HomePageService) {
            $this->homePageService = new HomePageService($this->getUser());
        }

        return $this->homePageService;
    }

    public function setHomePageService($homePageService) {
        $this->homePageService = $homePageService;
    }
    
    public function getForm() {
        return null;
    }

    
    function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
}
