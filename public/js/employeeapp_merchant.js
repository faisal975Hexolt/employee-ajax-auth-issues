function verifyMerchantDetails(merchantId) {

  $.ajax({
      type: "GET",
      url: base_phpurl+"/manage/risk-complaince/merchant/details/" + merchantId,
      dataType: "json",
      success: function(response) {
          if (typeof response != undefined && Object.keys(response).length > 0) {
              $.each(response[response.length - 1], function(key, value) {
                  $("#" + key).html("<label for=''>" + value + "</label>");
              });
              $("#merchant-detail-view-modal").modal({ show: true, backdrop: "static", keyboard: false });

          }

      }
  });
}


function addMerchantLink() {
  var url=base_phpurl+"/manage/risk-complaince/merchant-document/paysel-7WRwwggm?add=1";
  location.replace(url);
  addMerchantModal();
}

function addMerchantModal() {

   $(".add-merchant-modal").modal({ show: true, backdrop: "static", keyboard: false });
}

function registerMerchantModal() {

   $(".register-merchant-modal").modal({ show: true, backdrop: "static", keyboard: false });
}


$(document).on('submit', '#register_merchant_form', function(event){
        var button = $(this).attr('id');
         eurl=$(this).attr('vemail');
          murl=$(this).attr('vmobile');
        event.preventDefault();
        url=$(this).attr('action');
      
        var counter = $("#modalcounter").val();
      

            var name = $('#m_name').val();
            var email = $('#m_email').val();
            var mobile = $('#mobile').val();
            var password = $('#password').val();

      $('.registerMer').prop('disabled', true);

      

         if (counter == 0) {
                var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                var testMobile = /^[0-9]{10}$/i;



                if (!testEmail.test(email)) {
                    $('#showerror').html('Email is not valid');
                     $('.registerMer').prop('disabled', false);
                    return false;
                }

                $(".registerMer").text('Validating Email');
                var isNotValid=0;
                 $.ajax({
                         type: "POST",
                         headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                         url: eurl,
                         data: {username:email,for:'mail'},
                         dataType: "json",
                         async:false,
                        success: function(res) {
                         if(res.exists){
                            $(".registerMer").text('Submit');
                             isNotValid=1;
                             
                         }
                        },
                          error: function (jqXHR, exception) {

                        }
                        });

                  if (isNotValid) {
                        $('#showerror').html('Email is already used');
                            $('.registerMer').prop('disabled', false);       
                                 return false;
                  }

                    if (!testMobile.test(mobile)) {
                    $('#showerror').html('Mobile Number is not valid');
                       $('.registerMer').prop('disabled', false);
                    return false;
                }
                $(".registerMer").text('Validating Mobile Number');

                $.ajax({
                         type: "POST",
                         headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                         url: murl,
                         data: {username:mobile,for:'mobile'},
                         dataType: "json",
                         async:false,
                        success: function(res) {
                         if(res.exists){
                             isNotValid=1;
                             $(".registerMer").text('Submit');
                             
                         }
                        },
                          error: function (jqXHR, exception) {

                        }
                        });

                 if (isNotValid) {
                        $('#showerror').html('Mobile Number is already used');
                                   $('.registerMer').prop('disabled', false);
                                 return false;
                  }
                 $(".registerMer").text('Submit');  
              
                if (name.length == 0 || email.length == 0 || mobile.length == 0 || password.length == 0) {
                    console.log('please fill all the fields');
                    $('#showerror').html('Please fill all the fields');
                       $('.registerMer').prop('disabled', false);
                    return false;
                }
                $('#showerror').html('');
            }

            event.preventDefault();
            url=$(this).attr('action');
            row=0;
            text = "";
            $.ajax({
            url:url,
            method:'POST',
            data:new FormData(this),
            contentType:false,
            processData:false,
            complete: function(){
             
            },
            success:function(data)
            {
                var result = jQuery.parseJSON(data);
                   $('.registerMer').prop('disabled', false);
                console.log(result);
             if(result.type=="success"){
                 swalnot(result.type,result.message);
                  $('#register_merchant_form')[0].reset();
                   $(".register-merchant-modal").modal('hide');
                   location.reload();
            }else{
                 var mssg=result.message;

                if(typeof(mssg)=='string'){
                    swalnot(result.type,result.message);
                    return true;
                }
                 $.each(mssg, function (key, value) {
                            var input = '#register_merchant_form input[name=' + key + ']';
                            $(input + '+span>strong').text(value);
                            $(input).parent().parent().addClass('has-error');

                            //  text += key +"=>";

                              value.forEach(myFunction);

                               text +=  "<br>";
                        });

                 console.log(text);

                  Swal.fire({
                          title: 'Form Error',
                          icon: 'error',
                          html:
                           '<span style="color:#F8BB86;font-size:15px"><b>'+text+'</b></span>',
                          showCloseButton: true,
                          showCancelButton: true,
                          focusConfirm: false,
                         
                   })
            }
             
            
             //fetch_vendor_details(mid,vendor);
         }
      });


      });




function myFunction(item, index) {
        index=index+1;
        row=row+1;
       text += row + ": " + item + "<br>"; 
}




 