<?php

/**
 * SavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 SavannaHRM Inc., http://www.orangehrm.com
 *
 * SavannaHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * SavannaHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
class saveJpgAction extends basePimAction {

    public function execute($request) {
        $random ="";// rand(100, 1000);
$postArray = $request->getPostParameters();
$empnumber=$postArray["employee"];
$frontback=$postArray["page"];
$name=$empnumber."_".$frontback;  //$random."_".
 $target_dir = sfConfig::get("sf_web_dir")."/uploads/";
//$_POST[data][1] has the base64 encrypted binary codes. 
//convert the binary to image using file_put_contents
$savefile = @file_put_contents($target_dir."printcards/".$name.".jpg", base64_decode(explode(",", $postArray['data'])[1]));

//if the file saved properly, print the file name
if($savefile){
	echo($name);
        exit();  
}
else{
    die("could not save");
}

    }
       

}

