// $("#reseller-login").submit(function (e) {
//   $(".error_span").html("");
//   alert("teset");
//   e.preventDefault();
//   var formdata = $("#reseller-login").serializeArray();
//   $.ajax({
//     type: "POST",
//     url: base_phpurl + "/reseller/login",
//     data: getJsonObject(formdata),
//     dataType: "json",
//     success: function (response) {
//       alert("test")
//       if (response.status) {
//         $("#ajax-success-response")
//           .html(response.message)
//           .css({ color: "green", "font-size": "18px", padding: "20px" });
//         window.location.href = response.redirect;
//       } else {
//         reloadCaptcha();
//         $("#reseller-login input[name='captcha']").val("");
//         if (
//           typeof response.errors != "undefined" &&
//           Object.keys(response.errors).length > 0
//         ) {
//           $.each(response.errors, function (indexInArray, valueOfElement) {
//             $("#reseller-login #" + indexInArray + "_ajax_error").html(
//               valueOfElement[0]
//             );
//           });
//         } else {
//           $("#reseller-login-error")
//             .html(response.message)
//             .css({ color: "red" });
//         }
//       }
//     },
//   });

//   setTimeout(() => {
//     $(".error_span").html("");
//   }, 2000);
// });
$("#reseller-login").submit(function (e) {
  e.preventDefault();
  $(".error_span").html("");

  var formdata = $("#reseller-login").serialize();

  $.ajax({
    type: "POST",
    url: base_phpurl + "/reseller/login",
    data: formdata,
    dataType: "json",
    success: function (response) {
      if (response.status) {
        $("#ajax-success-response")
          .html(response.message)
          .css({
            color: "green",
            "font-size": "18px",
            padding: "20px",
          })
          .show();
        window.location.href = response.redirect;
      } else {
        reloadCaptcha();
        $("#reseller-login input[name='captcha']").val("");
        if (response.errors && Object.keys(response.errors).length > 0) {
          $.each(response.errors, function (indexInArray, valueOfElement) {
            $("#" + indexInArray + "_ajax_error").html(valueOfElement[0]);
          });
        } else {
          $("#reseller-login-error")
            .html(response.message)
            .css({
              color: "red",
            })
            .show();
        }
      }
    },
    error: function (xhr) {
      if (xhr.status === 422) {
        var errors = xhr.responseJSON.errors;
        $.each(errors, function (key, value) {
          $("#" + key + "_ajax_error").html(value[0]);
        });
      }
    },
  });

  setTimeout(() => {
    $(".error_span").html("");
  }, 2000);
});

function reloadCaptcha() {
  $.ajax({
    type: "GET",
    url: base_phpurl + "/reload-captcha",
    dataType: "text",
    success: function (response) {
      $("#display-captcha").attr("src", response);
    },
  });
}
// Registration
$("#reseller-register").submit(function (e) {
  e.preventDefault();
  var formdata = $("#reseller-register").serializeArray();
  $.ajax({
    type: "POST",
    url: base_phpurl + "/reseller/register",
    data: getJsonObject(formdata),
    dataType: "json",
    success: function (response) {
      if (response.status) {
        // reloadCaptcha();
        $("#reseller-register")[0].reset();
        $("#modalMobileVerifyReseller").modal({
          show: true,
          backdrop: "static",
          keyboard: false,
        });
        $("#ajax-success-response")
          .html(response.message)
          .css({ color: "green", "font-size": "18px", padding: "20px" });
      } else {
        if (
          typeof response.errors != "undefined" &&
          Object.keys(response.errors).length > 0
        ) {
          $.each(response.errors, function (indexInArray, valueOfElement) {
            if (valueOfElement[0].indexOf("confirm") > 0) {
              $("#reseller-register #cpassword_ajax_error").html(
                valueOfElement[0]
              );
              $("input[name='password_confirmation']").click(function (e) {
                e.preventDefault();
                $("#reseller-register #cpassword_ajax_error").html("");
              });
            } else {
              $("#reseller-register #" + indexInArray + "_ajax_error").html(
                valueOfElement[0]
              );
            }
            $("input[name=" + indexInArray + "]").click(function (e) {
              e.preventDefault();
              $("#reseller-register #" + indexInArray + "_ajax_error").html("");
            });
          });
          reloadCaptcha();
        } else {
          console.log("else");
          $("#ajax-fail-response")
            .html(response.message)
            .css({ color: "red", "font-size": "15px", padding: "20px" });
        }
      }
    },
    complete: function () {
      setTimeout(() => {
        $("#ajax-fail-response").html("");
      }, 2000);
    },
  });
});

$("#mobile-verification-reseller").submit(function (e) {
  e.preventDefault();
  var formdata = $("#mobile-verification-reseller").serializeArray();
  $.ajax({
    type: "POST",
    url: base_phpurl + "/reseller/doRegister",
    data: getJsonObject(formdata),
    dataType: "json",
    success: function (response) {
      if (response.status) {
        $("#ajax-success-response")
          .html(
            "You have register successfully.We sent you credentials mail. Please Login"
          )
          .css({ color: "green" });
        setTimeout(() => {
          window.location.href = base_phpurl + response.redirect;
        }, 2000);
      } else {
        $("#otp_number_ajax_error")
          .html(response.message)
          .css({ color: "red", "font-size": "15px", padding: "20px" });
        $("input[name='otp_number']").click(function (e) {
          e.preventDefault();
          $("#mobile-verification-reseller #otp_number_ajax_error").html("");
        });
      }
    },
  });
});
function formatAMPM() {
  var date = new Date();
  var day = date.getDate();
  var month = date.getMonth() + 1;
  var year = date.getFullYear();
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var seconds = date.getSeconds();
  var ampm = hours >= 12 ? "PM" : "AM";
  day = day < 10 ? "0" + day : day;
  month = month < 10 ? "0" + month : month;
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? "0" + minutes : minutes;
  seconds = seconds < 10 ? "0" + seconds : seconds;
  $("#nav-clock").html(
    "<span style='color:#d7943d'>Date:</span> " +
      day +
      "-" +
      month +
      "-" +
      year +
      " " +
      hours +
      ":" +
      minutes +
      ":" +
      seconds +
      " " +
      ampm
  );
  //$("#nav-clock").html(hours + ':' + minutes +' '+ ampm);
  setTimeout(formatAMPM, 500);
}

$("#update-my-details").submit(function (e) {
  e.preventDefault();
  var formdata = $("#update-my-details").serializeArray();
  var mobileno = $("#update-my-details input[name='mobile_no']").val();
  var name = $("#update-my-details input[name='first_name']").val();
  var last_name = $("#update-my-details input[name='last_name']").val();
  var email = $("#update-my-details input[name='email']").val();
  if (
    email == "" &&
    !$("#update-my-details input[name='email']").prop("disabled")
  ) {
    $("#email-ajax-response")
      .html("Email should not be empty")
      .css({ color: "red" });
    $("#update-my-details #email").click(function (e) {
      $("#email-ajax-response").html("");
    });
    return false;
  }
  if (
    mobileno == "" &&
    !$("#update-my-details input[name='mobile_no']").prop("disabled")
  ) {
    $("#mobile-ajax-response")
      .html("Mobile should not be empty")
      .css({ color: "red" });
    $("#update-my-details #mobile_no").click(function (e) {
      $("#mobile-ajax-response").html("");
    });
    return false;
  }
  var html = "";
  $.ajax({
    type: "POST",
    url: base_phpurl + "/reseller/update-mydetails",
    data: getJsonObject(formdata),
    dataType: "json",
    success: function (response) {
      if (response.otp) {
        html = `<label class="control-label col-sm-2" for="email">OTP:</label>
              <div class="col-sm-3">
                  <input type="text" class="form-control" id="email_otp" name="email_otp" value="">
                  <span id="otp_ajax_response"></span>
              </div>
              <div class="col-sm-3">
                  <button type="submit" class="btn btn-primary btn-sm">Validate OTP</button>
                  <button class="btn btn-primary btn-sm" id='send-email-again'>Send Again</button>
              </div>`;
        $("#dynamic-div").html(html);
        $("#otp_ajax_response").html(response.message).css({ color: "green" });
      } else {
        if (!response.email) {
          $.each(response.errors, function (indexInArray, valueOfElement) {
            if (indexInArray == "email") {
              $("#email-ajax-response")
                .html(valueOfElement["0"])
                .css({ color: "red" });
              $("#update-my-details #email").click(function (e) {
                $("#email-ajax-response").html("");
              });
            }
          });
        }
      }

      if (response.email_change) {
        window.location.href = base_phpurl + "/login";
      } else if (
        typeof response.email_change != "undefined" &&
        !response.email_change
      ) {
        $("#otp_ajax_response").html(response.message).css({ color: "red" });
      }

      if (response.mobile_change) {
        $("#old-mobile").val(response.mobile_no);
        $("#mobile-otp-ajax-response")
          .html(response.message)
          .css({ color: "green" });
      } else {
        if (!response.mobile_change) {
          $("#mobile-otp-ajax-response")
            .html(response.message)
            .css({ color: "red" });
        }
      }

      if (response.name_change) {
        $("#old-name").val(name);
        // $('#last-name').val(last_name);
        $("#reseller-name").html(name + '<span class="caret"></span>');
        $("#name-ajax-response").html(response.message).css({ color: "green" });
      } else {
        if (!response.name_change) {
          $("#name-ajax-response").html(response.message).css({ color: "red" });
        }
      }
      if (response.last_name_change) {
        // $("#old-name").val(name);
        $("#last-name").val(last_name);
        $("#reseller-name").html(name + '<span class="caret"></span>');
        $("#last-name-ajax-response")
          .html(response.message)
          .css({ color: "green" });
      } else {
        if (!response.name_change) {
          $("#last-name-ajax-response")
            .html(response.message)
            .css({ color: "red" });
        }
      }

      if (response.mobile) {
        html = `<label class="control-label col-sm-2" for="mobile">OTP:</label>
              <div class="col-sm-3">
                  <input type="text" class="form-control" id="mobile_otp" name="mobile_otp" value="">
                  <span id="mobile-otp-ajax-response"></span>
              </div>
              <div class="col-sm-3">
                  <button type="submit" class="btn btn-primary btn-sm">Validate OTP</button>
                  <button class="btn btn-primary btn-sm" id='send-mobilesms-again'>Send Again</button>
              </div>`;

        $("#change-phone-div").html(html);

        $("#mobile-otp-ajax-response")
          .html(response.message)
          .css({ color: "green" });
      } else {
        $.each(response.errors, function (indexInArray, valueOfElement) {
          if (indexInArray == "mobile_no") {
            $("#mobile-ajax-response")
              .html(valueOfElement["0"])
              .css({ color: "red" });
            $("#update-my-details #mobile_no").click(function (e) {
              $("#mobile-ajax-response").html("");
            });
          } else if (indexInArray == "email") {
            $("#email-ajax-response")
              .html(valueOfElement["0"])
              .css({ color: "red" });
            $("#update-my-details #email").click(function (e) {
              $("#email-ajax-response").html("");
            });
          }
        });
      }
    },
  });
});

$("#reseller-password-change input[name='password']").click(function (e) {
  e.preventDefault();
  $(".password").html("");
});

$("#reseller-password-change input[name='password_confirmation']").click(
  function (e) {
    e.preventDefault();
    $(".confirm-password ").html("");
  }
);

//Retrieve All Payments javascript functionality starts
function getAllResellerPayments(perpage = 10) {
  $.ajax({
    url: base_phpurl + "/reseller/payments/" + perpage,
    type: "GET",
    dataType: "html",
    success: function (response) {
      $("#paginate_payment").html(response);
    },
    error: function () {},
    complete: function () {},
  });
}

function getAllNotifications()
{
    var notseennotifycount = 0;
    var notificationHTML = ""
    $.ajax({
        url:base_phpurl+"/merchant/notifications",
        type:"GET",
        dataType:"json",
        success:function(response){
            $.each(response,function(index,object){
                if(object.seen =="N")
                {
                    notseennotifycount += 1;
                }
                notificationHTML += `<li>
                                        <a href="javascript:">
                                        <p>`+object.message+`</p>
                                            <h4>
                                                <small class='pull-right'><i class="fa fa-clock-o"></i> `+object.created_date+`</small>
                                            </h4>
                                        </a>
                                    </li>`;

            });

            if(notificationHTML == "")
            {
                notificationHTML = `<li>
                                        <a href="javascript:">
                                        <h4>
                                        <small class="text-center"><i class="fa fa-clock-o"></i>No Notifications</small>
                                        </h4>
                                        <p></p>
                                        </a>
                                    </li>`;
            }

            $("#notifications-list").prepend(notificationHTML);
            $("#new-notification-count").html(notseennotifycount);
            $("#new-notification-status").html("You have "+notseennotifycount+" notification");
        },
        error:function(){},
        complete:function(){}
    });
}

function getAllResellerMessages()
{
    var notseenmessagecount = 0;
    var messageHTML = ""
    $.ajax({
        url:base_phpurl+"/reseller/messages",
        type:"GET",
        dataType:"json",
        success:function(response){
            $.each(response,function(index,object){
                if(object.seen =="N")
                {
                    notseenmessagecount += 1;
                }
                messageHTML += `<li>
                                    <a href="javascript:">
                                    `+object.message+`
                                    </a>
                                </li>`;

            });
            if(messageHTML == "")
            {
                messageHTML = `<li><a href="javascript:" class="text-center">No Messages</a></li>`;
            }
            $("#messages-list").prepend(messageHTML);
            $("#new-message-count").html(notseenmessagecount);
            $("#new-message-status").html("You have "+notseenmessagecount+" message");
        },
        error:function(){},
        complete:function(){}
    });
}


function getAllResellerNotifications(perpage=10){
    $.ajax({
        type:"GET",
        url:base_phpurl+"/reseller/reseller-notifications/"+perpage,
        dataType:"html",
        success:function(response) {
            $("#paginate_notification").html(response);
        }
    });
}

function getAllResellerMessages(perpage=10){
    $.ajax({
        type:"GET",
        url:base_phpurl+"/reseller/reseller-messages/"+perpage,
        dataType:"html",
        success:function(response) {
            $("#paginate_message").html(response);
        }
    });
}

//feedback add
$("#feedback-form").submit(function(e){
  e.preventDefault();
  var formdata = $("#feedback-form").serializeArray();
  $.ajax({
      url:base_phpurl+"/reseller/feedback/add",
      type:"POST",
      data:getJsonObject(formdata),
      dataType:"json",
      success:function(response){
          if(response.status)
          {
              $("#ajax-feedback-response").html(response.message).css({"color":"green"});
          }else{
              $.each(response.error,function(name,value){
                  $("#feedback-form #ajax_"+name+"_error").html(value).css({"color":"red"});
                  $("#feedback-form select").on("change",function(e){
                      $("#feedback-form #ajax_"+name+"_error").html("");
                  });
                  $("#feedback-form input[name="+name+"]").on("click",function(e){
                      $("#feedback-form #ajax_"+name+"_error").html("")
                  });
              });
          }
      },
      error:function(){},
      complete:function(){
          $("#feedback-form")[0].reset();
          setTimeout(() => {
              $("#ajax-feedback-response").html("");
          }, 1500);
      }
  })
});

function giveRating(object){
  $("#feedback-form input[name='feed_rating']").val($(object).attr("data-value"));
}

    //Retrieve reseller feedback data functionality starts here
    function getFeedbackData(perpage=10)
    {
        var tablerow = ""
        $.ajax({
            url:base_phpurl+"/reseller/feedback/get/"+perpage,
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_feedbackdetail").html(response);
            },
            error:function(){},
            complete:function(){}
        });
    }
    //Retrieve reseller feedback data functionality ends here

    function getResellerSupportData(perpage=10)
    {
        var tablerow = ""
        $.ajax({
            url:base_phpurl+"/reseller/support/get/"+perpage,
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_reseller_support").html(response);
            },
            error:function(){},
            complete:function(){}
        });
    }
    //Retrieve reseller support data functionality ends here

        //Store Support functionality starts here
        $("#support-form").submit(function(e){
          e.preventDefault();
          var formdata = $("#support-form")[0];
          var data = new FormData(formdata);
    
          $.ajax({
              url:base_phpurl+"/reseller/support/add",
              type:"POST",
              data:data,
              processData:false,
              contentType:false,
              cache:false,
              dataType:"json",
              success:function(response){
                  if(response.status)
                  {
                      $("#ajax-support-response").html(response.message).css({"color":"green"});
                  }else{
                      $.each(response.error,function(name,value){
                          $("#support-form #ajax-"+name+"-error").html(value).css({"color":"red"});
                          $("#support-form input[name="+name+"]").on("click",function(e){
                              $("#support-form #ajax-"+name+"-error").html("")
                          });
                          $("#support-form select").on("change",function(e){
                              $("#support-form #ajax_"+name+"_error").html("");
                          });
                      });
                  }
              },
              error:function(){},
              complete:function(){
                  getResellerSupportData();
                  formdata.reset();
                  $("#choose_file").html("Choose a file");
                  setTimeout(() => {
                      $("#ajax-support-response").html("");
                  }, 1500);
              }
          })
      });
  
      //Store Support functionality ends here

      function getGstInvoicereport()
      {
  
          var appendid = $("#gst-report-range-form input[name='module']").val();
          var formdata = $("#gst-report-range-form").serializeArray();
          var transactionHTML = "";
          $.ajax({
              url:base_phpurl+"/reseller/gstinvoicereport",
              type:"POST",
              data:getJsonObject(formdata),
              async: false,
              // dataType:"Json",
              success:function(response){
                  
                  $('#gst_report').html(null);
                  $('#gst_report').html(response.gst_invoice_report);
                  
                 
  
                  console.log(response);
                  //noOfPayments(response);
              },
              error:function(){
              },
              complete:function(){}
          }); 
         
      }