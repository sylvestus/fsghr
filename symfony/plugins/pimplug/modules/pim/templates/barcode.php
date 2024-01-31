<?php
 require_once('../tcpdf/config/tcpdf_config.php');
       require_once('../tcpdf/tcpdf.php');
     require_once ("tcpdf/tcpdf_barcodes_2d.php");

$code = "hello";
$type = "PDF417";

$barcodeobj = new TCPDF2DBarcode($code, $type);
echo $barcodeobj->getBarcodePNG();

