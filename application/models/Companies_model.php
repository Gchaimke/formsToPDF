<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Companies_model extends CI_Model
{
    function create()
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
            'view_filds' => array(
                'type' => 'TEXT',
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

    public function addCompany($data)
    {
        if ($this->db->table_exists('companies')) {
            // Query to check whether username already exist or not
            $this->db->select('*');
            $this->db->from('companies');
            $this->db->where("name ='{$data['name']}'");
            $this->db->limit(1);
            $query = $this->db->get();
            if ($query->num_rows() == 0) {
                // Query to insert data in database
                $this->db->insert('companies', $data);
                if ($this->db->affected_rows() > 0) {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    function getCompanies($id = '', $name = '')
    {
        $response = array();
        if ($this->db->table_exists('companies')) {
            // Select record
            $this->db->select('*');
            $this->db->from('companies');
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
        }
        return $response;
    }

    public function editCompany($data)
    {
        $where = "id ={$data['id']}";
        return $this->db->update('companies', $data, $where);
    }

    function deleteCompany($id)
    {
        $this->db->delete('wft_companies', array('id' => $id));
    }
}
