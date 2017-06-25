$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var socket = io('http://localhost:3000');

    socket.on('orderDelete-channel:App\\Events\\DeleteOrder', function (data) {
        $('[data-id="'+data.id+'"]').remove();
    });

    socket.on('newOrder-channel:App\\Events\\NewOrder', function (data) {
        var data = data.form;
        $('#content').prepend('<div class="panel panel-info panel-style" style="display:none" data-id="'+
            data.id+'"><div class="panel-heading">Cooking...</div><div class="panel-body">' +
            '<ul class="list-group"><li class="list-group-item"><b>Name: </b>'+
            data.name+'</li> <li class="list-group-item"><b>Table: </b>'+
            data.table+'</li><li class="list-group-item"><b>Dish: </b>'+
            data.dish+'</li><li class="list-group-item js-time"><b>Time: <span class="js-clock"></span></b></li></ul></div>' +
            '<button type="button"  data-loading-text="Loading..." class="btn btn-info js-loading-btn">Done</button></div>');
        var panel = $('[data-id="'+data.id+'"]'),
            div = panel.find('.js-clock');
        startTimer(data.timeOfOrder,data.timeToOrder,div);
        panel.slideDown('slow');
        $('#notif_audio')[0].play();
    });



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
            panel.find('.js-loading-btn')
                .removeClass('btn-info')
                .addClass('btn-danger');
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
                    panel.find('.js-loading-btn')
                        .removeClass('btn-info')
                        .addClass('btn-danger');
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

    $('body').on ('click','.js-loading-btn' ,function () {
        var btn = $(this);
        btn.button('loading');
        var data= btn.closest('.panel').attr('data-id');
        $.ajax({
            url: "/cook/done",
            type: "POST",
            data:{
                id: data
            },
            success: function() {
                btn.button('reset');
                setTimeout (function() {
                    btn.attr('disabled', 'disabled');
                    btn.removeClass('btn-info')
                        .removeClass('btn-danger');
                    btn.addClass('btn-success');
                }, 0);
                var clos = btn.closest('.panel');
                clos.removeClass('panel-info');
                clos.removeClass('panel-danger');
                clos.addClass('panel-success');
                clos.find('.panel-heading').text ('Done');
            }
        });
    });


});
