<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
/* For logging PHP errors */
include_once('../../lib/confs/log_settings.php');

/* Added for compatibility with current orangehrm code 
 * OrangeHRM Root directory 
 */
define('ROOT_PATH', dirname(__FILE__) . '/../../');
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);
define('WPATH', $scriptPath . "/../../");

/* Redirect to installer if not set up */
if (!is_file(ROOT_PATH . '/lib/confs/Conf.php')) {
    header('Location: ' . WPATH . 'install.php');
    exit();
}

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
//connect to controller database and pick default schema
$username="silvano";$password="access"; $host="localhost";
$con = mysqli_connect($host,$username,$password,"homabay_hr2");
$code=@$_POST["company"];



if($code){
	$query2="UPDATE database_controller SET active=0 where company_code > 0";
$_SESSION['company']=$code;
$result2=mysqli_query($con, $query2) or die(mysqli_error($con));
$query='UPDATE database_controller SET active=1 where company_code="$code"';
$result=mysqli_query($con, $query) or die(mysqli_error($con));

}
$query3="Select * from database_controller where active=1";
$result3=mysqli_query($con, $query3) or die(mysqli_error($con));
$row3=mysqli_fetch_array($result3);
mysqli_close($con);
$schema=@$_SESSION['company'];
//connect to tenant db

//print_r($schema);
$configuration = ProjectConfiguration::getApplicationConfiguration('orangehrm',$schema,TRUE); //$schema
//die(print_r($configuration));
sfContext::createInstance($configuration)->dispatch();


