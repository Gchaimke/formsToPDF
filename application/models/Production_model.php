<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Production_model extends CI_Model
{

	function create()
	{
		$this->load->dbforge();
		$form = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 9,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'creator_id' => array(
				'type' => 'INT',
				'constraint' => 9,
				'null' => TRUE
			),
			'creator_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'company' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'date' => array(
				'type' => 'DATE',
				'null' => TRUE
			),
			'client_num' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE
			),
			'issue_num' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE
			),
			'client_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 60,
				'null' => TRUE
			),
			'issue_kind' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'place' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'start_time' => array(
				'type' => 'TIME',
				'null' => TRUE
			),
			'end_time' => array(
				'type' => 'TIME',
				'null' => TRUE
			),
			'manager' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'contact_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'activity_text' => array(
				'type' => 'TEXT',
				'null' => TRUE
			),
			'checking_text' => array(
				'type' => 'TEXT',
				'null' => TRUE
			),
			'summary_text' => array(
				'type' => 'TEXT',
				'null' => TRUE
			),
			'remarks_text' => array(
				'type' => 'TEXT',
				'null' => TRUE
			),
			'recommendations_text' => array(
				'type' => 'TEXT',
				'null' => TRUE
			),
			'email_to' => array(
				'type' => 'TEXT',
				'null' => TRUE
			),
			'client_sign' => array(
				'type' => 'TEXT',
				'null' => TRUE
			),
			'attachments' => array(
				'type' => 'TEXT',
				'null' => TRUE
			),
			'price' => array(
				'type' => 'decimal',
				'null' => TRUE
			),
			'details' => array(
				'type' => 'TEXT',
				'null' => TRUE
			),
			'old_serial' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'new_serial' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			)
		);
		$this->dbforge->add_field($form);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('forms');
	}

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
		$this->db->where("id =$id");
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function update_form($data)
	{
		// Query to check whether id already exist or not
		$where = "id ={$data['id']}";
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
				$condition = "issue_num LIKE '%$search%' OR client_num LIKE '%$search%' OR client_name LIKE '%$search%' OR creator_name LIKE '%$search%' OR place LIKE '%$search%' OR city LIKE '%$search%'";
				$this->db->where($condition);
				$this->db->select('*');
				$this->db->from('forms');
				$this->db->order_by('date', 'DESC');
				$this->db->order_by('start_time', 'DESC');
				$query = $this->db->get();
				//$response = $query->result_array();

				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$data[] = $row;
					}
					return $data;
				}
				return false;
			}
		}
	}

	function getMonthFroms($month = '1', $userid = '', $year = '', $company = '')
	{
		if ($this->db->table_exists('forms')) {

			if ($userid != '') {
				$this->db->where("creator_id = $userid");
			}

			if ($company != '') {
				$company = urldecode($company);
				$this->db->where("company ='$company'");
			}

			if (is_numeric($month)) {
				$this->db->where("MONTH(date) = $month");
			}

			if ($year != '') {
				$this->db->where("YEAR(date) = $year");
			} else {
				$year = date('Y');
				$this->db->where("YEAR(date) = $year");
			}

			$this->db->select('*');
			$this->db->from('forms');
			$this->db->order_by('date', 'DESC');
			$this->db->order_by('start_time', 'DESC');
			$q = $this->db->get();
			$response = $q->result_array();
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

	public function get_total($creator_id = '', $company_name = '', $year = '', $month = '', $date = '')
	{

		if($creator_id!=''){
			$this->db->where("creator_id = $creator_id");
		}

		if ($company_name != '') {
			$company = urldecode($company_name);
			$this->db->where("company ='$company'");
		}

		if ($year != '') {
			$this->db->where("YEAR(date) = $year");
		}

		if ($month != '') {
			$this->db->where("MONTH(date) = $month");
		}

		if ($date != '') {
			$this->db->where("date='$date'");
		}

		$this->db->from('forms');
		return $this->db->count_all_results();
	}

	public function get_current_forms_records($limit, $start, $creator_id = '', $company_name = '', $year = '', $month = '', $date = '')
	{
		if ($creator_id != '') {
			$this->db->where("creator_id = $creator_id");
		}

		if ($company_name != '') {
			$company = urldecode($company_name);
			$this->db->where("company = \"$company\"");
		}

		if ($year != '') {
			$this->db->where("YEAR(date) = $year");
		}

		if ($month != '') {
			$this->db->where("MONTH(date) = $month");
		}

		if ($date != '') {
			$this->db->where("date='$date'");
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
