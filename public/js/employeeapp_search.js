
//var alphanumeric = /^\w+$/;
var alphanumeric = /^([\b^\w-])*$/;
///^([\b^A-za-z0-9])*$/

$(document).ready(function(){
  $.ajaxSetup({async:true});
});




(function () {
  var showResults;
  $('#emp-transaction-table').keyup(function () { 
      var searchText;
      searchText = $('#emp-transaction-table').val();
      if(alphanumeric.test(searchText))
      {
        return showResults(searchText);
      }
  });

  function showResults(searchText)
  {
    if(searchText!='')
    {
      var pagemodule = 'settlement_transaction';
      $.ajax({
          type:"GET",
          url: base_phpurl+"/manage/emp/search/"+pagemodule+"/"+searchText,
          dataType: "html",
          success: function (response) {
               $("#paginate_alltransaction").html(response);
          }
      });
    }else{
      getMerchantTransactionsByDate()
    }
     
  }
}.call(this));



$(document).on('click', '#edit_settlement_admin', function(){

     $(".loader").show();
      var settlement_brief_gid=$(this).attr('orderid');
      var mode=$(this).attr('mode');

      $.ajax({
         headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            url:base_phpurl+"/manage/settlement/get_settlement_info",
            type:"POST",
            data:{mid:settlement_brief_gid,mode:mode},
            // dataType:"json",
            success:function(response){
                

             $("#admin-settlemnt-edit-modal").modal({ show: true, backdrop: "static", keyboard: false });
             $('#admin-settlemnt-edit-modal-body').html(null);
             $('#admin-settlemnt-edit-modal-title').html("Add Bank UTR No.");
            $('#admin-settlemnt-edit-modal-body').html(response.merchant_info);
            },
            error:function(){},
            complete:function(){
                 $(".loader").hide();
            }
        })
      

  });



 $(document).on('submit', '#update_settlemnt_details_form', function(event){
    
    event.preventDefault();
    
    var formdata = $("#update_settlemnt_details_form").serializeArray();
     url=$(this).attr('action');
    $.ajax({
        url:url,
        type:"POST",
        data:getJsonObject(formdata),
        dataType:"json",
        success:function(response){
            if(response.status)
            {
                $("#show-success-message").html(response.message).css({"color":"green"});
                $("#update_settlemnt_details_form")[0].reset();
                setTimeout(
                        function() 
                        {
                                 $("#admin-settlemnt-edit-modal").modal('hide');
                                 location.reload();
                        }, 2000);
                 
            }else{

                if(typeof response.errors != "undefined" && Object.keys(response.errors).length > 0)
                {
                    $.each(response.errors,function(name,message){
                        $("#"+name+"_ajax_error").html(message[0]).css({"color":"red"});
                        $("#update_settlemnt_details_form input[name="+name+"]").click(function(){
                            $("#"+name+"_ajax_error").html("");
                        });
                        $("#update_settlemnt_details_form select[name="+name+"]").click(function(){
                            $("#"+name+"_ajax_error").html("");
                        });
                    });
                }else{

                    $("#show-fail-message").html(response.message).css({"color":"red"});
                    $("#update_settlemnt_details_form")[0].reset();
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
    });
   });


