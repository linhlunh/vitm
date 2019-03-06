<main>
    <div class="content">
        <div class="row">
            <div class="left-content col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <?= $wheel ?>
            </div>
            <div class="right-content col-xs-6 col-sm-6 col-md-6 col-lg-6">

                <div class='logo-bestprice'>
                    <img src="<?= ASSETS . 'images/logo-bestprice.png' ?>" alt="">
                </div>
                <div class='let-spin'>
                    <img id="btn_let_spin" src="<?= ASSETS . 'images/let-spin.gif' ?>" alt="" onclick="startSpin();">
                </div>
                <div class='duong-lucky-draw'>
                    <img src="<?= ASSETS . 'images/duong-lucky-draw.png' ?>" alt="">
                </div>

            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modal-price">
    <div class="modal-dialog">
        <div id="modal_content" class="modal-content">
            <button type="button" class="close btn-close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <img height='767px' class='img-responsive' src="<?= ASSETS . 'images/price-img/bg-popup-price.gif' ?>" alt="">
        </div>
    </div>
</div>
<audio id='rolling' src="<?= ASSETS . 'mp3/rolling.mp3' ?> "></audio>
<audio id='winner' src="<?= ASSETS . 'mp3/winner.mp3' ?>"></audio> 