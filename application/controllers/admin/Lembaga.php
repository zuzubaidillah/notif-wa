<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Lembaga extends AN_Webadminpanel
{
	// metode yang pertama kali dijalankan

	public function __construct()
	{
		parent::__construct('thisFrmLembaga');
	}

	public function index()
	{
		$data['head_title'] = "Data Lembaga";
		$data['body_label_content'] = "Data Lembaga";
		$data['rootss'] = base_url('admin/lembaga/');
		$data['dtTabel'] = $this->Mlembaga->getData();

		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/lembaga/readv');
		$this->load->view('footerv');
	}

	public function add()
	{
		$data['head_title'] = "Tambah Lembaga";
		$data['body_label_content'] = "Lembaga";
		$data['rootss'] = base_url('admin/lembaga/');

		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/lembaga/addv');
		$this->load->view('footerv');
	}

	public function update($getId = "0")
	{
		$data['head_title'] = "Tambah Lembaga";
		$data['body_label_content'] = "Lembaga";
		$data['rootss'] = base_url('admin/lembaga/');

		// cek id user
		$cek = $this->Mlembaga->cekId($getId);
		if ($getId == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', jsHandlerIdKosong());
			redirect('admin/lembaga');
			exit();
		}

		$data['id'] = $cek[0]['id'];
		$data['nama'] = $cek[0]['nama'];

		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/lembaga/updatev');
		$this->load->view('footerv');
	}

	public function proses_add()
	{
		$n = htmlspecialchars($this->input->post('n'), ENT_QUOTES);

		// cek username tidak boleh sama
		$id = buat_id('', 'lembaga', 5);

		// cek nama
		$cek = $this->Mlembaga->cekNama($n);
		if (count($cek) == 1) {
			$this->session->set_flashdata('notifikasi', jsHandlerCustom("Maaf nama: $n sudah digunakan.", false));
			redirect('admin/lembaga');
			exit();
		}

		$dataSimpan = [
			"id" => $id,
			"nama" => $n,
		];
		if ($this->Makses->add('lembaga', $dataSimpan)) {
			$this->session->set_flashdata('notifikasi', jsHandler('c'));
			redirect('admin/lembaga');
			exit();
		}
		$this->session->set_flashdata('notifikasi', jsHandler('c', false));
		redirect('admin/lembaga/add');

	}

	public function proses_update()
	{
		$id = htmlspecialchars($this->input->post('id'), ENT_QUOTES);
		$n = htmlspecialchars($this->input->post('n'), ENT_QUOTES);

		// cek nama lembaga
		$cek = $this->Mlembaga->cekNama($n, $id);
		if (count($cek) >= 1) {
			$this->session->set_flashdata('notifikasi', jsHandlerCustom("Maaf Nama: $n Sudah digunakan", false));
			redirect('admin/lembaga/update/' . $id);
			exit();
		}

		$dataSimpan = [
			"nama" => $n,
		];

		if ($this->Makses->update('lembaga', $dataSimpan, 'id', $id)) {
			$this->session->set_flashdata('notifikasi', jsHandler('u'));
			redirect('admin/lembaga');
			exit();
		}
		$this->session->set_flashdata('notifikasi', jsHandler('u', false));
		redirect('admin/lembaga/update/' . $id);
	}

	public function proses_delete($getId = "0")
	{
		// cek id user
		$cek = $this->Mlembaga->cekId($getId);
		if ($getId == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', jsHandlerIdKosong());
			redirect('admin/lembaga');
			exit();
		}

		if ($this->Mlembaga->delete($getId)) {
			$this->session->set_flashdata('notifikasi', jsHandler('d'));
			redirect('admin/lembaga');
			exit();
		}

		$this->session->set_flashdata('notifikasi', jsHandler('d', false));
		redirect('admin/lembaga');
	}
}
