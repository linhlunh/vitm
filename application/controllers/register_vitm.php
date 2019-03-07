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

        $this->load->helper(array('url', 'form', 'email', 'language'));
    }
    public function index()
    {
        $data = array();

        $user_sess = $this->session->userdata('user');
        
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

        if ($action == 'save') {
            if ($this->form_validation->run()) {
                $oauth_user_submit = $this->input->post();

                $oauth_user = array(
                    'full_name' => $oauth_user_submit['full_name'],
                    'email'     => $oauth_user_submit['email'],
                    'phone'     => $oauth_user_submit['phone'],
                    'link'      => 'vitm',
                    'created'   =>  date('Y-m-d H:i:m'),
                    'modified'  =>  date('Y-m-d H:i:m'),
                );
                $insert_id = $this->Register_Vitm_Model->insert_oauth_user($oauth_user);
             
                if (!empty($insert_id)) {

                    $oauth_user['event_code'] = 'VITM' . str_pad($insert_id, 4, '0', STR_PAD_LEFT);

                    $oauth_user['id'] = $insert_id;
    
                    $this->Register_Vitm_Model->update_oauth_user($oauth_user);

                    //$content_email = $this->load->view('landing_page/email_template', true);

                    //send_email_bestprice('from', $oauth_user['email'], 'subject', $content_email, '', '', '', '');


                    //$this->send_sms_vitm($oauth_user, 'content');

                    echo('<script>alert("Mã đã gửi đến email và số điện thoại của bạn.")</script>');
                }
            }
        }
        $this->load->view('register_vitm_template/register_vitm_template', $data);
    }

    private function is_email($email)
    {
        return (preg_match("/^[A-Za-z0-9_\.]{6,32}@([a-zA-Z0-9]{2,12})(\.[a-zA-Z]{2,12})+$/", $email, $matches));
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
}
