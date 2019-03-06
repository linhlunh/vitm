<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function update_awards(){
		$data = array(
			array(
				'id' => 1,
				'alias' => 'TOUR-THAI-FREE',
				'name' => 'Tour Thái Lan '.PHP_EOL.'0 đồng',
				'amount' => -1,
				'special' => 0.0001,
				'pos' => 7,
				'email_award_id' => 3,
			),
			array(
				'id' => 2,
				'alias' => 'TOUR-SING-FREE',
				'name' => 'Tour Singapore '.PHP_EOL.'0 đồng',
				'amount' => -1,
				'special' => 0.0001,
				'pos' => 2,
				'email_award_id' => 3,
			),
			array(
				'id' => 3,
				'alias' => 'FLIGHT-FREE',
				'name' => 'Vé Máy Bay '.PHP_EOL.'0 đồng',
				'amount' => -1,
				'special' => 0.0001,
				'pos' => 9,
				'email_award_id' => 2,
			),
			array(
				'id' => 4,
				'alias' => 'VOU-VIN-FREE',
				'name' => 'Voucher Vinpearl '.PHP_EOL.'2N1Đ',
				'amount' => -1,
				'special' => 0.0001,
				'pos' => 4,
				'email_award_id' => 4,
			),
			array(
				'id' => 5,
				'alias' => 'VOU-50',
				'name' => 'Voucher '.PHP_EOL.'50.000 vnd',
				'amount' => 50000,
				'special' => 0.376,
				'pos' => 6,
				'email_award_id' => 1,
			),
			array(
				'id' => 6,
				'alias' => 'VOU-100',
				'name' => 'Voucher '.PHP_EOL.'100.000 vnd',
				'amount' => 100000,
				'special' => 0.25,
				'pos' => 8,
				'email_award_id' => 1,
			),
			array(
				'id' => 7,
				'alias' => 'VOU-200',
				'name' => 'Voucher '.PHP_EOL.'200.000 vnd',
				'amount' => 200000,
				'special' => 0.02,
				'pos' => 3,
				'email_award_id' => 1,
			),
			array(
				'id' => 8,
				'alias' => 'VOU-300',
				'name' => 'Voucher '.PHP_EOL.'300.000 vnd',
				'amount' => 300000,
				'special' => 0.002,
				'pos' => 5,
				'email_award_id' => 1,
			),
			array(
				'id' => 9,
				'alias' => 'VOU-500',
				'name' => 'Voucher '.PHP_EOL.'500.000 vnd',
				'amount' => 500000,
				'special' => 0.0016,
				'pos' => 10,
				'email_award_id' => 1,
			),
			array(
				'id' => 10,
				'alias' => 'GOOD-LUCK',
				'name' => 'Chúc bạn '.PHP_EOL.'may mắn lần sau',
				'amount' => 0,
				'special' => 0.35,
				'pos' => 1,
				'email_award_id' => null,
			),
		);

		$this->load->model('Award_Model');
		$this->Award_Model->create_table_awards($data);
	}

	public function update_email_template(){
		$data = array(
			array(
				'id' => 1, 
				'name' => 'Email voucher', 
				'content' => '<p>Chúc mừng bạn <b style="color: #ff0000">{name}</b> đã trúng voucher mã <b style="color: #ff0000">{code-voucher}</b> trị giá <b style="color: #ff0000">{amount}</b> của BestPrice Travel,  bạn có thể sử dụng voucher này để đặt các dịch vụ: <a href="https://www.bestprice.vn/ve-may-bay">vé máy bay</a>, <a href="https://www.bestprice.vn/tour">tour du lịch</a>, <a href="https://www.bestprice.vn/khach-san">đặt phòng khách sạn</a> tại <a href="https://www.bestprice.vn">www.bestprice.vn</a></p>
					<p>Voucher có thời hạn sử dụng tới 31/12/2018.</p>', 
			),
			array(
				'id' => 2, 
				'name' => 'Vé 0 đồng', 
				'content' => '<p>Chúc mừng bạn <span style="color: #ff0000;">{name}</span> đã trúng thưởng <strong style="color: #ff0000;">{award}</strong> của BestPrice.</p>
					<p>Điều kiện sử dụng:</p>
					<ul>
					<li>Chỉ áp dụng cho 1 vé máy bay đặt hành trình nội địa.</li>
					<li>Giá vé chưa bao gồm thuế phí.</li>
					<li>Phải đặt trước ít nhất 21 ngày.</li>
					<li>Giải thưởng không có giá trị quy đổi thành tiền mặt.</li>
					</ul>
					<p>Voucher có thời hạn sử dụng tới 31/12/2018.</p>', 
			),
			array(
				'id' => 3, 
				'name' => 'Tour 0 đồng', 
				'content' => '<p>Chúc mừng bạn <span style="color: #ff0000;">{name}</span> đã trúng thưởng <strong style="color: #ff0000;">{award}</strong> của BestPrice.</p>
					<p>Điều kiện sử dụng:</p>
					<ul>
					<li>Giải thưởng chỉ áp dụng cho 1 hành khách.</li>
					<li>Giá vé chưa bao gồm thuế phí.</li>
					<li>Phải đặt trước ít nhất 21 ngày.</li>
					<li>Giải thưởng không có giá trị quy đổi thành tiền mặt.</li>
					</ul>
					<p>Voucher có thời hạn sử dụng tới 31/12/2018.</p>', 
			),
			array(
				'id' => 4, 
				'name' => 'Voucher Vinpearl 2N1Đ', 
				'content' => '<p>Chúc mừng bạn <span style="color: #ff0000;">{name}</span> đã trúng thưởng <strong style="color: #ff0000;">{award}</strong> của BestPrice.</p>
					<p>Điều kiện sử dụng:</p>
					<ul>
					<li>Giải thưởng chỉ áp dụng cho phòng vinpearl 2 ngày 1 đêm.</li>
					<li>Voucher áp dụng tại: vinpearl Hạ Long, Vinpearl Nha Trang, Vinpearl Phú Quốc, Vinpearl Cần Thơ, Vinpearl Cửa Hội, Vinpearl Hà Tĩnh.</li>
					<li>Phải đặt trước ít nhất 21 ngày.</li>
					<li>Giải thưởng không có giá trị quy đổi thành tiền mặt.</li>
					</ul>
					<p>Voucher có thời hạn sử dụng tới 31/12/2018.</p>', 
			),
		);

		$this->load->model('Award_Model');
		$this->Award_Model->create_table_email_template($data);
	}

}