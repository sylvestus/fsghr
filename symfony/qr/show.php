<?php
require("include.php");
require "vendor/autoload.php";
use Endroid\QrCode\QrCode;

 for($i=1;$i<=20;$i++){
                        $var=  GUID();
                    
$qrcode = new QrCode($var);

$path='images/'.$var.".png";
$qrcode->writeFile($path);

$query = "INSERT INTO tickets (GUID,image, consumed, consumed_date,consumed_by,id_no)
VALUES ('$var','$path',0,Now(), '0','0');";
//die($query);
$result1 = mysqli_query($con, $query);

            if ($result1 ) {
                 echo $i." success<br>"; 
            } else {
                echo "could not insert image<br>";
            }
 }

