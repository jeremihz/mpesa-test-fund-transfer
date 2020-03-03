@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary"> <h3> Top Up your Account</h3> </div>

                <div class="card-body">
                @include('flash::message')

                <form class="" action="{{route('topup-submit')}}" method="post">
                    @csrf
                  <div class="form-group col-md-4">
                    <label for="">Enter Amount</label>
                  <input class="form-control" type="text" name="madeTo" value="" required>
                  </div>
                  <div class="form-group">
                  <button class="btn btn-primary" type="submit" name="button">Submit</button>
                  </div>

                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
