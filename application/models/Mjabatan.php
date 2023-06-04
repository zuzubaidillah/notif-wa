<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mjabatan extends CI_Model
{
	public function getData($id = '')
	{
		$sql = "SELECT * FROM jabatan ORDER BY nama ASC";
		$querySql = $this->db->query($sql);

		return $querySql->result_array();
	}

	public function cekId($id)
	{
		$sql = "SELECT * FROM jabatan WHERE id='$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function cekNama($n, $id = '')
	{
		if ($id == '') {
			$sql = "SELECT * FROM jabatan WHERE nama='$n'";
		} else {
			$sql = "SELECT * FROM jabatan WHERE nama='$n' AND id!='$id'";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function delete($nilai)
	{
		$sql = "SELECT * FROM jabatan jab inner join biodata bio on jab.id=bio.id_jabatan WHERE jab.id='$nilai'";
		$query = $this->db->query($sql);
		$hasil = $query->result_array();
		if (count($hasil) >= 1) {
			$this->session->set_flashdata('notifikasi', jsHandlerCustom('Maaf, data sudah digunakan di biodata', false));
			redirect('admin/jabatan');
			exit();
		}

		$this->db->where('id', $nilai);
		$this->db->delete('jabatan');
		return $this->db->affected_rows(); // 0 atau 1
	}
}
