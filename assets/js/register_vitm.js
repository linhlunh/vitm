$(document).on('submit', '#frm_register_vitm', function() {
    var full_name = $('#full_name').val();
    var email = $('#email').val();
    var phone = $('#phone').val();

    if (full_name === '' || full_name === null) {
        $('#error_full_name').show();
        $("html, body").animate({ scrollTop: ($('#frm_register_vitm').offset().top - 300) }, 2000);
        alert('Họ tên không được để trống!');
        return false;

    } else {
        $('#error_full_name').hide();
    }


    if (email === '' || email === null) {
        $('#error_email').show();
        $('#error_wrong_email').hide();
        $("html, body").animate({ scrollTop: ($('#frm_register_vitm').offset().top - 300) }, 2000);
        alert('Email không được để trống!');
        return false;
    } else {
        if (!(/^[A-Za-z0-9_\.]{1,32}@([a-zA-Z0-9]{2,12})(\.[a-zA-Z]{2,12})+$/.test(email))) {
            $('#error_wrong_email').show();
            $('#error_email').hide();
            $("html, body").animate({ scrollTop: ($('#frm_register_vitm').offset().top - 300) }, 2000);
            alert('Email không hợp lệ!');
            return false;
        } else {
            $('#error_wrong_email').hide();
        }
        $('#error_email').hide();

    }


    if (phone === '' || phone === null) {
        $('#error_phone').show();
        $('#error_wrong_phone').hide();
        $("html, body").animate({ scrollTop: ($('#frm_register_vitm').offset().top - 300) }, 2000);
        alert('Số điện thoại không được để trống!');
        return false;
    } else {
        $('#error_phone').hide();
        if (!(/^0(9\d{8}|8\d{8}|7\d{8}|3\d{8}|5\d{8})$/.test(phone))) {
            $('#error_wrong_phone').show();
            $("html, body").animate({ scrollTop: ($('#frm_register_vitm').offset().top - 300) }, 2000);
            alert('Số điện thoại không đúng!');
            return false;
        } else {
            $('#error_wrong_phone').hide();
        }
    }
    $('.content-btn-submit').hide();
    $('#btn_loading').show()
    $.ajax({
        url: 'submit_register_vitm',
        type: 'post',
        dataType: 'json',
        data: $('#frm_register_vitm').serialize() + '&action=save',
        success: function(result) {
            $('.content-btn-submit').show();
            $('#btn_loading').hide();
            if (result == 'true') {
                alert('Code đã được gửi đến email và số điện thoại của bạn.');
            } else {
                alert('Số điện thoại hoặc email đã được sử dụng.');
            }
        }
    });

    return false;
});