


function showMyPasssword(elementName, iconelement) {
    var status = $("div").data("pstatus");
    x = $("#reset-merchant-password-change input[name=" + elementName + "]")[0];
    if (x.type === "password") {
        x.type = "text";
        $(iconelement).html('<i class="fa fa-eye-slash fa-lg"></i>');
    } else {
        x.type = "password";
        $(iconelement).html('<i class="fa fa-eye fa-lg"></i>');
    }
}



//Retrieve merchant Webhook functioanlity starts here
function fetchWebhookData(id) {
    var eventscount = 0;
    var tablevalues = ["webhook_url", "is_active", "created_date"]
    var webhookURL = "";
    var isActive = "";
    var tablerowhtml = "";
    var createdDate = "";
    $.ajax({
        url: base_phpurl + "/manage/merchant/webhook/" + id,
        type: "GET",
        dataType: "json",
        success: function (response) {

            $('#merchant-webhook-view').html(null);
            $('#merchant-webhook-view').html(response.webhook_info);

        },
        error: function () { },
        complete: function () {


        }
    });
}




$(document).on('click', '.show_vendor_config', function () {
    var vendor_name = $(this).val();
    var mid = $(this).attr('mid');
    if (vendor_name != 'NA' && vendor_name != '') {
        fetch_vendor_details(mid, vendor_name);
    }

});

let text = "";
let row = 0;
$(document).on('submit', '#admin-vendor-delete-form', function (event) {
    event.preventDefault();
    url = $(this).attr('action');
    mid = $("#admin-vendor-delete-form input[name=id]").val();
    vendor_name = $("#admin-vendor-delete-form input[name=vendor_id]").val();
    row = 0;
    text = "";
    $.ajax({
        url: url,
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        complete: function () {

        },
        success: function (data) {
            var result = jQuery.parseJSON(data);


            if (result.type == "success") {
                swalnot(result.type, result.message);
                fetch_vendor_details(mid, vendor_name);
                $('#admin-vendor-delete-form')[0].reset();
                $("#vendorDeleteModal").modal('hide');
            } else {
                var mssg = result.message;

                if (typeof (mssg) == 'string') {
                    swalnot(result.type, result.message);
                    return true;
                }
                $.each(mssg, function (key, value) {
                    var input = '#admin-vendor-delete-form input[name=' + key + ']';
                    $(input + '+span>strong').text(value);
                    $(input).parent().parent().addClass('has-error');

                    //  text += key +"=>";

                    value.forEach(myFunction);

                    text += "<br>";
                });

                console.log(text);

                Swal.fire({
                    title: 'Form Error',
                    icon: 'error',
                    html:
                        '<span style="color:#F8BB86;font-size:15px"><b>' + text + '</b></span>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,

                })
            }

            // $("#vendor-config-edit-modal").modal('hide');

            //fetch_vendor_details(mid,vendor);
        }
    });
});


function fetch_vendor_details(mid, vendor) {


    $.ajax({
        url: base_phpurl + "/manage/merchant/vendorconfig/" + mid + "/" + vendor,
        type: "GET",
        // dataType:"json",
        success: function (response) {


            $('#vendor-config-div').html(null);
            $('#vendor-config-div').html(response.vendorconfig_details_view);

        },
        error: function () { },
        complete: function () { }
    })
}

$(document).on('click', '.add-vendor-key-admin', function () {

    var mid = $(this).attr('mid');
    var vendor = $(this).attr('vendor');
    var rowid = $(this).attr('rowid');

    // swalnot("error","hekko");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: base_phpurl + "/manage/merchant/vendorconfigshow/" + mid + "/" + vendor,
        type: "get",
        data: { rowid: rowid },
        // dataType:"json",
        success: function (response) {


            $("#vendor-config-add-modal").modal({ show: true, backdrop: "static", keyboard: false });
            $('#vendor-config-add-modal-body').html(null);
            $('#vendor-config-add-modal-body').html(response.vendorconfig_details_view);
        },
        error: function () { },
        complete: function () { }
    })


});


$(document).on('click', '.edit_vendor_config', function () {

    var mid = $(this).attr('mid');
    var vendor = $(this).attr('vendor');
    var rowid = $(this).attr('rowid');

    // swalnot("error","hekko");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: base_phpurl + "/manage/merchant/vendorconfigshow/" + mid + "/" + vendor,
        type: "POST",
        data: { rowid: rowid },
        // dataType:"json",
        success: function (response) {


            $("#vendor-config-edit-modal").modal({ show: true, backdrop: "static", keyboard: false });
            $('#vendor-config-edit-modal-body').html(null);
            $('#vendor-config-edit-modal-body').html(response.vendorconfig_details_view);
        },
        error: function () { },
        complete: function () { }
    })


});

$(document).on('click', '.add-webhook-admin', function () {

    var mid = $(this).attr('mid');
    var mode = $(this).attr('mode');
    var rowid = $(this).attr('rowid');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: base_phpurl + "/manage/merchant/getwebhook",
        type: "POST",
        data: { mid: mid, mode: mode, rowid: rowid },
        // dataType:"json",
        success: function (response) {


            $("#admin-webhook-modal").modal({ show: true, backdrop: "static", keyboard: false });
            $(".admin-webhook-modal-title").html('Add webhook');
            if (rowid) {
                $(".admin-webhook-modal-title").html('Edit webhook');
            }

            $('.admin-webhook-modal-body').html(null);
            $('.admin-webhook-modal-body').html(response.merchant_webhook_view);
        },
        error: function () { },
        complete: function () { }
    })






});


$(document).on('submit', '.admin_vendor_keys_form', function (event) {
    event.preventDefault();
    url = $(this).attr('action');


    mid = $("#admin_vendor_keys_form input[name='merchant_id'").val();
    vendor = $("#admin_vendor_keys_form input[name='vendor'").val();

    $.ajax({
        url: url,
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        complete: function () {

        },
        success: function (data) {
            var result = jQuery.parseJSON(data);
            swalnot(result.type, result.message);
            $("#vendor-config-edit-modal").modal('hide');
            $("#vendor-config-add-modal").modal('hide');

            fetch_vendor_details(mid, vendor);
        }
    });
});


$(document).on('submit', '#reset-merchant-password-change', function (event) {
    event.preventDefault();
    url = $(this).attr('action');
    row = 0;
    text = "";
    $.ajax({
        url: url,
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        complete: function () {

        },
        success: function (data) {
            var result = jQuery.parseJSON(data);

            console.log(result);
            if (result.type == "success") {
                swalnot(result.type, result.message);
                $('#reset-merchant-password-change')[0].reset();
            } else {
                var mssg = result.message;

                if (typeof (mssg) == 'string') {
                    swalnot(result.type, result.message);
                    return true;
                }
                $.each(mssg, function (key, value) {
                    var input = '#reset-merchant-password-change input[name=' + key + ']';
                    $(input + '+span>strong').text(value);
                    $(input).parent().parent().addClass('has-error');

                    //  text += key +"=>";

                    value.forEach(myFunction);

                    text += "<br>";
                });

                console.log(text);

                Swal.fire({
                    title: 'Form Error',
                    icon: 'error',
                    html:
                        '<span style="color:#F8BB86;font-size:15px"><b>' + text + '</b></span>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,

                })
            }

            // $("#vendor-config-edit-modal").modal('hide');

            //fetch_vendor_details(mid,vendor);
        }
    });
});


$(document).on('submit', '#update_merchant_details_form', function (event) {
    event.preventDefault();
    url = $(this).attr('action');
    row = 0;
    text = "";
    $.ajax({
        url: url,
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        complete: function () {

        },
        success: function (data) {
            var result = jQuery.parseJSON(data);

            console.log(result);
            if (result.type == "success") {
                swalnot(result.type, result.message);
                $('#update_merchant_details_form')[0].reset();
                $("#admin-merchant-edit-modal").modal('hide');
                location.reload();
            } else {
                var mssg = result.message;

                if (typeof (mssg) == 'string') {
                    swalnot(result.type, result.message);
                    return true;
                }
                $.each(mssg, function (key, value) {
                    var input = '#update_merchant_details_form input[name=' + key + ']';
                    $(input + '+span>strong').text(value);
                    $(input).parent().parent().addClass('has-error');

                    //  text += key +"=>";

                    value.forEach(myFunction);

                    text += "<br>";
                });

                console.log(text);

                Swal.fire({
                    title: 'Form Error',
                    icon: 'error',
                    html:
                        '<span style="color:#F8BB86;font-size:15px"><b>' + text + '</b></span>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,

                })
            }


            //fetch_vendor_details(mid,vendor);
        }
    });
});




$(document).on('submit', '#admin-webhook-form', function (event) {
    event.preventDefault();
    url = $(this).attr('action');
    merchant_id = $("#admin-webhook-form input[name='merchant_id']").val();
    row = 0;
    text = "";
    $.ajax({
        url: url,
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        complete: function () {

        },
        success: function (data) {
            var result = jQuery.parseJSON(data);


            if (result.type == "success") {
                swalnot(result.type, result.message);
                $('#admin-webhook-form')[0].reset();
                $(".admin-webhook-modal").modal('hide');
                fetchWebhookData(merchant_id);
                // location.reload();
            } else {
                var mssg = result.message;

                if (typeof (mssg) == 'string') {
                    swalnot(result.type, result.message);
                    return true;
                }
                $.each(mssg, function (key, value) {
                    var input = '#admin-webhook-form input[name=' + key + ']';
                    $(input + '+span>strong').text(value);
                    $(input).parent().parent().addClass('has-error');

                    //  text += key +"=>";

                    value.forEach(myFunction);

                    text += "<br>";
                });

                console.log(text);

                Swal.fire({
                    title: 'Form Error',
                    icon: 'error',
                    html:
                        '<span style="color:#F8BB86;font-size:15px"><b>' + text + '</b></span>',
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
    index = index + 1;
    row = row + 1;
    text += row + ": " + item + "<br>";
}


$(document).on('click', '.edit_merchant_admin', function () {

    $(".loader").show();

    var mid = $(this).attr('mid');
    var mode = $(this).attr('mode');

    var editModalTitle = $(this).html();
    $('.editModalTitle').html(editModalTitle + ' Merchant');

    // swalnot("error","hekko");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: base_phpurl + "/manage/merchant/get_merchant_info",
        type: "POST",
        data: { mid: mid, mode: mode },
        // dataType:"json",
        success: function (response) {


            $("#admin-merchant-edit-modal").modal({ show: true, backdrop: "static", keyboard: false });
            $('#admin-merchant-edit-modal-body').html(null);
            $('#admin-merchant-edit-modal-body').html(response.merchant_info);
        },
        error: function () { },
        complete: function () {
            $(".loader").hide();
        }
    })


});







$(document).on('change', '#e_business_category_id', function () {
    var categoryID = $(this).val();

    console.log(base_phpurl)

    if (!base_phpurl.startsWith('https://')) {
        base_phpurl = 'https://' + base_phpurl.replace(/^http:\/\//i, "");
    }

    var ajaxUrl = base_phpurl + "/manage/get_business_subcategories";
    console.log("Base URL: " + base_phpurl);
    console.log("AJAX URL: " + ajaxUrl);

    $.ajax({
        type: 'GET',
        datatype: 'json',
        url: ajaxUrl,
        data: {
            'categoryID': categoryID
        },

        success: function (data) {

            $('select[name="e_business_sub_category_id"]').empty();
            $.each(data, function (key, value) {

                $('select[name="e_business_sub_category_id"]').append('<option value="' + value.id + '">' + value.sub_category_name + '</option>');
            })
        }
    })
})




//Store merchant api functionality starts here

$(document).on('click', '.admin-generate-api', function (e) {
    e.preventDefault();
    var mid = $(this).attr('mid');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: base_phpurl + "/manage/papi/add",
        type: "POST",
        data: { mid: mid },
        dataType: "json",
        success: function (response) {
            if (response.length > 0) {

                $.each(response[response.length - 1], function (key, value) {
                    $("#update-api-modal-admin input[name=" + key + "]").val(value);
                });
            }
        },
        error: function () { },
        complete: function () {
            getA_MerchantApi(mid);
            $("#update-api-modal-admin").modal({ show: true, backdrop: 'static', keyboard: false });
        }
    })
});
//Store merchant api functionality ends here



//Retrieve merchant api functioanlity starts here
function getA_MerchantApi(mid) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: base_phpurl + "/manage/papi/get-api",
        type: "POST",
        data: { mid: mid },
        // dataType:"html",
        success: function (response) {

            $('#merchant-api-view').html(null);
            $('#merchant-api-view').html(response.api_info);
            // $("#merchant-api-view").html(response);
        },
        error: function () {

        }
    })
}

//Retrieve merchant api functionality ends here



//get Api Details javascript functionality code starts here
$(document).on('click', '.viewpayinApiadmin', function (e) {
    if (api_id != "") {
        var mid = $(this).attr('mid');
        var api_id = $(this).attr('rowid');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: base_phpurl + "/manage/papi/details/" + api_id,
            type: "POST",
            data: { mid: mid },
            dataType: "json",
            success: function (response) {
                if (response.length > 0) {
                    $.each(response[response.length - 1], function (key, value) {
                        $("#update-api-modal-admin input[name=" + key + "]").val(value);
                    });
                }
            },
            complete: function () {
                $("#update-api-modal-admin").modal({ show: true, backdrop: 'static', keyboard: false });
            }
        })
    }
});
//get Api Details javascript functionality code ends here


//Edit Api javascript functionality code starts here
$(document).on('click', '.regenerateApiadmin', function (e) {
    var mid = $(this).attr('mid');
    var api_id = $(this).attr('rowid');

    if (api_id != "") {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: base_phpurl + "/manage/papi/edit/" + api_id,
            type: "POST",
            data: { mid: mid },
            dataType: "json",
            success: function (response) {
                if (response.length > 0) {

                    $.each(response[response.length - 1], function (key, value) {
                        $("#update-api-modal-admin input[name=" + key + "]").val(value);
                    });
                }
            },
            complete: function () {
                getA_MerchantApi(mid);
                $("#update-api-modal-admin").modal({ show: true, backdrop: 'static', keyboard: false });
            }
        })
    }
});
//Edit Api javascript functionality code ends here

$(document).on('click', '.vendorDeleteModal', function (e) {

    var button = $(this) // Button that triggered the modal
    console.log(button);
    var id = button.data('id')
    var vendor = button.data('vendor')

    console.log(id, vendor);
    var modal = $(this)
    $("#admin-vendor-delete-form input[name=id]").val(id);
    $("#admin-vendor-delete-form input[name=vendor_id]").val(vendor);


    $("#vendorDeleteModal").modal('show');

})



$(document).on('click', '.edit_merchant_admin_documents', function () {

    $(".loader").show();

    var mid = $(this).attr('mid');
    var mode = $(this).attr('mode');

    var editModalTitle = $(this).html();
    $('.documentModalTitle').html(editModalTitle + ' Merchant Documents');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: base_phpurl + "/manage/merchant/get_merchant_info",
        type: "POST",
        data: { mid: mid, mode: mode },
        // dataType:"json",
        success: function (response) {


            $("#admin-merchant-document-modal").modal({ show: true, backdrop: "static", keyboard: false });
            $('#admin-merchant-document-modal-body').html(null);
            $('#admin-merchant-document-modal-body').html(response.merchant_info);
        },
        error: function () { },
        complete: function () {
            $(".loader").hide();
        }
    })


});

function getAdminMerchantDocumentForm() {
    var merchant_id = $('#update_merchant_details_document_form input[name="merchant_id"]').val();
    var bussinessType = $('#update_merchant_details_document_form input[name="business_type_id"]').val();
    $.ajax({
        type: "GET",
        url: base_phpurl + "/manage/uploddeddocumentsList/" + bussinessType + "/" + merchant_id,
        dataType: "json",
        success: function (response) {
            $('#admin-merchant-document-modal-body').html(null);
            $('#admin-merchant-document-modal-body').html(response.merchant_info);
        }
    });
}


$(document).on('change', '.inputfile-2', function (event) {
    event.preventDefault();

    data = new FormData();
    var file = document.getElementById(this.id).files[0];
    var merchant_id = $('#update_merchant_details_document_form input[name="merchant_id"]').val();
    data.append(this.name, file);
    data.append("doc_id", $("#doc_id").val());
    data.append("_token", $('meta[name="csrf-token"]').attr('content'));
    data.append("merchant_id", merchant_id);
    merchant_id
    $(".loader").show();
    $.ajax({
        url: base_phpurl + '/manage/admin-document-submission',
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json",
        success: function (response) {

            ajax_response = response.status;
            if (response.status) {
                swalnot('success', response.message);
                $("#ajax-activate-account-uploaded").html(response.message);
                getAdminMerchantDocumentForm();
            } else {

                // var mssg=result.message;


                swalnot('error', response.message);


                $(".loader").hide();
                if (Object.keys(response.error).length > 0) {
                    $.each(response.error, function (name, value) {
                        $("#" + name + "_error").html(value[0]).css({ "color": "red" });
                        $("input[name=" + name + "]").click(function () {
                            $("#" + name + "_error").html("");
                        });
                    });
                }
            }
        },
        complete: function () {

            $(".loader").hide();
            setTimeout(() => {
                $("#ajax-activate-account-uploaded").html("");
            }, 3000);
        }
    });
});

$(document).on('submit', '#update_merchant_details_document_form', function (event) {
    event.preventDefault();

    var notMandatory = ["comp_gst_doc"];
    $("#update_merchant_details_document_form input[type='file']").each(function (index, element) {
        var inputName = $(element).attr("name");
        if ($.inArray(inputName, notMandatory) == -1) {
            console.log()
            if ($("#" + inputName + "_file_not_exist").length > 0) {
                $("#ajax-activate-account-failed").html("Upload all the documents to submit form").css({ "color": "red" });
                valid = false;
                return false;
            } else {
                valid = true;
            }
        }
    });

    if (!valid) {
        return valid;
    }


    url = $(this).attr('action');
    row = 0;
    text = "";
    $.ajax({
        url: url,
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        complete: function () {

        },
        success: function (data) {
            var result = jQuery.parseJSON(data);

            console.log(result);
            if (result.type == "success") {
                swalnot(result.type, result.message);
                $('#update_merchant_details_document_form')[0].reset();
                $("#admin-merchant-document-modal").modal('hide');
                location.reload();
            } else {
                var mssg = result.message;

                if (typeof (mssg) == 'string') {
                    swalnot(result.type, result.message);
                    return true;
                }
                $.each(mssg, function (key, value) {
                    var input = '#update_merchant_details_form input[name=' + key + ']';
                    $(input + '+span>strong').text(value);
                    $(input).parent().parent().addClass('has-error');

                    //  text += key +"=>";

                    value.forEach(myFunction);

                    text += "<br>";
                });

                console.log(text);

                Swal.fire({
                    title: 'Form Error',
                    icon: 'error',
                    html:
                        '<span style="color:#F8BB86;font-size:15px"><b>' + text + '</b></span>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,

                })
            }


            //fetch_vendor_details(mid,vendor);
        }
    });
});


$(document).on('click', '#call-merchant-usage-modal', function () {

    recorid = 0;
    $.ajax({
        type: "GET",
        url: base_phpurl + "/manage/technical/get-merchant-usage/" + recorid,
        dataType: "json",
        success: function (data) {
            var response = data.data;
            $(".usageTitle").html("Add Merchant Usage Setting")
            $("#merchant-usage-form input[type='submit']").val("Add Usage Setting");
            $('#usgaeModalBoday').html(null);
            $('#usgaeModalBoday').html(data.view);
            updateMerchantForUsage();
            $("#merchant-usage-modal").modal({ show: true, backdrop: "static", keyboard: false });
        }
    });




});

$(document).on('click', '.editMerchantUsage', function () {
    var mid = $(this).attr('mid');
    recorid = mid;
    $("#merchant-usage-form input[name='usageid']").val(mid);
    $.ajax({
        type: "GET",
        url: base_phpurl + "/manage/technical/get-merchant-usage/" + recorid,
        dataType: "json",
        success: function (data) {
            var response = data.data;
            $(".usageTitle").html("Update Merchant Usage Setting")
            $("#merchant-usage-form input[type='submit']").val("Update Usage Setting");
            $('#usgaeModalBoday').html(null);
            $('#usgaeModalBoday').html(data.view);
            $("#merchant-usage-modal").modal({ show: true, backdrop: "static", keyboard: false });
        }
    });




});

function updateMerchantForUsage() {
    var merchantSelect = $("#merchant_list_usage");

    // Check if the element exists
    if (merchantSelect.length > 0) {
        $.ajax({
            type: "GET",
            url: base_phpurl + "/manage/technical/get_merchant_list_for_usage",
            dataType: "json",
            success: function (response) {
                merchantSelect.empty(); // Clear current options
                merchantSelect.append('<option value="">--Select--</option>'); // Add default option

                // Add new options from the response
                $.each(response, function (index, merchant) {
                    merchantSelect.append('<option value="' + merchant.id + '">' + merchant.merchant_gid + '</option>');
                });
            },
            error: function (xhr, status, error) {
                console.log('Server Response:', xhr.responseText);
            }
        });
    } else {
        console.log('#merchant_list_usage not found on the page.');
    }
}


$(document).ready(function () {
    updateMerchantForUsage();
});



$(document).on('submit', '#merchant-usage-form', function (event) {
    event.preventDefault();

    valid = true;
    $("#merchant-usage-form input[type='text']").each(function (index, element) {
        var inputVal = $(element).val();
        if (inputVal == '') {

            valid = false;

        } else {
            valid = true;
        }

    });

    if (!valid) {
        text = "field can't be empty";
        Swal.fire({
            title: 'Form Error',
            icon: 'error',
            html:
                '<span style="color:#F8BB86;font-size:15px"><b>' + text + '</b></span>',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,

        })

        return true;
    }


    url = $(this).attr('action');
    var formdata = $(this).serializeArray();
    $.ajax({
        url: url,
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: "json",
        complete: function () {

        },
        success: function (response) {

            if (response.status) {
                console.log('merchant form submit')
                updateMerchantForUsage();
                swalnot('success', response.message);
                $("#merchant-usage-add-succsess-response").html(response.message);

                getMerchantUsages();
                $("#merchant-usage-modal").modal('hide');
            } else {

                if (typeof response.errors != "undefined" && Object.keys(response.errors).length > 0) {
                    $.each(response.errors, function (key, value) {
                        $("#merchant-usage-form #" + key + "_error").html(value[0]);
                    });
                } else {
                    $("#merchant-usage-add-fail-response").html(response.message);
                }
            }

        }


        //fetch_vendor_details(mid,vendor);

    });

});

$(document).on('change', '.inputfile-agreement', function (event) {
    event.preventDefault();

    data = new FormData();
    var file = document.getElementById(this.id).files[0];

    var merchant_id = $(this).attr('uid');
    data.append(this.name, file);

    data.append("_token", $('meta[name="csrf-token"]').attr('content'));
    data.append("merchant_id", merchant_id);

    $(".loader").show();
    $.ajax({
        url: base_phpurl + '/manage/agreement-document-submission',
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json",
        success: function (response) {

            ajax_response = response.status;
            if (response.status) {
                swalnot('success', response.message);
                load_agreement_docuement(merchant_id);
            } else {

                // var mssg=result.message;


                swalnot('error', response.message);


                $(".loader").hide();
                if (Object.keys(response.error).length > 0) {
                    $.each(response.error, function (name, value) {
                        $("#" + name + "_error").html(value[0]).css({ "color": "red" });
                        $("input[name=" + name + "]").click(function () {
                            $("#" + name + "_error").html("");
                        });
                    });
                }
            }
        },
        complete: function () {

            $(".loader").hide();
            setTimeout(() => {
                $("#ajax-activate-account-uploaded").html("");
            }, 3000);
        }
    });
});


function load_agreement_docuement(user_id = '') {

    if (user_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: base_phpurl + '/manage/uploddedagreement',
            type: "POST",
            data: {
                user_id: user_id
            },
            dataType: 'json',
            beforeSend: function () {

                // createModal.addClass('modal_loading');
            },
            success: function (data) {

                $('#view_aggrement_doc_details').html(data.page);

            },

            error: function (xhr) { // if error occured
                // alert("<?php echo $this->lang->line("error_occurred_please_try_again"); ?>");

            },
            complete: function () {

            }
        });
    } else {

    }
}



//Edit Merchant Document File code starts here
$(document).on("click", ".buttonA125", function (e) {
    e.preventDefault();
    var column = $(this).data("name");
    var id = $(this).data("id");
    var user_id = $(this).data("uid");

    $.ajax({
        type: "GET",
        url: base_phpurl + "/manage/document-agreement/remove/" + column + "/" + id + "/" + user_id,
        dataType: "json",
        async: false,
        success: function (response) {
            if (response.status) {
                load_agreement_docuement(merchant_id);
            }
        }
    });
});



$(document).on('submit', '#add_direct_settelment_form', function (event) {
    event.preventDefault();
    url = $(this).attr('action');
    row = 0;
    text = "";
    $(".loader").show();

    $.ajax({
        url: url,
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        complete: function () {
            $(".loader").hide();

        },
        success: function (data) {
            var result = jQuery.parseJSON(data);

            if (result.type == "success") {
                swalnot(result.type, result.message);
                $('#add_direct_settelment_form')[0].reset();
                $("#admin-directsettel-edit-modal").modal('hide');
                location.reload();
            } else {
                var mssg = result.message;

                if (typeof (mssg) == 'string') {
                    swalnot(result.type, result.message);
                    return true;
                }
                $.each(mssg, function (key, value) {
                    var input = '#add_direct_settelment_form input[name=' + key + ']';
                    $(input + '+span>strong').text(value);
                    $(input).parent().parent().addClass('has-error');

                    //  text += key +"=>";

                    value.forEach(myFunction);

                    text += "<br>";
                });

                console.log(text);

                Swal.fire({
                    title: 'Form Error',
                    icon: 'error',
                    html:
                        '<span style="color:#F8BB86;font-size:15px"><b>' + text + '</b></span>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,

                })
            }


            //fetch_vendor_details(mid,vendor);
        }
    });
});



$(document).on('submit', '#add_account_settelment_form', function (event) {
    event.preventDefault();
    url = $(this).attr('action');
    row = 0;
    text = "";
    $(".loader").show();

    $.ajax({
        url: url,
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        complete: function () {
            $(".loader").hide();

        },
        success: function (data) {
            var result = jQuery.parseJSON(data);

            if (result.type == "success") {
                swalnot(result.type, result.message);
                $('#add_account_settelment_form')[0].reset();
                $("#admin-accountsettel-edit-modal").modal('hide');
                location.reload();
            } else {
                var mssg = result.message;

                if (typeof (mssg) == 'string') {
                    swalnot(result.type, result.message);
                    return true;
                }
                $.each(mssg, function (key, value) {
                    var input = '#add_account_settelment_form input[name=' + key + ']';
                    $(input + '+span>strong').text(value);
                    $(input).parent().parent().addClass('has-error');

                    //  text += key +"=>";

                    value.forEach(myFunction);

                    text += "<br>";
                });

                console.log(text);

                Swal.fire({
                    title: 'Form Error',
                    icon: 'error',
                    html:
                        '<span style="color:#F8BB86;font-size:15px"><b>' + text + '</b></span>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,

                })
            }


            //fetch_vendor_details(mid,vendor);
        }
    });
});


