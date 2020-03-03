@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header bg-primary"> <h3>Transfer Cash</h3> <span class="text-danger">(You can only Transfer
                  to users registered to this system)</span> </div>

                <div class="card-body">
                @include('flash::message')

                <form class="" action="{{route('transfer-submit')}}" method="post">
                  @csrf
                  <div class="form-group col-md-5">
                    <label for="">Enter user Email or Phone</label>
                  <input class="form-control" type="text" name="madeTo" value="" required>
                  </div>
                  <div class="form-group col-md-5">
                    <label for="">Enter Amount</label>
                  <input class="form-control" type="text" name="amount" value="" required>
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
