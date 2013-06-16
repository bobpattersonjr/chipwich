$(document).ready(function(){
    $(document).on('click', 'button.remove', function(e){
        e.preventDefault();
        var $that = $(this);
        $.post($(this).attr('href'),
            null,
            function(data){
                if (data['success']){
                    show_next_img($('#current').attr('data-id'));
                }
                // else
                //     $("#alert-area-login").append($('<div id="login-error" class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Invaild Login</strong></div>'));
            }, 
            "json");
    });

    $(document).on('click', 'button.approve', function(e){
        e.preventDefault();
        var $that = $(this);
        $.post($(this).attr('href'),
            null,
            function(data){
                if (data['success']){
                    show_next_img($('#current').attr('data-id'));
                }
                // else
                //     $("#alert-area-login").append($('<div id="login-error" class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Invaild Login</strong></div>'));
            }, 
            "json");
    });

    $(document).on('click', 'button.primary', function(e){
        e.preventDefault();
        var $that = $(this);
        $.post($(this).attr('href'),
            null,
            function(data){
                if (data['success']){
                    show_next_img($('#current').attr('data-id'));
                }
                // else
                //     $("#alert-area-login").append($('<div id="login-error" class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Invaild Login</strong></div>'));
            }, 
            "json");
    });

    $(document).keypress(function(e) {
        if(e.which == 97) {
            $('button.approve').click();
            //console.log('approve');
        }
        if(e.which == 115) {
            $('button.primary').click();
            //console.log('primary');
        }
        if(e.which == 100) {
            $('button.remove').click();
            //console.log('remove');
        }
    });


});

    function show_next_img(img_id) {
        next_img_id_int = parseInt(img_id) + 1;
        next_img = $('#' + next_img_id_int.toString());
        $('#remove_img').attr('href', next_img.attr('data-remove')).attr('data', next_img.attr('data-id'));
        $('#approve_img').attr('href', next_img.attr('data-approve')).attr('data', next_img.attr('data-id'));
        $('#primary_img').attr('href', next_img.attr('data-primary')).attr('data', next_img.attr('data-id'));
        $('#img_bar_name').html(next_img.attr('data-bar_name'));
        $('#img_user_name').html(next_img.attr('data-user_name'));
        $('#timeago_img').attr('title', next_img.attr('data-date_c')).html(next_img.attr('data-date_full'));
        $('#img_url').html('<a href="'+ next_img.attr('src') +'" >'+ next_img.attr('data-file_name') +'</a>');
        $('#current').attr('data-id', next_img_id_int.toString());
        $('#img_displayed').attr('data-id', toString(next_img_id_int)).attr('src', next_img.attr('src'));
        next_img.remove();
        $('#' + (parseInt(img_id) + 2).toString()).removeClass('hide');
    };