<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Production_model extends CI_Model
{

	public function add_form($data)
	{
		$this->db->insert('forms', $data);
		$insert_id = $this->db->insert_id();
		if ($this->db->affected_rows() > 0) {
			return $insert_id;
		} else {
			return false;
		}
	}

	function getForm($id)
	{
		// Select record
		$this->db->select('*');
		$this->db->from('forms');
		$condition = "id ='" . $id . "'";
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function update_form($data)
	{
		// Query to check whether id already exist or not
		$where = "id ='" . $data['id'] . "'";
		return $this->db->update('forms', $data, $where);
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
				} else {
					$id = str_replace(':', ',', $id);
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
			'company' => 'Trash ' . $data['company']
		);
		return $this->db->update('forms', $data, $where);
	}

	function deleteForm($id)
	{
		$this->db->delete('wft_forms', array('id' => $id));
	}

	function searchForm($search = '')
	{
		if ($this->db->table_exists('forms')) {
			if ($search != "") {
				$search = urldecode($search);
				$condition = "issue_num LIKE '%$search%' OR client_num LIKE '%$search%' OR client_name LIKE '%$search%' OR creator_name LIKE '%$search%' OR place LIKE '%$search%'";
				$this->db->where($condition);
				$this->db->select('*');
				$this->db->from('forms');
				$this->db->order_by('date', 'DESC');
				$this->db->order_by('start_time', 'DESC');
				$q = $this->db->get();
				$response = $q->result_array();
				return $response;
			}
		}
	}

	function searchFormByMonth($search = '1', $userid = '')
	{
		if ($this->db->table_exists('forms')) {
			if (is_numeric($search)) {
				$condition = "MONTH(date) = $search";
				if ($userid != '') {
					$condition .= " AND creator_id = $userid";
				}
				$this->db->where($condition);
				$this->db->select('*');
				$this->db->from('forms');
				$this->db->order_by('date', 'DESC');
				$this->db->order_by('start_time', 'DESC');
				$q = $this->db->get();
				$response = $q->result_array();
			}
			return $response;
		}
	}

	function getMonthTotal($month, $year, $userid = '')
	{
		if ($this->db->table_exists('forms')) {
			$this->db->where("MONTH(date) = $month");
			$this->db->where("YEAR(date) = $year");
			if ($userid != '') {
				$this->db->where("creator_id = $userid");
			}
			$this->db->select('SUM(price)');
			$this->db->from('forms');
			$this->db->order_by('date', 'DESC');
			$this->db->order_by('start_time', 'DESC');
			$q = $this->db->get();
			$response = $q->result_array();

			return $response;
		}
	}

	public function get_total($creator_id = '', $company_name = '', $date = '')
	{
		if ($creator_id != '') {
			$this->db->where("creator_id = $creator_id");
		}

		if ($company_name != '') {
			$company = urldecode($company_name);
			$this->db->where("company = \"$company\"");
		}

		if ($date != '') {
			$month = substr($date, 5, 2);
			$year = substr($date, 0, 4);
			$this->db->where("MONTH(date) = $month");
			$this->db->where("YEAR(date) = $year");
		}

		$this->db->from('forms');
		return $this->db->count_all_results();
	}

	public function get_current_forms_records($limit, $start, $creator_id = '', $company_name = '', $month = '')
	{
		if ($creator_id != '') {
			$this->db->where("creator_id = $creator_id");
		}

		if ($company_name != '') {
			$company = urldecode($company_name);
			$this->db->where("company = \"$company\"");
		}

		if ($month != '' && is_numeric($month)) {
			$this->db->where("MONTH(date) = $month");
		}
		$this->db->limit($limit, $start);
		$this->db->order_by('date', 'DESC');
		$this->db->order_by('start_time', 'DESC');
		$query = $this->db->get("forms");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
}
