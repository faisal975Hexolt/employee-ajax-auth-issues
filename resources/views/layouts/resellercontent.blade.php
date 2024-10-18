@extends('layouts.resellerapp')
@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.reseller-header')
    </div>
    <div class="row">
        <div class="col-sm-12">
            @include('layouts.reseller-nav')

            <div class="col-sm-12">
                <div class="merchant-content">
                    @yield('resellercontent')
                </div>
            </div>
        </div>
        @include('reseller.global-modal')
    </div>
    <div class="row">
        <div class="col-sm-11 col-sm-offset-1">
            @include('layouts.reseller-footer')
        </div>
    </div>
</div>

@endsection