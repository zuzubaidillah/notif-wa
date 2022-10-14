<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Makses extends CI_Model
{
	public function ambiluser()
	{
		$user = $this->session->userdata('session_id');
		
		$sql = "SELECT * FROM akses where id='$user'";
		$querySql = $this->db->query($sql);
		
		return $querySql->result_array();
	}
	
	public function getData()
	{
		$sql = "SELECT * FROM akses ORDER BY nama ASC";
		$querySql = $this->db->query($sql);
		
		return $querySql->result_array();
	}
	
	public function add($tb, $data)
	{
		$this->db->insert($tb, $data);
		return $this->db->affected_rows(); // 0 atau 1
	}
	
	public function cekUsername($idAkses)
	{
		$sql = "SELECT * FROM akses WHERE id='$idAkses'";
		$querySql = $this->db->query($sql);
		
		return $querySql->result_array();
	}
	
	public function getDataKecualiLogin()
	{
		$id = $this->session->userdata('session_id');
		$sql = "SELECT * FROM akses WHERE id != '$id' ORDER BY nama ASC, level asc";
		$querySql = $this->db->query($sql);
		
		return $querySql->result_array();
	}
	
	public function update($tb, $data, $kolom, $nilai)
	{
		$this->db->where($kolom, $nilai);
		$this->db->update($tb, $data);
		return $this->db->affected_rows(); // 0 atau 1
	}
	
	public function delete($nilai)
	{
		$this->db->where('id', $nilai);
		$this->db->delete('super_admin');
		return $this->db->affected_rows(); // 0 atau 1
	}
	
	public function cekId($id)
	{
		$sql = "SELECT * FROM akses WHERE id='$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
