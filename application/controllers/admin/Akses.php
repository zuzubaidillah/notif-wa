<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akses extends AN_Webadminpanel
{
	// metode yang pertama kali dijalankan
	
	public function __construct()
	{
		parent::__construct('thisFrmAkses');
	}
	
	public function index()
	{
		$data['head_title'] = "Akses";
		$data['body_label_content'] = "Akses";
		$data['rootss'] = base_url('admin/akses/');
		$data['dtTabel'] = $this->Makses->getDataKecualiLogin();
		
		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/users/readv');
		$this->load->view('footerv');
	}
	
	public function add()
	{
		$data['head_title'] = "Tambah Akses";
		$data['body_label_content'] = "Akses";
		$data['rootss'] = base_url('admin/akses/');
		
		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/users/addv');
		$this->load->view('footerv');
	}
	
	public function update($getId = "0")
	{
		$data['head_title'] = "Tambah Akses";
		$data['body_label_content'] = "Akses";
		$data['rootss'] = base_url('admin/akses/');
		
		// cek id user
		$cek = $this->Makses->cekId($getId);
		if ($getId == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','Maaf Id Tidak ditemukan','error')</script>");
			redirect('admin/akses');
			exit();
		}
		
		$data['id'] = $cek[0]['id'];
		$data['nama'] = $cek[0]['nama'];
		
		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/users/updatev');
		$this->load->view('footerv');
	}
	
	public function proses_add()
	{
		$n = htmlspecialchars($this->input->post('nama'), ENT_QUOTES);
		$p = htmlspecialchars($this->input->post('password'), ENT_QUOTES);
		
		// cek username tidak boleh sama
		$id = buat_id('', 'akses', 6);
		
		// eckripsi password
		$passwordEnkripsi = password_hash($p, PASSWORD_DEFAULT);
		$session_id_user = ambil_user();
		
		$dataSimpan = [
			"id" => $id,
			"nama" => $n,
			"password" => $passwordEnkripsi,
		];
		if ($this->Makses->add('super_admin', $dataSimpan)) {
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Berhasil','Tambah Data Berhasil disimpan','success')</script>");
			redirect('admin/akses');
			exit();
		}
		$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Gagal','Proses Lambat! Ulangi lagi','error')</script>");
		redirect('admin/akses/add');
		
	}
	
	public function proses_update()
	{
		$n = htmlspecialchars($this->input->post('nama'), ENT_QUOTES);
		$p = $this->input->post('password');
		$id = htmlspecialchars($this->input->post('username'), ENT_QUOTES);
		
		$dataSimpan = [
			"nama" => $n,
		];
		// eckripsi password
		if ($p != '') {
			$p = htmlspecialchars($this->input->post('password'), ENT_QUOTES);
			$passwordEnkripsi = password_hash($p, PASSWORD_DEFAULT);
			$dataSimpan['password'] = $passwordEnkripsi;
		}
		
		if ($this->Makses->update('super_admin', $dataSimpan,'id',$id)) {
			$this->session->set_flashdata('notifikasi', jsHandler('u'));
			redirect('admin/akses');
			exit();
		}
		$this->session->set_flashdata('notifikasi', jsHandler('u',false));
		redirect('admin/akses/update/' . $id);
	}
	
	public function proses_delete($getId = "0")
	{
		// cek id user
		$cek = $this->Makses->cekId($getId);
		if ($getId == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', jsHandlerIdKosong());
			redirect('admin/akses');
			exit();
		}
		
		if ($this->Makses->delete($getId)) {
			$this->session->set_flashdata('notifikasi', jsHandler('d'));
			redirect('admin/akses');
			exit();
		}
		
		$this->session->set_flashdata('notifikasi', jsHandler('d',false));
		redirect('admin/akses');
	}
}
