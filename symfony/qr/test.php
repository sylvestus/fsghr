<?php
$len = 10;   // total number of numbers
$min = 100;  // minimum
$max = 999;  // maximum
$range = []; // initialize array
foreach (range(0, $len - 1) as $i) {
    while(in_array($num = mt_rand($min, $max), $range));
   print_r("\r\n".$num);
}


die();