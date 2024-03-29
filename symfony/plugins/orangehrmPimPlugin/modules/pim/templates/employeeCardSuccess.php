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
?>



<?php use_javascript('jquery.PrintArea.js');use_javascript('html2canvas.js');

$weburl=$weburl."/symfony/web";
 require "../qr/vendor/autoload.php";
 $printwidth="505";
 $printheight="330";
 
 
  function getEmployeeService() {
      
            $employeeService = new EmployeeService();
            $employeeService->setEmployeeDao(new EmployeeDao());
     
        return $employeeService;
    }
 
 
 ?>
<style>
		/* these are just styles added for this demo page */
		.canvas{
			width: <?=$printwidth?>px;
			height: <?=$printheight?>px;
			margin: 0 auto;
		}
		.movable_div{
			color: white;
			font-family: Verdana;
			cursor: move;
			position: absolute;
		}
		#design{
			width: 200px;
			margin: 0 auto;
			background: white;
			border: 1px solid white;
			color : white;
		}
@media print {
    .printing { page-break-after: always; }
   body * {
    visibility: hidden;
    
  }
  #print, #print * {
    visibility: visible;
  }
  #print {
    position: absolute;
    left: 0;
    top: 0;
     * {-webkit-print-color-adjust:exact;}
  }
  .image {
         width:255px;
         height :254px;
    }
 
  
   //  body {-webkit-print-color-adjust: exact;}
}


		
	</style>
<!-- Listi view -->

	<div id="design">
            <div id="controls" style="display:hidden">
			 <input type="button" value="Print Card" id="capture"  /><br /><br />				
			
		</div>	
		<br/>
	</div>
<?php
$empdetails=  EmployeeDao::getEmployeeByNumber($empNumber);
$employeeService = getEmployeeService();
        $empPicture = $employeeService->getEmployeePicture($empNumber);
        $empdetails=  EmployeeDao::getEmployeeByNumber($empNumber);
         $contentss = @$empPicture->picture;
  
            $contentType = @$empPicture->file_type;
           
            $fileSize = @$empPicture->size;
            $fileName = @$empPicture->filename;
            if($contentss){ //&& !$empdetails->photo
            $image = imagecreatefromstring($contentss);
           } else{
 $image = imagecreatefromstring($empdetails->photo);
		   }
   // $image = imagescale($image, 400, 250);
    
    ob_start();
    imagejpeg($image);
    $contentss = ob_get_contents();
    ob_end_clean();
?>
<style>
    tbody tr:nth-child(even) {
    background:transparent !important; 
}
    </style>
    <?php 
//   if($englishtitle){ $padding="13"; } else{$padding="20";} //if title has somali
  // if(strlen(trim($title)) <47){$titlesize="24";} else if (strlen(trim($title)) >47 &&strlen(trim($title)) <50){$titlesize="23";} else{$titlesize="20";}
   //if(strlen($location)>41) {$mdasize="26";} else{$mdasize="28";}
   
   ?>
    <div id="print" class="printable" style="width:505px !important; margin:auto;">
    <div id="canvas" class="canvas" style="background:url(<?=$backgroundimage?>) no-repeat !important;background-size:cover !important;width:483px !important; height:306px !important;margin-left: 0px;">
        <table width="490px" style="position:absolute;margin-top:104px;z-index:1000;font-weight:900;font-size:10px;color:#000 !important;font-family:Arial Black; "><tr><td style="text-align:center"><?=strtoupper($location)?></td></tr></table>
    <table style="position:absolute;margin-top:115px;z-index:1000;font-weight:900;font-size:10px;color:#000 !important;font-family:Arial Black; ">
        <tr ><td colspan="3" style="text-align:left;vertical-align:top;padding-left:3px"><img src="<?=$weburl?>/uploads/card/magaca2.png" style="width:120px;"></td></tr>
        <tr><td colspan="3" style="text-align:left;vertical-align:top;font-size:12px;padding-left:3px"> <?=ucwords($names)?></tr>
	<tr><td style="text-align: left;padding-top:1px;padding-left:3px"> <img src="<?=$weburl?>/uploads/card/title.png"  style="width:120px;"></td>
<td style="text-align:left;padding-left:3px"> <span style="margin-left:-25px;margin-top:0px;z-index:1500;position:absolute;opacity:0.4"><?='<img height="70" width="70" src="data:image/jpeg;base64,'.base64_encode($contentss).'" />'?></span></td> 
<td><span style="top:5px;right:-40.4px;z-index:1500;position:absolute"><?='<img class="image" style="height:125px; width:124px;" src="data:image/jpeg;base64,'.base64_encode($contentss).'" />'?></span></td></tr>
        <tr><td colspan="3" style="text-align:left;font-size:12px;padding-left:3px"> <?=ucwords(trim($title))?><br><?=ucwords(trim($englishtitle))?>  </td></tr>
	<tr><td style="text-align:left;vertical-align:top;padding-top:1px;padding-left:3px"><img src="<?=$weburl?>/uploads/card/id.png"  style="width:200px;"> </td>
	<td colspan="2" style="text-align:right;padding-top:1px;"><img src="<?=$weburl?>/uploads/card/grade.png" style="width:120px;margin-right:100px;"></td></tr>
        <tr><td colspan="2" style="text-align:left;padding-top:1px;padding-left:3px;font-size:12px"><?=  strtoupper($employeeid)?></td><td style="text-align:center;margin-right:100px;font-size:12px"><?=strtoupper($grade)?></td></tr>
<tr><td colspan="2" style="text-align:left;padding-top:1px;vertical-align:top;padding-left:3px"><img src="<?=$weburl?>/uploads/card/issuedate.png" style="width:200px;"></td>
<td style="padding-top:2px;padding-left:30px;vertical-align:top"><span><img src="<?=$weburl?>/uploads/card/expdate.png" style="width:200px;"></span></td></tr>
<tr><td colspan="2" style="text-align:left;padding-top:0px;padding-left:100px;"><?=$issuedate?></td><td style="text-align:center"><?=$expirydate?></td></tr>
<tr><td colspan="2" style="text-align:right;padding-top:2px;vertical-align:top"><img src="<?=$weburl?>/uploads/card/gender.png" style="width:120px !important;height:19px"></td>
<td style="padding-top:7px;">&nbsp;&nbsp;:<?=$gender?></td></tr>
   
	
	</table>
</div>
	<?php imagedestroy($image);

       

use Endroid\QrCode\QrCode;

$qrstring=$empdetails->getEmployeeId()."_".$names."_".$title."_".$gender;
$qrcode = new QrCode($qrstring);
 $qrimage = imagecreatefromstring($qrcode->writeString());
   // $qrimage = imagescale($qrimage, 400, 300);
    
    ob_start();
    imagejpeg($qrimage);
    $qrcontants = ob_get_contents();
    ob_end_clean();
       
      
        ?>	
<br />

<div id="print" class="printable" style="position:relative;width:505px !important; padding-top:5px !important;">
    <div id="canvasback" class="canvas" style="background:url(<?=$backgroundimageback?>)  no-repeat !important;background-size:contain !important; width:505px !important; margin:auto;height:300px;margin-top:-18px;margin-left: 3px;">
        <span style="float:right;margin-left:240px;padding-top:5px;z-index:1500;position:absolute"><?='<img  height="100px" width="100px" src="data:image/jpeg;base64,'.base64_encode($qrcontants).'" />'?></span>
        <span style="margin-left:0px;padding-top:263px;z-index:1500;position:absolute;text-align:center"><img height="20" width="500px" src="<?=$weburl?>/uploads/qr/barcode2.png" /></span>
        <span style="padding-left:20px;padding-top:287px;font-weight:bolder;font-size:10px;z-index:1500;position:absolute;text-align:center;"><?=$qrstring?></span>
       
    </div>
    </div>
    </div>
    
    <!--<div id="print" class="printable"><div id="frontimage" class="printing" style="width:1004px;height:650px" >
        </div><div id="backimage"  style="width:1004px;height:645px"></div></div>-->
    
    <script type="text/javascript">	
		//$(function(){	
			
			
			
			//to change the background once the user select
			$('#background').change(function(){
				var background = $(this).val();
				$('#canvas').css('background', 'url(<?=$backgroundimage?>)');
			});
			
				<?php if($printmode=="download") {?>	

			//here is the hero, after the capture button is clicked
			//he will take the screen shot of the div and save it as image.
			$( document ).ready(function(){
				//get the div content
				div_content = document.querySelector("#canvas");
                                div_contentback = document.querySelector("#canvasback");
				//make it as html5 canvas
				html2canvas(div_content).then(function(canvas) {
					//change the canvas to jpeg image
					data = canvas.toDataURL('image/jpeg');
					
					//then call a super hero php to save the image
					save_img(data,"front");
				});
                                //back
                                html2canvas(div_contentback).then(function(canvas) {
					//change the canvas to jpeg image
					data = canvas.toDataURL('image/jpeg');
					
					//then call a super hero php to save the image
					save_img(data,"back");
				});
                                
                                
			});			
		//});
		
		
		//to save the canvas image
		function save_img(data,page){
			//ajax method.
			$.post('<?=url_for('pim/saveJpg')?>', {data: data,page:page,employee:"<?=$empNumber?>"}, function(res){
				//if the file saved properly, trigger a popup to the user.
				if(res != ''){
					//yes = confirm('File saved in output folder, click ok to download!');
                           //  if(yes){
                           //alert('Downloading file...');
//                                             var thePopup = window.open("<?=$weburl?>/uploads/printcards/"+res+".jpg", "ID Card", "menubar=0,location=0,height=700,width=700" );
//                                                    thePopup.print();
//						//window.pr(location.href =document.URL+'output/'+res+'.jpg');
//					}           
                                        setTimeout(function() {
  
   url ="<?=$weburl?>/uploads/printcards/"+res+".jpg";
  // backurl ="<?=$weburl?>/uploads/printcards/"+res+"back.jpg";
   downloadFile(url); // UNCOMMENT THIS LINE TO MAKE IT WORK
//  printWindow = window.open(
//  url, 
//  '_blank'
//  );
//printWindow.window.print();
}, 2000);

// Source: http://pixelscommander.com/en/javascript/javascript-file-download-ignore-content-type/
window.downloadFile = function (sUrl) {

    //iOS devices do not support downloading. We have to inform user about this.
    if (/(iP)/g.test(navigator.userAgent)) {
       //alert('Your device does not support files downloading. Please try again in desktop browser.');
       window.open(sUrl, '_blank');
       return false;
    }

    //If in Chrome or Safari - download via virtual link click
    if (window.downloadFile.isChrome || window.downloadFile.isSafari) {
        //Creating new link node.
        var link = document.createElement('a');
        link.href = sUrl;
        link.setAttribute('target','_blank');

        if (link.download !== undefined) {
            //Set HTML5 download attribute. This will prevent file from opening if supported.
            var fileName = sUrl.substring(sUrl.lastIndexOf('/') + 1, sUrl.length);
            link.download = fileName;
        }

        //Dispatching click event.
        if (document.createEvent) {
            var e = document.createEvent('MouseEvents');
            e.initEvent('click', true, true);
            link.dispatchEvent(e);
            return true;
        }
    }

    // Force file download (whether supported by server).
    if (sUrl.indexOf('?') === -1) {
        sUrl += '?download';
    }

    window.open(sUrl, '_blank');
    return true;
}

window.downloadFile.isChrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
window.downloadFile.isSafari = navigator.userAgent.toLowerCase().indexOf('safari') > -1;


				//}
				
			
		}
                else{
					alert('Could not download please retry');
				}
                });
                }
                <?php } else{?>
    
    	$( document ).ready(function(){
				//get the div content
				div_content = document.querySelector("#canvas");
                                div_contentback = document.querySelector("#canvasback");
				//make it as html5 canvas
				html2canvas(div_content).then(function(canvas) {
					//change the canvas to jpeg image
					data = canvas.toDataURL('image/jpeg');
					
					//then call a super hero php to save the image
					save_img(data,"front");
				});
                                //back
                                html2canvas(div_contentback).then(function(canvas) {
					//change the canvas to jpeg image
					data = canvas.toDataURL('image/jpeg');
					
					//then call a super hero php to save the image
					save_img(data,"back");
				});
                              
                                
			});			
		//});
		
		
		//to save the canvas image
		function save_img(data,page){
			//ajax method.
			$.post('<?=url_for('pim/saveJpg')?>', {data: data,page:page,employee:"<?=$empNumber?>"}, function(res){
				//if the file saved properly, trigger a popup to the user.
				if(res != ''){
					//yes = confirm('File saved in output folder, click ok to download!');
                           //  if(yes){
                           //alert('Downloading file...');
//                                             var thePopup = window.open("<?=$weburl?>/uploads/printcards/"+res+".jpg", "ID Card", "menubar=0,location=0,height=700,width=700" );
//                                                    thePopup.print();
//						//window.pr(location.href =document.URL+'output/'+res+'.jpg');
//					}           
                                        setTimeout(function() {
  
   url ="<?=$weburl?>/uploads/printcards/"+res+".jpg";
  
  // backurl ="<?=$weburl?>/uploads/printcards/"+res+"back.jpg";
   //downloadFile(url); // UNCOMMENT THIS LINE TO MAKE IT WORK
//  printWindow = window.open(
//  url, 
//  '_blank'
//  );
//printWindow.window.print();
url2=url.replace("back", "front");
urlback=url.replace("front", "back");
 $("#frontimage").html('<img id="frontimage" src="'+url2+'">');
 $("#backimage").html('<img id="backimage" src="'+urlback+'">');
  $("#controls").attr("display","block");
}, 500);

// Source: http://pixelscommander.com/en/javascript/javascript-file-download-ignore-content-type/
window.downloadFile = function (sUrl) {

    //iOS devices do not support downloading. We have to inform user about this.
    if (/(iP)/g.test(navigator.userAgent)) {
       //alert('Your device does not support files downloading. Please try again in desktop browser.');
       window.open(sUrl, '_blank');
       return false;
    }

    //If in Chrome or Safari - download via virtual link click
    if (window.downloadFile.isChrome || window.downloadFile.isSafari) {
        //Creating new link node.
        var link = document.createElement('a');
        link.href = sUrl;
        link.setAttribute('target','_blank');

        if (link.download !== undefined) {
            //Set HTML5 download attribute. This will prevent file from opening if supported.
            var fileName = sUrl.substring(sUrl.lastIndexOf('/') + 1, sUrl.length);
            link.download = fileName;
        }

        //Dispatching click event.
        if (document.createEvent) {
            var e = document.createEvent('MouseEvents');
            e.initEvent('click', true, true);
            link.dispatchEvent(e);
            return true;
        }
    }

    // Force file download (whether supported by server).
    if (sUrl.indexOf('?') === -1) {
        sUrl += '?download';
    }

    window.open(sUrl, '_blank');
    return true;
}

window.downloadFile.isChrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
window.downloadFile.isSafari = navigator.userAgent.toLowerCase().indexOf('safari') > -1;


				//}
				
			
		}
                else{
					alert('Could not download please retry');
				}
                });
                }
                
      
    
   
    
                <?php } ?>
    
    $("#capture").on( "click", function() {
         window.print();
    });
    </script>	
