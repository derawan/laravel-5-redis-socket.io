$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var socket = io('http://localhost:3000');

    socket.on('newOrder-channel:App\\Events\\NewOrder', function (data) {
        var data = data.form;
        $('#content').prepend('<div class="panel panel-info panel-style" style="display:none" data-id="'+
            data.id+'"><div class="panel-heading">Cooking...</div><div class="panel-body"><ul class="list-group"><li class="list-group-item"><b>Name: </b>'+
            data.name+'</li> <li class="list-group-item"><b>Table: </b>'+
            data.table+'</li><li class="list-group-item"><b>Dish: </b>'+
            data.dish+'</li><li class="list-group-item js-time"><b>Time: <span class="js-clock"></span></b></li></ul></div>'+
            '<a id="btn-submit" type="submit" class="btn btn-danger js-delete disabled">Delete</a></div>');
        var panel = $('[data-id="'+data.id+'"]'),
            div = panel.find('.js-clock');
        startTimer(data.timeOfOrder,data.timeToOrder,div);
        panel.slideDown('slow');
    });


    socket.on('orderDone-channel:App\\Events\\OrderDone', function (data) {
        var panel =  $('[data-id="'+data.id+'"]');
        panel.removeClass('panel-info');
        panel.removeClass ('panel-danger');
        panel.addClass('panel-success');
        panel.find('.panel-heading').text ('Done');
        panel.find('.js-delete').removeClass ('disabled');
        $('#notif_audio')[0].play();
    });


    $('#btn-submit').on('click', function (){
        var checkInputs = CheckInputs();
        if (!checkInputs) return false;
        var data = $('.js-form').serialize();
        $.ajax({
            url: "/waiter/order",
            type: "POST",
            data: data,
            success: function( data ) {
                ClearInputs ();
                $('#myModal').modal('hide');
            }
        });
        return false;
    })

    function CheckInputs() {
        var error = false ;
        $('.js-form input').each(function(){
            $(this).parent().removeClass('has-error');
            var j =  $(this).val();
            j = $.trim (j);
            if (j == "") {
                $(this).parent().addClass('has-error');
                error = true;
            }else {
                $(this).parent().addClass('has-success');
            }
        });
        if (error) return false;
        return true;
    };


    $('.js-form input').focusout (function (){
        $(this).parent().removeClass('has-error');
        var j =  $(this).val();
        j = $.trim (j);
        if (j == "") {
            $(this).parent().addClass('has-error');
        }else {
            $(this).parent().addClass('has-success');
        }
    })

    $('.js-modal-close').on("click", ClearInputs)

    function ClearInputs () {
        $(".js-form input").each(function(){
            $(this).val('');
            $(this).parent().removeClass('has-error');
            $(this).parent().removeClass('has-success');
        })
    }



    function startTimer(timeOfOrder, timeToOrder, div) {
        var date = new Date(),
            div = div,
            endTime= timeOfOrder * 1000 + timeToOrder*60*1000,
            nowTime = new Date().getTime();
        if (nowTime >=endTime) {
            if (div.closest('.panel').hasClass('panel-success')) {
                div.html('--:--');
                return;
            };
            div.html('00:00');
            var panel = div.closest('.panel');
            panel.removeClass('panel-info');
            panel.addClass('panel-danger');
            var panelH= panel.find('.panel-heading');
            panelH.text ('Delayed');
            return;
        }

        var timer = endTime - nowTime,
            minutes=  timer/(60 * 1000),
            m=  Math.floor(minutes),
            s = Math.floor((minutes - m) * 60);
        if (m < 10) m = "0" + m;
        function timeAgain () {
            if (div.closest('.panel').hasClass('panel-success')) {
                div.html('--:--');
                return;
            }
            if (s == 0) {
                if (m == 0) {
                    div.html('00:00');
                    var panel = div.closest('.panel');
                    panel.removeClass('panel-info');
                    panel.addClass('panel-danger');
                    var panelH= panel.find('.panel-heading');
                    panelH.text ('Delayed');
                    return;
                }
                m--;
                if (m < 10) m = "0" + m;
                s = 59;
            }
            else s--;
            if (s < 10) s = "0" + s;
            div.html(m+":"+s);
            setTimeout(timeAgain, 1000)
        }
        timeAgain ();
    }

    $('.js-time').each(function(){
        var timeOfOrder =  $(this).attr('data-time-of'),
            timeToOrder = $(this).attr('data-time-to'),
            div2 = $(this).find('.js-clock');
        startTimer(timeOfOrder,timeToOrder,div2);
    });

    $('body').on('click', '.js-delete', function (){
        var data= $(this).closest('.panel').attr('data-id');
        $.ajax({
            url: "/waiter/delete",
            type: "POST",
            data: {
                delete: data
            },
            success: function() {
                var panel =  $('[data-id="'+data+'"]');
                panel.remove();
            }
        });
    });




});
