<?php defined('BASEPATH') or exit('No direct script access allowed');

class Register_Vitm extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->model('Register_Vitm_Model');

        $this->load->library('form_validation');

        $this->load->language('vitm');

        $this->load->helper(array('url', 'form', 'email', 'language', 'file'));

        $this->load->add_package_path(APPPATH . 'third_party/captcha/')->library('Captcha');
    }
    public function index()
    {
        $data = array();

        $ip_client = $this->get_ip();

        if(file_exists(FCPATH . 'storage/submit_register_vitm_by_client_ip/list_client_ip_submited.txt')){

            $list_client_ip_submited = file_get_contents(FCPATH . 'storage/submit_register_vitm_by_client_ip/list_client_ip_submited.txt');

            $list_client_ip_submited = json_decode($list_client_ip_submited, true);

            if(!empty($list_client_ip_submited[$ip_client])){
                
                if ($list_client_ip_submited[$ip_client] >= 3) {
                    $data['show_captcha'] = 'true';
                }
            }
        }
        $this->load->view('register_vitm_template/register_vitm_template', $data);
    }

    function render_img_captcha()
    {
        try {

            $DayyanRandomCharacters = new DayyanRandomCharacters();

            $id = $DayyanRandomCharacters->get_id();

            $key = $DayyanRandomCharacters->get_key();

            $code = strtoupper($DayyanRandomCharacters->get_code());

            $_SESSION['captcha_code'] = $code;

            $id = urldecode($id);

            $key = urldecode($key);

            $DayyanRandomCharacters = new DayyanRandomCharacters();

            $ConfirmString = strtoupper($DayyanRandomCharacters->md5_decrypt($id, $key));

            $DayyanConfirmImage = new DayyanConfirmImage($ConfirmString);

            $DayyanConfirmImage->ShowImage();
        } catch (Exception $ex) {
            echo 'Caught exception: ',  $ex->getMessage(), "<br />\n";
            exit;
        }
    }

    function submit_register_vitm()
    {
        $action = $this->input->post('action');

        $oauth_user_rules = array(
            array(
                'field' => 'full_name',
                'label' => lang("full_name"),
                'rules' => 'required'
            ),
            array(
                'field' => 'email',
                'label' => lang("email"),
                'rules' => 'required|callback_email_check'
            ),
            array(
                'field' => 'phone',
                'label' => lang("phone"),
                'rules' => 'required|callback_phone_check'
            ),
        );
        $this->form_validation->set_rules($oauth_user_rules);

        $this->form_validation->set_error_delimiters('<span style="color:red">', '</span>');

        $ip_client = $this->get_ip();

        if ($action == 'save') {

            if(file_exists(FCPATH . 'storage/submit_register_vitm_by_client_ip/list_client_ip_submited.txt')){

                $list_client_ip_submited = file_get_contents(FCPATH . 'storage/submit_register_vitm_by_client_ip/list_client_ip_submited.txt');

                $list_client_ip_submited = json_decode($list_client_ip_submited, true);
            }else{
                write_file(FCPATH . 'storage/submit_register_vitm_by_client_ip/list_client_ip_submited.txt', json_encode(''));

                $list_client_ip_submited = array();
            }
            if(!empty($list_client_ip_submited[$ip_client])){

                $list_client_ip_submited[$ip_client] ++;

                if($list_client_ip_submited[$ip_client] == 3){
                    $result_ajax['reload_page'] = 'true';
                }
            }else{
                $list_client_ip_submited[$ip_client] = 1;
            }
            write_file(FCPATH . 'storage/submit_register_vitm_by_client_ip/list_client_ip_submited.txt', json_encode($list_client_ip_submited));

            if ($this->form_validation->run()) {

                $oauth_user_submit = $this->input->post();

                if(!empty($_SESSION['captcha_code'])){
                    $current_captcha_code = $_SESSION['captcha_code'];
                }

                $oauth_user = array(
                    'full_name' => $oauth_user_submit['full_name'],
                    'email'     => trim($oauth_user_submit['email']),
                    'phone'     => trim($oauth_user_submit['phone']),
                    'link'      => 'vitm',
                    'created'   =>  date('Y-m-d H:i:m'),
                    'modified'  =>  date('Y-m-d H:i:m'),
                );
                if ( empty($oauth_user_submit['captcha_code']) || $current_captcha_code == $oauth_user_submit['captcha_code']) {
                    if (!$this->Register_Vitm_Model->check_is_set_email_or_phone($oauth_user)) {

                        $insert_id = $this->Register_Vitm_Model->insert_oauth_user($oauth_user);

                        if (!empty($insert_id)) {

                            $oauth_user['event_code'] = 'VITM' . str_pad($insert_id, 4, '0', STR_PAD_LEFT);

                            $oauth_user['id'] = $insert_id;

                            $this->Register_Vitm_Model->update_oauth_user($oauth_user);

                            $email_template = $this->load->view('register_vitm_template/email_vitm_template', $oauth_user, true);

                            $sms_content = 'BestPrice gui ma luot quay ' . $oauth_user['event_code'] . ' de tham gia San Du Lich 0 Dong. Thong tin chi tiet LH: 19006505 hoac bestprice.vn';

                            //send_email_bestprice('marketing@bestprice.vn', $oauth_user['email'], 'BestPrice gửi mã lượt quay Săn du lịch 0đ', $email_template, '', '', '', '');

                            //$this->send_sms_vitm($oauth_user, $sms_content);

                            $result_ajax['success'] = 'true';
                        }
                    } else {
                        $result_ajax['exist_phone_or_email'] = 'true';
                    }
                } else {
                    $result_ajax['wrong_captcha'] = 'true';
                }
            }
           
            echo(json_encode($result_ajax));
        }
    }

    function check_available_email_and_phone()
    {
        $oauth_user_submit = $this->input->post();
        $oauth_user = array(
            'full_name' => $oauth_user_submit['full_name'],
            'email'     => trim($oauth_user_submit['email']),
            'phone'     => trim($oauth_user_submit['phone']),
            'link'      => 'vitm',
            'created'   =>  date('Y-m-d H:i:m'),
            'modified'  =>  date('Y-m-d H:i:m'),
        );

        echo json_encode($this->Register_Vitm_Model->check_is_set_email_or_phone($oauth_user) ? 'true' : 'false');
    }

    private function is_email($email)
    {
        return (preg_match("/^[A-Za-z0-9_\.]{1,32}@([a-zA-Z0-9]{2,12})(\.[a-zA-Z]{2,12})+$/", $email, $matches));
    }

    private function is_phone($phone)
    {
        return preg_match('/^0(9\d{8}|8\d{8}|7\d{8}|3\d{8}|5\d{8})$/', $phone) ? true : false;
    }

    function phone_check($str)
    {
        if ($this->is_phone($str)) {
            return true;
        } else {
            $this->form_validation->set_message('phone_check', lang('error_phone_format'));
            return false;
        }
    }

    function email_check($str)
    {
        if ($this->is_email($str)) {
            return true;
        } else {
            $this->form_validation->set_message('email_check', lang('error_email_format'));
            return false;
        }
    }

    function send_sms_vitm($oauth_user, $content_sms)
    {
        $sms_data_url = 'http://cloudsms.vietguys.biz:8088/api/?u=BPMarketing&pwd=hk7rg&from=BestPrice';

        $sms_data_url .= '&phone=' . $oauth_user['phone'];
        $sms_data_url .= '&sms=' . urlencode($content_sms);

        $ch = curl_init($sms_data_url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 2. execute and fetch the resulting HTML output
        $output = curl_exec($ch);
        $output = trim($output);

        if (!empty($output) && is_numeric($output) && $output < 0) {
            log_message('error', '[ERROR]send_sms_vitm - Event code -> ' . $oauth_user['event_code'] . ' Phone --> ' . $oauth_user['phone'] . ' Output: ---> ' . $output);
        }
        // 4. free up the curl handle
        curl_close($ch);

        if (!empty($output) && !is_numeric($output)) {
            return $output;
        }

        return false;
    }
    function get_ip()
    {
        $ipaddress = '0.0.0.0';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        }

        return trim($ipaddress);
    }
}
