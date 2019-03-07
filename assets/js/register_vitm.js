$(document).on('submit', '#frm_register_vitm', function() {
    var check = true;
    var full_name = $('#full_name').val();
    var email = $('#email').val();
    var phone = $('#phone').val();

    if (full_name === '' || full_name === null) {
        $('#error_full_name').show();
        $("html, body").animate({ scrollTop: ($('#full_name').offset().top - 100) }, 'slow');
        alert('Họ tên không được để trống!');
        return false;
        check = false;

    } else {
        $('#error_full_name').hide();
    }

    if (phone === '' || phone === null) {
        $('#error_phone').show();
        $('#error_wrong_phone').hide();
        $("html, body").animate({ scrollTop: ($('#phone').offset().top - 100) }, 'slow');
        alert('Số điện thoại không được để trống!');
        return false;
        check = false;
    } else {
        $('#error_phone').hide();
        if (!(/^0(9\d{8}|8\d{8}|7\d{8}|3\d{8}|5\d{8})$/.test(phone))) {
            $('#error_wrong_phone').show();
            $("html, body").animate({ scrollTop: ($('#phone').offset().top - 100) }, 'slow');
            alert('Số điện thoại không đúng!');
            return false;
            check = false;
        } else {
            $('#error_wrong_phone').hide();
        }
    }

    if (email === '' || email === null) {
        $('#error_email').show();
        $('#error_wrong_email').hide();
        $("html, body").animate({ scrollTop: ($('#email').offset().top - 100) }, 'slow');
        alert('Email không được để trống!');
        return false;
        check = false;
    } else {
        if (!(/^[A-Za-z0-9_\.]{6,32}@([a-zA-Z0-9]{2,12})(\.[a-zA-Z]{2,12})+$/.test(email))) {
            $('#error_wrong_email').show();
            $('#error_email').hide();
            $("html, body").animate({ scrollTop: ($('#email').offset().top - 100) }, 'slow');
            alert('Email không hợp lệ!');
            return false;
            check = false;
        } else {
            $('#error_wrong_email').hide();
        }
        $('#error_email').hide();

    }
    console.log(check);

    return check;

});