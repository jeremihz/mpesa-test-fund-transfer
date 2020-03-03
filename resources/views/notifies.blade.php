@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary"> <h3>Transaction Notifications</h3> </div>

                <div class="card-body">
                @include('flash::message')
                 <div class="row">
                   <table class="table">
                     <thead>
                       <th>Date</th>
                       <td>Message</td>
                     </thead>
                     <tbody>
                       @foreach($data as $data)
                       <tr>
                         <td>{{$data->created_at}}</td>
                         <td>{{$data->message}}</td>
                       </tr>
                       @endforeach
                     </tbody>
                   </table>

                 </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
