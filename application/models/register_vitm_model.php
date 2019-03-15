<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Register_Vitm_Model extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    function insert_oauth_user($oauth_user)
    {
        $this->db->insert('oauth_users', $oauth_user);

        $insert_id = $this->db->insert_id();

        return !empty($insert_id) ? $insert_id : '';
    }

    function update_oauth_user($oauth_user)
    {
        $this->db->update('oauth_users', $oauth_user, array('id' => $oauth_user['id']));

        return $this->db->affected_rows();
    }

    function check_is_set_email_or_phone($oauth_user)
    {
        $this->db->where('link','vitm');

        $this->db->where('(email = "'.$oauth_user['email'].'" OR phone = "'.$oauth_user['phone'].'")');

        $this->db->from('oauth_users');

        $result = $this->db->count_all_results();

        return ($result != 0) ? true : false;
    }
}
