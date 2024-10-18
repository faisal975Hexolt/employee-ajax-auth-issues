$(function () {
  //Cron Settings
  var tableCronSetting = $("#merchant-CronSetting-table").DataTable({
    processing: true,
    language: {
      processing:
        '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> ',
    },
    serverSide: true,
    ajax: {
      url: CronSettingUrl,
      data: function (d) {
        (d.search = $('#manage-CronSetting-form input[type="search"]').val()),
          (d.form = getJsonObject(
            $("#manage-CronSetting-form").serializeArray()
          ));
      },
    },
    drawCallback: function (settings) {
      // $(".loader").hide();
    },
    order: [[1, "asc"]],
    lengthMenu: [
      [10, 25, 50, 100, 200, -1],
      [10, 25, 50, 100, 200, "All"],
    ],
    pageLength: 50,
    // scrollX: true,
    columns: [
      {
        data: "DT_RowIndex",
        name: "DT_RowIndex",
        orderable: false,
      },
      {
        data: "cron_time",
        name: "cron_time",
      },
      {
        data: "transaction_form",
        name: "transaction_form",
      },
      {
        data: "transaction_form_day",
        name: "transaction_form_day",
      },
      {
        data: "transaction_to",
        name: "transaction_to",
      },
      {
        data: "transaction_to_day",
        name: "transaction_to_day",
      },
      {
        data: "status",
        name: "status",
      },
      {
        data: "created",
        name: "created",
      },
      {
        data: "action",
        name: "action",
        orderable: false,
      },

      // {
      //     data: 'action',
      //     name: 'action',
      //     orderable: false,
      //     searchable: false
      // },
    ],
  });

  $("#searchCronSetting").on("input", function () {
    var search = $(this).val();
    if (search.length < 4) {
      return true;
    }
    tableCronSetting.draw();
  });

  $(document).on("change", ".searchFilterBSubCat", function (event) {
    var target = $(event.target);
    var search = $(this).val();
    if (search.length < 4) {
      return true;
    }
    var elementType = $(this).prop("nodeName");

    tableCronSetting.draw();
  });

  //GST Cron Settings
  var tableGstCronSetting = $("#merchant-GstCronSetting-table").DataTable({
    processing: true,
    language: {
      processing:
        '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> ',
    },
    serverSide: true,
    ajax: {
      url: GstCronSettingUrl,
      data: function (d) {
        (d.search = $(
          '#manage-gstCronSetting-form input[type="search"]'
        ).val()),
          (d.form = getJsonObject(
            $("#manage-gstCronSetting-form").serializeArray()
          ));
      },
    },
    drawCallback: function (settings) {
      // $(".loader").hide();
    },
    order: [[1, "asc"]],
    lengthMenu: [
      [10, 25, 50, 100, 200, -1],
      [10, 25, 50, 100, 200, "All"],
    ],
    pageLength: 50,
    // scrollX: true,
    columns: [
      {
        data: "DT_RowIndex",
        name: "DT_RowIndex",
        orderable: false,
      },
      {
        data: "gst_cron_day",
        name: "gst_cron_day",
      },
      {
        data: "gst_cron_time",
        name: "gst_cron_time",
      },

      {
        data: "status",
        name: "status",
      },
      {
        data: "created",
        name: "created",
      },
      {
        data: "action",
        name: "action",
        orderable: false,
      },

      // {
      //     data: 'action',
      //     name: 'action',
      //     orderable: false,
      //     searchable: false
      // },
    ],
  });

  $("#searchGstCronSetting").on("input", function () {
    var search = $(this).val();
    if (search.length < 4) {
      return true;
    }
    tableGstCronSetting.draw();
  });

  $(document).on("change", ".searchFilterGstCat", function (event) {
    var target = $(event.target);
    var search = $(this).val();

    var elementType = $(this).prop("nodeName");

    tableGstCronSetting.draw();
  });

  ///cron-setting

  $(".cron-setting-modal").on("shown.bs.modal", function () {
    $(this).find("#bc_category_name").focus();
  });

  $(".bcclose_btn").click(function () {
    $("#csettings_form")[0].reset();
    $('#csettings_form input[name="operation').val("");
  });

  $(document).on("click", "#add_settelment_cron", function (event) {
    $(".cron-setting-modal").modal("show");
    $("#csettings_form")[0].reset();
    $("#CSclose_btn").html("Add Settelment Cron Settings");
    $("#CSclose_btn").attr("disabled", false);
    $('#csettings_form input[name="operation"]').val("Add");
    $("#CSmodalTitle").html("Add Settelment Cron Settings");
    var start = moment().subtract(12, "hours").startOf("day");
    $('#csettings_form input[name="cron_time"]').val(start.format("HH:mm:ss"));
    $('#csettings_form input[name="transaction_form"]').val(
      start.format("HH:mm:ss")
    );
    $('#csettings_form input[name="transaction_to"]').val(
      start.format("HH:mm:ss")
    );
  });

  $(document).on("submit", "#csettings_form", function (event) {
    event.preventDefault();
    if (confirm("Are you sure you want to Submit this?")) {
      $("#CSclose_btn").attr("disabled", true);
      $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_phpurl + "/manage/updateSettelmentCronSetting",
        data: new FormData(this),
        contentType: false,
        processData: false,
        method: "POST",
        success: function (data) {
          var result = jQuery.parseJSON(data);

          if (result.type == "success") {
            swalnot(result.type, result.message);
            $("#csettings_form")[0].reset();
            $(".cron-setting-modal").modal("hide");
            tableCronSetting.draw();
          } else {
            var mssg = result.message;

            if (typeof mssg == "string") {
              swalnot(result.type, result.message);
              return true;
            }
            $.each(mssg, function (key, value) {
              var input = "#csettings_form input[name=" + key + "]";
              $(input + "+span>strong").text(value);
              $(input).parent().parent().addClass("has-error");

              //  text += key +"=>";

              value.forEach(myFunction);

              text += "<br>";
            });

            Swal.fire({
              title: "Form Error",
              icon: "error",
              html:
                '<span style="color:#F8BB86;font-size:15px"><b>' +
                text +
                "</b></span>",
              showCloseButton: true,
              showCancelButton: true,
              focusConfirm: false,
            });
          }

          reset();
          $("#CSclose_btn").attr("disabled", false);
        },
        error: function () {
          alert("Fail to insert data into database....!");
        },
      });
    }
  });

  $(document).on("click", "#edit_CronSetting", function (event) {
    $("#csettings_form")[0].reset();
    $("#CSclose_btn").html("Edit Settelment Cron Settings");
    $("#CSclose_btn").attr("disabled", false);
    $('#csettings_form input[name="operation"]').val("Edit");
    $("#CSmodalTitle").html(
      '<i class="fa fa-edit"></i>&nbsp;Edit Settelment Cron Settings'
    );
    var row_id = $(this).attr("orderid");

    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: base_phpurl + "/manage/fetchSettelmentCronSetting",
      method: "POST",
      data: { row_id: row_id },
      dataType: "json",
      success: function (response) {
        data = response.data;
        $(".cron-setting-modal").modal("show");

        $("#cs_cron_time").val(data.cron_time);
        $("#cs_transaction_from").val(data.transaction_form);
        $("#cs_transaction_form_day").val(data.transaction_form_day);
        $("#cs_transaction_to").val(data.transaction_to);
        $("#cs_transaction_to_day").val(data.transaction_to_day);
        $("#cs_status").val(data.status);

        $('#csettings_form input[name="row_id"]').val(data.id);

        $("#CSclose_btn").attr("disabled", false);
      },
    });
  });

  ///gst cron-setting

  $(".gst-cron-setting-modal").on("shown.bs.modal", function () {
    $(this).find("#gst_cron_day").focus();
  });

  $(".bcclose_btn").click(function () {
    $("#gcsettings_form")[0].reset();
    $('#gcsettings_form input[name="operation').val("");
  });

  $(document).on("click", "#add_gst_cron", function (event) {
    $(".gst-cron-setting-modal").modal("show");
    $("#gcsettings_form")[0].reset();
    $("#GCSclose_btn").html("Add GST Cron Settings");
    $("#GCSclose_btn").attr("disabled", false);
    $('#gcsettings_form input[name="operation"]').val("Add");
    $("#GCSmodalTitle").html("Add Gst Cron Settings");
    var start = moment().subtract(12, "hours").startOf("day");
    $('#gcsettings_form input[name="gst_cron_time"]').val(
      start.format("HH:mm:ss")
    );
  });

  $(document).on("submit", "#gcsettings_form", function (event) {
    event.preventDefault();
    if (confirm("Are you sure you want to Submit this?")) {
      $("#GCSclose_btn").attr("disabled", true);
      $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_phpurl + "/manage/updateGstCronSetting",
        data: new FormData(this),
        contentType: false,
        processData: false,
        method: "POST",
        success: function (data) {
          var result = jQuery.parseJSON(data);

          if (result.type == "success") {
            swalnot(result.type, result.message);
            $("#gcsettings_form")[0].reset();
            $(".gst-cron-setting-modal").modal("hide");
            tableGstCronSetting.draw();
          } else {
            var mssg = result.message;

            if (typeof mssg == "string") {
              swalnot(result.type, result.message);
              return true;
            }
            $.each(mssg, function (key, value) {
              var input = "#gcsettings_form input[name=" + key + "]";
              $(input + "+span>strong").text(value);
              $(input).parent().parent().addClass("has-error");

              //  text += key +"=>";

              value.forEach(myFunction);

              text += "<br>";
            });

            Swal.fire({
              title: "Form Error",
              icon: "error",
              html:
                '<span style="color:#F8BB86;font-size:15px"><b>' +
                text +
                "</b></span>",
              showCloseButton: true,
              showCancelButton: true,
              focusConfirm: false,
            });
          }

          reset();
          $("#GCSclose_btn").attr("disabled", false);
        },
        error: function () {
          alert("Fail to insert data into database....!");
        },
      });
    }
  });

  $(document).on("click", "#edit_GstCronSetting", function (event) {
    $("#gcsettings_form")[0].reset();
    $("#GCSclose_btn").html("Edit Gst Cron Settings");
    $("#GCSclose_btn").attr("disabled", false);
    $('#gcsettings_form input[name="operation"]').val("Edit");
    $("#GCSmodalTitle").html(
      '<i class="fa fa-edit"></i>&nbsp;Edit Gst Cron Settings'
    );
    var row_id = $(this).attr("orderid");

    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: base_phpurl + "/manage/fetchGstCronSetting",
      method: "POST",
      data: { row_id: row_id },
      dataType: "json",
      success: function (response) {
        data = response.data;
        $(".gst-cron-setting-modal").modal("show");

        $("#gst_cron_time").val(data.gst_cron_time);
        $("#gst_cron_day").val(data.gst_cron_day);

        $("#gcs_status").val(data.status);

        $('#gcsettings_form input[name="row_id"]').val(data.id);

        $("#GCSclose_btn").attr("disabled", false);
      },
    });
  });

  function reset() {
    row = 0;
    text = "";
  }
  reset();
});

$(function () {
  $('#csettings_form input[name="cron_time"]')
    .daterangepicker({
      timePicker: true,
      singleDatePicker: true,
      timePicker24Hour: true,
      timePickerIncrement: 01,
      timePickerSeconds: true,
      startDate: "12:00:00",
      locale: {
        format: "HH:mm:ss",
      },
    })
    .on("show.daterangepicker", function (ev, picker) {
      picker.container.find(".calendar-table").hide();
    });
  $('#csettings_form input[name="transaction_form"]')
    .daterangepicker({
      timePicker: true,
      singleDatePicker: true,
      timePicker24Hour: true,
      timePickerIncrement: 01,
      timePickerSeconds: true,
      startDate: "12:00:00",
      locale: {
        format: "HH:mm:ss",
      },
    })
    .on("show.daterangepicker", function (ev, picker) {
      picker.container.find(".calendar-table").hide();
    });
  $('#csettings_form input[name="transaction_to"]')
    .daterangepicker({
      timePicker: true,
      singleDatePicker: true,
      timePicker24Hour: true,
      timePickerIncrement: 01,
      timePickerSeconds: true,
      startDate: "12:00:00",
      locale: {
        format: "HH:mm:ss",
      },
    })
    .on("show.daterangepicker", function (ev, picker) {
      picker.container.find(".calendar-table").hide();
    });

  $('#gcsettings_form input[name="gst_cron_time"]')
    .daterangepicker({
      timePicker: true,
      singleDatePicker: true,
      timePicker24Hour: true,
      timePickerIncrement: 01,
      timePickerSeconds: true,
      startDate: "12:00:00",
      locale: {
        format: "HH:mm:ss",
      },
    })
    .on("show.daterangepicker", function (ev, picker) {
      picker.container.find(".calendar-table").hide();
    });
});
