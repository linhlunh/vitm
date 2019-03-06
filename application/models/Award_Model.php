<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Award_Model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function get_total_number_awards_luckydraw(){
		$this->db->select('sum(number_award) as total');
		$this->db->from('awards');
		$this->db->where('deleted !=', 1);
		$this->db->where('active', 1);
		$results = $this->db->get()->result_array();
		if (!empty($results)){
			return $results[0]['total'];
		}
		return $results;
	}
	public function get_all_luckydraw_awards(){
		$this->db->select('aw.id, aw.number_award');
		$this->db->from('awards AS aw');
		$this->db->where('aw.deleted !=', 1);
		$this->db->where('aw.active', 1);
		$results = $this->db->get()->result_array();
		return $results;
	}
	public function update($table, $data, $where)
	{
		$data['user_modified_id'] = 146;
		$data['date_modified'] = date('c');
		$this->db->where($where);
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}
	function create_table_awards($data) {
		// $this->load->dbforge();
		// // create table
		// $this->dbforge->add_field('id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY');
		// $this->dbforge->add_field("alias varchar(50) NOT NULL");
		// $this->dbforge->add_field("name varchar(100) NOT NULL");
		// $this->dbforge->add_field("active tinyint(4) NOT NULL DEFAULT '1'");
		// $this->dbforge->add_field("special int(4) NULL DEFAULT '0'");
		// $this->dbforge->add_field("pos int(4) NOT NULL");
		// $this->dbforge->add_field("user_created_id int(11) NOT NULL");
		// $this->dbforge->add_field("date_created datetime NOT NULL");
		// $this->dbforge->add_field("user_modified_id int(11) NOT NULL");
		// $this->dbforge->add_field("date_modified datetime NOT NULL");
		// $this->dbforge->add_field("deleted tinyint(4) NOT NULL DEFAULT '0'");
		
		// $this->dbforge->create_table('awards', TRUE, array('ENGINE' => 'MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci'));
		
		// insert data
		$this->db->insert_batch ( 'awards', $data );
	}

	function create_table_email_template($data){
		$this->db->insert_batch ( 'template_email_award', $data );
	}

	function get_awards($default = 'alias', $select_more = '') {
		$this->db->select ( $default . ' as text' . (! empty ( $select_more ) ? ',' . $select_more : '') );
		$this->db->from ( 'awards' );
		$this->db->where ( array (
				'active' => 1,
				'deleted !=' => 1 
		) );
		$this->db->order_by ( 'pos' );
		$this->db->limit ( 16 );
		$results = $this->db->get ()->result_array ();
		return $results;
	}
	function get_award_by_alias($text, $alias) {
		$this->db->select('id, alias, name, amount, number_award');
		$this->db->from('awards');
		$this->db->where ( array (
				$text => $alias,
				'active' => 1,
				'deleted !=' => 1 
		) );
		$result = $this->db->get ()->first_row ();
		return $result;
	}
	function get_award_by_email($email, $award_alias) {
		$this->db->select ( 'ou.first_name, ou.last_name, aw.name AS award_name, aw.amount, oa.code, tea.content' );
		$this->db->from ( 'awards AS aw' );
		$this->db->join ( 'oauth_awards AS oa', 'oa.awards_alias = aw.alias' );
		$this->db->join ( 'oauth_users AS ou', 'ou.oauth_uid = oa.oauth_uid' );
		$this->db->join ( 'template_email_award AS tea', 'tea.id = aw.email_award_id AND tea.deleted != 1', 'left' );
		
		$this->db->where ( 'aw.alias', $award_alias );
		$this->db->where ( 'ou.email', $email );
		$this->db->where ( 'aw.amount !=', 0 );
		$this->db->where ( 'aw.deleted !=', 1 );
		$this->db->order_by('oa.id', 'desc');

		$result = $this->db->get()->first_row();
		echo('<pre>');print_r($this->db->last_query());echo('</pre>');exit();
		return $result;
	}
	function get_oauth_user_by_id($uid) {
		$this->db->select ( 'id, oauth_uid, first_name, last_name, email, spin, share' );
		$this->db->from ( 'oauth_users' );
		$this->db->where ( 'oauth_uid', $uid );
		
		$res = $this->db->get ()->first_row ();
		return $res;
	}
	function save_oauth_user($data) {
		$this->db->insert ( 'oauth_users', $data );
	}
	function update_oauth_user($data, $id) {
		$this->db->update ( 'oauth_users', $data, array (
				'id' => $id 
		) );
		return $this->db->affected_rows ();
	}
	function save_oauth_award($data) {
		$this->db->insert ( 'oauth_awards', $data );
	}

	function insert($table, $data) {
		$this->db->insert ( $table, $data );
	}
	function insert_multi($table, $data) {
		$this->db->insert_batch ( $table, $data );
	}
}