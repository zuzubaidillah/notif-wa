<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	// metode yang pertama kali dijalankan
	public function __construct()
	{
		parent::__construct();
		// maka session harus dijalankan, apabila ada session maka dia dilarang untuk login.
		if ($this->session->userdata('session_id') != null) {
			// $this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','Kamu sudah login','info')</script>");
			redirect('admin/dashboard');
			exit();
		}
	}
	
	public function index()
	{
		// cek tabel user
		$cek = $this->Makses->getData();
		if (count($cek) == 0) {
			redirect('admin/login/registrasi');
		}
		$data['head_title'] = "Login";
		$data['body_label_content'] = "Login";
		
		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/loginv');
		$this->load->view('footerv');
	}
	
	public function registrasi()
	{
		// cek tabel user
		// $cek = $this->Makses->getData();
		// if (count($cek) >= 1) {
		// 	redirect('admin/login');
		// }
		
		$data['head_title'] = "Registrasi";
		$data['body_label_content'] = $data['head_title'];
		
		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/registrasiv');
		$this->load->view('footerv');
	}
	
	public function proses_registrasi()
	{
		// mengambil nilai yang dikirim
		$u = htmlspecialchars($this->input->post('username'), ENT_QUOTES);
		$p = htmlspecialchars($this->input->post('password'), ENT_QUOTES);
		$nd = htmlspecialchars($this->input->post('nama'), ENT_QUOTES);
		$passwordEncript = password_hash($p, PASSWORD_DEFAULT);
		$id = mt_rand(100000, 999999);
		
		// data disimpan
		$dtSimpan = [
			"id" => $id,
			"nama" => $nd,
			"password" => $passwordEncript,
		];
		if ($this->Makses->add('super_admin', $dtSimpan)) {
			http_response_code(200);
			echo json_encode(res_success([
				"username" => $id,
				"nama" => $nd,
				"level" => "super admin",
			], 'Berhasil', 'Registrasi Berhasil'));
			exit();
		}
		http_response_code(400);
	}
	
	public function proses_login()
	{
		// menerima inputan dari bagian view
		$idAkses = htmlspecialchars($this->input->post('u'), ENT_QUOTES);
		$p = htmlspecialchars($this->input->post('p'), ENT_QUOTES);
		
		// cek username
		$cekUser = $this->Makses->cekUsername($idAkses);
		
		// percabangan, 
		if (count($cekUser) == 0) {
			$res = res_error('', 'Gagal', 'Username salah!');
			http_response_code($res['code']);
			echo json_encode($res);
			exit();
		}
		
		if (password_verify($p, $cekUser[0]['password'])) {
			if ($cekUser[0]['level'] == 'petugas') {
				$cekAktif = $this->Mbiodata->cekAktif($cekUser[0]['id']);
				if (count($cekAktif) == 0) {
					$res = res_success('', 'Pemberitahuan', 'Akun anda tidak aktif');
					http_response_code($res['code']);
					echo json_encode($res);
					exit();
				}
			}
			$ses = [
				"session_id" => $cekUser[0]['id'],
				"session_namafull" => $cekUser[0]['nama'],
				"session_level" => $cekUser[0]['level']
			];
			$this->session->set_userdata($ses);
			
			$res = res_success('', 'Berhasil', 'Proses Validasi Sesuai');
			http_response_code($res['code']);
			echo json_encode($res);
			exit();
		} else {
			$res = res_error('', 'Gagal', 'Password salah!');
			http_response_code($res['code']);
			echo json_encode($res);
			exit();
		}
	}
}
