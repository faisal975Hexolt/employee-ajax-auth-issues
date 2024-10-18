 base_url=$('#base_url').val();
 $(document).on('submit', '#merchant-transaction-report-form', function(event){
        event.preventDefault();
         $.ajax({
                    type:"POST",
                    url: base_url+'/merchant/createdownloadreport',
                    data: $('#merchant-transaction-report-form').serializeArray(),
                    async: false,
                    success: function(data){

                            var url = base_url+"/merchant/downloadreport?" + $.param(data.res);

                            window.location = url;

                    }
       });

       
           
    });