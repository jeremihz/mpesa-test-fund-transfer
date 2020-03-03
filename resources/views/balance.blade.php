@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary"> <strong> Dashboard</strong></div>

                <div class="card-body text-center">
                @include('flash::message')

                        <h1 class="text-info"> Your balance is {{$data}}</h1>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
