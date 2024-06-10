function start_loader(){
    $('body').append('<div id="preloader"><div class="loader-holder"><div></div><div></div><div></div><div></div>')
}

function end_loader(){
    $('#preloader').fadeOut('fast', function() {
        $(this).remove(); // Changed '#preloader' to 'this'
    });
}

window.alert_toast = function($msg = 'TEST', $bg = 'success', $pos = ''){
    var Toast = Swal.mixin({
        toast: true,
        position: $pos || 'top-end',
        showConfirmButton: false,
        timer: 5000
    });
    Toast.fire({
        icon: $bg,
        title: $msg
    });
};

$(document).ready(function(){
    $('#login-frm').submit(function(e){
        e.preventDefault();
        start_loader();
        if($('.err_msg').length > 0)
           $('.err_msg').remove();
        $.ajax({
            url: _base_url_ + 'Login.php?f=login',
            method: 'POST',
            data: $(this).serialize(),
            error: function(err){
                console.log(err);
            },
            success: function(resp){
                if(resp){
                    resp = JSON.parse(resp);
                    if(resp.status == 'success'){
                        location.replace(_base_url_ + 'it');
                    }else if(resp.status == 'incorrect'){
                        var _frm = $('#login-frm');
                        var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i><Incorrect username or password</div>";
                        _frm.prepend(_msg);
                        _frm.find('input').addClass('is-invalid');
                        $('[name="username"]').focus();
                    }
                    end_loader();
                }
            }
        });
    });

    $('#system-frm').submit(function(e){
        e.preventDefault();
        start_loader();
        if($('.err_msg').length > 0)
            $('.err_msg').remove();
        $.ajax({
            url: _base_url_ + 'classes/SystemSettings.php?f=update_settings',
            data: new FormData($(this)[0]),
            cache: false,
            processData: false,
            method: 'POST',
            success: function(resp){
                if(resp == 1){
                    location.reload();
                }else{
                    $('#msg').html('<div class="alert alert-danger err_msg">An Error occurred</div>');
                    end_loader();
                }
            }
        });
    });
});
