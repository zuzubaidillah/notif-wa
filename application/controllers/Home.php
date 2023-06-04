<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Home extends CI_Controller
{
	public function index()
	{
		redirect('admin/login');
		$data['head_title'] = "Home";

		$this->load->view('headerv', $data);
		$this->load->view('public/menuv');
		$this->load->view('public/homev');
		$this->load->view('footerv');
	}
}
