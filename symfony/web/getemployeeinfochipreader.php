<?php
$dbHost="127.0.0.1:3306";
$dbUsername="root";
$dbPassword="mysql";
$dbName="fgshr";

$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 

$empid=trim($_REQUEST["empid"]);

$empnumber=""; $names="N/A"; $jobtitle="N/A";$mda="N/A";
$query=mysqli_query($db,"select emp_number,CONCAT(emp_firstname,' ',emp_middle_name,' ',emp_lastname) as names,job_title_code from hs_hr_employee WHERE employee_id='".$empid."'") or die(mysqli_error($db));
while($rows= mysqli_fetch_array($query,MYSQLI_ASSOC)){
	$empnumber=$rows["emp_number"];
	
$names=strtoupper($rows["names"]);	
$jobtitle=$rows["job_title_code"];
$jobtitlequery=mysqli_query($db,"SELECT job_title FROM ohrm_job_title WHERE id='".$jobtitle."'") or die(mysqli_error($db));
while($rowss= mysqli_fetch_array($jobtitlequery,MYSQLI_ASSOC)){
	$jobtitle=strtoupper($rowss["job_title"]);
}

$locationquery=mysqli_query($db,"SELECT location_id FROM hs_hr_emp_locations WHERE emp_number='".$empnumber."'") or die(mysqli_error($db));
while($rowlocation= mysqli_fetch_array($locationquery,MYSQLI_ASSOC)){
	$locid=$rowlocation["location_id"];
	$locationnamequery=mysqli_query($db,"SELECT name FROM ohrm_location WHERE id='".$locid."'") or die (mysqli_error($db));
	while($rowsss= mysqli_fetch_array($locationnamequery,MYSQLI_ASSOC)){
	$mda=strtoupper($rowsss["name"]);
}
	
}





}
//query job title and location
mysqli_close($db);
if(!$empnumber){
	echo "Employee Not Found*Employee Not Found*Employee Not Found*Employee Not Found";
	
	}
echo $empnumber."*".$names."*".$jobtitle."*".$mda;

