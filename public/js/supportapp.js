$(document).ready(function(){
   if(window.location.href.indexOf("/case-status/customer") > 0)
   {
        getCommentDetails();
   }
});

$(document).ajaxError(function( event, jqxhr, settings, thrownError ) {
    if(jqxhr.status!=200)
    {   
       // return false;
        alert("Your token has expired please refresh the page");
        location.href = "/support";
    }
});

//Customer Comment functionality Starts here
$("#customer-comment-form").submit(function(e){
    e.preventDefault();
    var formdata = $("#customer-comment-form").serializeArray();
    $.ajax({
        url:base_phpurl+"/support/customer/comment/add",
        type:"POST",
        data:getJsonObject(formdata),
        dataType:"json",
        success:function(response){
            if(response.status)
            {
                $("#ajax-comment-response").html(response.message).css({"color":"green"});
            }
        },
        error:function(){},
        complete:function(){
            getCommentDetails();
            $("#customer-comment-form")[0].reset();
            setTimeout(() => {
                $("#ajax-comment-response").html("");
            }, 1500);
        }
    });
});

//Retrieve Case Comments 
function getCommentDetails(){
    var caseid = $("#customer-comment-form input[name='case_id']").val();
    var commentHtml = "";
    $.ajax({
        url:base_phpurl+"/support/case/comment/get/"+caseid,
        type:"GET",
        dataType:"json",
        success:function(response){
            alert(1);
            if(response.length > 0)
            {
                $.each(response,function(index,object){
                    commentHtml+="<div class='row comment'>";
                    commentHtml+="<div class='head'><strong class='user'>"+object.commented_user+"</strong><strong class='user'>"+object.commented_date+"</strong></div>";
                    commentHtml+="<p>"+object.comment+"</p>";
                    commentHtml+="</div>";
                });
            }else{
                commentHtml+="<div class='row comment'>";
                commentHtml+="<div class='head'></div>";
                commentHtml+="<p>No comments till now</p>";
                commentHtml+="</div>";
            }
            $("#previous-comment").html(commentHtml);
        },
        error:function(){},
        complete:function(){}
    });
}


$("#transactionProof").attr("src",$('#inputtransactionProof').val());
$(document).on('submit', '#case-form', function(event){
      event.preventDefault();

      $.ajax({
            url:base_phpurl+"/support/new",
            method:'POST',
            data:new FormData(this),
            contentType:false,
            processData:false,
            dataType:"json",
            success:function(response){
               
            if(response.status)
            {
                $("#show-success-message").html(response.message).css({"color":"green"});
                $("#case-form")[0].reset();
                $("#transactionProof").attr("src",$('#inputtransactionProof').val());
                 setTimeout(() => {
                    alert(response.message);
                     window.close();
                }, 3000);

            }else{
               
                if(typeof response.errors != "undefined" && Object.keys(response.errors).length > 0)
                {
                   
                    $.each(response.errors,function(name,message){
                       
                        $("#"+name+"_ajax_error").html(message[0]).css({"color":"red"});
                        $("#case-form input[name="+name+"]").click(function(){
                            $("#"+name+"_ajax_error").html("");
                        });
                        $("#case-form select[name="+name+"]").click(function(){
                            $("#"+name+"_ajax_error").html("");
                        });
                         $("#case-form file[name="+name+"]").click(function(){
                            $("#"+name+"_ajax_error").html("");
                        });
                    });
                }else{

                    $("#show-fail-message").html(response.message).css({"color":"red"});
                    alert(response.message);
                     location.href = "/support";
                    // $("#case-form")[0].reset();
                }
            }
        },
        error:function(){},
        complete:function(){
            setTimeout(() => {
                $("#show-fail-message").html("");
                $("#show-success-message").html("");

            }, 6000);
        }
        })



      });



function getCommentDetails(){
    var caseid = $("#customer-comment-form input[name='case_id']").val();
    var commentHtml = "";
    var userType = {'merchant':'Merchant','customer':'Customer','managepay':'S2payment'};
    $.ajax({
        url:base_phpurl+"/support/case/comment/get/"+caseid,
        type:"GET",
        dataType:"json",
        success:function(response){
            if(response.length > 0)
            {
                $.each(response,function(index,object){
                    var right = true;
                    if(object.user_type == 'merchant')
                    {
                        commentHtml+=`<li class="clearfix">
                            <div class="message-data align-right">
                            <span class="message-data-time" >`+object.commented_date+`</span> &nbsp; &nbsp;
                            <span class="message-data-name" >`+userType[object.user_type]+`</span> <i class="fa fa-circle me"></i>
                            </div>
                            <div class="message other-message float-right">
                            `+object.comment+`
                            </div>
                            </li>`;
                        right = false;
                    }else if(object.user_type == 'customer'){
  
                      commentHtml+=`<li>
                          <div class="message-data">
                          <span class="message-data-name" >`+userType[object.user_type]+`</span> <i class="fa fa-circle me"></i>
                          <span class="message-data-time" >`+object.commented_date+`</span> &nbsp; &nbsp;
                          </div>
                          <div class="message my-message">
                          `+object.comment+`
                          </div>
                          </li>`;
                    }else{
  
                        if(right){
                          commentHtml+=`<li class="clearfix">
                            <div class="message-data align-right">
                            <span class="message-data-time" >`+object.commented_date+`</span> &nbsp; &nbsp;
                            <span class="message-data-name" >`+userType[object.user_type]+`</span> <i class="fa fa-circle me"></i>
                            </div>
                            <div class="message other-message float-right">
                            `+object.comment+`
                            </div>
                            </li>`;
                        }else{
                            commentHtml+=`<li>
                            <div class="message-data">
                            <span class="message-data-name" >`+userType[object.user_type]+`</span> <i class="fa fa-circle me"></i>
                            <span class="message-data-time" >`+object.commented_date+`</span> &nbsp; &nbsp;
                            </div>
                            <div class="message my-message">
                            `+object.comment+`
                            </div>
                            </li>`;
                        }
                       
                    }
                });
                
                
            }else{
                commentHtml=`<li class="clearfix">
                            <div class="message-data align-right">
                            <span class="message-data-time" ></span> &nbsp; &nbsp;
                            <span class="message-data-name" >Merchant</span> <i class="fa fa-circle me"></i>
                            </div>
                            <div class="message other-message float-right">
                            No comments till now
                            </div>
                            </li>`;
            }
            $("#previous-comment").html(commentHtml);
            $(".chat-history").each(function(index,element){
                $(".chat-history").animate({ scrollTop: element.scrollHeight}, 600); 
            });
        },
        error:function(){},
        complete:function(){}
    });
  }

function getJsonObject(formdata){
    var jsondata = {};
    $.each(formdata,function(index,Obj){
        jsondata[Obj.name] = Obj.value;
    });
    return jsondata;
}


//Web Image
    var webimagesPreview = function(input, previewId) {
        if (input.files) {
            var filesAmount = input.files.length;
            var preview;
            $('#'+previewId).html('');
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                   // console.log(event.target.result);
                    preview = '<div style="margin-right:10px;margin-bottom:10px;"><img id="transactionProof" style="width: 70%;" src="'+event.target.result+'"  ></div>';
                    $('#'+previewId).append(preview);       
                }

                reader.readAsDataURL(input.files[i]);
            }

        }
    };
    $('.homeImg').on('change', function() {
        var privewclss=$(this).data("privewclss") ;
       // console.log(privewclss);
        webimagesPreview(this, privewclss);
    });

    $('#web_image').on('change', function() {
        webimagesPreview(this, 'web_image_preview');
    });

    