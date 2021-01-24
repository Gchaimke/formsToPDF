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
				'type' => 'VARCHAR',
				'constraint' => 30,
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
			"status" => 'new'
		);
		$this->db->insert('tickets', $admin);
	}

	public function add($data)
	{
		if ($this->db->table_exists('tickets')) {
			$this->db->select('*');
			$this->db->from('tickets');
			$this->db->where("client_num ='{$data['client_num']}'");
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() == 0) {
				// Query to insert data in database
				$this->db->insert('tickets', $data);
				if ($this->db->affected_rows() > 0) {
					return true;
				}
			} else {
				return false;
			}
		}
	}

	function get_all($user_id = '')
	{
		$response = array();
		// Select record
		$this->db->select('*');
		$this->db->from('tickets');
		if($user_id!=''){
			$this->db->where("creator_id ='$user_id'");
		}
		$q = $this->db->get();
		$response = $q->result_array();
		return $response;
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

	public function update($data)
	{
		if(isset($data['id'])){
			$where = "id =" . $data['id'];
			$this->db->update('tickets', $data, $where);
		}
		else if(isset($data['client_num'])){
			$where = "client_num =" . $data['client_num'];
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
