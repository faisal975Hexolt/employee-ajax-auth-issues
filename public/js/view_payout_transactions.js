$(".loader").hide();
var url='';
$(document).on("click", ".view-transaction-model", function (e) {
    e.preventDefault();
    var link = $(this).attr('href');
    show_transaction_details(link);
});
var transaction_status = '';
var transaction_response_code;
var transaction_id = '';
var show_chargeback_form ='';
var error_message ='';
var error_type ='';
var routes = {};
var s2s_double_check = false;
var team_type = '';
var first_level_chargeback_present = '';

function show_transaction_details(link) {
    $(".loader").show();
    $("#create-chargback_form").trigger("reset");
    $("#create-chargeback-id").hide();
    $.ajax({
        type: "GET",
        url: link,
        datatype: 'json',
        success: function success(json) {
            var responseDataJson = jQuery.parseJSON(json);
            transaction_id = responseDataJson['transaction-details']['Transaction ID'];
            transaction_status = responseDataJson['transaction-details']['Transaction Status'];
            transaction_response_code = responseDataJson['transaction-details']['Transaction Response Code'];
            routes = responseDataJson['routes'];
            show_chargeback_form = (responseDataJson['chargeback_eligibility']['show_chargeback_form'] ?? '');
            error_message =(responseDataJson['chargeback_eligibility']['message'] ?? '');
            error_type = (responseDataJson['chargeback_eligibility']['error_type'] ?? '');
            team_type = (responseDataJson['team_type'] ?? '');
            first_level_chargeback_present = (responseDataJson['chargeback_present'] ?? '');
            second_level_chargeback_present = (responseDataJson['second_level_chargeback'] ?? '');

            resetPaymentQueryLogTable();
            resetS2SCallbackInfoTable();
            resetPaymentRequestLogsTable();
            var actived_nav = $('.nav-tabs > li.active');
            actived_nav.removeClass('active');
            //If the transaction is success then only show the create chargeback button
            if (transaction_response_code == 0) {
                var inputs = $("#create-chargback_form input[type='text'],#create-chargback_form select");
                clearErrors(inputs);
                $("#create-refund-button-id").show();
            } else {
                $("#create-refund-button-id").hide();
            }
            if (team_type === 'merchant') {
                $("#payment-query-logs-id").hide();
                $("#payment-request-logs-id").hide();
            } else {
                $("#payment-query-logs-id").show();
                $("#payment-request-logs-id").show();
            }
            var status = responseDataJson.status;
            var message = responseDataJson.message;

            if (status === 'success') {
                $('input[name="crbk_transaction_id"]').val(transaction_id);
                $("#detailsblock").empty();
                $("#logbody").empty();
                $("#settlementlogbody").empty();
                $.each(responseDataJson, function (n, elem) {

                    if (n.indexOf("-details") !== -1) {
                        var find = '-';
                        var re = new RegExp(find, 'g');

                        var heading = n.replace(re, " ").toUpperCase();
                        var header = "<div class=\"col-md-6\">" +
                                                "<div class=\"box box-primary\">" +
                                                    "<div class=\"box-header with-border transaction-details-block\">" +
                                                        "<h3 class=\"box-title\">" + heading + "</h3>" +
                                                    "</div>";
                        var body = "<div class=\"box-body\" style=\"\">";
                        var footer = "</div></div>"

                        var len = Object.keys(elem).length;
                        $.each(elem, function (key, value) {
                            if (value === null) {
                                value = '';
                            }
                            body = body + "<div class=\"row\" style=\"margin: 0 1%;\"><div class=\"col-sm-6 text-right item\" style=\"text-align:left;\">" + key + ":</div>";
                            if (key.indexOf("ID") !== -1 && value !== '') {
                                var copyToClipboardId = key.replace(/ /g,"_").toLowerCase();
                                body = body + "<div class=\"col-sm-6 text-left item\"><strong class=\"copy-to-clipboard-text\" id=\""+copyToClipboardId+"\">" + value + "</strong>&nbsp;&nbsp;&nbsp;" +
                                                    "<span title=\"Copy\" onclick=\"copyToClipboard('"+copyToClipboardId+"')\" class=\"copy_to_clipboard ctc_"+copyToClipboardId+"\">" +
                                                    "<i class=\"fa fa-clipboard copy-to-clipboard-icon\" data-toggle=\"tooltip\" " +
                                                        "data-placement=\"bottom\" title=\"Copy to clipboard\"></i></span>" +
                                            "</div></div>";
                            } else {
                                body = body + "<div class=\"col-sm-6 text-left item\"><b>" + value + "</b></div></div>";
                            }

                        });
                        body = body + "</div>";
                        $("#detailsblock").append(header + body + footer);
                        $('.item').css({'padding-top': '5px', 'padding-bottom': '5px', 'word-wrap': 'break-word'});
                    } else if (n.indexOf("-log") !== -1) {
                        $.each(elem, function (key, value) {
                            var td_body = "<tr>";
                            var settlement_log_td_body = "<tr>";
                            let settlemnt_data_flag = false;
                            if (value === null) {
                                value = '';
                            }
                            $.each(value, function (key1, value1) {
                                if (value1 === null) {
                                    value1 = '';
                                }
                                if(n.indexOf("settlement-log") !== -1) {
                                    settlemnt_data_flag = true;
                                    settlement_log_td_body = settlement_log_td_body + "<td class=\"text-center\">" + value1 + "</td>";
                                } else {
                                    td_body = td_body + "<td class=\"text-center\">" + value1 + "</td>";
                                }
                            });
                            td_body = td_body + "</tr>";
                            $("#logbody").append(td_body);

                            if(settlemnt_data_flag) {
                                $("#settlement-log-datatable").css('display', 'block');
                                $("#settlement-log-datatable-empty").css('display', 'none');
                                settlement_log_td_body = settlement_log_td_body + "</tr>";
                                $("#settlementlogbody").append(settlement_log_td_body);
                            } else {
                                $("#settlement-log-datatable").css('display', 'none');
                                $("#settlement-log-datatable-empty").css('display', 'block');
                            }

                        });
                    }
                });

                if (Swal.isVisible()) {
                    Swal.close();
                }
                $(".loader").hide();

                $("#myModal").modal();

            } else {
                $(".loader").hide();
                Swal.fire("Error!", "Something went wrong!", "error");
            }
        }

    });
}
//The Boostrap modal box has a function called enforceFocus that immediately puts focus on the modal itself
// as soon as we try to focus into an element that is not wrapped in the BS modal box.
//It fixes the issue facing in firefox browser
$('#myModal').on('shown.bs.modal', function() {
    $(document).off('focusin.modal');
});


 function adminfundtransferDetailsView(trans_id)
    {
       
        $.ajax({
            url:base_phpurl+"/payoutdetails/fundtrasnferInfoDetail?transactionID="+trans_id,
            type:"GET",
            // dataType:"json",
            success:function(response){
                routes = response.routes;
                res=response.data;
                transaction_id = res.transaction_info['transaction_gid'];
                $("#fund-detail-transaction-model").modal({show:true,keyboard:false,backdrop:'static'});
                $('#fund-transaction_details_view').html(null);
                $('#fund-transaction_details_view').html(response.tran_details_view);
                
            },
            error:function(){},
            complete:function(){}
        })
       
    }

$( "#create-chargeback-button-id" ).click(function() {
    if(second_level_chargeback_present){
        Swal.fire("Error!", "Maximum chargebacks has already been created against this Transaction.", "error");
        $('#create-chargeback-button-id').disable();
        $("#create-chargeback-id").hide();
    }else if(first_level_chargeback_present){
        Swal.fire({
            title: "Chargeback is already present in the system, do you wish to create another chargeback!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $('#crbk_second_chargeback').val('y');
                $("#create-chargeback-id").show();
            }else{
                $('#crbk_second_chargeback').val('n');
                $("#create-chargeback-id").hide();
            }
        });
    }else{
        if(!$('#create-chargeback-id').is(":visible")){
            $("#create-chargeback-id").show();
        }
    }
});

function clearErrors(inputs) {
    $('#create-chargback_form>ul').hide();
    for (var i = 0; i < inputs.length; i++) {
        var input_field = inputs[i].id;
        var input = $('input[name=' + input_field + ']');
        input.removeAttr('data-toggle').removeAttr('data-trigger').removeAttr('data-placement').removeAttr('data-content');
        input.removeClass('highlight-error');
        input.popover('destroy');
    }
}

$(document).ready(function () {
    $("#create-refund-button-id").click(function () {
        if(transaction_response_code == 0){
            window.location = routes['refund'];
        }
    });


    function callStatusOrS2sApi(link) {
        var get_transaction_details_link = routes['get_transaction_details'];
        $.ajax({
            type: "POST",
            url: link,
            success: function (json) {
                $(".loader").hide();
                var state = jQuery.parseJSON(json);
                var status = state.status;
                var data = state.data;
                if(status == 'success'){
                    Swal.fire("Success!", data, "success");
                    show_transaction_details(get_transaction_details_link);
                }else{
                    Swal.fire("Error!", data, "error");
                }
            },
            error: function (err) {
                $(".loader").hide();
                var errors = jQuery.parseJSON(err.responseText)['message'];
                Swal.fire("Error!", errors, "error");
            }
        });
    }


    $("#get-payment-status-button").click(function () {
        Swal.fire({
            title: 'Are You Sure ?',
            text: 'After clicking YES, background job get fire it may take some time to complete.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                if(transaction_status != 'SUCCESS'){
                    $(".loader").show();
                    callStatusOrS2sApi(routes['get_payment_status']);
                }
            }
        });
    });

    $("#create-chargeback-button-id").click(function () {
        if (show_chargeback_form === 'n') {
            $("#create-chargback_form").hide();
        }else{
            $("#create-chargback_form").show();
        }
        if(error_type === 'warning'){
            Swal.fire("Warning!", error_message, "warning");
        }else if(error_type === 'error'){
            Swal.fire("Error!", error_message, "error");
        }
    });

    $("#send-s2s-response-button").click(function () {
        if(s2s_double_check){
            var title_message = 'S2S response is already sent for this transaction, If you still want to send again, Please enter "{CODE}" in following input box and click Confirm.';
            var text = 'After clicking Confirm, background job get fire it may take some time to complete.';
            //If s2s is successfully sent earlier, then ask the user for double confirmation
            double_confirmation_alert(title_message, text, function(status) {
                // If the status given from the [confirm] method
                if (status == true) {
                    callStatusOrS2sApi(routes['send_s2s_response']);
                }
            });
        }else{
            //If s2s not sent earlier , then send the s2s response to merchant
            Swal.fire({
                title: 'Are You Sure ?',
                text: 'After clicking YES, background job get fire it may take some time to complete.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    $(".loader").show();
                    callStatusOrS2sApi(routes['send_s2s_response']);
                }
            });
        }
    });

    $("#payment-query-logs-id").on('click', function (e) {
        e.preventDefault();
        resetPaymentQueryLogTable();

        if (transaction_status == 'SUCCESS') {
            $("#get-payment-status-button").hide();
        } else {
            $("#get-payment-status-button").show();
        }
        if (transaction_id != '') {
            $(".loader").show();
            $.ajax({
                type: 'POST',
                url: routes['get_payment_query_logs'],
                success: function (data) {
                    if (data.length > 0) {
                        $('#payment-query-logs-table').DataTable({
                            data: data,
                            columns: [
                                {title: "DateTime"},
                                {title: "Message"},
                                {title: "Request"},
                                {title: "Responses"}
                            ],
                            'order': [[0, "desc"]],
                            'paging': true,
                            'lengthChange': true,
                            'lengthMenu': [[10, 15, 25, 50, 100, 200, -1], [10, 15, 25, 50, 100, 200, "All"]],
                            'searching': true,
                            'searchDelay': 200, //ms
                            'ordering': true,
                            'dom': 'Bflrtip',
                            'info': true,
                            'buttons': []
                        });
                        $("#payment-query-logs-div").show();
                    } else {
                        $('#no_data').show();
                    }
                    $(".loader").hide();
                    return true;
                },
                error: function (err) {
                    $(".loader").hide();
                    var error = '';
                    error = JSON.parse(err.responseText).message;
                    Swal.fire("Error!", error, "error");
                }
            });
        }
    });

  
    $(document).on('click','#s2s-callback-logs-id', function(e) {
        e.preventDefault();
        resetS2SCallbackInfoTable();

        if (transaction_id != '') {
            $(".loader").show();
            s2s_double_check = false;
            $.ajax({
                type: 'POST',
                url: routes['get_s2s_callback_logs'],
                success: function (data) {
                    data = jQuery.parseJSON(data);
                    if (data.length > 0) {
                        $.each(data, function (key, val) {
                            //val[2] has status code of the s2s log, if status code is 200 then s2s is sent successfully to merchant
                            if(val[2] === '200' && val[3] !== 'paymentResponse'){
                                s2s_double_check = true;
                            }
                        });
                        $('#s2s-callback-logs-table').DataTable({
                            data: data,
                            columns: [
                                {title: "DateTime"},
                                {title: "Callback URL"},
                                {title: "Status"},
                                {title: "Type"},
                                {title: "Request Log"},
                                {title: "Response Log"},
                            ],
                            'order': [[0, "desc"]],
                            'paging': true,
                            'lengthChange': true,
                            'lengthMenu': [[10, 15, 25, 50, 100, 200, -1], [10, 15, 25, 50, 100, 200, "All"]],
                            'searching': true,
                            'searchDelay': 200, //ms
                            'ordering': true,
                            'dom': 'Bflrtip',
                            'info': true,
                            'buttons': []
                        });
                        $("#s2s-callback-logs-div").show();
                    } else {
                        $('#no_s2s_data').show();
                    }
                    $(".loader").hide();
                    return true;
                },
                error: function (err) {
                    $(".loader").hide();
                    var error = '';
                    error = JSON.parse(err.responseText).message;
                    Swal.fire("Error!", error, "error");
                }
            });
        }
    });



   $(document).on('click','#payment-request-logs-id', function(e) {
        e.preventDefault();
       
        resetPaymentRequestLogsTable();
        if (transaction_id != '') {
            $(".loader").show();

            
            $.ajax({
                type: 'POST',
                url: routes['get_payment_request_logs'],
                success: function (json) {
                    var state = jQuery.parseJSON(json);

                    var status = state.status;
                    var data = state.data;


                    if (data.length > 0 && status == 'success') {
                        $('#payment-request-logs-table').DataTable({
                            data: data,
                            columns: [
                                {title: "Payment Date Time"},
                                {title: "Payment Request"},
                                {title: "Payment Response"}
                            ],
                            "columnDefs": [
                                        { "width": "20%", "targets": 2 }
                                ],
                            'order': [[0, "desc"]],
                            'paging': true,
                            'lengthChange': true,
                            'lengthMenu': [[10, 15, 25, 50, 100, 200, -1], [10, 15, 25, 50, 100, 200, "All"]],
                            'searching': true,
                            'searchDelay': 200, //ms
                            'ordering': true,
                            'dom': 'Bflrtip',
                            'info': true,
                            'buttons': []
                        });
                        $("#payment-request-logs-div").show();
                    } else {
                        Swal.fire("Warning!", data, "warning");
                        $('#no_payment_request_data').show();
                    }
                    $(".loader").hide();
                    return true;
                },
                error: function (err) {
                    $(".loader").hide();
                    var error = '';
                    error = JSON.parse(err.responseText).message;
                    Swal.fire("Error!", error, "error");
                }
            });
        }
    });
});

//Clear the table after reset
function resetPaymentQueryLogTable() {
    $("#no_data").hide();
    if ($.fn.DataTable.isDataTable("#payment-query-logs-table")) {
        $("#payment-query-logs-table").DataTable().destroy();
    }
    $("#payment-query-logs-table").empty();
    $('#payment-query-logs-div').hide();
    $('#get-payment-status-button').hide();

}

//Clear the table after reset
function resetS2SCallbackInfoTable() {
    $("#no_s2s_data").hide();
    if ($.fn.DataTable.isDataTable("#s2s-callback-logs-table")) {
        $("#s2s-callback-logs-table").DataTable().destroy();
    }
    $("#s2s-callback-logs-table").empty();
    $('#s2s-callback-logs-div').hide();

}

//Clear the table after reset
function resetPaymentRequestLogsTable() {
    $("#no_payment_request_data").hide();
    if ($.fn.DataTable.isDataTable("#payment-request-logs-table")) {
        $("#payment-request-logs-table").DataTable().destroy();
    }
    $("#payment-request-logs-table").empty();
    $('#payment-request-logs-div').hide();

}

//Copy text to clipboard by clciking copy icon
function copyToClipboard(selector){
    copyText = $("#" + selector).html()
    navigator.clipboard.writeText(copyText);
    $(".copy-to-clipboard-icon").attr("data-original-title", "Copy to clipboard").parent().find('.tooltip-inner').html("Copy to clipboard");
    $(".ctc_"+selector+" .copy-to-clipboard-icon").attr("data-original-title", "Copied to clipboard").parent().find('.tooltip-inner').html("Copied to clipboard");

    $(document).on("mouseleave", ".ctc_" + selector + " .copy-to-clipboard-icon", function(){
        sleep(500).then(() => {
            $(".copy-to-clipboard-icon").attr("data-original-title", "Copy to clipboard").parent().find('.tooltip-inner').html("Copy to clipboard");
        });
    });

    //$("strong.copy-to-clipboard-text").css({'background-color' : "", "padding" : "", "line-height" : ""});
    //$(".copy_to_clipboard .fa-clipboard").css({'margin-top' : ""});
    //$(".ctc_"+selector+" .fa-clipboard").css({'margin-top' : ""});
    //$("#" + selector).css({'background-color' : "#ccc", "padding" : "4px", "line-height" : "20px"});
    //$(".ctc_"+selector+" .fa-clipboard").css({'margin-top' : "6px"});
}


function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}


