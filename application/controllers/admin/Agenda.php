<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agenda extends AN_Webadminpanel
{
	// metode yang pertama kali dijalankan

	public function __construct()
	{
		parent::__construct('thisFrmAgenda');
	}

	public function index()
	{
		$data['head_title'] = "Data Agenda";
		$data['body_label_content'] = "Data Agenda";
		$data['rootss'] = base_url('admin/agenda/');
		$data['dtTabel'] = $this->Magenda->getDataRelasi();

		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/agenda/readv');
		$this->load->view('footerv');
	}

	public function add()
	{
		$data['head_title'] = "Tambah Agenda";
		$data['body_label_content'] = "Jabatan";
		$data['rootss'] = base_url('admin/agenda/');

		$id_lembaga = '';
		if ($this->session->userdata('session_level') == 'petugas') {
			$id_lembaga = $this->Mbiodata->cekId(ambil_user())[0]['id_lembaga'];
			$data['dtBiodata'] = AN_Webadminpanel::getBiodata($id_lembaga, 'select');
		}
		$data['dtLembaga'] = AN_Webadminpanel::getLembaga($id_lembaga);

		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/agenda/addv');
		$this->load->view('footerv');
	}

	public function update($getId = "0")
	{
		$data['head_title'] = "Update Agenda";
		$data['body_label_content'] = "Agenda";
		$data['rootss'] = base_url('admin/agenda/');

		// cek id user
		$cek = $this->Magenda->cekId($getId);
		if ($getId == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', jsHandlerIdKosong());
			redirect('admin/agenda');
			exit();
		}

		$id_lembaga = '';
		if ($this->session->userdata('session_level') == 'petugas') {
			$id_lembaga = $this->Mbiodata->cekId(ambil_user())[0]['id_lembaga'];
		} else {
			$id_lembaga = $this->Mbiodata->cekId($cek[0]['id_biodata'])[0]['id_lembaga'];
		}
		$data['dtBiodata'] = AN_Webadminpanel::getBiodata($id_lembaga, 'select', $cek[0]['id_biodata']);

		$data['dtLembaga'] = AN_Webadminpanel::getLembaga($id_lembaga);
		$data['id'] = $cek[0]['id'];
		$data['dari'] = $cek[0]['dari'];
		$data['deskripsi'] = $cek[0]['deskripsi'];
		$data['waktu'] = date("Y-m-d", strtotime($cek[0]['waktu']));
		$data['jam'] = date("H:i", strtotime($cek[0]['waktu']));
		$data['durasi'] = $cek[0]['menit_sebelum_notif'];
		$data['notifKe'] = $cek[0]['notif_ke'];
		$data['id_biodata'] = $cek[0]['id_biodata'];

		$data['hPu'] = ($cek[0]['jenis_agenda'] == 'private' ? '' : 'checked');
		$data['hPr'] = ($cek[0]['jenis_agenda'] == 'private' ? 'checked' : '');

		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/agenda/updatev');
		$this->load->view('footerv');
	}

	public function proses_add()
	{
		$lembaga = htmlspecialchars($this->input->post('lembaga'), ENT_QUOTES);
		$biodata = htmlspecialchars($this->input->post('biodata'), ENT_QUOTES);
		$dari = htmlspecialchars($this->input->post('dari'), ENT_QUOTES);
		$jenis = htmlspecialchars($this->input->post('jenis'), ENT_QUOTES);
		$tgl = htmlspecialchars($this->input->post('tgl'), ENT_QUOTES);
		$durasi = htmlspecialchars($this->input->post('durasi'), ENT_QUOTES);
		$keterangan = htmlspecialchars($this->input->post('keterangan'), ENT_QUOTES);
		$jam = htmlspecialchars($this->input->post('jam'), ENT_QUOTES);

		// cek username tidak boleh sama
		$id = buat_id('AGE', 'agenda');

		$dataSimpan = [
			"id" => $id,
			"id_biodata" => $biodata,
			"dari" => $dari,
			"jenis_agenda" => $jenis,
			"waktu" => $tgl . " " . $jam,
			"menit_sebelum_notif" => $durasi,
			"deskripsi" => $keterangan,
			"notif_ke" => 0,
		];
		if ($this->Makses->add('agenda', $dataSimpan)) {
			$this->session->set_flashdata('notifikasi', jsHandler('c'));
			redirect('admin/agenda');
			exit();
		}
		$this->session->set_flashdata('notifikasi', jsHandler('c', false));
		redirect('admin/agenda/add');
	}

	public function proses_update($id = '0')
	{
		$id = $id;
		$biodata = htmlspecialchars($this->input->post('biodata'), ENT_QUOTES);
		$dari = htmlspecialchars($this->input->post('dari'), ENT_QUOTES);
		$jenis = htmlspecialchars($this->input->post('jenis'), ENT_QUOTES);
		$tgl = htmlspecialchars($this->input->post('tgl'), ENT_QUOTES);
		$durasi = htmlspecialchars($this->input->post('durasi'), ENT_QUOTES);
		$keterangan = htmlspecialchars($this->input->post('keterangan'), ENT_QUOTES);
		$jam = htmlspecialchars($this->input->post('jam'), ENT_QUOTES);

		$cekIdAgenda = $this->Magenda->cekId($id);
		if (count($cekIdAgenda) == 0) {
			$this->session->set_flashdata('notifikasi', jsHandlerIdKosong());
			redirect('admin/agenda');
			exit();
		}

		$dataSimpan = [
			"id_biodata" => $biodata,
			"dari" => $dari,
			"jenis_agenda" => $jenis,
			"waktu" => $tgl . " " . $jam,
			"menit_sebelum_notif" => $durasi,
			"deskripsi" => $keterangan,
		];
		$h = $this->Makses->update('agenda', $dataSimpan, 'id', $id);
		if ($h) {
			$this->session->set_flashdata('notifikasi', jsHandler('u'));
			redirect('admin/agenda');
			exit();
		}
		$this->session->set_flashdata('notifikasi', jsHandler('u', false));
		redirect('admin/agenda/update/' . $id);
	}

	public function proses_delete($getId = "0")
	{
		// cek id user
		$cek = $this->Magenda->cekId($getId);
		if ($getId == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', jsHandlerIdKosong());
			redirect('admin/agenda');
			exit();
		}

		$h = $this->Magenda->delete($getId);
		if ($h) {
			$this->session->set_flashdata('notifikasi', jsHandler('d'));
			redirect('admin/agenda');
			exit();
		}

		$this->session->set_flashdata('notifikasi', jsHandler('d', false));
		redirect('admin/agenda');
	}

	public function biodata_filter()
	{
		$idLembaga = $this->input->post('lembaga');
		$cek = $this->Mlembaga->cekId($idLembaga);
		if (count($cek) == 0) {
			$res = res_error(null, 'gagal', 'id tidak ditemukan');
			http_response_code($res['code']);
			exit();
		}
		$hasilBiodata = AN_Webadminpanel::getBiodata($idLembaga, 'select');
		$res = res_success($hasilBiodata, 'berhasil', 'ditemukan');
		http_response_code($res['code']);
		echo json_encode($res);
	}
}
