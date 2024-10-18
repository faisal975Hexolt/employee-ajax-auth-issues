{{-- Sms Template Add Modal --}}
<div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="templateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btclose_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="templateModalLabel">Add Sms Template</h4>

            </div>
            <div class="modal-body">
                <form action="{{ route('sms-temp.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group ">
                            <label for="provider_name">Identifier</label>
                            <input type="text" class="form-control" id="identifier" name="identifier" required>
                        </div>
                        <div class="form-group ">
                            <label for="sms_username">SMS Body</label>
                            <input type="text" class="form-control" id="sms_body" name="sms_body" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group ">
                            <label for="otp_username">Template Id</label>
                            <input type="text" class="form-control" id="template_id" name="template_id" required>
                        </div>
                        <div class="form-group ">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="0">Inactive</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Sms Template Edit modal  --}}

<div class="modal fade" id="editTemplateModal" tabindex="-1" aria-labelledby="editTemplateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="editTemplateModalLabel">Edit SMS Template</h3>

            </div>
            <form id="editTemplateForm" method="POST" action="{{ route('sms-temp.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_temp_id">
                    <div class="form-row">
                        <div class="form-group ">
                            <label for="edit_provider_name">Identifier</label>
                            <input type="text" class="form-control" id="edit_identifier" name="identifier">
                        </div>
                        <div class="form-group ">
                            <label for="edit_sms_username">SMS Body</label>
                            <input type="text" class="form-control" id="edit_sms_body" name="sms_body">
                        </div>
                    </div>
                    <div class="form-row">

                        <div class="form-group ">
                            <label for="otp_username">Template Id</label>
                            <input type="text" class="form-control" id="edit_template_id" name="template_id"
                                required>
                        </div>
                        <div class="form-group ">
                            <label for="status">Status</label>
                            <select class="form-control" id="edit_temp_status" name="status" required>
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
{{-- <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert 2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> --}}


<script>
    $(document).ready(function() {
        $('.template-edit-btn').click(function() {
            var id = $(this).val();
            $('#edit_temp_id').val(id);
            $('#edit_identifier').val($(this).data('identifier'));
            $('#edit_sms_body').val($(this).data('sms_body'));
            $('#edit_template_id').val($(this).data('template_id'));
            $('#edit_temp_status').val($(this).data('temp-status'));
        });
        $(document).on('click', '.delete-btn-temp', function(e) {
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
                        url: 'sms-template/delete/' + id,
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
