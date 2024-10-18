 

$("body").on("change",".inputfile-new",function(e){
        e.preventDefault();

        data = new FormData();
        var file = document.getElementById(this.id).files[0];
        data.append(this.name,file);
        var mid=$(this).attr('mid');
        var user_id=$(this).attr('uid');
         $("#"+this.id+"_error").html('');
        data.append("id",mid);
        data.append("_token",$('meta[name="csrf-token"]').attr('content')); 
       // $("#divLoading").addClass("show");
        //$("#divLoading").removeClass("hide");
       
       
        $.ajax({
            url:base_phpurl+'/merchant/document-submission',
            type: 'POST',
            data:data,
            processData:false,
            contentType:false,
            cache:false,
            dataType:"json",
            success: function(response){
                ajax_response = response.status;
                if(response.status)
                {

                    load_onboard_docuement(user_id);
                    $("#ajax-activate-account-uploaded").html(response.message);
                   // getMerchantDocumentForm();
                }else{

                    if(Object.keys(response.error).length > 0)
                    {
                        $.each(response.error,function(name,value)
                        {
                            $("#"+name+"_error").html(value[0]).css({"color":"red"});
                            $("input[name="+name+"]").click(function(){
                                $("#"+name+"_error").html("");
                            });
                        });
                    }
                }
            },
            complete:function(){

                $("#divLoading").removeClass("show");
                $("#divLoading").addClass("hide");
                setTimeout(() => {
                    $("#ajax-activate-account-uploaded").html("");
                },3000);
            }
        });
    });


     function load_onboard_docuement(user_id){
        $("#ajax1-activate-account-failed").html("");
         if(user_id){
             $.ajax({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                 url:base_phpurl+'/merchant/fetch_reonboarding_doc',
                 type: "POST",
                 data: {
                     user_id: user_id
                 },
                 dataType: 'json',
                 beforeSend: function() {

                     // createModal.addClass('modal_loading');
                 },
                 success: function (data) {

                    $('#view_doc_details').html(data.page);

                 },

                 error: function(xhr) { // if error occured
                    // alert("<?php echo $this->lang->line("error_occurred_please_try_again"); ?>");

                 },
                 complete: function() {

                 }
             });
         }else{

         }
     }



//Edit Merchant Document File code starts here
$("body").on("click",".button125",function(e){
    e.preventDefault();
    var column = $(this).data("name");
    var id = $(this).data("id");
    var user_id=$(this).data('uid');

    $.ajax({
        type:"GET",
        url:base_phpurl+"/merchant/document-submission/remove/"+column+"/"+id,
        dataType:"json",
        async:false,
        success: function (response) {
            if(response.status)
            {
                load_onboard_docuement(user_id);
            }
        }
    });
});

load_onboard_docuement($("#onboardmerchantId").val());

$(document).on('submit', '#merchant-info-form', function(event){

    
    event.preventDefault();
    url=$(this).attr('action');
    formData=new FormData(this);
    console.log(formData);

    valid = true;
    var notMandatory = [];
    $("#merchant-info-form input[type='file']").each(function(index,element){

        var inputName = $(element).attr("name");
        if($.inArray(inputName,notMandatory) == -1){
            console.log()
            if($("#"+inputName+"_file_not_exist").length > 0)
            {
                $("#ajax1-activate-account-failed").html("Upload all the documents to submit form").css({"color":"red"});
                valid = false;
                return false;
            }
        }
    });
    let addharPresent=false;
    console.log(valid);   
    $("#merchant-info-form input[type='text']").each(function(index,element){

        var  inputId= $(element).attr("id");
        var  inputName= $(element).attr("name");
        if($("#"+inputId).val()=='' && inputName!='otp_aadhar_number'){
            $("#merchant-info-form #"+inputName+"_error").html("Field is required")
            .css({"color":"red"});

            $("input[name="+inputName+"]").click(function (e){
                e.preventDefault();
                $("#merchant-info-form #"+inputName+"_error").html("");
            });
            valid = false;
        }
        if(!ValidateRecorrect(inputId,inputName+"_error")){
            console.log(inputId);
            valid = false;
        }
        if(inputName=="mer_aadhar_number"){
            addharPresent=true;
        }
        
    })
    
    if(addharPresent){

         formdata1 =  $("#merchant-info-form").serializeArray();
        var checkAddhar=0;   
        $.ajax({
            type:"POST",
            url:base_phpurl+"/merchant/business-aadhaar/reverify",
            data:formdata1,
            async:false,
            dataType:"json",
            success: function (response) {
                console.log(response);
                mer_aadhar_number='mer_aadhar_number';
                if(response.status)
                {
                    checkAddhar=1;
                    
                    
                    //$("#ajax-business-detail-info-response-message").html(response.message).css({"color":"green"});
                    $("#merchant-info-form #"+mer_aadhar_number+"_error").html(response.message).css({"color":"green"});
                }else{
                    $("#merchant-info-form #"+mer_aadhar_number+"_error").html(response.message).css({"color":"red"});
                   
                }
            },complete:function(){
              
            }
        });
       
    if(checkAddhar==0){
        return false;
    }  
        
    }
       
    $("#merchant-info-form select").each(function(index,element){
        var  inputId= $(element).attr("id");
        var  inputName= $(element).attr("name");
        if($("#"+inputId).val()==''){
            $("#merchant-info-form #"+inputName+"_error").html("Field is required")
            .css({"color":"red"});

            $("input[name="+inputName+"]").click(function (e){
                e.preventDefault();
                $("#merchant-info-form #"+inputName+"_error").html("");
            });
            valid = false;
        }
    })
       
    if(valid){
        $.ajax({
            url:url,
            method:'POST',
            data:new FormData(this),
            contentType:false,
            processData:false,
            dataType:"json",
            complete: function(){

                
             
            },
            success:function(response)
            {

                if(response.status)
                {
                    $("#ajax1-business-info-response-message").html(response.message).css({"color":"green"});

                    if(response.d){
                        swalnot("success",response.message);
                        setTimeout(() => {
                            window.location.href=base_phpurl+"/merchant/dashboard";
                        }, 1000);
                    }else{
                        swalnot("error",response.message);
                    }
                    

                    
                }else{
                    if(Object.keys(response.errors).length > 0)
                    {
                        $.each(response.errors,function (indexInArray, valueOfElement) { 
                             $("#merchant-info-form #"+indexInArray+"_error").html(valueOfElement["0"])
                             .css({"color":"red"});
                            $("select[name="+indexInArray+"]").click(function (e){
                                e.preventDefault();
                                $("#merchant-info-form #"+indexInArray+"_error").html("");
                            });
                            $("input[name="+indexInArray+"]").click(function (e){
                                e.preventDefault();
                                $("#merchant-info-form #"+indexInArray+"_error").html("");
                            });
                        });
                    }
                }
            }
        });
    }else{
        swalnot("error","Please Fill All the required fields Properly");
    }
    

});


//Retrive Business SubCategory starts
function getonboardsubcategory(element){

    var category_id = $(element).val();
    var optionText = $("#"+element.id+" option:selected").text();
    if(optionText != "Others"){
       
        
       
        $.ajax({
            url:base_phpurl+"/merchant/get-sub-category",
            type:"POST",
            data:{id:category_id,_token:$('meta[name="csrf-token"]').attr('content')},
            dataType:"json",
            success:function(response){
                var html='<option value="">--Select--</option>';
                $.each(response,function(index,value){
                    html+='<option value='+value.id+'>'+value.sub_category_name+'</option>';
                });
                $("#sub_category_name").html(html);
                $("#sub_category_name").prop("disabled",false);
            },
            error:function(error){
                
            }
        });
    }else{
       
        $("#sub_category_name").prop("disabled",true);
        
    }
    
}


$(document).on('click', '#on_send_aadhar_otp', function(event){
    formdata1 =  $("#merchant-info-form").serializeArray();
    $(".loader_custom").show();
    var functionStatus = true;
        if (1) { 
            if(functionStatus && validateAadharCard('mer_aadhar_number','mer_aadhar_number_error'))
            {  
                
                $("#mer_aadhar_check_error").html('');
                $.ajax({
                    type:"POST",
                    url:base_phpurl+"/merchant/business-aadhaar/verify",
                    data:formdata1,
                    async:false,
                    dataType:"json",
                    success: function (response) {
                        
                        $("div#mer_aadhar_verify_error_view").removeClass('hide');  
                        if(response.status)
                        {
                            console.log(response.aadhar_otp_count);
                            if(response.aadhar_otp_count>2){
                                $("div#otp_aadhar_view").addClass('hide');  
                                $("#on_send_aadhar_otp").prop("disabled",true);
                                
                                $("#mer_aadhar_verify_error").html(response.message).css({"color":"red"});
                                
                            }else{
                                $("#on_send_aadhar_otp").html('Resend OTP');
                                $("#mer_aadhar_verify_error").html(response.message).css({"color":"green"});
                                $("#on_send_aadhar_otp").prop("disabled",true);
                                $("#otp_aadhar_number").val('');    
                                $("div#otp_aadhar_view").removeClass('hide');  

                                  setTimeout(() => {  
                                    $("#on_send_aadhar_otp").prop("disabled",false);
                                }, 10000);

                            }
                            //$("#ajax-business-detail-info-response-message").html(response.message).css({"color":"green"});
                        }else{
                            if(Object.keys(response.errors).length > 0)
                            {
                                $.each(response.errors,function (indexInArray, valueOfElement) { 
                                    $("#merchant-info-form #"+indexInArray+"_error").html(valueOfElement["0"])
                                    .css({"color":"red"});
                                    $("input[name="+indexInArray+"]").click(function (e){
                                        e.preventDefault();
                                        $("#merchant-info-form #"+indexInArray+"_error").html("");
                                    });
                                });
                            }
                            functionStatus = response.status;
                        }
                    },complete:function(){
                        setTimeout(() => {
                            $(".loader_custom").hide();
                            $("#ajax-business-detail-info-response-message").html("");  
                        }, 3000);
                    }
                });

            }
        }
});


$(document).on('click', '#on_verify_aadhar_otp', function(event){
    var functionStatus = true;
    $(".loader_custom").show();
        if (1) { 
            if(functionStatus && validateOtpAadharCard('otp_aadhar_number','otp_aadhar_number_error') && validateAadharCard('mer_aadhar_number','mer_aadhar_number_error'))
            {  
                formdata1 =  $("#merchant-info-form").serializeArray();            
                $.ajax({
                    type:"POST",
                    url:base_phpurl+"/merchant/business-aadhaar/check",
                    data:formdata1,
                    async:false,
                    dataType:"json",
                    success: function (response) {
                        $("div#mer_aadhar_check_error_view").removeClass('hide'); 
                        if(response.status)
                        {
                            console.log(response.data);
                            if(response.data==5){
                                $("div#mer_aadhar_verify_error_view").addClass('hide'); 
                                $("div#otp_aadhar_view").addClass('hide');  
                                $("#on_send_aadhar_otp").addClass("hide");
                                setTimeout(() => {  
                                    $("#on_send_aadhar_otp").prop("disabled",true);
                                }, 10010);
                                $("#on_verify_aadhar_otp").prop("disabled",true);
                                $("#mer_aadhar_verify_error").html('');
                                $("#mer_aadhar_check_error").html(response.message).css({"color":"green"});
                                $("#merchant-info-form #mer_name").val(response.user_full_name);
                                $("#merchant-info-form #mer_name").prop("readonly",true); 
                                $("#merchant-info-form #mer_aadhar_number").prop("readonly",true);  
                            }else{
                                $("#on_verify_aadhar_otp").prop("disabled",true);
                                $("#on_verify_aadhar_otp").html('Re Verify OTP');
                                $("#mer_aadhar_check_error").html(response.message).css({"color":"red"}); 
                                
                                  setTimeout(() => {
                                    $("#on_verify_aadhar_otp").prop("disabled",false);
                                }, 10000);

                            }
                            //$("#ajax-business-detail-info-response-message").html(response.message).css({"color":"green"});
                        }else{
                            if(Object.keys(response.errors).length > 0)
                            {
                                $.each(response.errors,function (indexInArray, valueOfElement) { 
                                    $("#activate-account #"+indexInArray+"_error").html(valueOfElement["0"])
                                    .css({"color":"red"});
                                    $("input[name="+indexInArray+"]").click(function (e){
                                        e.preventDefault();
                                        $("#activate-account #"+indexInArray+"_error").html("");
                                    });
                                });
                            }
                            functionStatus = response.status;
                        }
                    },complete:function(){
                        setTimeout(() => {
                            $(".loader_custom").hide();
                            $("#ajax-business-detail-info-response-message").html("");  
                        }, 3000);
                    }
                });

            }
        }
});