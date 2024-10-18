$(function () {
  //category
  var tableBCat = $("#merchant-BCat-table").DataTable({
    processing: true,
    language: {
      processing:
        '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> ',
    },
    serverSide: true,
    ajax: {
      url: BCatUrl,
      data: function (d) {
        (d.search = $('#manage-BCat-form input[type="search"]').val()),
          (d.form = getJsonObject($("#manage-BCat-form").serializeArray()));
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
        data: "category_name",
        name: "category_name",
      },
      {
        data: "status",
        name: "status",
      },
      {
        data: "created",
        name: "created",
        orderable: false,
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

  $("#searchBCat").on("input", function () {
    var search = $(this).val();
    if (search.length < 4) {
      return true;
    }
    tableBCat.draw();
  });

  $(document).on("change", ".searchFilterBCat", function (event) {
    var target = $(event.target);
    var search = $(this).val();
    if (search.length < 4) {
      return true;
    }
    var elementType = $(this).prop("nodeName");

    tableBCat.draw();
  });

  //business type
  var tableBType = $("#merchant-BType-table").DataTable({
    processing: true,
    language: {
      processing:
        '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> ',
    },
    serverSide: true,
    ajax: {
      url: BTypeUrl,
      data: function (d) {
        (d.search = $('#manage-BType-form input[type="search"]').val()),
          (d.form = getJsonObject($("#manage-BType-form").serializeArray()));
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
        data: "type_name",
        name: "type_name",
      },
      {
        data: "status",
        name: "status",
      },
      {
        data: "created",
        name: "created",
        orderable: false,
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

  $("#searchBType").on("input", function () {
    var search = $(this).val();
    if (search.length < 4) {
      return true;
    }
    tableBType.draw();
  });

  $(document).on("change", ".searchFilterBType", function (event) {
    var target = $(event.target);
    var search = $(this).val();
    if (search.length < 4) {
      return true;
    }
    var elementType = $(this).prop("nodeName");

    tableBType.draw();
  });

  //sub category
  var tableBSubCat = $("#merchant-BSubCat-table").DataTable({
    processing: true,
    language: {
      processing:
        '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> ',
    },
    serverSide: true,
    ajax: {
      url: BSubCatUrl,
      data: function (d) {
        (d.search = $('#manage-BSubCat-form input[type="search"]').val()),
          (d.form = getJsonObject($("#manage-BSubCat-form").serializeArray()));
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
        data: "sub_category_name",
        name: "sub_category_name",
      },
      {
        data: "category_name",
        name: "category_name",
      },
      {
        data: "status",
        name: "status",
      },
      {
        data: "created",
        name: "created",
        orderable: false,
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

  $("#searchBSubCat").on("input", function () {
    var search = $(this).val();
    if (search.length < 4) {
      return true;
    }
    tableBSubCat.draw();
  });

  $(document).on("change", ".searchFilterBSubCat", function (event) {
    var target = $(event.target);
    var search = $(this).val();
    if (search.length < 4) {
      return true;
    }
    var elementType = $(this).prop("nodeName");

    tableBSubCat.draw();
  });

  $(".bussiness-type-modal").on("shown.bs.modal", function () {
    $(this).find("#btype_type_name").focus();
  });

  $(".btclose_btn").click(function () {
    $("#btype_form")[0].reset();
    $('#btype_form input[name="operation').val("");
  });

  $(document).on("click", "#add_accountant", function (event) {
    $(".accountant-add-modal").modal("show");
    $("#accountant_form")[0].reset();
    $("#accountantmodalBtn").html("Add Accountant");
    $("#accountantmodalBtn").attr("disabled", false);
    $('#btype_form input[name="operation"]').val("Add");
    $("#btmodalTitle").html("Add Accountant");
  });

  $(document).on("click", "#add_vendor", function (event) {
    $(".vendor-add-modal").modal("show");
    $("#vendor_form")[0].reset();
    $("#vendormodalBtn").html("Add Vendor");
    $("#vendormodalBtn").attr("disabled", false);
  });

  $(document).on("click", "#add_btype", function (event) {
    $(".bussiness-type-modal").modal("show");
    $("#btype_form")[0].reset();
    $("#btmodalBtn").html("Add Business Type");
    $("#btmodalBtn").attr("disabled", false);
    $('#btype_form input[name="operation"]').val("Add");
    $("#btmodalTitle").html("Add Business Type");
  });

  $(document).on("submit", "#btype_form", function (event) {
    event.preventDefault();
    if (confirm("Are you sure you want to Submit this?")) {
      $("#btmodalBtn").attr("disabled", true);
      $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_phpurl + "/manage/updateBusinessType",
        data: new FormData(this),
        contentType: false,
        processData: false,
        method: "POST",
        success: function (data) {
          var result = jQuery.parseJSON(data);

          console.log(result);
          if (result.type == "success") {
            swalnot(result.type, result.message);
            $("#btype_form")[0].reset();
            $(".bussiness-type-modal").modal("hide");
            tableBType.draw();
          } else {
            var mssg = result.message;

            if (typeof mssg == "string") {
              swalnot(result.type, result.message);
              return true;
            }
            $.each(mssg, function (key, value) {
              var input = "#btype_form input[name=" + key + "]";
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
          $("#btmodalBtn").attr("disabled", false);
        },
        error: function () {
          alert("Fail to insert data into database....!");
        },
      });
    }
  });



  $(document).on("click", "#edit_btype", function (event) {
    $("#btype_form")[0].reset();
    $("#btmodalBtn").html("Edit Business Type");
    $("#btmodalBtn").attr("disabled", false);
    $('#btype_form input[name="operation"]').val("Edit");
    $("#btmodalTitle").html(
      '<i class="fa fa-edit"></i>&nbsp;Edit Business Type'
    );
    var row_id = $(this).attr("orderid");

    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: base_phpurl + "/manage/fetchBusinessType",
      method: "POST",
      data: { row_id: row_id },
      dataType: "json",
      success: function (response) {
        data = response.data;
        $(".bussiness-type-modal").modal("show");

        $("#btype_type_name").val(data.type_name);
        $("#btype_status").val(data.status);
        $('#btype_form input[name="row_id"]').val(data.id);

        $("#btmodalBtn").attr("disabled", false);
      },
    });
  });

  //sub cat

  $(".bussiness-subcat-modal").on("shown.bs.modal", function () {
    $(this).find("#bsc_sub_category_name").focus();
  });

  $(".bscclose_btn").click(function () {
    $("#bscat_form")[0].reset();
    $('#bscat_form input[name="operation').val("");
  });

  $(document).on("click", "#add_bsubcat", function (event) {
    $(".bussiness-subcat-modal").modal("show");
    $("#bscat_form")[0].reset();
    $("#bscmodalBtn").html("Add Business SubCategory");
    $("#bscmodalBtn").attr("disabled", false);
    $('#bscat_form input[name="operation"]').val("Add");
    $("#bscmodalTitle").html("Add Business SubCategory");
  });

  $(document).on("submit", "#bscat_form", function (event) {
    event.preventDefault();
    if (confirm("Are you sure you want to Submit this?")) {
      $("#btmodalBtn").attr("disabled", true);
      $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_phpurl + "/manage/updateBusinessSubCategory",
        data: new FormData(this),
        contentType: false,
        processData: false,
        method: "POST",
        success: function (data) {
          var result = jQuery.parseJSON(data);

          console.log(result);
          if (result.type == "success") {
            swalnot(result.type, result.message);
            $("#bscat_form")[0].reset();
            $(".bussiness-subcat-modal").modal("hide");
            tableBSubCat.draw();
          } else {
            var mssg = result.message;

            if (typeof mssg == "string") {
              swalnot(result.type, result.message);
              return true;
            }
            $.each(mssg, function (key, value) {
              var input = "#bscat_form input[name=" + key + "]";
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
          $("#bscmodalBtn").attr("disabled", false);
        },
        error: function () {
          alert("Fail to insert data into database....!");
        },
      });
    }
  });

  $(document).on("click", "#edit_bsubcat", function (event) {
    $("#bscat_form")[0].reset();
    $("#bscmodalBtn").html("Edit Business SubCategory");
    $("#bscmodalBtn").attr("disabled", false);
    $('#bscat_form input[name="operation"]').val("Edit");
    $("#bscmodalTitle").html(
      '<i class="fa fa-edit"></i>&nbsp;Edit Business SubCategory'
    );
    var row_id = $(this).attr("orderid");

    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: base_phpurl + "/manage/fetchBusinessSubCategory",
      method: "POST",
      data: { row_id: row_id },
      dataType: "json",
      success: function (response) {
        data = response.data;
        $(".bussiness-subcat-modal").modal("show");

        $("#bsc_sub_category_name").val(data.sub_category_name);
        $("#bsc_category_id").val(data.category_id);
        $("#bsc_status").val(data.status);
        $('#bscat_form input[name="row_id"]').val(data.id);

        $("#bscmodalBtn").attr("disabled", false);
      },
    });
  });

  ///category

  $(".bussiness-cat-modal").on("shown.bs.modal", function () {
    $(this).find("#bc_category_name").focus();
  });

  $(".bcclose_btn").click(function () {
    $("#bcat_form")[0].reset();
    $('#bcat_form input[name="operation').val("");
  });

  $(document).on("click", "#add_bcat", function (event) {
    $(".bussiness-cat-modal").modal("show");
    $("#bcat_form")[0].reset();
    $("#bcmodalBtn").html("Add Business Category");
    $("#bcmodalBtn").attr("disabled", false);
    $('#bcat_form input[name="operation"]').val("Add");
    $("#bcmodalTitle").html("Add Business Category");
  });

  $(document).on("submit", "#bcat_form", function (event) {
    event.preventDefault();
    if (confirm("Are you sure you want to Submit this?")) {
      $("#bcmodalBtn").attr("disabled", true);
      $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_phpurl + "/manage/updateBusinessCategory",
        data: new FormData(this),
        contentType: false,
        processData: false,
        method: "POST",
        success: function (data) {
          var result = jQuery.parseJSON(data);

          if (result.type == "success") {
            swalnot(result.type, result.message);
            $("#bcat_form")[0].reset();
            $(".bussiness-cat-modal").modal("hide");
            tableBCat.draw();
          } else {
            var mssg = result.message;

            if (typeof mssg == "string") {
              swalnot(result.type, result.message);
              return true;
            }
            $.each(mssg, function (key, value) {
              var input = "#bcat_form input[name=" + key + "]";
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
          $("#bcmodalBtn").attr("disabled", false);
        },
        error: function () {
          alert("Fail to insert data into database....!");
        },
      });
    }
  });

  $(document).on("click", "#edit_bcat", function (event) {
    $("#bcat_form")[0].reset();
    $("#bcmodalBtn").html("Edit Business Category");
    $("#bcmodalBtn").attr("disabled", false);
    $('#bcat_form input[name="operation"]').val("Edit");
    $("#bcmodalTitle").html(
      '<i class="fa fa-edit"></i>&nbsp;Edit Business Category'
    );
    var row_id = $(this).attr("orderid");

    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: base_phpurl + "/manage/fetchBusinessCategory",
      method: "POST",
      data: { row_id: row_id },
      dataType: "json",
      success: function (response) {
        data = response.data;
        $(".bussiness-cat-modal").modal("show");

        $("#bc_category_name").val(data.category_name);
        $("#bc_status").val(data.status);
        $('#bcat_form input[name="row_id"]').val(data.id);

        $("#bcmodalBtn").attr("disabled", false);
      },
    });
  });

  function reset() {
    row = 0;
    text = "";
  }
  reset();
});
