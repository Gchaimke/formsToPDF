<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contacts_model extends CI_Model
{
    function create()
    {
        $this->load->dbforge();
        $contact = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 9,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => 60
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => TRUE
            ),
            'company' => array(
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => TRUE
            ),
            'users_list' => array(
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => TRUE
            ),
        );

        $this->dbforge->add_field($contact);
        // define primary key
        $this->dbforge->add_key('id', TRUE);
        // create table
        $this->dbforge->create_table('contacts');

        $cl = array(
            "name" => 'Yosef',
            "email" => 'Yosef@forms.com',
            "company" => 'Forms',
            "users_list" => ''
        );
        $this->db->insert('contacts', $cl);
    }

    public function add($data)
    {
        if ($this->db->table_exists('contacts')) {
            // Query to check whether username already exist or not
            $this->db->select('*');
            $this->db->from('contacts');
            $this->db->where("email ='{$data['email']}'");
            $this->db->limit(1);
            $query = $this->db->get();
            if ($query->num_rows() == 0) {
                // Query to insert data in database
                $this->db->insert('contacts', $data);
                if ($this->db->affected_rows() > 0) {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    function get($id = '', $name = '')
    {
        $response = array();
        if ($this->db->table_exists('contacts')) {
            // Select record
            $this->db->select('*');
            $this->db->from('contacts');
            if ($id != '') {
                $this->db->where("id ='$id'");
                $this->db->limit(1);
            }
            if ($name != '') {
                $this->db->where("name = '$name'");
                $this->db->limit(1);
            }
            $q = $this->db->get();
            $response = $q->result_array();
        }else{
            $this->create();
        }
        return $response;
    }

    public function edit($data)
    {
        $where = "id ={$data['id']}";
        return  $this->db->update('contacts', $data, $where);  
    }

    function delete($id)
    {
        $this->db->delete('contacts', array('id' => $id));
    }
}
