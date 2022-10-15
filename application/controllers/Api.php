<?php
defined('BASEPATH') or exit('No direct script access allowed');

header('Content-Type: Application/json');

class Api extends CI_Controller
{
	public function index()
	{
		$res = res_custom('', '', '', 500);
		http_response_code($res['code']);
		echo json_encode($res);
		exit();
	}
	
	public function cekAgenda()
	{
		$tgl = datetime_sendiri();
		$cek = $this->Magenda->cekAgenda($tgl);
		if (count($cek) == 0) {
			$res = res_error(null, 'Berhasil', 'Tidak Ditemukan Agenda');
			http_response_code($res['code']);
			echo json_encode($res);
			exit();
		}
		$row = [];
		foreach ($cek as $l) {
			$tgl = tgl_indo($l['waktu']);
			$jam = format_time($l['waktu']);
			$pesan = <<<PESAN
Pengingat

Nama: *$l[nama_pengguna]*
Dari: *$l[dari]*
Tanggal: *$tgl*
Jam: *$jam*
keterangan: $l[deskripsi]

Pesan ini tidak perlu dibalas, otomatis oleh sistem
PESAN;
			
			$data = [
				"pesan" => $pesan,
				"nomor" => $l['nomor_wa'],
			];
			$resApi = format_api("http://103.163.226.154:8001/kirimpesan", $data, 'POST');
			$row[] = $resApi[1];
			if ($resApi[1] == 200) {
				$update = [
					"notif_ke" => 1
				];
				$this->Makses->update('agenda', $update, 'id', $l['id']);
			}
		}
		$res = res_success([$cek, $tgl, $row], '', '');
		http_response_code($res['code']);
		echo json_encode($res);
		exit();
	}
	
	private function kirimWa()
	{
		return true;
	}
}
