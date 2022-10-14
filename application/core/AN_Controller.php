<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AN_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
}

class AN_Public extends CI_Controller
{
	public $menuUjian = 1;
	
	function __construct()
	{
		parent::__construct();
		$data['meta_logo'] = get_pengaturan('meta_logo', '007');
	}
	
	function meta_public()
	{
		return [1, 2, 3, 4, 5];
	}
}

class AN_Webadminpanel extends CI_Controller
{
	public $dataLabel;
	public $aksesc = array();
	public $log_form = 'log_history';
	
	function __construct($idformini = "dashboard")
	{
		parent::__construct();
		$this->dataLabel = [
			"admin-panel" => [
				"footerKiri" => "Sistem Informasi Simpan Kegiatan",
				"footerKiriLink" => "#",
				"footerKanan" => "",
				"footerKananBy" => "Skripsi UNIPDU",
				"footerKananTahun" => "2022",
				"headeLogo" => "",
			],
			"public" => [],
		];
		
		$aksesPetugas = ['thisFrmDashboard', 'thisFrmJabatan', 'thisFrmAgenda', 'thisFrmBiodata'];
		$aksesSuperdmin = ['dashboard', 'thisFrmBiodata', 'thisFrmLembaga', 'thisFrmJabatan', 'thisFrmDashboard', 'thisFrmAkses', 'thisFrmAgenda'];
		
		$sessionId = $this->session->userdata('session_id');
		if ($sessionId == null) {
			redirect('admin/logout');
			exit();
		}
		
		$sessionLevel = $this->session->userdata('session_level');
		if ($sessionLevel == 'petugas') {
			if (!in_array($idformini, $aksesPetugas)) {
				redirect('admin/dashboard');
				exit();
			}
		}
		$this->cekIdAkses($sessionId);
		$data['labels'] = $this->dataLabel;
		$this->load->view('headerv', $data, true);
	}
	
	public function cekHakakses($thisFrm,$jenis, $url='admin/dashboard')
	{
		$dtHakakses = [
			"petugas" => [
				"thisFrmJabatan" => [
					"create" => 1,
					"read" => 1,
					"update" => 0,
					"delete" => 0,
					"print" => 1,
					"public" => 0,
				],
			],
		];
		$level = $this->session->userdata('session_level');
		if (!$dtHakakses[$level][$thisFrm][$jenis]){
			$this->session->set_flashdata('notifikasi', jsHandlerCustom("Anda tidak memiliki akses $jenis data $thisFrm", false));
			redirect($url);
			exit();
		}
	}
	
	private function cekIdAkses($id)
	{
		$sql = "SELECT * FROM akses WHERE id='$id'";
		$cek = cektabelsql($sql);
		if (!$cek) {
			session_destroy();
			if ($this->input->get('__') !== null) {
				handlerFilter("Autentikasi Gagal. Login Ulang ya....", 'custom', 'json');
			} else {
				redirect('admin/login');
				exit();
			}
		}
		return true;
	}
	
	public function getLembaga($id = '')
	{
		$dtLembaga = $this->Mlembaga->getData($id);
		
		$hLembaga = "";
		foreach ($dtLembaga as $l) {
			$chec = '';
			if ($id == $l['id']) {
				$chec = 'selected';
			}
			$hLembaga .= "<option $chec value=\"" . $l['id'] . "\">" . $l['nama'] . "</option>";
		}
		return $hLembaga;
	}
	
	public function getBiodata($idLembaga = '', $jenis='', $idBiodata='')
	{
		$dtTabel = $this->Mbiodata->getDataRelasi($idLembaga);
		
		$h = "";
		if ($jenis=='select'){
			foreach ($dtTabel as $l) {
				$chec = '';
				if ($idBiodata == $l['id']) {
					$chec = 'selected';
				}
				$h .= "<option $chec value=\"" . $l['id'] . "\">$l[nama] __ $l[nama_jabatan]</option>";
			}
		}else{
		}
		
		return $h;
	}
	
	public function getJabatan($id = '')
	{
		$dtJabatan = $this->Mjabatan->getData($id);
		
		$hJabatan = "";
		foreach ($dtJabatan as $l) {
			$chec = '';
			if ($id == $l['id']) {
				$chec = 'selected';
			}
			$hJabatan .= "<option $chec value=\"" . $l['id'] . "\">" . $l['nama'] . "</option>";
		}
		return $hJabatan;
	}
}
