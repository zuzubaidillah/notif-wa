<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mbiodata extends CI_Model
{
	public function getData($idLembaga='')
	{
		$sql = "SELECT * FROM biodata $where ORDER BY nama ASC";
		$querySql = $this->db->query($sql);
		
		return $querySql->result_array();
	}
	
	public function getDataRelasi($idLembaga='')
	{
		$level = cek_level();
		$where = '';
		if ($idLembaga!=''){
			$where = "WHERE id_lembaga='$idLembaga'";
		}else{
			if ($level=='petugas'){
				$idLembaga = $this->Mbiodata->cekId(ambil_user())[0]['id_lembaga'];
				$where = "WHERE bio.id_lembaga='$idLembaga'";
			}
		}
		$sql = "SELECT
		    bio.*,
		    lem.nama as nama_lembaga,
		    jbt.nama as nama_jabatan
		FROM
		    biodata bio
		INNER JOIN jabatan jbt ON
		    bio.id_jabatan = jbt.id
		INNER JOIN lembaga lem ON
		    bio.id_lembaga = lem.id $where
		    ORDER BY bio.nama ASC, jbt.nama ASC, lem.nama ASC;";
		$querySql = $this->db->query($sql);
		
		return $querySql->result_array();
	}
	
	public function cekId($id)
	{
		$sql = "SELECT * FROM biodata WHERE id='$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function cekAktif($id)
	{
		$sql = "SELECT aktif FROM biodata WHERE id='$id' AND aktif='aktif'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function cekNama($n, $id = '')
	{
		if ($id == '') {
			$sql = "SELECT * FROM biodata WHERE nama='$n'";
		} else {
			$sql = "SELECT * FROM biodata WHERE nama='$n' AND id!='$id'";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function cekNamaDiLembagaSama($n, $lembaga, $id = '')
	{
		if ($id == '') {
			$sql = "SELECT * FROM biodata WHERE nama='$n' AND id_lembaga='$lembaga'";
		} else {
			$sql = "SELECT * FROM biodata WHERE nama='$n' AND id_lembaga='$lembaga' AND id!='$id'";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function delete($nilai)
	{
		$sql = "SELECT * FROM biodata bio inner join agenda age on bio.id=age.id_biodata WHERE id!='$nilai'";
		$query = $this->db->query($sql);
		$hasil = $query->result_array();
		if (count($hasil)>=1){
			$this->session->set_flashdata('notifikasi', jsHandlerCustom('Maaf, data sudah digunakan di Agenda.',false));
			redirect('admin/biodata');
			exit();
		}
		
		$this->db->where('id', $nilai);
		$this->db->delete('biodata');
		return $this->db->affected_rows(); // 0 atau 1
	}
}
