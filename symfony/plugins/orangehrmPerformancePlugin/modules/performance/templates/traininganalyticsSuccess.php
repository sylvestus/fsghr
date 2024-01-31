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


<?php use_javascript('jquery.PrintArea.js') ?>
<style>
    
    .chartdiv {
  width:600px;
  margin-left:-10px;
  height: 300px;
  font-size: 11px;
 
}

.amcharts-pie-slice {
  transform: scale(1);
  transform-origin: 50% 50%;
  transition-duration: 0.3s;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  -o-transition: all .3s ease-out;
  cursor: pointer;
  box-shadow: 0 0 30px 0 #000;
}

.amcharts-pie-slice:hover {
  transform: scale(1.1);
  filter: url(#shadow);
}			
    </style>
    
    <!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<!-- Listi view -->

<div id="recordsListDiv" class="box miniList">
    <div class="head">
        <h1><?php echo __('Training Analytics & Forecasting:Year '.date('Y')); ?>&nbsp;&nbsp; </h1>
            
       <?php $imagePath = theme_path("images");?>     

    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
        <form name="frmList" id="frmList" method="post" action="<?php echo url_for('loans/viewloan'); ?>">
          
            <p id="listActions">
                <input type="hidden" id="viewslab" value="<?php echo url_for('loans/viewloan'); ?>">
                   <input type="hidden" id="repayslab" value="<?php echo url_for('loans/repayloan'); ?>">
                    <input type="hidden" id="pdfurl" value="<?php echo url_for('admin/pdf'); ?>">
                        <input type="hidden" id="addurl" value="<?php echo url_for('performance/addCourse'); ?>">
                   <a href="#" class="addbutton" style="float:right !important" id="emailbtn"><img src="<?php echo "{$imagePath}/email.png";?>" alt="email"></a>   
                 <a href="#" class="addbutton" style="float:right !important" id="pdfbtn"><img src="<?php echo "{$imagePath}/pdf.png"; ?>"></a>   
     <a href="#" class="addbutton" style="float:right !important" id="export"><img src="<?php echo "{$imagePath}/excelicon.png"; ?>" /></a>
      <!--<input type="button" class="addbutton" style="float:right !important" id="btnAddSlab" rel="dvData"  value="<?php echo __('+ Add Course') ?>"/>-->
     <br>
            </p>
            <div id="dvData">
            <table class="display  dataTables tablestatic" width="100%" id="recordsListTable">
                        <tr><td>
                        <div id="panel_draggable_1_3" class="panel_draggable panel-preview" style="margin:4px 2px; ">
                                <fieldset id="panel_resizable_1_3" class="panel_resizable panel-preview" style="width:350px; height:380px; ">
                                    <legend>Trainings/Department</legend>
                                    
    <div class="" style="height: 100%;" id="dashboard__pendingLeaveRequests"><div id="task-list-group-panel-container" class="" style="height:100%; ">
    <div id="task-list-group-panel-menu_holder" class="task-list-group-panel-menu_holder" style=" overflow-x:scroll; overflow-y:hidden;">
        <div id="chartdiv" class="chartdiv">
            
            
            
            
        </div> 
    </div>
    <div id="total">
        <table class="table">
            <tbody>
              
                
               
        </tbody></table>
    </div>
</div>

</div>
   
                                </fieldset> 
                            </div>
                    </td>
                    
                    <td>
                        <div id="panel_draggable_1_3" class="panel_draggable panel-preview" style="margin:4px 2px; ">
                                <fieldset id="panel_resizable_1_3" class="panel_resizable panel-preview" style="width:350px; height:380px; ">
                                    <legend>Trainings Cost/Department</legend>
                                    
    <div class="" style="height: 100%;" id="dashboard__pendingLeaveRequests"><div id="task-list-group-panel-container" class="" style="height:100%; ">
    <div id="task-list-group-panel-menu_holder" class="task-list-group-panel-menu_holder" style="height:85%; overflow-x:scroll; overflow-y:hidden;">
        <div id="chartdiv2" class="chartdiv">
            
            
            
            
        </div> 
    </div>
    <div id="total">
        <table class="table">
            <tbody>
              
                
               
        </tbody></table>
    </div>
</div>

</div>
   
                                </fieldset> 
                            </div>
                    </td>
                      
                    <td>
                        <div id="panel_draggable_1_3" class="panel_draggable panel-preview" style="margin:4px 2px; ">
                                <fieldset id="panel_resizable_1_3" class="panel_resizable panel-preview" style="width:500px; height:380px; ">
                                    <legend>Trainings/Course</legend>
                                    
    <div class="" style="height: 100%;" id="dashboard__pendingLeaveRequests"><div id="task-list-group-panel-container" class="" style="height:100%; ">
    <div id="task-list-group-panel-menu_holder" class="task-list-group-panel-menu_holder" style="overflow-x: hidden; overflow-y:hidden;">
        <div id="chartdiv3" class="chartdiv"></div> 
    </div>
    <div id="total">
        <table class="table">
            <tbody>
              
                
                
        </tbody></table>
    </div>
</div>

</div>
   
                                </fieldset> 
                            </div>
                    </td>
                        
                        
                        </tr>
                    
                   
                    
                
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
     $("#pdfbtn").click(function(e){
       
     html=$("#recordsListTable").html();
     url=$("#pdfurl").val();
$.ajax({
            url: url,
            type: 'post',
            data: {
                'data':html
                
            },
            dataType: 'html',
            success: function(urll) {
                window.open(urll, '_blank');
            }
        });  
        });
           $("#btnAddSlab").click(function(e){
       
   
     url=$("#addurl").val();
window.location.href=url; 
        });
        
        $("#emailbtn").click(function(e){
     html=$("#pdftable").html();
     url=$("#pdfurl").val()+"?sendemail=true&report=Disbursed Loans Report";
$.ajax({
            url: url,
            type: 'post',
            data: {
                'data':html
                
            },
            dataType: 'html',
            success: function(success) {
               alert(success);
            }
        });  
   
   });
  
         $(function() {
	
	$('.print').click(function() {
		var container = $(this).attr('rel');
		$('#' + container).printArea();
		return false;
	}); 
   });  
   
     //trainings /department
     
     
var chart = AmCharts.makeChart("chartdiv", {
  "type": "pie",
  "startDuration": 0,
   "theme": "light",
  "addClassNames": true,
 
  "innerRadius": "30%",
  "defs": {
    "filter": [{
      "id": "shadow",
      "width": "200%",
      "height": "200%",
      "feOffset": {
        "result": "offOut",
        "in": "SourceAlpha",
        "dx": 0,
        "dy": 0
      },
      "feGaussianBlur": {
        "result": "blurOut",
        "in": "offOut",
        "stdDeviation": 5
      },
      "feBlend": {
        "in": "SourceGraphic",
        "in2": "blurOut",
        "mode": "normal"
      }
    }]
  },
  "dataProvider": [{
    "department": "Management",
    "value": 2
  }, {
    "department": "IT&Finance",
    "value":5
  }, {
    "department": "HR&Admin",
    "value": 6
  }, {
    "department": "Marketing",
    "value": 0
  }, {
    "department": "Operations",
    "value": 1
  }],
  "valueField": "value",
  "titleField": "department",
  "export": {
    "enabled": true
  }
});

chart.addListener("init", handleInit);

chart.addListener("rollOverSlice", function(e) {
  handleRollOver(e);
});

function handleInit(){
  chart.legend.addListener("rollOverItem", handleRollOver);
}

function handleRollOver(e){
  var wedge = e.dataItem.wedge.node;
  wedge.parentNode.appendChild(wedge);
}
     
    
});

//trainings cost
var chart = AmCharts.makeChart( "chartdiv2", {
  "type": "serial",
  "theme": "light",
   "dataProvider": [{
    "department": "Management",
    "value":1000000
  }, {
    "department": "IT&Finance",
    "value":600000
  }, {
    "department": "HR&Admin",
    "value": 600000
  }, {
    "department": "Marketing",
    "value": 400000
  }, {
    "department": "Operations",
    "value": 900000
  }],
  "valueAxes": [ {
    "gridColor": "#FFFFFF",
    "gridAlpha": 0.2,
    "dashLength": 0
  } ],
  "gridAboveGraphs": true,
  "startDuration": 1,
  "graphs": [ {
    "balloonText": "[[category]]: <b>[[value]]</b>",
    "fillAlphas": 0.8,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": "value"
  } ],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "department",
  "categoryAxis": {
    "gridPosition": "start",
    "gridAlpha": 0,
    "tickPosition": "start",
    "tickLength": 20
  },
  "export": {
    "enabled": true
  }

} );

//skills count

var chart = AmCharts.makeChart( "chartdiv3", {
  "type": "pie",
  "theme": "light",
  "dataProvider": [ {
    "skill": "Managerial 101",
    "trainings": 2
  }, {
    "skill": "Communication&Dialogue",
    "trainings": 10
  },{
    "skill": "MIS",
    "trainings": 5
  },{
    "skill": "Marketing",
    "trainings": 8
  } ],
  "valueField": "trainings",
  "titleField": "skill",
  "outlineAlpha": 0.4,
  "depth3D": 15,
  "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
  "angle": 30,
  "export": {
    "enabled": true
  }
} );

</script>