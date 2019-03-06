var outerRadius = 275;
var innerRadius = 100;
var textFontSize = 16;

var dataspin = jQuery.parseJSON($('#spin_button').attr('data-spin'));




var theWheel = new Winwheel({
    'drawMode': 'image', // drawMode must be set to image.
    'numSegments': $('#spin_button').attr('num-data'), // The number of segments must be specified.
    'imageOverlay': true, // Set imageOverlay to true to display the overlay.
    'lineWidth': 4, // Overlay uses wheel line width and stroke style so can set these
    'strokeStyle': 'transparent',
    'segments': dataspin,
    'animation': // Define spin to stop animation.
    {
        'type': 'spinToStop',
        'duration': 5,
        'spins': 8,
        'callbackFinished': alertPrize,
    }
});

let firstImg = new Image();

firstImg.onload = function() {
    theWheel.wheelImage = firstImg; // Make wheelImage equal the loaded image object.
    theWheel.draw(); // Also call draw function to render the wheel.
}

firstImg.src = "assets/images/wheel-price.png";

var wheelPower = 0;
var wheelSpinning = false;
// -------------------------------------------------------
// Click handler for spin button.
// -------------------------------------------------------
function startSpin() {
    // Ensure that spinning can't be clicked again while already running.
    if (wheelSpinning == false) {
        $('#rolling').get(0).currentTime = 0;
        $('#rolling').get(0).play();
        $('#btn_let_spin').removeAttr('onClick');
        $.ajax({
            url: 'get_radius',
            type: 'post',
            data: { total: $('#spin_button').attr('num-data') },
            dataType: 'json',
            success: function(res) {
                if (res.radius) {
                    theWheel.rotationAngle = 0;
                    // Begin the spin animation by calling startAnimation on the wheel object.
                    theWheel.startAnimation(res.radius);

                } else {
                    alert(res.msg);
                    if (res.open_popup_email) {
                        $('#myModal').modal('show');
                    }
                }
            },
            error: function(err) {
                alert('Lỗi! Vui lòng thử lại.')
            },
        });
    } else {
        alert('Bạn đã hết lượt quay.')
    }
}

// -------------------------------------------------------
// Called when the spin animation has finished by the callback feature of the wheel because I specified callback in the parameters.
// -------------------------------------------------------
function alertPrize() {
    // Get the segment indicated by the pointer on the wheel background which is at 0 degrees.
    var winningSegment = theWheel.getIndicatedSegment();
    $.ajax({
        url: 'get_name_awards',
        type: 'post',
        data: { alias: winningSegment.text },
        dataType: 'json',
        success: function(res) {
            if (res.status == 1) {
                if (res.data.alias == 'GOOD-LUCK') {
                    alert(res.data.award);
                } else {
                    $('#modal_content').removeClass();
                    $('#modal_content').addClass('modal-content');
                    $('#modal_content').addClass('award-' + res.data.alias);
                    $('#modal-price').modal('show');
                    $('#btn_let_spin').attr('onClick', 'startSpin();');
                    // send email
                    //ajax_send_email_award(res.data.email, res.data.alias);
                    $('#rolling').get(0).pause();
                    $('#rolling').get(0).currentTime = 0;
                    $('#winner').get(0).play();
                }
                $('#num-spin .num').html(res.data.spin);
            } else {
                alert(res.msg);
            }
        },
        error: function(err) {},
    });

}

function ajax_send_email_award(email, award_alias) {
    //$("#LoadingImage").show();
    $.ajax({
        url: 'send_email_award',
        type: 'post',
        data: { 'email_to': 'huudt@bestprice.vn', 'award_alias': award_alias },
        dataType: 'json',
        success: function(res) {
            //$("#LoadingImage").hide();
            //alert(res.msg);
        },
        error: function(err) {
            //$("#LoadingImage").hide();
            //alert('Fail');
        },
    });
}

// // off by phuongnh
// function load_modal_getemail(){
//     var modal = '<div id="myModal" class="modal fade" role="dialog">'
//                     + '<div class="modal-dialog">'
//                         + '<div class="modal-content">'
//                             + '<div class="modal-header">'
//                                 + '<h4 class="modal-title">Email</h4>'
//                                 + '<button type="button" class="close" data-dismiss="modal">&times;</button>'
//                             + '</div>'
//                             + '<div class="modal-body">'
//                                 + '<label>Add email</label>'
//                                 + '<input id="email" class="form-control" name="email" type="email" />'
//                             + '</div>'
//                             + '<div class="modal-footer">'
//                                 + '<button type="button" class="btn btn-save-email btn-success">Save</button>'
//                                 + '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
//                             + '</div>'
//                         + '</div>'
//                     + '</div>'
//                 + '</div>';


//     $('#modal-email').html(modal);
// }

$(document).ready(function() {
    // // off by phuongnh
    // if($('#num-spin .num').length && $('#num-spin .num').html() == 0){
    //     load_modal_getemail();
    // }

    $('#modal-price').on('hidden.bs.modal', function() {
        $('#winner').get(0).pause();
        $('#winner').get(0).currentTime = 0;
    });

    $('.btn-save-email').on('click', function() {
        var email = $(this).closest('.modal-dialog').find('input[name=email]').val();
        if (email) {
            $.ajax({
                url: 'saveUserEmail',
                type: 'post',
                data: { email: email },
                dataType: 'json',
                success: function(res) {
                    alert(res.msg);
                    if (res.status == 1) {
                        $('#myModal').modal('hide');
                    }

                    // // off by phuongnh
                    // if(res.status == 1){
                    //     $('#myModal').modal('hide');
                    //     $('.btn-add-email').remove();
                    // }
                },
                error: function(err) {},
            })
        }
    });
});