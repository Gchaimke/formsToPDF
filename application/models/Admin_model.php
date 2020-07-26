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
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'email_to' => array(
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

    function createCompaniesDb()
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
            'logo' =>array(
                'type' => 'VARCHAR',
                'constraint' => 500
            ),
            'form_header' => array(
                'type' => 'VARCHAR',
                'constraint' => 500
            ),
            'form_extra_filds' => array(
                'type' => 'VARCHAR',
                'constraint' => 500
            ),
            'form_footer' => array(
                'type' => 'VARCHAR',
                'constraint' => 500
            )            
        );

        $this->dbforge->add_field($client);
        // define primary key
        $this->dbforge->add_key('id', TRUE);
        // create table
        $this->dbforge->create_table('companies');

        $cl = array(
            "name" => 'Avdor-HLT',
            "logo"=> '/assets/img/logo.png',
            "form_header" => 'Company Header',
            "form_extra_filds" => 'extra',
            "form_footer" => 'Company Footer',
            
        );
        $this->db->insert('companies', $cl);
    }

    function createFormsDb()
    {
        $this->load->dbforge();
        $company = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 9,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'date' => array(
                'type' => 'DATE'
            ),
            'client_num' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
            ),
            'issue_num' => array(
                'type' => 'VARCHAR',
                'constraint' => 50
            ),
            'client_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 60
            ),
            'issue_kind' => array(
                'type' => 'VARCHAR',
                'constraint' => 500
            ),
            'place' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'start_time' => array(
                'type' => 'TIME'
            ),
            'end_time' => array(
                'type' => 'TIME'
            ),
            'manager' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'contact_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'activity_text' => array(
                'type' => 'TEXT'
            ),
            'checking_text' => array(
                'type' => 'TEXT'
            ),
            'summary_text' => array(
                'type' => 'TEXT'
            ),
            'remarks_text' => array(
                'type' => 'TEXT'
            ),
            'trip_start_time' => array(
                'type' => 'TIME'
            ),
            'trip_end_time' => array(
                'type' => 'TIME'
            )
        );
        $this->dbforge->add_field($company);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('forms');

        $demoForm = array(
            "date" => '2020-04-30',
            "client_num" => '123456',
            "issue_num" => '#1225544',
            "client_name" => 'Client',
            "issue_kind" => 'issue',
            "place" => 'Tel-Aviv',
            "start_time" => '',
            "end_time" => '',
            "manager" => '',
            "contact_name" => '',
            "activity_text" => '',
            "checking_text" => '',
            "summary_text" => '',
            "remarks_text" => '',
            "trip_start_time" => '',
            "trip_end_time" => '',
        );
        $this->db->insert('forms', $demoForm);
    }


    function createSettingsDb()
    {
        $this->load->dbforge();
        $settings = array(
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

        $this->dbforge->add_field($settings);
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
        //get companies number
        if ($this->db->table_exists('companies')) {
            $response['companies'] = $this->db->count_all("companies");
        }
        //get forms number
        if ($this->db->table_exists('forms')) {
            $response['forms'] = $this->db->count_all("forms");
        }
        return $response;
    }

    public function get_current_forms_records($limit, $start, $form)
	{
		$this->db->limit($limit, $start);
		if ($form != '') {
			$form = urldecode($form);
			$condition = "form LIKE \"$form%\"";
			$this->db->where($condition);
		}
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

    public function get_total($form = '')
	{
		if ($form != '') {
			$this->db->from('forms');
            $form = urldecode($form);
            $condition = "form LIKE '$form%'";
			$this->db->where($condition);
		}
		return $this->db->count_all_results();
    }
    
    function deleteForm($id)
	{
		$this->db->delete('wft_forms', array('id' => $id));
    }
    
    function restore_from_trash($data)
	{
        $where = "id =" . $data['id'];
        $form = str_replace('Trash ','',$data['form']);
		$data = array(
			'form' => $form
		);
		return $this->db->update('forms', $data, $where);
	}
}
