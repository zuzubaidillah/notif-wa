<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mlembaga extends CI_Model
{
	public function getData($id = '')
	{
		$level = cek_level();
		$where = '';
		if ($level == 'petugas') {

			$idLembaga = $this->Mbiodata->cekId(ambil_user())[0]['id_lembaga'];
			$where = "WHERE id='$idLembaga'";
		}
		$sql = "SELECT * FROM lembaga $where ORDER BY nama ASC";
		$querySql = $this->db->query($sql);

		return $querySql->result_array();
	}

	public function cekId($id)
	{
		$sql = "SELECT * FROM lembaga WHERE id='$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function cekNama($n, $id = '')
	{
		if ($id == '') {
			$sql = "SELECT * FROM lembaga WHERE nama='$n'";
		} else {
			$sql = "SELECT * FROM lembaga WHERE nama='$n' AND id!='$id'";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function delete($nilai)
	{
		$sql = "SELECT * FROM lembaga lem inner join biodata bio on lem.id=bio.id_lembaga WHERE lem.id='$nilai'";
		$query = $this->db->query($sql);
		$hasil = $query->result_array();
		if (count($hasil) >= 1) {
			$this->session->set_flashdata('notifikasi', jsHandlerCustom('Maaf, data sudah digunakan di biodata', false));
			redirect('admin/lembaga');
			exit();
		}

		$this->db->where('id', $nilai);
		$this->db->delete('lembaga');
		return $this->db->affected_rows(); // 0 atau 1
	}
}
