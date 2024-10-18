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
                    <div class="card-header">Assign a Accountant to Merchant </div>
                    <div class="card-body">
                        <form id="importForm" method="POST"  action="{{ route('addmerchantaccountant') }}">
                            @csrf
                            <div class="form-group">
                                <label for="date">Merchant</label>
                                <select class="form-control" name="merchant_id">
                                    @foreach ($merchants as $merchant)
                                        <option value="{{ $merchant['id'] }}">{{ $merchant['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="acquirer">Accountant:</label>
                                <select  class="form-control" name="accountant_id">
                                    @foreach ($accountants as $accountant)
                                        <option value="{{ $accountant['id'] }}">{{ $accountant['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                            <div id="message" style="display: none;">Import has been started in the background</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    </script>
@endsection
