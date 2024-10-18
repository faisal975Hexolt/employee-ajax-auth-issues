base_url = $("#base_url").val();
getAllNotifications();
getAllMessages();
$(document).on("submit", "#report_form", function (event) {
  event.preventDefault();
  $.ajax({
    type: "POST",
    url: base_url + "/reseller/createdownloadreport",
    data: $("#report_form").serializeArray(),
    async: false,
    success: function (data) {
      var url = base_url + "/reseller/downloadreport?" + $.param(data.res);

      window.location = url;
      fetch_reseller_report_log(0);
    },
  });

  fetch_reseller_report_log(0);
});

$(".submitButton").prop("disabled", true);

$(document).on("change", "#listreport", function (event) {
  var tableName = $(this).val();

  if (tableName) {
    $(".submitButton").prop("disabled", true);
    $(".loader").show();
    $.ajax({
      type: "POST",
      url: base_phpurl + "/reseller/getreportResellerparameter",
      data: $("#report_form").serializeArray(),
      dataType: "json",
      success: function (response) {
        $(".report_parameter").html(null);
        if (response.status) {
          $(".report_parameter").html(response.view);
        }
      },
      complete: function () {
        setTimeout(() => {
          $(".loader").hide();

          $(".submitButton").prop("disabled", false);
        }, 1500);
      },
    });
  }
});

$(document).on("submit", "#datatable_form", function (event) {
  event.preventDefault();
  $.ajax({
    type: "POST",
    url: base_url + "/reseller/createdownloadreport",
    data: $("#datatable_form").serializeArray(),
    async: false,
    success: function (data) {
      var url = base_url + "/reseller/downloadreport?" + $.param(data.res);

      window.location = url;
      fetch_reseller_report_log(1);
    },
  });

  fetch_reseller_report_log(1);
});
if (window.location.href.indexOf("payin/transaction_report") > 0) {
  fetch_reseller_report_log(0);
  
}
if (window.location.href.indexOf("payin/transaction") > 0) {
  getResellerTransactionsByDate();
  getAllNotifications();
  getAllMessages();
}
if (window.location.href.indexOf('reseller') > 0) {
  getAllNotifications();
  getAllMessages();
}
function fetch_reseller_report_log(is_datatable) {
  $.ajax({
    type: "GET",
    url: base_url + "/reseller/reportlog?is_datatable=" + is_datatable,

    success: function (response) {
      // $("#transaction-report-div").html(null);
      $("#transaction-report-div").html(response.log_view);
    },
  });
}

function gstInvoiceReort(element, filter_date) {
  $(".d-show").html(null);
  $(".d-show").html(filter_date);
  $.ajax({
    type: "POST",
    url: base_url + "/reseller/gstinvoicereportdetails",
    data: {
      _token: $('meta[name="csrf-token"]').attr("content"),
      filter_date: filter_date,
    },
    async: false,
    success: function (response) {
      $("#gst_report_details").html(null);
      $("#gst_report_details").html(response.detail_view);
    },
  });

  $("#gst-report-model").modal("show");
}

$("#Payouttransactiontbl").DataTable({
  fnInitComplete: function () {
    // Disable TBODY scoll bars
    $(".dataTables_scrollBody").css({
      overflow: "hidden",
      border: "0",
    });

    // Enable TFOOT scoll bars
    $(".dataTables_scrollFoot").css("overflow", "auto");

    $(".dataTables_scrollHead").css("overflow", "auto");

    // Sync TFOOT scrolling with TBODY
    $(".dataTables_scrollFoot").on("scroll", function () {
      $(".dataTables_scrollBody").scrollLeft($(this).scrollLeft());
    });

    $(".dataTables_scrollHead").on("scroll", function () {
      $(".dataTables_scrollBody").scrollLeft($(this).scrollLeft());
    });
  },
  dom: "lBfrtip",
  pageLength: 10,
  scrollX: true,
  buttons: ["colvis", "print", "pdf", "excel"],
});

var table = $("#example1").DataTable({
  fnInitComplete: function () {
    // Disable TBODY scoll bars
    $(".dataTables_scrollBody").css({
      overflow: "hidden",
      border: "0",
    });

    // Enable TFOOT scoll bars
    $(".dataTables_scrollFoot").css("overflow", "auto");

    $(".dataTables_scrollHead").css("overflow", "auto");

    // Sync TFOOT scrolling with TBODY
    $(".dataTables_scrollFoot").on("scroll", function () {
      $(".dataTables_scrollBody").scrollLeft($(this).scrollLeft());
    });

    $(".dataTables_scrollHead").on("scroll", function () {
      $(".dataTables_scrollBody").scrollLeft($(this).scrollLeft());
    });
  },
  scrollX: true,
  scrollCollapse: true,
  dom: "Zlrtip",
  colResize: {
    tableWidthFixed: false,
    //"handleWidth": 10,
    resizeCallback: function (column) {},
  },
  searching: false,
  paging: false,
  info: false,
  deferRender: true,
  sScrollX: "190%",
});

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
//Retrieve All Payments javascript functionality ends

//Retrieve All Refunds javascript functionality starts
function getAllResellerRefunds(perpage = 10) {
  $.ajax({
    url: base_phpurl + "/reseller/refunds/" + perpage,
    type: "GET",
    dataType: "html",
    success: function (response) {
      $("#paginate_refund").html(response);
    },
    error: function () {},
    complete: function () {},
  });
}
//Retrieve All Refunds javascript functionality ends

//Retrieve All Orders javascript functionality starts
function getAllResellerOrders(perpage = 10) {
  $.ajax({
    url: base_phpurl + "/reseller/orders/" + perpage,
    type: "GET",
    dataType: "html",
    success: function (response) {
      $("#paginate_order").html(response);
    },
    error: function () {},
    complete: function () {},
  });
}
//Retrieve All Orders javascript functionality ends

function getAllResellerDisputes(perpage=10)
{
    $.ajax({
        url:base_phpurl+"/reseller/disputes/"+perpage,
        type:"GET",
        dataType:"html",
        success:function(response){
            $("#paginate_dispute").html(response);
        },
        error:function(){},
        complete:function(){}
    });
}

function viewAllNotifications(){
  $.ajax({
      type:"GET",
      url:base_phpurl+"/reseller/view-all-notifications",
      dataType:"json",
      success: function(response){
          $("#reseller-new-notification-count").html("0");
          $("#reseller-new-notification-status").html("You have 0 new notification");
      }
  });
}
function getAllNotifications()
{
  
    var notseennotifycount = 0;
    var notificationHTML = ""
    $.ajax({
        url:base_phpurl+"/reseller/notifications",
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

            $("#reseller-notifications-list").prepend(notificationHTML);
            $("#reseller-new-notification-count").html(notseennotifycount);
            $("#reseller-new-notification-status").html("You have "+notseennotifycount+" notification");
        },
        error:function(){},
        complete:function(){}
    });
}

function getAllMessages()
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