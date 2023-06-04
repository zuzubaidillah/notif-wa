<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

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
		if (cek_level() == 'petugas') {
			$data['labelLembaga'] = $this->Mbiodata->getDataRelasiSesuaiIdBiodata($this->session->userdata('session_id'))[0]['nama_lembaga'];
		}
		$resAgenda = $this->Magenda->hitungAgenda();
		$men = $resAgenda[0]['menunggu'];
		$sel = $resAgenda[0]['selesai'];
		$tot = $men + $sel;
		$data['jsHitungAgendaMenunggu'] = $men;
		$data['jsHitungAgendaSelesai'] = $sel;
		$data['jsHitungAgendaAll'] = $tot;

		$this->load->view('headerv', $data);
		$this->load->view('admin/menuv');
		$this->load->view('admin/dashboardv');
		$this->load->view('footerv');
	}
}
