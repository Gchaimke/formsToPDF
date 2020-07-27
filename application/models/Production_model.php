<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Production_model extends CI_Model
{

	public function add_form($data)
	{
		// Query to check whether serial already exist or not
		$condition = "issue_num ='" . $data['issue_num'] . "'";
		$this->db->select('*');
		$this->db->from('forms');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			// Query to insert data in database
			$this->db->insert('forms', $data);
			$insert_id = $this->db->insert_id();
			if ($this->db->affected_rows() > 0) {
				return $insert_id;
			}
		} else {
			return false;
		}
	}

	function getForms($id = '', $company = '')
	{
		$response = array();
		if ($this->db->table_exists('forms')) {
			// Select record
			$this->db->select('*');
			$this->db->from('forms');
			if ($id != '') {
				if (strpos($id, ':') == false) {
					$condition = "id ='$id'";
					$this->db->where($condition);
					$this->db->limit(1);
				}else{
					$id = str_replace(':',',',$id);
					$condition = "id IN ($id)";
					$this->db->where($condition);
				}
			}
			if ($company != '') {
				$company = urldecode($company);
				$condition = "company =\"$company\"";
				$this->db->where($condition);
			}
			$q = $this->db->get();
			$response = $q->result_array();
		}
		return $response;
	}

	function move_to_trash($data)
	{
		$where = "id =" . $data['id'];
		$data = array(
			'company' => 'Trash '. $data['company']
		);
		return $this->db->update('forms', $data, $where);
	}

}
