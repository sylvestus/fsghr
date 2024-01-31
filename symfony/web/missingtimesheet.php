<?php
 ini_set('display_errors', 1);
 function getShiloahConnection(){



$conn = mysqli_connect("localhost","root","","grandways_hr"); //orangehrm_mysql
return $conn;

}

  
 function executeAction() {
       $conn=getShiloahConnection();
	  // die(print_r($conn));
	   $query="SELECT emp_number,employee_id from hs_hr_employee WHERE termination_id IS NULL";
	   //die($query);
	   $result=mysqli_query($conn, $query) or die(mysqli_error($conn));
	 $count=1;
	 $empnumbers=array();
	   while ($row=mysqli_fetch_array($result)){
		  array_push($empnumbers,$row["employee_id"]);	  
	   }	   
	  return $empnumbers; 
	   
    }
    
    
  function getleaveDaysinMonth(){
             $conn=getShiloahConnection();
      $monthyear=date("Y-m");
	  
      $query="SELECT * from ohrm_leave where DATE_FORMAT(date,'%Y-%m') like '%$monthyear%' ";
	   //die($query);
	   $result=mysqli_query($conn, $query) or die(mysqli_error($conn));
	   
	   //we have  the employee number here
	   while($row=mysqli_fetch_array($result)){
		 	   $leavedays[]=$row;  
	   }
	
	return $leavedays;   

	   
  }  
    
    
    
    
	
function markRegisterForLeaveEmployees($empnumber,$datee){
$conn=getShiloahConnection();
	  // die(print_r($conn));
$date=  DateTime::createFromFormat("Y-m-d", $datee);
	   $monthyear=$date->format("m")."-".$date->format("Y");
	   $dayofmonth=$date->format("d");
	   //record into missed attendance
	   	   $query2="DELETE from ohrm_missed_attendance WHERE emp_number='$empnumber' AND monthyear='$monthyear' AND day_missed='$dayofmonth' ";
echo $query2."<br>";	   	
		$result=mysqli_query($conn, $query2) or die(mysqli_error($conn));    
    
}
    
    
    
function getBiometricDeviceConnection(){


// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "biometric", "pwd" => "12345678", "Database" => "AxTrax1", "LoginTimeout" => 30, "Encrypt" => 0, "TrustServerCertificate" => 1);
$serverName ="SHILLOAHSERVER\VERITRAX,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo) or die( print_r( sqlsrv_errors(), true));
return $conn;

}
	
	
	
	
	/************888check which employees havent checked in today***************/
	
function getMissingTimesheet($empid){
$date=date("d-m-Y");
	$tsql = "SELECT count(IdEmpSlot) as timesenrolled,tFullName,tIdentification,dtEventReal,tDesc,CONVERT(varchar(10),tblEvents.dtEventReal,105) as dateentered FROM dbo.tblEvents join dbo.tblEmployees on tblEvents.IdEmpNum=tblEmployees.iEmployeeNum where tDesc like '%entry%' and CONVERT(varchar(10),tblEvents.dtEventReal,105)='$date' and tIdentification like '%$empid%' and iEventType='17' group by IdEmpSlot,tFullName,tIdentification,dtEventReal,tDesc order by tblEvents.dtEventReal DESC ";  
//die($tsql);
 //get bio connectionInfo
 $conn=getBiometricDeviceConnection();

if(!$conn){


    die("Connection to Biometric Database could not be established");

}
 
$getProducts = sqlsrv_query($conn, $tsql);  
if ($getProducts == FALSE)  
     print_r( sqlsrv_errors(), true); 
$productCount = 0;  
$alltimes=array();
$timesenrolled=0;
while($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC))  
{  
$timesenrolled+=$row["timesenrolled"];
}
return array("timesenrolled"=>$timesenrolled,"date"=>$date,"empid"=>$empid);
	
}


function recordMissedAttendance($empid,$date){
	$conn=getShiloahConnection();
	  // die(print_r($conn));
	   $query="SELECT emp_number,employee_id from hs_hr_employee WHERE termination_id IS NULL and employee_id like '%$empid%' ";
	   //die($query);
	   $result=mysqli_query($conn, $query) or die(mysqli_error($conn));
	   
	   //we have  the employee number here
	   while($row=mysqli_fetch_array($result)){
		 	   $empnumber=$row["emp_number"];  
	   }
	
	   

	   $monthyear=date("m-Y");
	   $dayofmonth=date("d");
	   //record into missed attendance
	   	   $query2="INSERT into ohrm_missed_attendance (emp_number,monthyear,day_missed) VALUES ('$empnumber','$monthyear','$dayofmonth')";
echo $query2."<br>";	   	
		$result=mysqli_query($conn, $query2) or die(mysqli_error($conn));
	   

	
}
	
	
	
	
	$employees=executeAction();
	
foreach($employees as $emp){
	
	$empsmissed=getMissingTimesheet($emp);



	if($empsmissed["timesenrolled"]==0){

	recordMissedAttendance($empsmissed["empid"],$empsmissed["date"]);
	}
	
	

	
	
}
	
$leavedays=getleaveDaysinMonth();
foreach ($leavedays as $leaveday) {
    markRegisterForLeaveEmployees($leaveday["emp_number"], $leaveday["date"]);   
}

    



