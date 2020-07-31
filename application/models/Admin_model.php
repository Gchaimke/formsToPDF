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
            'email_to' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'log' => array(
                'type' => 'TEXT',
                'null' => TRUE
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
        $company = array(
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
            'logo' => array(
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => TRUE
            ),
            'form_header' => array(
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => TRUE
            ),
            'form_extra_filds' => array(
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => TRUE
            ),
            'form_footer' => array(
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => TRUE
            )
        );

        $this->dbforge->add_field($company);
        // define primary key
        $this->dbforge->add_key('id', TRUE);
        // create table
        $this->dbforge->create_table('companies');

        $cl = array(
            "name" => 'Avdor-HLT',
            "logo" => '/assets/img/logo.png',
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
            'trip_start_time' => array(
                'type' => 'TIME',
                'null' => TRUE
            ),
            'trip_end_time' => array(
                'type' => 'TIME',
                'null' => TRUE
            ),
            'back_start_time' => array(
                'type' => 'TIME',
                'null' => TRUE
            ),
            'attachments' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'back_end_time' => array(
                'type' => 'TIME',
                'null' => TRUE
            )
        );
        $this->dbforge->add_field($company);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('forms');

        $demoForm = array(
            "date" => '2020-05-26',
            "client_num" => '123456',
            "issue_num" => '1225544',
            "client_name" => 'Client',
            "issue_kind" => 'issue',
            "place" => 'Tel-Aviv'
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
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'log' => array(
                'type' => 'LONGTEXT',
                'null' => TRUE
            )
        );

        $this->dbforge->add_field($settings);
        // define primary key
        $this->dbforge->add_key('id', TRUE);
        // create table
        $this->dbforge->create_table('settings');

        $st = array(
            'roles' => 'Admin,Manager,User',
            'log' => 'Database "settings created."'
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

    function restore_from_trash($data)
    {
        $where = "id =" . $data['id'];
        $form = str_replace('Trash ', '', $data['form']);
        $data = array(
            'form' => $form
        );
        return $this->db->update('forms', $data, $where);
    }
}
