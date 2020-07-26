<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Companies_model extends CI_Model
{

    public function addCompany($data)
    {
        if ($this->db->table_exists('companies')) {
            // Query to check whether username already exist or not
            $condition = "name ='" . $data['name'] . "'";
            $this->db->select('*');
            $this->db->from('companies');
            $this->db->where($condition);
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
                $condition = "id ='$id'";
                $this->db->where($condition);
                $this->db->limit(1);
            }
            if ($name != '') {
                $condition = "name = '$name'";
                $this->db->where($condition);
                $this->db->limit(1);
            }
            $q = $this->db->get();
            $response = $q->result_array();
        }
        return $response;
    }

    public function editCompany($data)
    {
        $where = "id ='" . $data['id'] . "'";
        return $this->db->update('companies', $data, $where);
    }

    function deleteCompany($id)
    {
        $this->db->delete('wft_companies', array('id' => $id));
    }
}
