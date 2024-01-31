<div id="profile-pic">
    
 <?php $empdetails=  EmployeeDao::getEmployeeByNumber($empNumber);?>
<h1><?php echo $fullName; ?>(<?=$empdetails->employee_id?>)</h1>
  <div class="imageHolder">

<?php if ($photographPermissions->canUpdate() || $photographPermissions->canDelete()) : ?>
  <a href="<?php echo url_for('pim/viewPhotograph?empNumber=' . $empNumber); ?>" title="<?php echo __('Change Photo'); ?>" class="tiptip">
<?php else: ?>
  <a href="#">
<?php endif; ?>
      
      <?php
      
      function getEmployeeService() {
      
            $employeeService = new EmployeeService();
            $employeeService->setEmployeeDao(new EmployeeDao());
     
        return $employeeService;
    }
      
      function getEmployeePhoto($empNumber){
     
           $employeeService = getEmployeeService();
        $empPicture = $employeeService->getEmployeePicture($empNumber);
        $empdetails=  EmployeeDao::getEmployeeByNumber($empNumber);
         $contents = @$empPicture->picture;
  
            $contentType = @$empPicture->file_type;
           
            $fileSize = @$empPicture->size;
            $fileName = @$empPicture->filename;
            //if($contents){
            // return '<img src="data:'.$contentType.';base64,' . base64_encode($contents) .'" border="0" id="empPic" alt="Employee Photo"   height="150" width="200">';
           // }
            if ($empdetails->photo) {
          $image = imagecreatefromstring($empdetails->photo);
$image = imagescale($image, 200, 150);

ob_start();
imagejpeg($image);
$contentss = ob_get_contents();
ob_end_clean();

echo "<img src='data:image/jpeg;base64,".base64_encode($contentss)."' />";

imagedestroy($image);
//                                    $img = "<img src= 'data:image/jpg;base64,".base64_encode($empdetails->photo)."' alt='Employee Photo'   height='150' width='200' />";
//                                   echo($img);
                                    
        }
            else{
           echo '<br>No image uploaded';    
            }
      }
      
     echo getEmployeePhoto($empNumber); 
      ?>
  
  </a>

  </div>    
</div> <!-- profile-pic -->