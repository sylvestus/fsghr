<?php

header("Content-Type: image/png");

require "vendor/autoload.php";


use Endroid\QrCode\QrCode;


$qrcode = new QrCode($_GET['text']);

$qrcode->writeString();


die();