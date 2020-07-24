<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    function createUsersDb()
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
            'role' => array(
                'type' => 'VARCHAR',
                'constraint' => 60
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 500
            ),
            'log' => array(
                'type' => 'TEXT'
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

    function createClientsDb()
    {
        $this->load->dbforge();
        $client = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 9,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => 60,
                'unique' => TRUE
            ),
            'projects' => array(
                'type' => 'VARCHAR',
                'constraint' => 500
            ),
            'logo' =>array(
                'type' => 'VARCHAR',
                'constraint' => 500
            )
        );

        $this->dbforge->add_field($client);
        // define primary key
        $this->dbforge->add_key('id', TRUE);
        // create table
        $this->dbforge->create_table('clients');

        $cl = array(
            "name" => 'Avdor-HLT',
            "projects" => 'Project1,Project 2',
            "logo"=> '/assets/img/logo.png'
        );
        $this->db->insert('clients', $cl);
    }

    function createChecklistDb()
    {
        $this->load->dbforge();
        $checklist = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 9,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'serial' => array(
                'type' => 'VARCHAR',
                'constraint' => 30,
            ),
            'client' => array(
                'type' => 'VARCHAR',
                'constraint' => 30
            ),
            'project' => array(
                'type' => 'VARCHAR',
                'constraint' => 60
            ),
            'data' => array(
                'type' => 'VARCHAR',
                'constraint' => 500
            ),
            'progress' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE
            ),
            'assembler' => array(
                'type' => 'VARCHAR',
                'constraint' => 50
            ),
            'qc' => array(
                'type' => 'VARCHAR',
                'constraint' => 50
            ),
            'date' => array(
                'type' => 'DATE',
                'null' => FALSE
            ),
            'log' => array(
                'type' => 'TEXT'
            ),
            'scans' => array(
                'type' => 'TEXT'
            )
        );
        $this->dbforge->add_field($checklist);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('checklists');

        $demoChecklist = array(
            "serial" => 'P001-07-20',
            "client" => 'Avdor-HLT',
            "project" => 'Project1',
            "data" => '',
            "progress" => '0',
            "assembler" => 'User',
            "qc" => 'Admin',
            "date" => '2020-04-30',
            "log" => 'New checklist creatin in project Project1 for client Avdor-HLT',
        );
        $this->db->insert('checklists', $demoChecklist);
    }

    function createProjectsDb()
    {
        $this->load->dbforge();
        $project = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 9,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'client' => array(
                'type' => 'VARCHAR',
                'constraint' => 60
            ),
            'project' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => TRUE
            ),
            'data' => array(
                'type' => 'TEXT'
            ),
            'template' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
            ),
            'scans' => array(
                'type' => 'TEXT'
            )
        );

        $this->dbforge->add_field($project);
        // define primary key
        $this->dbforge->add_key('id', TRUE);
        // create table
        $this->dbforge->create_table('projects');

        $tp = array(
            "client" => 'Avdor-HLT',
            "project" => 'Project1',
            "data" => 'header;HD',
            "template" => 'Pxxx,mm,yy,-'
        );
        $this->db->insert('projects', $tp);
    }

    function createSettingsDb()
    {
        $this->load->dbforge();
        $project = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 9,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'roles' => array(
                'type' => 'TEXT'
            ),
            'log' => array(
                'type' => 'LONGTEXT'
            )
        );

        $this->dbforge->add_field($project);
        // define primary key
        $this->dbforge->add_key('id', TRUE);
        // create table
        $this->dbforge->create_table('settings');

        $st = array(
            'roles' => 'Admin,Assembler,QC',
            'log' =>'Database "settings created."'
        );
        $this->db->insert('settings', $st);
    }

    function getSettings()
    {
        $response = array();
        // Select record
        $this->db->select('*');
        $this->db->from('settings');
        $query = $this->db->get();
        $response = $query->result_array();
        return $response;
    }

    public function save_settings($data)
	{
		$where = "id =1";
		$data = array(
			'roles' => $data['roles']
		);
		return $this->db->update('settings', $data, $where);
	}

    function getStatistic()
    {
        $response = array();
        //get users number
        if ($this->db->table_exists('users')) {
            $response['users']  = $this->db->count_all("users");
        }
        //get clients number
        if ($this->db->table_exists('clients')) {
            $response['clients'] = $this->db->count_all("clients");
        }
        //get checklists number
        if ($this->db->table_exists('checklists')) {
            $response['checklists'] = $this->db->count_all("checklists");
        }
        return $response;
    }

    public function get_current_checklists_records($limit, $start, $project)
	{
		$this->db->limit($limit, $start);
		if ($project != '') {
			$project = urldecode($project);
			$condition = "project LIKE \"$project%\"";
			$this->db->where($condition);
		}
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get("checklists");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}

			return $data;
		}

		return false;
	}

    public function get_total($project = '')
	{
		if ($project != '') {
			$this->db->from('checklists');
            $project = urldecode($project);
            $condition = "project LIKE '$project%'";
			$this->db->where($condition);
		}
		return $this->db->count_all_results();
    }
    
    function deleteChecklist($id)
	{
		$this->db->delete('wft_checklists', array('id' => $id));
    }
    
    function restore_from_trash($data)
	{
        $where = "id =" . $data['id'];
        $project = str_replace('Trash ','',$data['project']);
		$data = array(
			'project' => $project
		);
		return $this->db->update('checklists', $data, $where);
	}
}
