@extends('layouts.app')
@section('title', 'Manager')
@section('content')
    <div class="container">
        <div class="row">
            <select class="user">
                @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name . ' <'. $user->email . '>'}}</option>
                @endforeach
            </select>

            <select class="role">
                    <option value="manager">manager</option>
                    <option value="cook">cook</option>
                    <option value="waiter">waiter</option>
                    <option value="delete">delete</option>
            </select>
            <button class="btn btn-info js-change">Change</button>
        </div>
        <div class="row">
            <div class="status">

            </div>
        </div>
    </div>


    <!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/manager.js') }}"></script>




@endsection