 
 base_url=$('#base_url').val();
//  $(document).on('submit', '#report_form', function(event){
//         event.preventDefault();
//          $.ajax({
//                     type:"POST",
//                     url: base_url+'/merchant/createdownloadreport',
//                     data: $('#report_form').serializeArray(),
//                     async: false,
//                     success: function(data){

//                             var url = base_url+"/merchant/downloadreport?" + $.param(data.res);

//                             window.location = url;
//                              fetch_report_log(0);

//                     }
//        });

//         fetch_report_log(0);
           
//     });



    $(".submitButton").prop("disabled", true);

    $(document).on('change', '#listreport', function(event){
         var tableName = $(this).val();
       
         if(tableName){
             $(".submitButton").prop("disabled", true);
            $(".loader").show();
             $.ajax({
                  type: "POST",
                  url: base_phpurl+"/merchant/getreportMerchantparameter",
                  data: $('#report_form').serializeArray(),
                  dataType: "json",
                  success: function(response) {
                              $('.report_parameter').html(null);
                              if(response.status){
                                 $('.report_parameter').html(response.view);
                              }
                              
                               
                      } ,complete: function() {
                             setTimeout(() => {
                                 $(".loader").hide();
                                  $(".submitButton").prop("disabled", false);
                             }, 1500);
                         }
                  });
         }
          

    });


 $(document).on('submit', '#datatable_form', function(event){
        event.preventDefault();
         $.ajax({
                    type:"POST",
                    url: base_url+'/merchant/createdownloadreport',
                    data: $('#datatable_form').serializeArray(),
                    async: false,
                    success: function(data){

                            var url = base_url+"/merchant/downloadreport?" + $.param(data.res);

                            window.location = url;
                             fetch_report_log(1);

                    }
       });

        fetch_report_log(1);
           
    });

 
 function fetch_report_log(is_datatable){
      $.ajax({
                    type:"GET",
                    url: base_url+'/merchant/reportlog?is_datatable='+is_datatable,
                    
                    success: function(response){

                      $('#report-div').html(null);
                     $('#report-div').html(response.log_view);


                    }
       });
 }



 function gstInvoiceReort(element,filter_date) {
     
        
         $('.d-show').html(null);
        $('.d-show').html(filter_date);
          $.ajax({
                    type:"POST",
                    url: base_url+'/merchant/gstinvoicereportdetails',
                    data:  {_token:$('meta[name="csrf-token"]').attr('content'), filter_date:filter_date},
                    async: false,
                    success: function(response){

                       $('#gst_report_details').html(null);
                      $('#gst_report_details').html(response.detail_view);     

                    }
       });

  
     $('#gst-report-model').modal('show');
 }


   $('#Payouttransactiontbl').DataTable({
    "fnInitComplete": function(){
                // Disable TBODY scoll bars
                $('.dataTables_scrollBody').css({
                    'overflow': 'hidden',
                    'border': '0'
                });
                
                // Enable TFOOT scoll bars
                $('.dataTables_scrollFoot').css('overflow', 'auto');
                
                $('.dataTables_scrollHead').css('overflow', 'auto');
                
                // Sync TFOOT scrolling with TBODY
                $('.dataTables_scrollFoot').on('scroll', function () {
                    $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
                });      
                
                $('.dataTables_scrollHead').on('scroll', function () {
                    $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
                });
            },
                 dom: 'lBfrtip',
                 pageLength: 10,
                 scrollX: true,
                 buttons: [
                     'colvis', 'print', 'pdf', 'excel'
                 ]
             });


   var table = $('#example1')
        .DataTable(
        {
            "fnInitComplete": function(){
                // Disable TBODY scoll bars
                $('.dataTables_scrollBody').css({
                    'overflow': 'hidden',
                    'border': '0'
                });
                
                // Enable TFOOT scoll bars
                $('.dataTables_scrollFoot').css('overflow', 'auto');
                
                $('.dataTables_scrollHead').css('overflow', 'auto');
                
                // Sync TFOOT scrolling with TBODY
                $('.dataTables_scrollFoot').on('scroll', function () {
                    $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
                });      
                
                $('.dataTables_scrollHead').on('scroll', function () {
                    $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
                });
            },
            "scrollX": true,
            "scrollCollapse": true,
            "dom": 'Zlrtip',
            "colResize": {
                "tableWidthFixed": false,
                //"handleWidth": 10,
                "resizeCallback": function(column)
                {

                }
            },
            "searching":   false,
            "paging":   false,
            "info":     false,
            "deferRender": true,
            "sScrollX": "190%"
        });
        