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





<!-- Listi view -->

<div id="recordsListDiv" class="box miniList">
    <div class="head">
        <h1><?php echo __('Wages Journal ('.$month.')'); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
     
          
            <p id="listActions">
             
                   
                   
        <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
              <input type="button" class="addbutton print" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('Print') ?>"/>
     <br>
            </p>
            <div id="dvData">
                <table class="table hover data-table displayTable exporttable tablestatic" id="recordsListTable">
                <thead>
                    <tr>
                       
                        <td class="boldText borderBottom"><?php echo __('Group'); ?></td>
                        <td class="boldText borderBottom"><?php echo __('Taxable Pay'); ?></td>
                        <td class="boldText borderBottom"><?php echo __('Absentee Pay'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Nssf (Employer)'); ?></td>
                                <td class="boldText borderBottom"><?php echo __('Total'); ?></td>
                                 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allslips as $locationslip) {
                        $grosspay=0;
                        $total=0;
                        ?>
                        
                  
                   
                    <tr><td><?=$locationslip["location"]?></td><td><?php 
                    
                    foreach ($locationslip["slips"] as $slip)
                        
                        { $grosspay=$grosspay+$slip->getGrossPay();  }
                        echo number_format(round($grosspay),0);
                        $total=$total+$grosspay;
                        unset($grosspay);
                        ?> 
                        
                        </td><td>
                           <?php
                           $deductions=0;
                            $datetime=new DateTime();
        $mydate=$datetime->createFromFormat("m/Y", $month);
        $monthyear=$mydate->format("m-Y");
                             foreach ($locationslip["slips"] as $slip)
                        
                        {  $absentdays=OhrmMissedAttendanceTable::getEmployeeMissedDaysOfMonth($slip->getEmpNumber(),$monthyear);
                     
                        $basicpay= PayslipsTable::getEmpBasicSalary($slip->getEmpNumber(),$monthyear)+PayslipsTable::getEmpHouseAllowance($slip->getEmpNumber(),$monthyear);
                        $dailypay=round(($basicpay*12)/365);
                        $absenteepay=$dailypay*$absentdays;
                        $deductions=$deductions+$absenteepay;
                        }
                        echo number_format(round(-$deductions),0);
                        $total=$total-$deductions;
                        unset($deductions);
                           ?>
                        </td><td>
                            <?php
                           $nssfemployer=0;
                             foreach ($locationslip["slips"] as $slip)
                        
                        { $nssfemployer=$nssfemployer+(2/3*$slip->getNssf());  }
                        echo number_format(round($nssfemployer),0);
                         $total=$total+$nssfemployer;
                        unset($nssfemployer);
                        
                           ?>
                            
                        </td><td>
                            <?=  number_format($total,0);?>
                            
                        </td></tr>
                    
                     <?php 
                     unset($total);
                        } ?>
                </tbody>
            </table>
            </div>
        </form>
    </div>
    
</div> <!-- recordsListDiv -->    

<!-- Confirmation box HTML: Begins -->
<div class="modal hide" id="deleteConfModal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo __('TechSavannaHRM - Confirmation Required'); ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo __(CommonMessages::DELETE_CONFIRMATION); ?></p>
  </div>
  <div class="modal-footer">
    <input type="button" class="btn" data-dismiss="modal" id="dialogDeleteBtn" value="<?php echo __('Ok'); ?>" />
    <input type="button" class="btn reset" data-dismiss="modal" value="<?php echo __('Cancel'); ?>" />
  </div>
</div>
<!-- Confirmation box HTML: Ends -->


<script type="text/javascript">
$(document).ready(function() {
  
    //manage
     $('#btnfilter').click(function(e) {
         e.preventDefault();
           var startdate=$("#startdate").val();
           var enddate=$("#enddate").val();
       var url=$("#filterurl").val();
       if(startdate=="" || enddate==""){
           alert("please choose start/end dates");
           return 0;
       } else{
       window.location.replace(url+'?startdate='+startdate+"&enddate="+enddate);
   }
    });
    
  
   
     
    
});

</script>