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
            <h1 class='title-vitm'>ĐĂNG KÝ LƯỢT QUAY SĂN DU LỊCH 0 ĐỒNG</h1>
            <div class='vitm-rules'>
                <b>Thể lệ:</b>
                <ul class='rules-detail'>
                    <li> Người chơi đăng ký thông tin cá nhân để nhận mã lượt quay qua email và tin nhắn SMS.</li>
                    <li> Người chơi cầm mã lượt quay đến bàn lễ tân tại gian hàng của BetsPrice tại hội chợ Du lịch Quốc tế (VITM) từ ngày 27/03/2019 - 30/03/2019 để đổi 1 lượt quay Săn du lịch 0 đồng</li>
                </ul>
            </div>
            <h2 class='title-form-register'>THÔNG TIN ĐĂNG KÝ</h2>
            <div class='midle-vitm'>

                <div class="row">
                    
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 left">
                    </div>
                    
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-12 midle">
                        <form id="frm_register_vitm" action="" method='post'>
                            <input type="text" name="full_name" autocomplete="off" id="full_name" value="<?= set_value('full_name') ?>" placeholder="Họ tên">
                            <div class="notification">
                                <span class='error' id='error_full_name'>Họ tên không được để trống!</span>
                            </div>
                            <input type="text" name="phone" id="phone" autocomplete='off' value="<?= set_value('phone') ?>" placeholder="Số điện thoại ">
                            <div class="notification">
                                <span class='error' id='error_phone'>Số điện thoại không được để trống!</span>
                                <span class='error' id='error_wrong_phone'>Số điện thoại không đúng!</span>
                            </div>
                            <input type="text" name="email" id="email" autocomplete='off' value="<?= set_value('email') ?>" placeholder="Email">
                            <div class="notification">
                                <span class='error' id='error_email'>Email không được để trống!</span>
                                <span class='error' id='error_wrong_email'>Email không hợp lệ!</span>
                            </div>
                            <button name='action' id='btn_render_code' type='submit' value='save'>Nhận mã</button>
                            <div></div>
                        </form>
                    </div>

                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 right">
                        <div class='wheel'>
                            <img src="<?= ASSETS ?>images/register-vitm/vong-quay.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <h3 class='price-vitm-title'>NHỮNG GIẢI THƯỞNG 0 ĐỒNG GIÁ TRỊ NHẤT</h3>
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
                <b class='company-name'>Thông tin Công ty Du lịch BestPrice</b>
                <br />
                <b>VP Hà Nội:</b> 12A ngõ Bà Triệu, Phố Bà Triệu, Q.Hai Bà Trưng
                <br />
                <b>VP HCM:</b> 95 Trần Quang Khải, Tân, Q1
                <br />
                <b>Hotline:</b> 19006505 (Nhấn phím 0 để được trợ giúp)
                <br />
                <b>Email:</b> marketing@bestprice.vn
            </div>
        </div>
    </div>
</body>

</html> 