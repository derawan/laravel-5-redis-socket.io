@extends('layouts.app')
@section('title', 'Cook')
@section('content')
<audio id="notif_audio"><source src="{!! asset('sounds/notify.ogg') !!}" type="audio/ogg"><source src="{!! asset('sounds/notify.mp3') !!}" type="audio/mpeg"><source src="{!! asset('sounds/notify.wav') !!}" type="audio/wav"></audio>

<div class="container">
    <h2>Cook Website</h2>
</div>

<div id="content">
    @foreach($orders as $order)
        <div class="panel {{$order->done== 'true' ? 'panel-success' : 'panel-info'}}
         panel-style" data-id="{{$order->id}}" >
            <!-- Default panel contents -->
            <div class="panel-heading">{{$order->done == 'true' ? 'Done': 'Cooking...'}}</div>
            <div class="panel-body">
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item"><b>Name: </b>{{$order->name}}</li>
                    <li class="list-group-item"><b>Table: </b>{{$order->table}}</li>
                    <li class="list-group-item"><b>Dish: </b>{{$order->dish}}</li>
                    <li class="list-group-item js-time"
                        data-time-of='{{$order->timeOfOrder}}'
                        data-time-to='{{$order->timeToOrder}}'><b>Time: <span class="js-clock"></span> </b></li>
                </ul>
            </div>
            @if (!($order->done== 'true'))
               <a type="button"  data-loading-text="Loading..." class="btn btn-info js-loading-btn">Done</a>
            @endif
        </div>
    @endforeach
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
<script src="js/cook.js"></script>
@endsection


