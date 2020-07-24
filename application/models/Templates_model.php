<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Templates_model extends CI_Model
{
	function getTemplates($client_name = '')
	{
		$response = array();
		// Select record
		$this->db->select('*');
		$this->db->from('projects');
		if (!$client_name == '') {
			$condition = "client ='$client_name'";
			$this->db->where($condition);
		}
		$this->db->order_by('client');
		$q = $this->db->get();
		$response = $q->result_array();
		return $response;
	}

	public function addTemplate($data)
	{
		// Query to check whether username already exist or not
		$condition = "project ='" . $data['project'] . "'";
		$this->db->select('*');
		$this->db->from('projects');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			// Query to insert data in database
			$this->db->insert('projects', $data);
			if ($this->db->affected_rows() > 0) {
				return true;
			}
		} else {
			return false;
		}
	}

	function getTemplate($id = '', $name = '')
	{
		$response = array();
		$condition = "";
		// Select record
		$this->db->select('*');
		$this->db->from('projects');
		$condition = "id ='$id'";
		if (!$id == '') {
			$condition = "id ='$id'";
		}

		if (!$name == '') {
			$name = urldecode($name);
			$condition = "project ='" . $name . "'";
		}
		$this->db->where($condition);
		$this->db->limit(1);
		$q = $this->db->get();
		$response = $q->result_array();
		return $response;
	}

	public function editTemplate($data)
	{
		$where = "id =" . $data['id'];
		$data = array('data' => $data['data'], 'template' => $data['template'], 'scans' => $data['scans']);
		return $this->db->update('projects', $data, $where);
	}

	function deleteTemplate($id)
	{
		$this->db->delete('wft_projects', array('id' => $id));
	}

}
