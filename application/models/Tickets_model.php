<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tickets_model extends CI_Model
{
	function create()
	{
		$this->load->dbforge();
		$db = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 9,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'client_num' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'unique' => TRUE
			),
			'client_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'address' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => TRUE
			),
			'city' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => TRUE
			),
			'warehouse_num' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'company_id' => array(
				'type' => 'INT',
				'constraint' => 9,
				'null' => TRUE
			),
			'creator_id' => array(
				'type' => 'INT',
				'constraint' => 9,
				'null' => TRUE
			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 2,
				'null' => TRUE
			)
		);

		$this->dbforge->add_field($db);
		// define primary key
		$this->dbforge->add_key('id', TRUE);
		// create table
		$this->dbforge->create_table('tickets');

		$admin = array(
			"client_num" => '12345',
			"client_name" => 'Client',
			"status" => '0'
		);
		$this->db->insert('tickets', $admin);
	}

	public function add($data)
	{
		if ($this->db->table_exists('tickets')) {
			$this->db->select('*');
			$this->db->from('tickets');
			$this->db->where("client_num ='".$data['client_num']."'");
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() == 0) {
				// Query to insert data in database
				$this->db->insert('tickets', $data);
				if ($this->db->affected_rows() > 0) {
					return true;
				}
			} else {
				unset($data['status']);
				$where = "client_num ='".$data['client_num']."'";
				$this->db->update('tickets', $data, $where);
				return false;
			}
		}
	}

	function get_all($user_id = '', $company_id = '', $search = '', $status = '')
	{
		$user_role ='';
		$current_user_id = '';
		if(isset($this->session->userdata['logged_in'])){
			$user_role =$this->session->userdata['logged_in']['role'];
			$current_user_id = $this->session->userdata['logged_in']['id'];
		}
		$response = array();
		// Select record
		$this->db->select('*');
		$this->db->from('tickets');
		if ($user_id != '') {
			if ($user_id > 0) {
				$this->db->where("creator_id =$user_id");
			} else {
				$this->db->where("creator_id is null");
			}
		}
		if ($user_role == "User") {
			$this->db->where("creator_id =$current_user_id");
		}
		if ($company_id != '') {
			$this->db->where("company_id ='$company_id'");
		}
		if ($search != '') {
			$search = urldecode($search);
			$this->db->where("city LIKE '%$search%' 
								OR client_num LIKE '%$search%' 
								OR client_name LIKE '%$search%' 
								OR address LIKE '%$search%' 
								OR warehouse_num LIKE '%$search%'");
		}
		if ($status != '') {
			$this->db->where("status =$status");
		} else {
			$this->db->where("status NOT LIKE 2");
		}
		$this->db->order_by('city');
		$this->db->order_by('address');
		$this->db->order_by('creator_id');
		$q = $this->db->get();
		$response = $q->result_array();
		return $response;
	}

	function update_status_all($str, $value)
	{
		$data['status'] = $value;
		$where = "status ='$str'";
		$q = $this->db->update('tickets', $data, $where);
		return $q;
	}

	function get($id)
	{
		// Select record
		$this->db->select('*');
		$this->db->from('tickets');
		$this->db->where("id ='$id'");
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	function get_working_tickets_by_client_num($client_num){
		$response = array();
		// Select record
		$this->db->select('*');
		$this->db->from('tickets');
		$this->db->where("client_num='$client_num'");
		$this->db->where("status=1");
		$q = $this->db->get();
		$response = $q->result_array();
		return $response;
	}

	public function update($data)
	{
		if (isset($data['id'])) {
			$where = "id=" . $data['id'];
			$this->db->update('tickets', $data, $where);
		} else if (isset($data['client_num'])) {
			$where = "client_num='" . $data['client_num'] . "' AND status != 3";
			$this->db->update('tickets', $data, $where);
		}

		if ($this->db->affected_rows() > 0) {
			return 'עודכנו בעצלחה';
		}
		return 'אין פרטים חדשים לעדכן';
	}

	function delete($id)
	{
		$this->db->delete('tickets', array('id' => $id));
	}
}
