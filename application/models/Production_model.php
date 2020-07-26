<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Production_model extends CI_Model
{

	public function addForm($data)
	{
		// Query to check whether serial already exist or not
		$condition = "serial ='" . $data['serial'] . "' AND company='" . $data['company'] . "'";
		$this->db->select('*');
		$this->db->from('forms');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			// Query to insert data in database
			$this->db->insert('forms', $data);
			if ($this->db->affected_rows() > 0) {
				return true;
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

	public function get_current_forms_records($limit, $start)
	{
		$this->db->limit($limit, $start);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get("forms");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function get_total()
	{
		$this->db->from('forms');
		return $this->db->count_all_results();
	}
}
