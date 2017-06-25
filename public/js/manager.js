$(document).ready(function (){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.js-change').on('click', function(){
       var user = $('.user').val(),
           role =  $('.role').val();

        $.ajax({
            url: "/manager/change",
            type: "POST",
            data:{
                user : user,
                role : role
            },
            success: function() {
                $('.status').append('<p>Changed</p>');
            },

        });
    });
});
