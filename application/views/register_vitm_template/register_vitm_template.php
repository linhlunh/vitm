<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Chương trình vòng quay may mắn - BestPrice</title>

    <meta name="robots" content="noindex,nofollow" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:url" content="http://res.bestprice.vn/luckydraw/" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Chương trình vòng quay may mắn - BestPrice" />
    <meta property="og:description" content="Chương trình vòng quay may mắn - BestPrice" />
    <meta property="og:image" content="https://owa.bestprice.vn/assets/img/bestpricevn-logo.13092017.png" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://owa.bestprice.vn/assets/img/favicon.27042017.ico">

    <script type="text/javascript" src="<?= ASSETS ?>libs/jquery.min-3.3.1.js"></script>
    <script type="text/javascript" src="<?= ASSETS ?>libs/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?= ASSETS ?>libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ASSETS ?>css/register_vitm.css">
    <link rel="stylesheet" href="<?= ASSETS ?>css/main.css">
    <script type="text/javascript" src="<?= ASSETS ?>js/register_vitm.js"></script>
</head>

<body>
    <div class='content-vitm'>
        <div class="container">
            <h1 class='title-vitm'><?= lang('title_vitm') ?></h1>
            <div class='vitm-rules'>
                <b><?= lang('rules') ?>:</b>
                <ul class='rules-detail'>
                    <li> <?= lang('rule_1') ?></li>
                    <li> <?= lang('rule_2') ?></li>
                </ul>
            </div>
            <h2 class='title-form-register'><?= lang('title_form_register') ?></h2>
            <div class='midle-vitm'>

                <div class="row">

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 left">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 midle">
                        <form id="frm_register_vitm" action="" method='post'>
                            <input type="text" name="full_name" autocomplete="off" id="full_name" value="<?= set_value('full_name') ?>" placeholder="<?= lang('full_name') ?>">
                            <div class="notification">
                                <span class='error' id='error_full_name'><?= lang('error_full_name') ?></span>
                            </div>
                            <input type="text" name="email" id="email" autocomplete='off' value="<?= set_value('email') ?>" placeholder="<?= lang('email') ?>">
                            <div class="notification">
                                <span class='error' id='error_email'><?= lang('error_email') ?></span>
                                <span class='error' id='error_wrong_email'><?= lang('error_wrong_email') ?></span>
                            </div>
                            <input type="text" name="phone" id="phone" autocomplete='off' value="<?= set_value('phone') ?>" placeholder="<?= lang('phone') ?>">
                            <div class="notification">
                                <span class='error' id='error_phone'><?= lang('error_phone') ?></span>
                                <span class='error' id='error_wrong_phone'><?= lang('error_wrong_phone') ?></span>
                            </div>
                            <?php if (!empty($show_captcha)) : ?>
                            <div class='line-captcha'>
                                <img id='img_captcha' src="<?= base_url() ?>/render_img_captcha" />
                                <input class='input-captcha' type="text" placeholder='' id='captcha_code' name='captcha_code' autocomplete='off'>
                                <i class="fa fa-refresh" id='btn_change_captcha' aria-hidden="true"></i>
                            </div>
                            <div class="notification">
                                <span class='error' id='error_captcha_code'>Mời bạn điền mã xác nhận</span>
                            </div>
                            <div class='wrong_captcha'>Sai mã Captcha</div>
                            <?php endif; ?>
                            <button name='action' id='btn_render_code' value='save'>
                                <span class='content-btn-submit'><?= lang('render_code') ?></span>
                                <span id='btn_loading'><i style='margin-right: 4px' class="fa fa-spinner fa-spin"></i>Đang gửi...</span>
                            </button>
                        </form>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 right">
                        <div class='wheel'>
                            <img src="<?= ASSETS ?>images/register-vitm/vong-quay.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <h3 class='price-vitm-title'><?= lang('price_vitm_title') ?></h3>
            <div class='price-vitm'>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <img class='img-upper' src="<?= ASSETS ?>images/register-vitm/tour-thai-lan-13032019_914.png">
                        <img class='img-below fix-img-pc' src="<?= ASSETS ?>images/register-vitm/tour-du-thuyen-13032019_914.png">
                        <img class='img-upper fix-img-mobile' src="<?= ASSETS ?>images/register-vitm/nghi-duong-vinpearl.png">
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <img class='img-below fix-img-mobile' src="<?= ASSETS ?>images/register-vitm/tour-du-thuyen-13032019_914.png">
                        <img class='img-upper fix-img-pc' src="<?= ASSETS ?>images/register-vitm/nghi-duong-vinpearl.png">
                        <img class='img-below' src="<?= ASSETS ?>images/register-vitm/ve-may-bay-0-dong-13032019_914.png">
                    </div>
                </div>
            </div>
            <div class='dash-footer-vitm'></div>
            <div class='footer-vitm'>
                <div class='company-name'>
                    <b class='company-name'><?= lang('bestprice_info') ?></b>
                </div>
                <b>VP Hà Nội:</b> <?= lang('ha_noi_office') ?>
                <br />
                <b>VP Hồ Chí Minh:</b> <?= lang('hcm_office') ?>
                <br />
                <b>Hotline:</b> <?= lang('company_hotline') ?>
                <br />
                <b>Email:</b> <?= lang('company_email') ?>
            </div>
            <div class='dash-footer-vitm'></div>
            <div class='donor-vitm'>
                <div class='donor-vitm-title'> <b>Nhà tài trợ:</b></div>
                <div>
                    <img class='' src="<?= ASSETS ?>images/donor/list_donor_top.png">

                </div>
                <div>
                    <img class='' src="<?= ASSETS ?>images/donor/list_donor_bottom.png">
                </div>
            </div>
        </div>
    </div>
</body>

</html> 