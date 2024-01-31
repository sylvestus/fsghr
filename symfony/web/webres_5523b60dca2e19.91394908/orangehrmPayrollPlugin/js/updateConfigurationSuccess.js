$(document).ready(function() {
    
    $('#btnSave').click(function() {
       var form = $("#frmupdatePayrollConfig");
   $.ajax({
    url: form.attr('action'),
    type: form.attr('method'),
    data: form.serialize(),
    success: function(response) {
    
        $("#messagediv").html(response);
         $("#successDialog").show();
         
   $("#successDialog").fadeOut(3000);
    }
  });
    });
    });