<?php
defined('BASEPATH') or exit('No direct script access allowed');

header('Content-Type: Application/json');
date_default_timezone_set("Asia/Jakarta");

class Api extends CI_Controller
{
	public function index()
	{
		$res = res_custom('', '', '', 500, "");
		http_response_code($res['code']);
		echo json_encode($res);
		exit();
	}

	public function cekAgenda($getId = '')
	{
		if ($getId == '') {
			$tgl = datetime_sendiri();
			$cek = $this->Magenda->cekAgenda($tgl);
		} else {
			$cek = $this->Magenda->getDataRelasi($getId);
		}
		if (count($cek) == 0) {
			$res = res_error(null, 'Berhasil', 'Tidak Ditemukan Agenda');
			http_response_code($res['code']);
			echo json_encode($res);
			exit();
		}
		$row = [];
		foreach ($cek as $l) {
			if ($l['status'] < 0) {
				if ($getId == '') {
					$row[] = 409;
					continue;
				} else {
					$this->session->set_flashdata('notifikasi', jsHandlerCustom('Maaf Agenda Sudah Selesai.', false));
					redirect('admin/agenda/update/' . $getId);
					exit();
				}
			}
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
				"target" => $l['nomor_wa'],
			];
			$resApi = format_api("", $data, 'POST');
			$row[0] = $resApi[0];
			$row[1] = $resApi[1];
			if ($resApi[1] == 200) {
				// if ($getId == '') {
				// } else {
				// 	$jml = 0;
				// }
				$jml = $l['notif_ke'] + 1;
				$update = [
					"notif_ke" => $jml
				];
				$this->Makses->update('agenda', $update, 'id', $l['id']);
			}
		}
		if ($getId == '') {
			$res = res_success([$cek, $tgl, $row], '', '');
			http_response_code($res['code']);
			echo json_encode($res);
			exit();
		} else {
			return $resApi[1];
		}
	}

	public function kirimwaidagenda($id = '0')
	{
		if ($id == '0') {
			$this->session->set_flashdata('notifikasi', jsHandlerIdKosong());
			redirect('admin/agenda');
			exit();
		}
		$has = $this->cekAgenda($id);
		if ($has == 200) {
			$this->session->set_flashdata('notifikasi', jsHandlerCustom('Berhasil Terkirim', true));
			redirect('admin/agenda/update/' . $id);
			exit();
		} else {
			$this->session->set_flashdata('notifikasi', jsHandler('u', false));
			redirect('admin/agenda/update/' . $id);
			exit();
		}
	}
}
