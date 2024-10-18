{{-- Sms Api Add Model --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btclose_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Add Sms Api Setting</h4>

            </div>
            <div class="modal-body">
                <form action="{{ route('sms-api.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="provider_name">Provider Name</label>
                            <input type="text" class="form-control" id="provider_name" name="provider_name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sms_username">SMS Username</label>
                            <input type="text" class="form-control" id="sms_username" name="sms_username" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="otp_username">OTP Username</label>
                            <input type="text" class="form-control" id="otp_username" name="otp_username" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sms_password">SMS Password</label>
                            <input type="password" class="form-control" id="sms_password" name="sms_password" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="sms_sid">SMS SID</label>
                            <input type="text" class="form-control" id="sms_sid" name="sms_sid" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="api_key">API Key</label>
                            <input type="text" class="form-control" id="api_key" name="api_key" required>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- Sms Api Edit modal  --}}

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit SMS Provider</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" action="{{ route('sms-api.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="edit_provider_name">Provider Name</label>
                            <input type="text" class="form-control" id="edit_provider_name" name="provider_name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="edit_sms_username">SMS Username</label>
                            <input type="text" class="form-control" id="edit_sms_username" name="sms_username">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="otp_username">OTP Username</label>
                            <input type="text" class="form-control" id="edit_otp_username" name="otp_username"
                                required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sms_password">SMS Password</label>
                            <input type="password" class="form-control" id="edit_sms_password" name="sms_password"
                                required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="sms_sid">SMS SID</label>
                            <input type="text" class="form-control" id="edit_sms_sid" name="sms_sid" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="edit_api_key">API Key</label>
                            <input type="text" class="form-control" id="edit_api_key" name="api_key">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="status">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="0">Inactive</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert 2 CDN -->
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> --}}


<script>
    $(document).ready(function() {
        $('.edit-btn').click(function() {
            $('#edit_id').val($(this).data('id'));
            $('#edit_provider_name').val($(this).data('provider_name'));
            $('#edit_sms_username').val($(this).data('sms_username'));
            $('#edit_api_key').val($(this).data('api_key'));
            $('#edit_otp_username').val($(this).data('otp-username'));
            $('#edit_sms_password').val($(this).data('sms-password'));
            $('#edit_sms_sid').val($(this).data('sms-id'));
            $('#edit_status').val($(this).data('status'));
        });

        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).val();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'sms-management/delete/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error',
                                'Something went wrong',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
