<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Play extends CI_Controller {
	// config rate: 1/1000
	var $ratio = 100;
	var $num_spin = 3;
	var $text = 'name';
	var $date = '31-12-2018';

	public function __construct(){
		parent::__construct();

		$this->load->model('Award_Model');
	}

	public function index()
	{
		$data = array();

		$user_sess = $this->session->userdata('user');
		$data['user'] = $this->Award_Model->get_oauth_user_by_id($user_sess['id']);

		$awards = $this->Award_Model->get_awards($this->text);
		$data['num_awards'] = count($awards);

		$data['awards'] = $this->set_color_spin($awards);

		$data['wheel'] = $this->load->view('play/content/wheel', $data, true);
		$data['content'] = $this->load->view('play/index', $data, true);
		$data['load_js'] = $this->load->view('play/load_js', $data, true);
		$data['load_css'] = $this->load->view('play/load_css', $data, true);

		$this->load->view('_layout/theme', $data);
	}

	public function get_name_awards(){
		
		$data_return = array(
			'status' => 0,
			'msg' => 'Fail! Please try again.',
		);

		$alias = $this->input->post('alias');
		if($alias){
			
			$award = $this->Award_Model->get_award_by_alias($this->text, $alias);
			
			// update spin and award
			/* $data_user = $this->Award_Model->get_oauth_user_by_id($this->session->userdata('user')['id']);
			$this->Award_Model->update_oauth_user(array('spin'=>$data_user->spin - 1), $data_user->id);
			$this->Award_Model->save_oauth_award(array(
				'oauth_uid' => $data_user->oauth_uid,
				'awards_alias' => $award->alias,
				'code' => isset($award->amount) && $award->amount > 0 ? 'STP'.$this->generate_random_code() : null,
				'amount' => isset($award->amount) && $award->amount > 0 ? $award->amount : null,
				'description' => $award->name,
				'created' => date('c'),
			)); */
			if(!empty($award)){
				$data_return = array(
						'status' => 1,
						'data' => array(
								'award' => str_replace(PHP_EOL, '', $award->name),
								'alias' => $award->alias,
								'spin' => 1,
								'email' => '',
								'alias' => $award->alias,
						),
						'msg' => 'Congratulation!'
				);
				
				$aw_number['number_award'] = $award->number_award == 0 ? 0 : $award->number_award - 1;
				$aff = $this->Award_Model->update('awards', $aw_number, array('id'=>$award->id));
				
				
				// Calculator rate award
				// 1. Get total award
				$total_adwar = $this->Award_Model->get_total_number_awards_luckydraw();
					
				// 2. Update all rate award
				$all_adwars = $this->Award_Model->get_all_luckydraw_awards();
				foreach ($all_adwars as $aw){
					$rate = !empty($total_adwar) ? $aw['number_award']/$total_adwar : 0;
					$aw_rate['special'] = $rate;
					$aff = $this->Award_Model->update('awards', $aw_rate, array('id'=>$aw['id']));
				}
			}
		}
		echo  json_encode($data_return);
	}

	public function get_radius(){
		$data_return = array();
		
		$total = $this->input->post('total');
		
		$awards = $this->Award_Model->get_awards($this->text, 'id, special');
		// dao nguoc mang
		$awards = array_reverse($awards);
			
		$range = 0;
		foreach ($awards as $key => $value) {
			$range += $value['special'];
			$awards[$key]['range'] = $range;
		}
		
		// chose lucky number
		$rand = rand(0, $this->ratio) / $this->ratio;
		
		foreach ($awards as $key => $value) {
			if($value['range'] > $rand){
				$item = $key;
				break;
			}
		}
		if(!isset($item)){
			$item = count($awards) - 1;
		}
		
		$data_return = array(
				'status' => 1,
				'radius' => $item * (360/$total) + 180/$total + 275, // 135: goc 4h30
				'spin' => 1,
		);
		/* if($user_sess = $this->session->userdata('user')){
			// check number spin
			$user = $this->Award_Model->get_oauth_user_by_id($user_sess['id']);

			if(!empty($user->email)){
				if(!empty($user->spin) && $user->spin > 0){

					

				} else {
					$data_return = array(
						'status' => 0,
						'msg' => 'Đã hết lượt quay!',
					);
				}
			} else {
				$data_return = array(
					'status' => 0,
					'open_popup_email' => 1,
					'msg' => 'Vui lòng thêm email để nhận giải!',
				);
			}
		} else {
			$data_return = array(
				'status' => 0,
				'msg' => 'Vui lòng đăng nhập facebook để tham gia quay thưởng!',
			);
		} */

		echo json_encode($data_return);
		
	}

	private function set_color_spin($awards){
		if(!empty($awards) > 0){
			foreach ($awards as $key => $value) {
				switch ($key % 4) {
					case 1:
						$awards[$key]['fillStyle'] = 'transparent';
						break;
					case 2:
						$awards[$key]['fillStyle'] = 'transparent';
						break;
					case 3:
						$awards[$key]['fillStyle'] = 'transparent';
						break;
					default:
						$awards[$key]['fillStyle'] = 'transparent';
						break;
				}
			}
		}
		return $awards;
	}

	public function check_user_login(){
		$response = $this->input->post();

		$data_return = array();
		$sess_user = $this->session->userdata('user');

		if(!empty($response['status']) && $response['status'] == 'connected'){
			
			$this->check_datauser($response);

			if(empty($sess_user['id']) || $sess_user['id'] != $response['id']){
				$this->session->set_userdata('user', $response);
				$data_return['reload'] = true;
			}
		} else {
			$this->session->unset_userdata('user');
			if(!empty($sess_user['id'])){
				$data_return['reload'] = true;
			}
		}

		echo json_encode($data_return);
	}

	private function check_datauser($data){
		$user = $this->Award_Model->get_oauth_user_by_id($data['id']);
		
		if(!count($user)){
			$insert = array(
				'oauth_provider' => 'facebook',
				'oauth_uid' => $data['id'],
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name'],
				'email' => isset($data['email']) ? $data['email'] : '',
				'spin' => $this->num_spin,
				'created' => date('c'),
				'modified' => date('c'),
			);

			$this->Award_Model->save_oauth_user($insert);
		}
	}

	public function processAfterShare(){
		$data_return = array(
			'status' => 0,
			'msg' => 'Lỗi! Vui lòng thử lại.',
		);
		// get data user
		$data_user = $this->Award_Model->get_oauth_user_by_id($this->session->userdata('user')['id']);
		
		if(!empty($data_user->id) && empty($data_user->share)){
			$update = $this->Award_Model->update_oauth_user(array('spin'=>$data_user->spin + 3, 'share'=>1), $data_user->id);
			if($update){
				$data_return = array(
					'status' => 1,
					'spin' => $data_user->spin + 3,
					'msg' => 'Bạn được thêm 3 lượt quay.',
				);
			}
		}

		echo json_encode($data_return);
	}

	public function saveUserEmail(){
		$data_return = array(
			'status' => 0,
			'msg' => 'Lỗi! Vui lòng thử lại.',
		);

		$email = $this->input->post('email');

		// get data user
		$data_user = $this->Award_Model->get_oauth_user_by_id($this->session->userdata('user')['id']);
		if(!empty($data_user->id)){
			$update = $this->Award_Model->update_oauth_user(array('email'=>$email), $data_user->id);

			if($update){
				$data_return = array(
					'status' => 1,
					'msg' => 'Cập nhật email thành công.',
				);
			}

			// if($update){
			// 	// send email after update email
			// 	$this->send_email_award($email);

			// 	$data_return = array(
			// 		'status' => 1,
			// 		'msg' => 'Đã gửi thông tin phần thưởng tới email.',
			// 	);
			// }
		}

		echo json_encode($data_return);
	}

	private function generate_random_code($alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789", $code_len = 6){
	    $pass = array(); //remember to declare $pass as an array

	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

	    for ($i = 0; $i < $code_len; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	function send_email_award(){
		$voucher = array();
		$data_return = array(
			'status' => 0,
			'msg' => 'Lỗi! Vui lòng thử lại.',
		);

		// // off by phuongnh
		// if(!$email_to){
		// 	$email_to = $this->input->post('email_to');
		// }
		$email_to = $this->input->post('email_to');
		$award_alias = $this->input->post('award_alias');

		if(!empty($email_to)){
			$data_award = $this->Award_Model->get_award_by_email($email_to, $award_alias);
		}

		$content = '';

		$view['content_email'] = '';
		if(!empty($data_award)){
			if($data_award->amount == -1 && $data_award->code == NULL){
				$data_award->award_name = str_replace(PHP_EOL, '', $data_award->award_name);
				$data_award->content = str_replace('{name}', $data_award->last_name . ' ' . $data_award->first_name, $data_award->content);
				$data_award->content = str_replace('{award}', $data_award->award_name, $data_award->content);
			}
			if($data_award->amount > 0 && !empty($data_award->code)){
				$data_award->content = str_replace('{name}', $data_award->last_name . ' ' . $data_award->first_name, $data_award->content);
				$data_award->content = str_replace('{code-voucher}', $data_award->code, $data_award->content);
				$data_award->content = str_replace('{amount}', number_format($data_award->amount, 0) . ' VND', $data_award->content);

				$voucher = array(
					'code' => $data_award->code,
					'amount' => $data_award->amount,
					'expired_date' => date('Y-m-d', strtotime($this->date)),
					'log' => 'created by spinwheel',
					'date_created' => date('c'),
					'date_modified' => date('c'),
				);
			}

			$view['content_email'] = $data_award->content;
			$content = $this->load->view('email_template/email_award', $view, true);
		}

		$subject = 'Bestprice: Thông báo giải thưởng chương trình quay số.';
		$this->load->helper('email');
		$send = send_email(RESERVATION_EMAIL, $email_to, $subject, $content);
		if($send){
			$data_return = array(
				'status' => 1,
				'msg' => 'Đã gửi thông tin phần thưởng tới email.',
			);
		}

		if($send && !empty($voucher)){
			// create voucher in table voucher
			$this->Award_Model->insert('vouchers', $voucher);
		}

		if(!$this->input->post('email')){
			echo json_encode($data_return);
		}
	}

	function send_email_award_to_organizer(){
		$email_to = $this->input->post('email_to');
		$award_alias = $this->input->post('award_alias');	
	}
}
