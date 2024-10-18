@php
    use App\AppOption;
    $stype = AppOption::get_customer_support();
@endphp

@extends('layouts.managepaycontent')
@section('managepaycontent')

    <section id="contact" class="section pt-5">
        <!-- Container Starts -->
        <div class="container">
            <main class="login-form">
                <div class="cotainer">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Payment List<h5 class="forgot-form-heading">List Of payment done by
                                        Mobile number:{{ Session::get('customer_transaction_contact') }}</h5><a
                                        href="{{ '/' }}" class="back-link">Back</a>
                                </div>
                                <div class="card-body">



                                    @if (Session::has('message'))
                                        <div class="alert alert-success" role="alert">
                                            {{ Session::get('message') }}
                                        </div>
                                    @endif

                                    @if (Session::has('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ Session::get('error') }}
                                        </div>
                                    @endif
                                    <div class="table-responsive">
                                        <table id="example"
                                            class="table table-hover table-striped table-bordered text-nowrap"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Sr</th>
                                                    <th>Customer Details</th>

                                                    <th>Mode</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>

                                            <tfoot>
                                                <tr>
                                                    <th>Sr</th>
                                                    <th>Customer Details</th>

                                                    <th>Mode</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>

                                            <tbody>

                                                @if (!empty($paymentlist))
                                                    @foreach ($paymentlist as $row => $transaction)
                                                        <tr class="success">
                                                            <td>{{ $row + 1 }}</td>
                                                            <td>{{ ucwords($transaction->transaction_username) }}
                                                                <br>{{ $transaction->transaction_email }}
                                                                <br>{{ $transaction->transaction_contact }}
                                                            </td>

                                                            <td>{{ ucwords($transaction->transaction_mode) }}</td>
                                                            <td>{{ $transaction->transaction_amount }}</td>
                                                            <td>{{ strtoupper($transaction->transaction_status) }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($transaction->created_date)->format('M d, Y h:i:s A') }}
                                                            </td>
                                                            <td><a target="_blank"
                                                                    href="{{ route('support', encrypt($transaction->transaction_gid)) }}"
                                                                    class="btn btn-danger">
                                                                    Complain
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </section>
@endsection

<script></script>
