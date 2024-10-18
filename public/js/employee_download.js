
$(document).on('submit', '#merchant-transaction-download-form', function(event){
    event.preventDefault();
    var url=$(this).attr('action');
    var formdata = $("#merchant-transaction-form").serializeArray();

   // swalnot("error","hekko");
   $("#merchant-transaction-form").attr('action',url)
   $("#merchant-transaction-form").attr('method','POST')
   $('form#merchant-transaction-form').submit();

});


$(document).on('submit', '#no-merchant-transaction-download-form', function(event){
    event.preventDefault();
    var url=$(this).attr('action');
    var mode=$("#no-merchant-transaction-download-form input[name='mode']").val();
    $(".mer_trans_date_range_form input[name='mode']").val(mode);

    var formdata = $(".mer_trans_date_range_form").serializeArray();

   // swalnot("error","hekko");
   $(".mer_trans_date_range_form").attr('action',url)
   $(".mer_trans_date_range_form").attr('method','POST')
   $('form.mer_trans_date_range_form').submit();

});


$(document).on('submit', '#total-merchant-transaction-download-form', function(event){
    event.preventDefault();
    var url=$(this).attr('action');
    var mode=$("#total-merchant-transaction-download-form input[name='mode']").val();
    $(".mer_trans_date_range_form input[name='mode']").val(mode);

    var formdata = $(".mer_trans_date_range_form").serializeArray();

   // swalnot("error","hekko");
   $(".mer_trans_date_range_form").attr('action',url)
   $(".mer_trans_date_range_form").attr('method','POST')
   $('form.mer_trans_date_range_form').submit();

});


$(document).on('submit', '#tecnical-transaction-download-form', function(event){
    event.preventDefault();
    var url=$(this).attr('action');

   // swalnot("error","hekko");
   $("#show-tecnical-transaction-form").attr('action',url)
   $("#show-tecnical-transaction-form").attr('method','POST')
   $('form#show-tecnical-transaction-form').submit();

});



$(document).on('submit', '#summary-brief-transaction-download-form', function(event){
    event.preventDefault();
    var url=$(this).attr('action');

   // swalnot("error","hekko");
   $("#summary-brief-transaction-form").attr('action',url)
   $("#summary-brief-transaction-form").attr('method','POST')
  $('form#summary-brief-transaction-form').submit();

});

$(document).on('submit', '#summary-refund-transaction-download-form', function(event){
  event.preventDefault();
  var url=$(this).attr('action');

 // swalnot("error","hekko");
 $("#summary-refund-transaction-form").attr('action',url)
 $("#summary-refund-transaction-form").attr('method','POST')
$('form#summary-refund-transaction-form').submit();

});


$(document).on('submit', '#ecollect-transaction-download-form', function(event){
    event.preventDefault();
    var url=$(this).attr('action');

   // swalnot("error","hekko");
   $("#manage-ecollect-transaction-form").attr('action',url)
   $("#manage-ecollect-transaction-form").attr('method','POST')
  $('form#manage-ecollect-transaction-form').submit();

});

$(document).on('submit', '#fundtransfer-transaction-download-form', function(event){
    event.preventDefault();
    var url=$(this).attr('action');

   // swalnot("error","hekko");
   $("#manage-Fundstransfer-form").attr('action',url)
   $("#manage-Fundstransfer-form").attr('method','POST')
  $('form#manage-Fundstransfer-form').submit();

});

$(document).on('submit', '#manage-ledger-transaction-download-form', function(event){
    event.preventDefault();
    var url=$(this).attr('action');

   // swalnot("error","hekko");
   $("#payout-ledger-form").attr('action',url)
   $("#payout-ledger-form").attr('method','POST')
  $('form#payout-ledger-form').submit();

});