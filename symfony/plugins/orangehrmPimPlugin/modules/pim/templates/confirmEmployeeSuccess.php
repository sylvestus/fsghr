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
        <h1><?php echo __('Employee Appointment Letter: '); ?><?=$employee->getEmpFirstname().' '.$employee->getEmpMiddleName().' '.$employee->getEmpLastname()?>&nbsp;&nbsp;  <span style="float:right"><a class="word-export" href="javascript:void(0)"> Export as .doc </a></span></h1>
            
            

    </div>
    
    <div class="inner" id="page-content">
    <center class="boldText">APPOINTMENT LETTER</center>
  <hr>
<br><br>

<table width="100%">
    <tr>
        <td> <b>NAME OF EMPLOYEE: </b>  <u><?=$employee->getEmpFirstname()?></u></td> <td width="30%">   <u><?=$employee->getEmpMiddleName()?></u></td>   <td width="40%"><u><?=$employee->getEmpLastname()?></u></td></tr>
<tr> <td colspan="5"><br><br></td></tr>
<tr>
    <td>Employee ID #: <u><?=$employee->getEmployeeId()?></u></td><td>Email: <u><?=$employee->getEmpWorkEmail()?></u></td>
</tr>
<tr> <td colspan="5"><br><br></td></tr>

<tr>
    <td><b>ID CARD NO:</b>#: <u><?=$employee->getEmpDriLiceNum()?></u></td><td>Email: <u><?=$employee->getEmpWorkEmail()?></u></td>
</tr>


<tr> <td colspan="5"><br><br></td></tr>


<tr><td colspan="2">
<br>
If your loan application is approved, Finance Department will contact you and ask you to come to  sign the Acceptance agreeing to the repayment terms on the loan.
<br><br></td></tr>

<tr><td>
Please indicate the best way to contact you:
[   ]   Email Address          OR                  [  ]    Mailing Address:  [  ]    Phone No:	 
 			        <br><br><br>
    </td> </tr>

<tr><td>
I declare under penalty of perjury that the above statements are true and correct.<br><br>
________________________________________________________     _______________________

<br><br></td></tr>

<tr><td colspan="5">
                                   Employee Signature        	 		                           Date
    </td>
</tr>
<br><br>
<tr><td colspan="5">
<hr class="boldText">
FOR ADMINISTRATIVE USE ONLY<br><br>
Finance Dept Review:   [  ]  Employee approved for loan    Reviewed by:   _______________  Date: _______________      
    <td></tr>
</table>  
</div>
</div>
<!-- Confirmation box HTML: Ends -->


<script type="text/javascript">
$(document).ready(function() {
       $("#checkAll").click(function() {
          if($("#checkAll").is(":checked")){
       $(".checkboxAtch").each(function(){
           $('.checkboxAtch').attr("checked","checked");
       });
          }
          else{
              $(".checkboxAtch").each(function(){
           $('.checkboxAtch').prop("checked",false);
       });   
          }
          });
       //update
       
      
   
    //add tax slab
     $('#btnAddSlab').click(function(e) {
         e.preventDefault();
           var id=$(".check .checkboxAtch:checked").val();
         var url=$("#approveslab").val();
            window.location.replace(url+'?id='+id);
    });
    
    //update tax slab
         $('#btnUpdateSlab').click(function(e) {
         e.preventDefault();
         var id=$(".check .checkboxAtch:checked").val();
         var url=$("#ammendslab").val();
             if(id !==null){
        window.location.replace(url+'?id='+id);
          }else{return;}
    });
    
         $('#btnDelSlab').click(function(e) {
         e.preventDefault();
           if ($(".check .checkboxAtch:checked").length > 0) {
               var id=$(".check .checkboxAtch:checked").val();
         var url=$("#rejectslab").val();
           
         window.location.replace(url+'?id='+id);
    
         }
    });
    
    //export
    $("a.word-export").click(function(event) {

	$("#page-content").wordExport();

	});
});

</script>