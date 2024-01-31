$(document).ready(function() {
   
    isValidForm();
   
    $('#addCustomer_customerId').val(customerId);
    $('#btnSave').click(function() {
        if($('#btnSave').val() == lang_edit){
            $(".editable").each(function(){
                $(this).removeAttr("disabled");
            });
            $('#btnSave').val(lang_save);
        } else if ($('#btnSave').val() == lang_save){
            if(isValidForm()){  
                $('#frmAddCustomer').submit();
            }      
        }
    });
    
    $("#undeleteYes").click(function(){
        $('#frmUndeleteCustomer').submit();
        $("#undeleteDialog").toggle();
    });

    $("#undeleteNo").click(function(){
        $(this).attr('disabled', true);
        $('#addCustomer_customerName').attr('disabled', false);
        $('#frmAddCustomer').get(0).submit();
        $("#undeleteDialog").toggle();
    });
    
    $("#undeleteCancel").click(function(){
        $("#undeleteDialog").toggle();
    });
       
    if(customerId > 0) {
        $('#addCustomerHeading').text(lang_editCustomer);
        $(".editable").each(function(){
            $(this).attr("disabled", "disabled");
        });
        $('#btnSave').val(lang_edit);
    }
       
    $('#btnCancel').click(function() {
        window.location.replace(cancelBtnUrl+'?customerId='+customerId);
    });
       
    $('#btnAdd').click(function() {
        window.location.replace(addCustomerUrl);
    });
    

    
    
});




