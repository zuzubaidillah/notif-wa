<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Biodata extends AN_Webadminpanel
{
	// metode yang pertama kali dijalankan
	
	public function __construct()
	{
		parent::__construct('thisFrmBiodata');
	}
	
	public function index()
	{
		$data['head_title'] = "Data Biodata";
		$data['body_label_content'] = "Data Biodata";
		$data['rootss'] = base_url('admin/biodata/');
		$data['dtTabel'] = $this->Mbiodata->getDataRelasi();
		
		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/biodata/readv');
		$this->load->view('footerv');
	}
	
	public function add()
	{
		$data['head_title'] = "Tambah Biodata";
		$data['body_label_content'] = "Biodata";
		$data['rootss'] = base_url('admin/biodata/');
		
		$data['passwordRequired'] = ($this->session->userdata('session_level') == 'petugas' ? "readonly" : "required");
		$data['passwordMessageSmall'] = ($this->session->userdata('session_level') == 'petugas' ? "Tidak untuk diisi, karena isi password hanya level super admin" : "Harus diisi, karena biodata ini bisa melakukan login di sistem ini");
		$data['dtLembaga'] = AN_Webadminpanel::getLembaga();
		$data['dtJabatan'] = AN_Webadminpanel::getJabatan();
		
		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/biodata/addv');
		$this->load->view('footerv');
	}
	
	public function update($getId = "0")
	{
		$data['head_title'] = "Update Biodata";
		$data['body_label_content'] = "Biodata";
		$data['rootss'] = base_url('admin/biodata/');
		
		// cek id user
		$cek = $this->Mbiodata->cekId($getId);
		if ($getId == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', jsHandlerIdKosong());
			redirect('admin/biodata');
			exit();
		}
		
		$data['passwordRequired'] = ($this->session->userdata('session_level') == 'petugas' ? "readonly" : "required");
		$data['passwordMessageSmall'] = ($this->session->userdata('session_level') == 'petugas' ? "Tidak untuk diisi, karena isi password hanya level super admin" : "Kosongi jika tidak ingin dirubah, jika diisi maka data ini bisa melakukan login");
		$data['dtLembaga'] = AN_Webadminpanel::getLembaga($cek[0]['id_lembaga']);
		$data['dtJabatan'] = AN_Webadminpanel::getJabatan($cek[0]['id_jabatan']);
		$data['id'] = $cek[0]['id'];
		$data['nam'] = $cek[0]['nama'];
		$data['nom'] = $cek[0]['no_telp'];
		$data['kel'] = $cek[0]['kelahiran'];
		
		$data['hLak'] = ($cek[0]['jenis_kelamin']=='Perempuan' ? '' : 'checked');
		$data['hPer'] = ($cek[0]['jenis_kelamin']=='Perempuan' ? 'checked' : '');
		
		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/biodata/updatev');
		$this->load->view('footerv');
	}
	
	public function detail($getId = "0")
	{
		$data['head_title'] = "Detail Biodata";
		$data['body_label_content'] = "Biodata";
		$data['rootss'] = base_url('admin/biodata/');
		
		// cek id user
		$cek = $this->Mbiodata->cekId($getId);
		if ($getId == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', jsHandlerIdKosong());
			redirect('admin/biodata');
			exit();
		}
		
		$data['dtLembaga'] = AN_Webadminpanel::getLembaga($cek[0]['id_lembaga']);
		$data['dtJabatan'] = AN_Webadminpanel::getJabatan($cek[0]['id_jabatan']);
		$data['id'] = $cek[0]['id'];
		$data['nam'] = $cek[0]['nama'];
		$data['nom'] = $cek[0]['no_telp'];
		$data['kel'] = $cek[0]['kelahiran'];
		
		$data['hLak'] = ($cek[0]['jenis_kelamin']=='Perempuan' ? '' : 'checked');
		$data['hPer'] = ($cek[0]['jenis_kelamin']=='Perempuan' ? 'checked' : '');
		
		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/biodata/detailv');
		$this->load->view('footerv');
	}
	
	public function proses_add()
	{
		$n = htmlspecialchars($this->input->post('n'),ENT_QUOTES);
		$jk = $this->input->post('jk');
		$kel = htmlspecialchars($this->input->post('kel'),ENT_QUOTES);
		$tgl = htmlspecialchars($this->input->post('tgl'),ENT_QUOTES);
		$nomor = format_number_wa(htmlspecialchars($this->input->post('nomor'),ENT_QUOTES));
		$lembaga = $this->input->post('lembaga');
		$jabatan = $this->input->post('jabatan');
		$p = htmlspecialchars($this->input->post('p'),ENT_QUOTES);
		
		// cek username tidak boleh sama
		$id = buat_id('BIO', 'biodata',4);
		
		// cek nama
		$cek = $this->Mbiodata->cekNamaDiLembagaSama($n, $lembaga);
		if (count($cek) == 1) {
			$this->session->set_flashdata('notifikasi', jsHandlerCustom("Maaf nama: $n sudah digunakan, pada Lembaga yang anda pilih.", false));
			redirect('admin/biodata');
			exit();
		}
		// eckripsi password
		$passwordEnkripsi = ($this->session->userdata('session_level') == 'petugas' ? "" : password_hash($p, PASSWORD_DEFAULT));
		
		$dataSimpan = [
			"id" => $id,
			"nama" => $n,
			"kelahiran" => $kel,
			"tgl_lahir" => $tgl,
			"jenis_kelamin" => $jk,
			"no_telp" => $nomor,
			"id_lembaga" => $lembaga,
			"id_jabatan" => $jabatan,
			"aktif" => 'aktif',
			"password" => $passwordEnkripsi,
		];
		if ($this->Makses->add('biodata', $dataSimpan)) {
			$this->session->set_flashdata('notifikasi', jsHandler('c'));
			redirect('admin/biodata');
			exit();
		}
		$this->session->set_flashdata('notifikasi', jsHandler('c', false));
		redirect('admin/lembaga/add');
		
	}
	
	public function proses_update($id='0')
	{
		$id = htmlspecialchars($id, ENT_QUOTES);
		$n = htmlspecialchars($this->input->post('n'),ENT_QUOTES);
		$jk = $this->input->post('jk');
		$kel = htmlspecialchars($this->input->post('kel'),ENT_QUOTES);
		$tgl = htmlspecialchars($this->input->post('tgl'),ENT_QUOTES);
		$nomor = format_number_wa(htmlspecialchars($this->input->post('nomor'),ENT_QUOTES));
		$lembaga = $this->input->post('lembaga');
		$jabatan = $this->input->post('jabatan');
		$p = $this->input->post('p');
		
		// cek nama lembaga
		$cek = $this->Mbiodata->cekNamaDiLembagaSama($n, $lembaga, $id);
		if (count($cek) >= 1) {
			$this->session->set_flashdata('notifikasi', jsHandlerCustom("Maaf Nama: $n Sudah digunakan. di Lembaga yang anda pilih", false));
			redirect('admin/biodata/update/' . $id);
			exit();
		}
		
		$dataSimpan = [
			"nama" => $n,
			"kelahiran" => $kel,
			"tgl_lahir" => $tgl,
			"jenis_kelamin" => $jk,
			"no_telp" => $nomor,
			"id_lembaga" => $lembaga,
			"id_jabatan" => $jabatan,
			"aktif" => 'aktif',
		];
		if ($p != '') {
			$p = htmlspecialchars($p, ENT_QUOTES);
			$passwordEnkripsi = password_hash($p, PASSWORD_DEFAULT);
			$dataSimpan['password'] = $passwordEnkripsi;
		}
		$h = $this->Makses->update('biodata', $dataSimpan, 'id', $id);
		if ($h) {
			$this->session->set_flashdata('notifikasi', jsHandler('u'));
			redirect('admin/biodata');
			exit();
		}
		$this->session->set_flashdata('notifikasi', jsHandler('u', false));
		redirect('admin/biodata/update/' . $id);
	}
	
	public function proses_delete($getId = "0")
	{
		// cek id user
		$cek = $this->Mbiodata->cekId($getId);
		if ($getId == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', jsHandlerIdKosong());
			redirect('admin/biodata');
			exit();
		}
		
		$h = $this->Mbiodata->delete($getId);
		if ($h) {
			$this->session->set_flashdata('notifikasi', jsHandler('d'));
			redirect('admin/biodata');
			exit();
		}
		die();
		
		$this->session->set_flashdata('notifikasi', jsHandler('d', false));
		redirect('admin/biodata');
	}
}
