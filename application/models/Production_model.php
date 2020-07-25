<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Production_model extends CI_Model
{

	public function addChecklist($data)
	{
		// Query to check whether serial already exist or not
		$condition = "serial ='" . $data['serial'] . "' AND project='" . $data['project'] . "'";
		$this->db->select('*');
		$this->db->from('checklists');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			// Query to insert data in database
			$this->db->insert('checklists', $data);
			if ($this->db->affected_rows() > 0) {
				return true;
			}
		} else {
			return false;
		}
	}

	function getChecklists($id = '', $project = '')
	{
		$response = array();
		if ($this->db->table_exists('checklists')) {
			// Select record
			$this->db->select('*');
			$this->db->from('checklists');
			if ($id != '') {
				if (strpos($id, ':') == false) {
					$condition = "id ='$id'";
					$this->db->where($condition);
					$this->db->limit(1);
				}else{
					$id = str_replace(':',',',$id);
					$condition = "id IN ($id)";
					$this->db->where($condition);
				}
			}
			if ($project != '') {
				$project = urldecode($project);
				$condition = "project =\"$project\"";
				$this->db->where($condition);
			}
			$q = $this->db->get();
			$response = $q->result_array();
		}
		return $response;
	}

	public function editChecklist($data)
	{
		$where = "id =" . $data['id'];
		$data = array(
			'data' => $data['data'],
			'log' => $data['log'],
			'progress' => $data['progress'],
			'assembler' => $data['assembler'],
			'qc' => $data['qc'],
			'scans' => $data['scans']
		);
		return $this->db->update('checklists', $data, $where);
	}

	public function batchEditChecklist($data)
	{
		$where = "id =" . $data['id'];
		$data = array(
			'data' => $data['data'],
			'log' => $data['log'],
			'progress' => $data['progress'],
			'assembler' => $data['assembler'],
			'qc' => $data['qc'],
		);
		return $this->db->update('checklists', $data, $where);
	}

	function move_to_trash($data)
	{
		$where = "id =" . $data['id'];
		$data = array(
			'project' => 'Trash '. $data['project']
		);
		return $this->db->update('checklists', $data, $where);
	}

	function getLastChecklist($project)
	{
		$response = array();
		if ($this->db->table_exists('checklists')) {
			$project = urldecode($project);
			$condition = "project =\"$project\"";
			$this->db->select('*');
			$this->db->from('checklists');
			$this->db->where($condition);
			$this->db->order_by('id', 'DESC');
			$this->db->limit(1);
			$q = $this->db->get();
			if ($q->num_rows() > 0) {
				$response = $q->result_array();
				return $response[0]['serial'];
			} else {
				return '00000000000000000';
			}
		}
	}

	function searchChecklist($sn = '')
	{
		if ($this->db->table_exists('checklists')) {
			if ($sn != "") {
				$sn = urldecode($sn);
				$condition = "serial LIKE '%$sn%'";
				$this->db->select('*');
				$this->db->from('checklists');
				$this->db->where($condition);
				$this->db->order_by('project');
				$q = $this->db->get();
				$response = $q->result_array();
				return $response;
			}
		}
	}

	public function get_current_checklists_records($limit, $start, $project)
	{
		$this->db->limit($limit, $start);
		if ($project != '') {
			$project = urldecode($project);
			$condition = "project =\"$project\"";
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
			$this->db->where('project', $project);
		}
		return $this->db->count_all_results();
	}
}
