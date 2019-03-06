function statusChangeCallback(response) {console.log(response);
    if(response.status !== 'connected'){
        ajax_check_form(response);
    }

    afterLogin(response);
}

function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

function afterLogin(response){
    if(response.status === 'connected'){
        FB.api('/me?fields=id,first_name,last_name,email', function(res) {
            res.status = response.status;
            ajax_check_form(res);
        });
    }
}

function ajax_check_form(response){
    $.ajax({
        url: 'check_user_login',
        type: 'post',
        data: response,
        dataType: 'json',
        success: function(res){
            if(res.reload){
                window.location.reload(true);
            }
        },
        error: function(err){
            alert('Lỗi! Vui lòng thử lại.');
        }
    })
}

function checkPermissionEmail(){
    FB.api('/me/permissions', function(response) {
        var check = true;
        for (i = 0; i < response.data.length; i++) { 
            if (response.data[i].permission == "email" && response.data[i].status == "declined") {
                check = false;
            }
        }

        if(!check){}
    });
}

function shareFacebook(obj){
    // check share facebook
    FB.ui({
        method: 'share',
        mobile_iframe: true,
        href: obj.attr('data-href'),
    }, function(response){
        if (response && !response.error_code) {
            $.ajax({
                url: 'processAfterShare',
                type: 'post',
                dataType: 'json',
                success: function(res){
                    if(res.spin){
                        alert(res.msg);
                        $('#num-spin .num').html(res.spin);
                    }
                },
                error: function(err){
                    alert('Lỗi! Vui lòng thử lại.');
                }
            });
        }
    });
}

var appId = '430365350743795';

window.fbAsyncInit = function() {
    FB.init({
        appId      : appId,
        xfbml      : true,
        version    : 'v3.0'
    });
    FB.AppEvents.logPageView();

    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });

    FB.Event.subscribe('auth.login', function(response) {
        afterLogin(response);
    });
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.0&appId='+appId+'&autoLogAppEvents=1';
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));