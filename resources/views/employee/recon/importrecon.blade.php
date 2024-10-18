@extends('layouts.employeecontent')
@section('employeecontent')
    <style>
        #specificInput {
            display: block !important;
            /* Or you can use another display value */
        }
    </style>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Import Recon Form</div>
                    <div class="card-body">
                        <form id="importForm">
                            @csrf
                            <div class="form-group">
                                <label for="date">Transaction Date:</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="form-group">
                                <label for="acquirer">Acquirer:</label>
                                <select class="form-control" id="acquirer" name="acquirer">
                                    @foreach ($acquirer as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->bank_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="file">Import File:</label>
                                <input type="file" class="form-control-file" id="specificInput" name="import_file"
                                    required>
                            </div>
                            <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                            <div id="message" style="display: none;">Import has been started in the background</div>

                            <div id="responseMessage" class="text-danger"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#importForm').submit(function(event) {
                event.preventDefault(); // Prevent the form from submitting via the browser
                var formData = new FormData($(this)[0]); // Create FormData object to send file data
                $('#submitButton').prop('disabled', true); // Disable submit button
                $('#message').show(); // Show message

                var messageText = $('#responseMessage').text();
                console.log(messageText);

                $('#responseMessage').hide();
                $('#responseMessage').text('');



                $.ajax({
                    url: "{{ route('import_recon') }}",
                    type: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // You can do further actions upon successful import, if needed

                        if (!response.success) {
                            // Update HTML element with success message
                            $('#responseMessage').show();
                            $('#responseMessage').text(response.message);
                        } else {
                            window.location.href = "{{ route('show_recon') }}";
                        }


                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error("Error:", errorThrown);
                        // Handle errors here
                    },
                    complete: function() {
                        // Redirect to the 'show_recon' route after AJAX request completes


                        $('#submitButton').prop('disabled',
                            false); // Re-enable submit button after request completes
                    }
                });
            });
        });
    </script>
@endsection
