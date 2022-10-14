<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends AN_Webadminpanel
{
	// metode yang pertama kali dijalankan
	public function __construct()
	{
		parent::__construct('thisFrmDashboard');
	}

	public function index()
	{
		$data['head_title'] = "Dashboard";
		$data['body_label_content'] = "Dashboard";

		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/dashboardv');
		$this->load->view('footerv');
	}
}
