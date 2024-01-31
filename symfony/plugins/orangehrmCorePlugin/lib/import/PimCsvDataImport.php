<?php

/**
 * TechSavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 TechSavannaHRM Inc., http://www.techsavanna.technology
 *
 * TechSavannaHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * TechSavannaHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 *
 */
class PimCsvDataImport extends CsvDataImport {

	private $employeeService;
	private $nationalityService;
	private $countryService;

	public function import($data) {

		if ($data[1] == "" || $data[2] == "" || strlen($data[1]) > 30 || strlen($data[2]) > 30) {
			return false;
		}
		
           
               
               $empService = new EmployeeService();
              $employeeobj=$empService->getEmployeeByEmployeeId(str_replace(" ","",$data[1]));
               if(is_object($employeeobj)){
                   //update
               
                 $employeeobj->setFirstName($data[2]);
//		if (strlen($data[1]) <= 30) {
//			$employeeobj->setMiddleName($data[1]);
//		}
		$employeeobj->setLastName("");

		if (strlen($data[1]) <= 50) {
			$employeeobj->setEmployeeId($data[1]);
		}
		if (strlen($data[1]) <= 30) {
			$employeeobj->setOtherId($data[1]);
		}
//		if (strlen($data[5]) <= 30) {
//			$employeeobj->setLicenseNo($data[0]);
//		}
		if ($this->isValidJobTitle($data[3])) {
                   $titlecode=$this->isValidJobTitle($data[3]);
			$employeeobj->setJobTitleCode($titlecode);
		}

		if (strtolower($data[4]) == 'male') {
			$employeeobj->setEmpGender('1');
		} else if (strtolower($data[4]) == 'female') {
			$employeeobj->setEmpGender('2');
		}
                //data[5] grade ==> custom1
                if ($data[5]) {
			$employeeobj->setCustom1($data[5]);
		}
                //joined recruited date
                if ($date=$this->isValidDate($data[6])) {
			$employeeobj->setJoinedDate($date);
		}
               
                //department
                if ($workstation=$this->isValidWorkStation($data[7])) {
			$employeeobj->setWorkStation($workstation);
		}
                
                
                if ($bd=$this->isValidDate($data[8])) {
			$employeeobj->setEmpBirthday($bd);
		}
                 if ($loc=$this->isValidLocation($data[9])) {
                   $locc= HsHrEmpLocationsTable::findEmployeeLocationId($employeeobj->getEmpNumber());
                   if($loc){
                    $updateid= HsHrEmpLocationsTable::updateEmployeeLocation($employeeobj->getEmpNumber(),$loc);  
                   }
			
		}
                
                
             $savedemp=$empService->saveEmployee($employeeobj); 
             if(!is_numeric($locc)){
                 //die($savedemp->getEmpNumber()."cdcdf".$loc);
                   HsHrEmpLocationsTable::addEmployeeLocation($savedemp->getEmpNumber(),$loc);
             }
                   
               }
               else{
                   $employee = new Employee();
              
		$employee->setFirstName($data[2]);
//		if (strlen($data[1]) <= 30) {
//			$employee->setMiddleName($data[1]);
//		}
		$employee->setLastName("");

		if (strlen($data[1]) <= 50) {
			$employee->setEmployeeId($data[1]);
		}
		if (strlen($data[1]) <= 30) {
			$employee->setOtherId($data[1]);
		}
//		if (strlen($data[5]) <= 30) {
//			$employee->setLicenseNo($data[0]);
//		}
		if ($this->isValidJobTitle($data[3])) {
                   $titlecode=$this->isValidJobTitle($data[3]);
			$employee->setJobTitleCode($titlecode);
		}

		if (strtolower($data[4]) == 'male' || strtolower($data[4])=='lab'  ) {
			$employee->setEmpGender('1');
		} else if (strtolower($data[4]) == 'female' || strtolower($data[4])=='dhedig') {
			$employee->setEmpGender('2');
		}
                //data[5] grade
                if ($data[5]) {
			$employee->setCustom1($data[5]);
		}
                //joined recruited date
                if ($jd=$this->isValidDate($data[6])) {
			$employee->setJoinedDate($jd);
		}
               
                //department
                if ($workstation=$this->isValidWorkStation($data[7])) {
			$employee->setWorkStation($workstation);
		}
                
                
                if ($date=$this->isValidDate($data[8])) {
			$employee->setEmpBirthday($date);
		}
              
//                
//		if (strtolower($data[8]) == 'single') {
//			$employee->setEmpMaritalStatus('Single');
//		} else if (strtolower($data[8]) == 'married') {
//			$employee->setEmpMaritalStatus('Married');
//		} else if (strtolower($data[8]) == 'other') {
//			$employee->setEmpMaritalStatus('Other');
//		}
//
//		$nationality = $this->isValidNationality($data[9]);
//		if (!empty($nationality)) {
//			$employee->setNationality($nationality);
//		}
//		if ($this->isValidDate($data[10])) {
//			$employee->setEmpBirthday($data[10]);
//		}
//		if (strlen($data[11]) <= 70) {
//			$employee->setStreet1($data[11]);
//		}
//		if (strlen($data[12]) <= 70) {
//			$employee->setStreet2($data[12]);
//		}
//		if (strlen($data[13]) <= 70) {
//			$employee->setCity($data[13]);
//		}
//		
//		if (strlen($data[15]) <= 10) {
//			$employee->setEmpZipcode($data[15]);
//		}
//
//		$code = $this->isValidCountry($data[16]);
//		if (!empty($code)) {
//			$employee->setCountry($code);
//			if (strtolower($data[16]) == 'united states') {				
//				$code = $this->isValidProvince($data[14]);
//				if(!empty($code)){
//					$employee->setProvince($code);
//				}
//			} else if (strlen($data[14]) <= 70) {
//				$employee->setProvince($data[14]);
//			}
//		}
//		if (strlen($data[17]) <= 25 && $this->isValidPhoneNumber($data[17])) {
//			$employee->setEmpHmTelephone($data[17]);
//		}
//		if (strlen($data[18]) <= 25 && $this->isValidPhoneNumber($data[18])) {
//			$employee->setEmpMobile($data[18]);
//		}
//		if (strlen($data[19]) <= 25 && $this->isValidPhoneNumber($data[19])) {
//			$employee->setEmpWorkTelephone($data[19]);
//		}
//		if ($this->isValidEmail($data[20]) && strlen($data[20]) <= 50 && $this->isUniqueEmail($data[20])) {
//			$employee->setEmpWorkEmail($data[20]);
//		}
//		if ($this->isValidEmail($data[21]) && strlen($data[21]) <= 50 && $this->isUniqueEmail($data[21])) {
//			$employee->setEmpOthEmail($data[21]);
//		}

		
		$employeesaved=$empService->saveEmployee($employee);
                if ($loc=$this->isValidLocation($data[9])) {
                    $loc2= HsHrEmpLocationsTable::findEmployeeLocationId($employeesaved->getEmpNumber());
                    if(!is_numeric($loc2) && is_numeric($loc)){
                     HsHrEmpLocationsTable::addEmployeeLocation($employeesaved->getEmpNumber(),$loc);  
                    } else {
                        if($loc){
                     $updateid= HsHrEmpLocationsTable::updateEmployeeLocation($employeesaved->getEmpNumber(),$loc); 
                        }
                    }
			
		}
                 }
                 return true;
                 
		
	}

	private function isValidEmail($email) {
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}

	private function isUniqueEmail($email) {

		$emailList = $this->getEmployeeService()->getEmailList();
		$isUnique = true;
		foreach ($emailList as $empEmail) {

			if ($empEmail['emp_work_email'] == $email || $empEmail['emp_oth_email'] == $email) {
				$isUnique = false;
			}
		}
		return $isUnique;
	}

	private function isValidDate($date) {
            if(strlen($date)==4){
                $date=$date."-01-01";
            }
            else{
           $date=date("Y-m-d",  strtotime($date));
            }
        return $date;
//		if (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date)) {
//			list($year, $month, $day) = explode('-', $date);
//			return checkdate($month, $day, $year);
//		} else {
//			return false;
//		}
	}
        
        
        private function isValidJobTitle($title){
           $newtitle=  str_replace(" ","", $title);
           $q = Doctrine_Query :: create()
                            ->from('JobTitle')
           ->where('REPLACE(job_title," ","") = ?',$newtitle);
           $result=$q->execute();
          //die(print_r($result[0]->id."dsd"));
           if($result[0]->id){
               return $result[0]->id;
           }else{
               $jobtitle=new JobTitle();
               $jobtitle->setJobTitleName($title);
               $jobtitle->setJobDescription($title);
               $jobtitle->setIsDeleted(0);
               $jobtitle->save();
              return $jobtitle->getId();
           }
       
            
        }
        
         private function isValidWorkStation($workstation){
           $newtitle=  str_replace(" ","", $workstation);
           
           $q = Doctrine_Query :: create()
                            ->from('OhrmSubunit')
           ->where('REPLACE(name," ","") = ?',$newtitle);
           $result=$q->execute();
           
           if($result[0]->id){
               return $result[0]->id;
           }else{
               return FALSE;
           }
       
            
        }
        
        private function isValidLocation($workstation){
           $newtitle=  str_replace(" ","", $workstation);
           
           $q = Doctrine_Query :: create()
                            ->from('OhrmLocation')
           ->where('REPLACE(name," ","") = ?',$newtitle);
           $result=$q->execute();
           
           if(is_object($result)){
               return $result[0]->id;
           }else{
               return FALSE;
           }
       
            
        }



        private function isValidNationality($name) {

		$nationalities = $this->getNationalityService()->getNationalityList();

		foreach ($nationalities as $nationality) {
			if (strtolower($nationality->getName()) == strtolower($name)) {
				return $nationality;
			}
		}
	}

	private function isValidCountry($name) {

		$countries = $this->getCountryService()->getCountryList();

		foreach ($countries as $country) {
			if (strtolower($country->cou_name) == strtolower($name)) {
				return $country->cou_code;
			}
		}
	}
	
	private function isValidProvince($name) {

		$provinces = $this->getCountryService()->getProvinceList();
		
		foreach ($provinces as $province) {
			if (strtolower($province->province_name) == strtolower($name)) {
				return $province->province_code;
			}
		}
	}

	public function isValidPhoneNumber($number) {
		if (preg_match('/^\+?[0-9 \-]+$/', $number)) {
			return true;
		}
	}

	public function getCountryService() {
		if (is_null($this->countryService)) {
			$this->countryService = new CountryService();
		}
		return $this->countryService;
	}

	public function getNationalityService() {
		if (is_null($this->nationalityService)) {
			$this->nationalityService = new NationalityService();
		}
		return $this->nationalityService;
	}

	public function getEmployeeService() {
		if (is_null($this->employeeService)) {
			$this->employeeService = new EmployeeService();
			$this->employeeService->setEmployeeDao(new EmployeeDao());
		}
		return $this->employeeService;
	}

}

?>
