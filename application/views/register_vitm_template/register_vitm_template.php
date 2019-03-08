<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="<?= ASSETS ?>libs/jquery.min-3.3.1.js"></script>
    <script type="text/javascript" src="<?= ASSETS ?>libs/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?= ASSETS ?>libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ASSETS ?>css/register_vitm.css">
    <script type="text/javascript" src="<?= ASSETS ?>js/register_vitm.js"></script>
</head>

<body>
    <div class='content-vitm'>
        <div class="container">
            <h1 class='title-vitm'><?=lang('title_vitm')?></h1>
            <div class='vitm-rules'>
                <b><?=lang('rules')?></b>
                <ul class='rules-detail'>
                    <li><?=lang('rule_1')?></li>
                    <li><?=lang('rule_2')?></li>
                </ul>
            </div>
            <h2 class='title-form-register'><?=lang('title_form_register')?></h2>
            <div class='midle-vitm'>

                <div class="row">

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 left">
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 midle">
                        <form id="frm_register_vitm" action="" method='post'>
                            <input type="text" name="full_name" autocomplete="off" id="full_name" value="<?= set_value('full_name') ?>" placeholder="<?=lang('full_name')?>">
                            <div class="notification">
                                <span class='error' id='error_full_name'><?=lang('error_full_name')?></span>
                            </div>
                            <input type="text" name="email" id="email" autocomplete='off' value="<?= set_value('email') ?>" placeholder="<?=lang('email')?>">
                            <div class="notification">
                                <span class='error' id='error_email'><?=lang('error_email')?></span>
                                <span class='error' id='error_wrong_email'><?=lang('error_wrong_email')?></span>
                            </div>
                            <input type="text" name="phone" id="phone" autocomplete='off' value="<?= set_value('phone') ?>" placeholder="<?=lang('phone')?>">
                            <div class="notification">
                                <span class='error' id='error_phone'><?=lang('error_phone')?></span>
                                <span class='error' id='error_wrong_phone'><?=lang('error_wrong_phone')?></span>
                            </div>

                            <button name='action' id='btn_render_code' type='submit' value='save'><?=lang('render_code')?></button>
                            <div></div>
                        </form>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 right">
                        <div class='wheel'>
                            <img src="<?= ASSETS ?>images/register-vitm/vong-quay.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <h3 class='price-vitm-title'><?=lang('price_vitm_title')?></h3>
            <div class='price-vitm'>
                <div class="row">

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <img src="<?= ASSETS ?>images/register-vitm/tour-thai-lan.png" alt="">
                        <img src="<?= ASSETS ?>images/register-vitm/tour-du-thuyen.png" alt="">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <img src="<?= ASSETS ?>images/register-vitm/nghi-duong-vinpearl.png" alt="">
                        <img src="<?= ASSETS ?>images/register-vitm/ve-may-bay-0-dong.png" alt="">
                    </div>
                </div>
            </div>
            <div class='footer-vitm'>
                <b class='company-name'><?=lang('bestprice_info')?></b>
                <br />
                <b>VP Hà Nội:</b> <?=lang('ha_noi_office')?>
                <br />
                <b>VP HCM:</b> <?=lang('hcm_office')?>
                <br />
                <b>Hotline:</b> <?=lang('company_hotline')?>
                <br />
                <b>Email:</b> <?=lang('company_email')?>
            </div>
        </div>
    </div>
    <?php if($exist_phone_or_email){
        echo '<script>alert("Số điện thoại hoặc email đã được sử dụng.")</script>';
    } ?>
</body>

</html> 