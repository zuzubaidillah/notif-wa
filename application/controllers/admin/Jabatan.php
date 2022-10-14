<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends AN_Webadminpanel
{
	// metode yang pertama kali dijalankan
	public $thisForm = 'thisFrmJabatan';
	
	public function __construct()
	{
		parent::__construct($this->thisForm);
	}
	
	public function index()
	{
		AN_Webadminpanel::cekHakakses($this->thisForm,'read','admin/dashboard');
		$data['head_title'] = "Data Jabatan";
		$data['body_label_content'] = "Data Jabatan";
		$data['rootss'] = base_url('admin/jabatan/');
		$data['dtTabel'] = $this->Mjabatan->getData();
		
		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/jabatan/readv');
		$this->load->view('footerv');
	}
	
	public function add()
	{
		AN_Webadminpanel::cekHakakses($this->thisForm,'create','admin/jabatan');
		$data['head_title'] = "Tambah Jabatan";
		$data['body_label_content'] = "Jabatan";
		$data['rootss'] = base_url('admin/jabatan/');
		
		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/jabatan/addv');
		$this->load->view('footerv');
	}
	
	public function update($getId = "0")
	{
		AN_Webadminpanel::cekHakakses($this->thisForm,'update','admin/jabatan');
		$data['head_title'] = "Tambah Jabatan";
		$data['body_label_content'] = "Jabatan";
		$data['rootss'] = base_url('admin/jabatan/');
		
		// cek id user
		$cek = $this->Mjabatan->cekId($getId);
		if ($getId == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', jsHandlerIdKosong());
			redirect('admin/jabatan');
			exit();
		}
		
		$data['id'] = $cek[0]['id'];
		$data['nama'] = $cek[0]['nama'];
		
		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/jabatan/updatev');
		$this->load->view('footerv');
	}
	
	public function proses_add()
	{
		AN_Webadminpanel::cekHakakses($this->thisForm,'delete','admin/jabatan');
		
		$n = htmlspecialchars($this->input->post('n'), ENT_QUOTES);
		
		// cek username tidak boleh sama
		$id = buat_id('', 'jabatan', 5);
		
		// cek nama
		$cek = $this->Mjabatan->cekNama($n);
		if (count($cek) == 1) {
			$this->session->set_flashdata('notifikasi', jsHandlerCustom("Maaf nama: $n sudah digunakan.",false));
			redirect('admin/jabatan');
			exit();
		}
		
		$dataSimpan = [
			"id" => $id,
			"nama" => $n,
		];
		if ($this->Makses->add('jabatan', $dataSimpan)) {
			$this->session->set_flashdata('notifikasi', jsHandler('c'));
			redirect('admin/jabatan');
			exit();
		}
		$this->session->set_flashdata('notifikasi', jsHandler('c',false));
		redirect('admin/jabatan/add');
	}
	
	public function proses_update()
	{
		AN_Webadminpanel::cekHakakses($this->thisForm,'update','admin/jabatan');
		
		$id = htmlspecialchars($this->input->post('id'), ENT_QUOTES);
		$n = htmlspecialchars($this->input->post('n'), ENT_QUOTES);
		
		// cek nama lembaga
		$cek = $this->Mjabatan->cekNama($n, $id);
		if (count($cek)>=1){
			$this->session->set_flashdata('notifikasi', jsHandlerCustom("Maaf Nama: $n Sudah digunakan", false));
			redirect('admin/jabatan/update/'.$id);
			exit();
		}
		
		$dataSimpan = [
			"nama" => $n,
		];
		
		if ($this->Makses->update('jabatan', $dataSimpan,'id',$id)) {
			$this->session->set_flashdata('notifikasi', jsHandler('u'));
			redirect('admin/jabatan');
			exit();
		}
		$this->session->set_flashdata('notifikasi', jsHandler('u',false));
		redirect('admin/jabatan/update/' . $id);
	}
	
	public function proses_delete($getId = "0")
	{
		AN_Webadminpanel::cekHakakses($this->thisForm,'delete','admin/jabatan');
		
		// cek id user
		$cek = $this->Mjabatan->cekId($getId);
		if ($getId == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', jsHandlerIdKosong());
			redirect('admin/jabatan');
			exit();
		}
		
		if ($this->Mjabatan->delete($getId)) {
			$this->session->set_flashdata('notifikasi', jsHandler('d'));
			redirect('admin/jabatan');
			exit();
		}
		
		$this->session->set_flashdata('notifikasi', jsHandler('d',false));
		redirect('admin/jabatan');
	}
}
