<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Magenda extends CI_Model
{
	public function getData()
	{
		$sql = "SELECT * FROM agenda ORDER BY nama ASC";
		$querySql = $this->db->query($sql);
		
		return $querySql->result_array();
	}
	
	public function getDataRelasi()
	{
		$level = $this->session->userdata('session_level');
		$sql = "SELECT
		    age.*,
		    bio.nama as nama_pengguna,
		    lem.nama as nama_lembaga
		FROM
		    agenda age
		INNER JOIN biodata bio ON
		    age.id_biodata = bio.id
		INNER JOIN lembaga lem ON
		    bio.id_lembaga = lem.id
		    ORDER BY bio.nama ASC";
		$querySql = $this->db->query($sql);
		
		return $querySql->result_array();
	}
	
	public function cekId($id)
	{
		$sql = "SELECT * FROM agenda WHERE id='$id'";
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function cekNama($n, $id = '')
	{
		if ($id == '') {
			$sql = "SELECT * FROM agenda WHERE nama='$n'";
		} else {
			$sql = "SELECT * FROM agenda WHERE nama='$n' AND id!='$id'";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function cekNamaDiLembagaSama($n, $lembaga, $id = '')
	{
		if ($id == '') {
			$sql = "SELECT * FROM agenda WHERE nama='$n' AND id_lembaga='$lembaga'";
		} else {
			$sql = "SELECT * FROM agenda WHERE nama='$n' AND id_lembaga='$lembaga' AND id!='$id'";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function delete($nilai)
	{
		$sql = "SELECT * FROM agenda bio inner join agenda age on bio.id=age.id_biodata WHERE id!='$nilai'";
		$query = $this->db->query($sql);
		$hasil = $query->result_array();
		if (count($hasil) >= 1) {
			$this->session->set_flashdata('notifikasi', jsHandlerCustom('Maaf, data sudah digunakan di Agenda.', false));
			redirect('admin/biodata');
			exit();
		}
		
		$this->db->where('id', $nilai);
		$this->db->delete('biodata');
		return $this->db->affected_rows(); // 0 atau 1
	}
}
