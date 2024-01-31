<!DOCTYPE html>
<?php 
$cultureElements = explode('_', $sf_user->getCulture()); 
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $cultureElements[0]; ?>" lang="<?php echo $cultureElements[0]; ?>">
    
    <head>

        <title>SAVANNA HRM</title>
        
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        
        <link rel="shortcut icon" href="<?php echo theme_path('images/favicon.ico')?>" />
        
        <!-- Library CSS files -->
        <link href="<?php echo theme_path('css/bootstrap.css')?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo theme_path('css/reset.css')?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo theme_path('css/tipTip.css')?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo theme_path('css/jquery/jquery-ui-1.8.21.custom.css')?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo theme_path('css/jquery/jquery.autocomplete.css')?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo theme_path('css/css/TableTools.css')?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo theme_path('css/css/jquery.dataTables.css')?>" rel="stylesheet" type="text/css"/>
         <link href="<?php echo theme_path('css/bootstrap-year-calendar.css')?>" rel="stylesheet" type="text/css"/>
         <style type="text/css">
/*             @media all {
    .exporttable tr td {
    white-space: nowrap !important;
    border-top:1px solid #000 !important;
}

          .exporttables tr td {
    white-space: nowrap !important;
    border-top:1px solid #000 !important;
}
}*/
          
    
/*        #tabs { margin:0; padding:0; list-style:none; overflow:hidden;margin-top:40px }
        #tabs li { float:left; display:block; padding:5px; background-color:#bbb; margin-right:5px;}
        #tabs li a { color:#fff; text-decoration:none; }
        #tabs li.current { background-color:#e1e1e1;}
        #tabs li.current a { color:#000; text-decoration:none; }
        #tabs li a.remove { color:#f00; margin-left:10px;}
        #content { //background-color:#e1e1e1;
        }
  
        
        #main { width:900px; margin:0px auto; overflow:hidden;background-color:#F6F6F6; margin-top:5px;
             -moz-border-radius:10px;  -webkit-border-radius:10px; padding:10px;}
        #wrapper, #doclist { float:left; margin:0 10px 0 0;}
        #doclist { width:150px; border-right:solid 1px #dcdcdc;}
        #doclist ul { margin:0; list-style:none;}
        #doclist li { margin:10px 0; padding:0;}
        #documents { margin:0; padding:0;}
        
        #wrapper { width:99%; margin-top:10px;}
            */
        
    </style>
        <!-- Custom CSS files -->
        <link href="<?php echo theme_path('css/main.css')?>" rel="stylesheet" type="text/css"/>
        
        
        <?php       
        // Library JavaScript files

        echo javascript_include_tag('jquery/jquery-1.7.2.min.js');

        echo javascript_include_tag('jquery/validate/jquery.validate.js');
        
        echo javascript_include_tag('jquery/jquery.ui.core.js');
        echo javascript_include_tag('jquery/jquery.autocomplete.js');
        echo javascript_include_tag('orangehrm.autocomplete.js');
        echo javascript_include_tag('jquery/jquery.ui.datepicker.js');
        echo javascript_include_tag('jquery/jquery.form.js');
        echo javascript_include_tag('jquery/jquery.tipTip.minified.js');
        echo javascript_include_tag('jquery/bootstrap-modal.js');
        echo javascript_include_tag('jquery/jquery.clickoutside.js');

        
        echo javascript_include_tag('orangehrm.validate.js');
        echo javascript_include_tag('archive.js');
         echo javascript_include_tag('FileSaver.js');
         echo javascript_include_tag('jquery.wordexport.js');
           echo javascript_include_tag('jquery.table2excel.js');
  echo javascript_include_tag('bootstrap-year-calendar.js');
echo javascript_include_tag('datatables/jquery.dataTables.js');
           echo javascript_include_tag('datatables/TableTools/media/js/TableTools.js');
           
          
        /* Note: use_javascript() doesn't work well when we need to maintain the order of JS inclutions.
         * Ex: It may include a jQuery plugin before jQuery core file. There are two position options as
         * 'first' and 'last'. But they don't seem to resolve the issue.
         */
        ?>
        
        <!--<script type="text/javascript" language="javascript" src=""></script>-->
        
         <script type="text/javascript">
      $(document).ready(function() {
          $(".menu").on("click","a",function(e) {
             
              if($(this).attr("id")=="menu_payroll_/"){
                 e.preventDefault();
              //open in new popup
              var nwin=window.open($(this).prop("href"),'','height=800,width=1000');
              if(window.focus){
                  nwin.focus();
              }
              return false;
          }
          });
            
            

    (function()
    {//this IIFE is optional, but is just a lot tidier (no vars cluttering the rest of the script)
        var colours = ['#F00','#0F0','#F11','#0F5','#F03','#0F5','#F30','#0F1','#F06','#0F7','#F08','#0F9','#F60','#0F0'],
     //   currentColour = +(localStorage.previousBGColour || -1) + 1;
      //  $('#content').css({backgroundColor:colours[currentColour]});
    //    localStorage.previousBGColour = currentColour;
    }());
               // addTab($(this));
            });
//
//            $('#tabs').on('click','a.tab',function() {
//                
//                // Get the tab name
//                var contentname = $(this).attr("id") + "_content";
//
//                // hide all other tabs
//                $("#content p").hide();
//                $("#tabs li").removeClass("current");
//
//                // show current tab
//                $("#" + contentname).show();
//                $(this).parent().addClass("current");
//            });
//
//            $('#tabs').on('click',' a.remove', function() {
//                // Get the tab name
//                var tabid = $(this).parent().find(".tab").attr("id");
//
//                // remove tab and related content
//                var contentname = tabid + "_content";
//                $("#" + contentname).remove();
//                $(this).parent().remove();
//
//                // if there is no current tab and if there are still tabs left, show the first one
//                if ($("#tabs li.current").length == 0 && $("#tabs li").length > 0) {
//
//                    // find the first tab    
//                    var firsttab = $("#tabs li:first-child");
//                    firsttab.addClass("current");
//
//                    // get its link name and show related content
//                    var firsttabid = $(firsttab).find("a.tab").attr("id");
//                    $("#" + firsttabid + "_content").show();
//                }
           //});
      // });
//        function addTab(link) {
//            // If tab already exist in the list, return
//            if($(".tab").attr("id")==$(link).attr("id"))
//           {
//              
//                return;
//            }
//            // hide other tabs
//            $("#tabs li").removeClass("current");
//            $("#content p").hide();
//            
//            // add new tab and related content
//            var linkid=$(link).attr("id");
//            $("#tabs").append("<li class='current'><a class='tab' id='" +
//                linkid + "' href='#'>" + $(link).html() + 
//                "</a><a href='#' class='remove'>x</a></li>");
//$("#content").attr("class",linkid);
//if($("#content").attr("class")==linkid){
// $("#content").load("http://localhost/"+$(link).attr("href"));
////            $("#content").html("<p id='" + $(link).attr("id") + "_content'>" + 
////                $(link).attr("href") + "</p>");
//            
//            // set the newly added tab as current
//            $("#" + $(link).attr("id") + "_content").show();
//        }
//        }
    </script>
	
        
       
        <form id="csvform" name="csvform" action= "<?=  url_for('payroll/getCsv')?>" method ="post" > 
<input type="hidden" name="csv_text" id="csv_text">

</form>
        <script type="text/javascript">
            
         $(document).ready(function () {

   
    
    $("#export").on('click', function (event) {
//          event.preventDefault();
//        
//          var csv_value=$('.exporttable').table2CSV({delivery:'value'});
//          
//        
//  $("#csv_text").val(csv_value); 
//  $("#csvform").submit();

$(".exporttable").table2excel({
					//exclude: ".noExl",
					name: "Exported File",
					filename: "exportedList"
				});
                                $(".exporttables").table2excel({
					//exclude: ".noExl",
					name: "Exported File",
					filename: "exportedList"
				});
    });
    
            });
          $(document).ready(function() {   
         $('.exporttable').DataTable( {
        dom: 'T<"clear">lfrtip',
         "autoWidth":true,
          "bSort" : false,
         "bFilter": false,
          "iDisplayLength":500,
        "tableTools": {
            "sSwfPath": "copy_csv_xls_pdf.swf"
        }
    } );
   /* (function($) {
   $.fn.fixMe = function() {
      return this.each(function() {
         var $this = $(this),
            $t_fixed;
         function init() {
            $this.wrap('<div class="dataManipDiv" />');
            $t_fixed = $this.clone();
            $t_fixed.find("tbody").remove().end().addClass("fixed").insertBefore($this);
            resizeFixed();
         }
         function resizeFixed() {
            $t_fixed.find("th").each(function(index) {
               $(this).css("width",$this.find("th").eq(index).outerWidth()+"px");
            });
         }
         function scrollFixed() {
            var offset = $(this).scrollTop(),
            tableOffsetTop = $this.offset().top,
            tableOffsetBottom = tableOffsetTop + $this.height() - $this.find("thead").height();
            if(offset < tableOffsetTop || offset > tableOffsetBottom)
               $t_fixed.hide();
            else if(offset >= tableOffsetTop && offset <= tableOffsetBottom && $t_fixed.is(":hidden"))
               $t_fixed.show();
         }
         $(window).resize(resizeFixed);
         $(window).scroll(scrollFixed);
         init();
      });
   };
})(jQuery);

//$(document).ready(function(){
   $(".tablestatic").fixMe();
   $(".up").click(function() {
      $('html, body').animate({
      scrollTop: 0
   }, 2000);
 });
//}); */
   });     
            

   
        </script>
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->  