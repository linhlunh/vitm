$(document).on('submit', '#frm_register_vitm', function(event) {
    var full_name = $('#full_name').val();
    var email = $('#email').val();
    var phone = $('#phone').val();
    var captcha_code = $('#captcha_code').val();
    set_input_to_default();
    $('input').css('border-color', '#00ffff');
    if (full_name === '' || full_name === null) {
        $('#error_full_name').show();
        $("html, body").animate({ scrollTop: ($('#frm_register_vitm').offset().top - 300) }, 2000);
        alert('Họ tên không được để trống!');
        $('#full_name').css('border-color', '#feff00');
        return false;

    } else {
        $('#error_full_name').hide();
        $('#full_name').css('border-color', '#00ffff');
    }


    if (email === '' || email === null) {
        $('#error_email').show();
        $('#error_wrong_email').hide();
        $("html, body").animate({ scrollTop: ($('#frm_register_vitm').offset().top - 300) }, 2000);
        alert('Email không được để trống!');
        $('#email').css('border-color', '#feff00');
        return false;
    } else {
        if (!(/^[A-Za-z0-9_\.]{1,32}@([a-zA-Z0-9]{2,12})(\.[a-zA-Z]{2,12})+$/.test(email))) {
            $('#error_wrong_email').show();
            $('#error_email').hide();
            $('#email').css('border-color', '#00ffff');
            $("html, body").animate({ scrollTop: ($('#frm_register_vitm').offset().top - 300) }, 2000);
            alert('Email không hợp lệ!');
            $('#email').css('border-color', '#feff00');
            return false;
        } else {
            $('#error_wrong_email').hide();
            $('#email').css('border-color', '#00ffff');
        }
        $('#error_email').hide();

    }


    if (phone === '' || phone === null) {
        $('#error_phone').show();
        $('#error_wrong_phone').hide();
        $("html, body").animate({ scrollTop: ($('#frm_register_vitm').offset().top - 300) }, 2000);
        alert('Số điện thoại không được để trống!');
        $('#phone').css('border-color', '#feff00');
        return false;
    } else {
        $('#error_phone').hide();
        $('#phone').css('border-color', '#00ffff');
        if (!(/^0(9\d{8}|8\d{8}|7\d{8}|3\d{8}|5\d{8})$/.test(phone))) {
            $('#error_wrong_phone').show();
            $("html, body").animate({ scrollTop: ($('#frm_register_vitm').offset().top - 300) }, 2000);
            alert('Số điện thoại không đúng!');
            $('#phone').css('border-color', '#feff00');
            return false;
        } else {
            $('#error_wrong_phone').hide();
            $('#phone').css('border-color', '#00ffff');
        }
    }

    if (captcha_code === '' || captcha_code === null) {
        $('#error_captcha_code').show();
        $("html, body").animate({ scrollTop: ($('#frm_register_vitm').offset().top - 300) }, 2000);
        alert('Bạn cần điền mã xác nhận!');
        $('#captcha_code').css('border-color', '#feff00');
        return false;
    } else {
        $('#error_captcha_code').hide();
        $('#captcha_code').css('border-color', '#00ffff');
    }


    $('.content-btn-submit').hide();
    $('#btn_loading').show();
    $('#btn_render_code').prop('disabled', true);
    $.ajax({
        url: 'submit_register_vitm',
        type: 'post',
        dataType: 'json',
        data: $('#frm_register_vitm').serialize() + '&action=save',
        success: function(result) {
            $('.content-btn-submit').show();
            $('#btn_loading').hide();

            if (result.success == 'true') {
                $('#btn_render_code').prop('disabled', false);
                alert('Code đã được gửi đến email và số điện thoại của bạn.');
                location.reload();
            } else if (result.exist_phone_or_email == 'true') {
                setTimeout(show_alert_exist_phone_or_email, 50);
            } else {
                $('#btn_render_code').prop('disabled', false);
            }


            if (result.wrong_captcha == 'true') {
                $('.wrong_captcha').show();
            } else {
                $('.wrong_captcha').hide();
            }
            if (result.reload_page == 'true') {
                location.reload();
            }
        }
    });

    return false;
});

function show_alert_exist_phone_or_email() {

    $('#btn_render_code').prop('disabled', false);

    alert('Số điện thoại hoặc email đã được sử dụng.');

}

function set_input_to_default() {
    $('.notification').children().hide();
}

$(document).ready(function() {
    $('#btn_change_captcha').click(function() {
        var src = $('#img_captcha').attr('src');
        $('#img_captcha').attr('src', src);
    });
});