<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
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
            'smtp_on' => array(
                'type' => 'INT',
                'constraint' => 1,
                'unsigned' => TRUE
            ),
            'smtp_host' => array(
                'type' => 'VARCHAR',
                'constraint' => 300,
                'null' => TRUE
            ),
            'smtp_port' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ),
            'smtp_user' => array(
                'type' => 'VARCHAR',
                'constraint' => 300,
                'null' => TRUE
            ),
            'smtp_pass' => array(
                'type' => 'VARCHAR',
                'constraint' => 300,
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
            'smtp_on' => '0',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => '465',
            'smtp_user' => 'user',
            'smtp_pass' => '',
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
        $this->db->limit(1);
        $query = $this->db->get();
        $response = $query->result_array();
        return $response;
    }

    public function save_settings($data)
    {
        $where = "id =1";
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

    function add_field($col_name,$field_name,$type='VARCHAR',$length = 150){
        $this->load->dbforge();
        if (!$this->db->field_exists($field_name, $col_name)) {
            $fields = array($field_name => array('type' => $type,'constraint'=>$length));
            $this->dbforge->add_column($col_name, $fields);
        }
    }
}
