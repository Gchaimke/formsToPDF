<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clients_model extends CI_Model
{

    public function addClient($data)
    {
        if ($this->db->table_exists('clients')) {
            // Query to check whether username already exist or not
            $condition = "name ='" . $data['name'] . "'";
            $this->db->select('*');
            $this->db->from('clients');
            $this->db->where($condition);
            $this->db->limit(1);
            $query = $this->db->get();
            if ($query->num_rows() == 0) {
                // Query to insert data in database
                $this->db->insert('clients', $data);
                if ($this->db->affected_rows() > 0) {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    function getClients($id = '', $projects = '')
    {
        $response = array();
        if ($this->db->table_exists('clients')) {
            // Select record
            $this->db->select('*');
            $this->db->from('clients');
            if ($id != '') {
                $condition = "id ='$id'";
                $this->db->where($condition);
                $this->db->limit(1);
            }
            if ($projects != '') {
                $condition = "projects LIKE '%$projects%'";
                $this->db->where($condition);
                $this->db->limit(1);
            }
            $q = $this->db->get();
            $response = $q->result_array();
        }
        return $response;
    }

    public function editClient($data)
    {
        $where = "id ='" . $data['id'] . "'";
        $data = array(
            'projects' => $data['projects'],
            'logo' => $data['logo']
		);
        return $this->db->update('clients', $data, $where);
    }

    function deleteClient($id)
    {
        $this->db->delete('wft_clients', array('id' => $id));
    }
}
