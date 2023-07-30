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

    public function getDataRelasi($id = '', $filter = [])
    {
        $level = $this->session->userdata('session_level');
        $where = "";
        if ($level == 'petugas') {
            $idBiodata = $this->session->userdata('session_id');
            $idLembaga = $this->Mbiodata->cekId($idBiodata)[0]['id_lembaga'];
            $where = "AND bio.id_lembaga='$idLembaga'";
        }
        if ($id != '') {
            $where = "AND age.id='$id'";
        }
        if (isset($filter['awal']) && isset($filter['akhir'])) {
            $where = "AND (age.waktu BETWEEN '$filter[awal]' AND '$filter[akhir]')";
        }
        $tgl = datetime_sendiri();
        $sql = "SELECT
		    age.*,
		    bio.nama as nama_pengguna,
		    bio.no_telp as nomor_wa,
		    lem.nama as nama_lembaga,
		    (
		        TIMESTAMPDIFF(
		            HOUR,
		            '$tgl',
		            age.waktu
		        )
		    ) as status
		FROM
		    agenda age
		INNER JOIN biodata bio ON
		    age.id_biodata = bio.id
		INNER JOIN lembaga lem ON
		    bio.id_lembaga = lem.id $where
		    ORDER BY age.waktu DESC,bio.nama ASC";
        $querySql = $this->db->query($sql);

        return $querySql->result_array();
    }

    public function hitungAgenda()
    {
        $level = $this->session->userdata('session_level');
        $dateTime = datetime_sendiri();
        if ($level == 'petugas') {
            $idBiodata = $this->session->userdata('session_id');
            $idLembaga = $this->Mbiodata->cekId($idBiodata)[0]['id_lembaga'];
            $where = "INNER JOIN biodata bio ON age.id_biodata=bio.id WHERE bio.id_lembaga='$idLembaga' AND age.waktu >= '$dateTime'";
            $whereSelesai = "INNER JOIN biodata bio ON age.id_biodata=bio.id WHERE bio.id_lembaga='$idLembaga' AND age.waktu <= '$dateTime'";
        } else {
            $where = "WHERE age.waktu >= '$dateTime'";
            $whereSelesai = "WHERE age.waktu <= '$dateTime'";
        }
        $sql = "SELECT
		    (
		    SELECT
		        COUNT(age.id) AS menunggu
		    FROM
		        agenda age $where
		) AS menunggu,
		(
		    SELECT
		        COUNT(age.id) AS selsai
		    FROM
		        agenda age $whereSelesai
		) AS selesai;";
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

    public function cekAgenda($tgl)
    {
        // $tgl = datetime_sendiri();
        $sql = "SELECT
		    age.*,
		    bio.nama AS nama_pengguna,
		    bio.no_telp AS nomor_wa,
		    lem.nama AS nama_lembaga,
		    (
		        TIMESTAMPDIFF(
		            HOUR,
		            '$tgl',
		            age.waktu
		        )
		    ) as status
		FROM
		    agenda age
		INNER JOIN biodata bio ON
		    age.id_biodata = bio.id
		INNER JOIN lembaga lem ON
		    bio.id_lembaga = lem.id
		WHERE
		    age.waktu >= '$tgl' AND (
		        TIMESTAMPDIFF(
		            HOUR,
		            '$tgl',
		            age.waktu
		        )
		    ) <= age.menit_sebelum_notif AND age.notif_ke = '0'
		ORDER BY
		    `age`.`id_biodata` ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function delete($nilai)
    {
        $this->db->where('id', $nilai);
        $this->db->delete('agenda');
        return $this->db->affected_rows(); // 0 atau 1
    }

    public function cekAgendaBelumSelesai()
    {
        $tgl = datetime_sendiri();
        $sql = "SELECT
		    age.*,
		    bio.nama AS nama_pengguna,
		    bio.no_telp AS nomor_wa,
		    lem.nama AS nama_lembaga,
		    (
		        TIMESTAMPDIFF(
		            HOUR,
		            '$tgl',
		            age.waktu
		        )
		    ) as status
		FROM
		    agenda age
		INNER JOIN biodata bio ON
		    age.id_biodata = bio.id
		INNER JOIN lembaga lem ON
		    bio.id_lembaga = lem.id
		WHERE
		    age.waktu >= '$tgl' AND (
		        TIMESTAMPDIFF(
		            HOUR,
		            '$tgl',
		            age.waktu
		        )
		    ) <= 240
		ORDER BY
		    `age`.`id_biodata` ASC limit 50;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
