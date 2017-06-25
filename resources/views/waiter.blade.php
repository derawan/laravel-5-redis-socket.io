@extends('layouts.app')
@section('title', 'Waiter')
@section('content')
<audio id="notif_audio"><source src="{!! asset('sounds/notify.ogg') !!}" type="audio/ogg"><source src="{!! asset('sounds/notify.mp3') !!}" type="audio/mpeg"><source src="{!! asset('sounds/notify.wav') !!}" type="audio/wav"></audio>


<div class="container">
    <h2>Waiter Website</h2>
    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">New order</button>

    <!-- Modal -->
    <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close js-modal-close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Order</h4>
                    </div>
                    <form class="form-horizontal js-form" action="" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Table: </label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="table" name="table" type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Dish: </label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="dish" name="dish" type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Time: </label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="timeToOrder" name="timeToOrder" type="text" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btn-submit" type="submit" class="btn btn-info">Create</button>
                            <button type="button" class="btn btn-danger js-modal-close" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="content">
    @foreach($orders as $order)
        <div class="panel {{$order['done']== 'true' ? 'panel-success' : 'panel-info' }}
                panel-style" data-id="{{$order['id']}}" >
            <!-- Default panel contents -->
            <div class="panel-heading">{{$order['done']== 'true' ? 'Done' : 'Cooking...'}}</div>
            <div class="panel-body">
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item"><b>Name: </b>{{$order['name']}}</li>
                    <li class="list-group-item"><b>Table: </b>{{$order['table']}}</li>
                    <li class="list-group-item"><b>Dish: </b>{{$order['dish']}}</li>
                    <li class="list-group-item js-time"
                        data-time-of='{{$order['timeOfOrder']}}'
                        data-time-to='{{$order['timeToOrder']}}'><b>Time: <span class="js-clock"></span> </b></li>
                </ul>
            </div>
            <a id="btn-submit" type="submit" class="btn btn-danger js-delete
            @if ($order['done']== 'false') {{'disabled'}} @endif ">Delete</a>
        </div>
    @endforeach
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
<script src="js/waiter.js"></script>
@endsection