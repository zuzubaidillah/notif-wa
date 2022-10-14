<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (!function_exists('systems')) {
	
	function format_api($url, $data = [], $methode = 'GET', $headers = '')
	{
		$s_token_barrer = gettabelsql("SELECT nilai FROM pengaturan where id='003'");
		
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_POST, true);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($handle, CURLOPT_HTTPHEADER, [
			"Content-Type: application/json",
			"Accept: application/json",
			"Authorization: Bearer " . $s_token_barrer[0]->nilai
		]);
		
		curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($data));
		
		//for debug only!
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		
		$resp = curl_exec($handle);
		$httpcode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		
		curl_close($handle);
		return [$resp, $httpcode];
	}
	
	function link_api_v1_official($url = '')
	{
		$s = gettabelsql("SELECT nilai FROM pengaturan where id='005'");
		return $s[0]->nilai;
	}
	
	function link_api_v1($url = '')
	{
		$s = gettabelsql("SELECT nilai FROM pengaturan where id='004'");
		return $s[0]->nilai . $url;
	}
	
	function datetime_sendiri()
	{
		date_default_timezone_set("Asia/Jakarta");
		$tgl = date('Y-m-d H:i:s');
		return $tgl;
	}
	
	function date_sendiri()
	{
		date_default_timezone_set("Asia/Jakarta");
		$tgl = date('Y-m-d');
		return $tgl;
	}
	
	function jam_sendiri()
	{
		date_default_timezone_set("Asia/Jakarta");
		$tgl = date('H:i:s');
		return $tgl;
	}
	
	function rupiah($nominal)
	{
		return number_format($nominal, 0, ',', '.');
	}
	
	function data_mapel()
	{
		$idAkses = ambil_user();
		
		$sql = "SELECT mgu.id as id_guru FROM m_guru mgu
    	inner join akses as aks on mgu.id_akses=aks.id
         where mgu.id_akses='$idAkses'";
		$cekRelasiKeAkses = gettabelsql($sql);
		if (is_array($cekRelasiKeAkses)) {
			foreach ($cekRelasiKeAkses as $k) {
				$idGuru = $k->id_guru;
				$sql = "SELECT mma.*
				FROM guru_mapel gma
				         inner join m_guru mg on gma.id_guru = mg.id
				         inner join m_mapel mma on gma.id_mapel = mma.id
				where gma.id_guru = '$idGuru' AND mma.aktif='aktif' order by mma.jurusan asc, mma.nama asc;";
			}
		} else {
			lanjutIni:
			$sql = "SELECT * FROM m_mapel where aktif='aktif' order by jurusan asc, nama asc";
		}
		$dt = gettabelsql($sql);
		if (!is_array($dt)) {
			goto lanjutIni;
		}
		return $dt;
	}
	
	function dtMenu()
	{
		$dtMenu = [
			[
				"nama" => "Home",
				"idMenuLi" => "liHome",
				"idMenuA" => "aHome",
				"url" => base_url()."",
				"jenisMenu" => "public",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "LogIn",
				"idMenuLi" => "liLogin",
				"idMenuA" => "aLogin",
				"url" => base_url()."admin/login",
				"jenisMenu" => "public",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "Dashboard",
				"idMenuLi" => "liDashboard",
				"idMenuA" => "aDashboard",
				"url" => base_url()."admin/dashboard",
				"jenisMenu" => "admin-panel",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "Lembaga",
				"idMenuLi" => "liLembaga",
				"idMenuA" => "aLembaga",
				"url" => base_url()."admin/lembaga",
				"jenisMenu" => "admin-panel",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "Jabatan",
				"idMenuLi" => "liJabatan",
				"idMenuA" => "aJabatan",
				"url" => base_url()."admin/jabatan",
				"jenisMenu" => "admin-panel",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "Biodata",
				"idMenuLi" => "liBiodata",
				"idMenuA" => "aBiodata",
				"url" => base_url()."admin/biodata",
				"jenisMenu" => "admin-panel",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "Agenda",
				"idMenuLi" => "liAgenda",
				"idMenuA" => "aAgenda",
				"url" => base_url()."admin/agenda",
				"jenisMenu" => "admin-panel",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "Akses",
				"idMenuLi" => "liAkses",
				"idMenuA" => "aAkses",
				"url" => base_url()."admin/akses",
				"jenisMenu" => "admin-panel",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
		];
		return $dtMenu;
	}
	
	function data_staff()
	{
		$dt = [36, 12, 11, 33, 3, 1, 2, 10, 29, 4, 5, 7, 9];
		return $dt;
	}
	
	function rupiahrp($nominal)
	{
		return 'Rp ' . number_format($nominal, 0, ',', '.');
	}
	
	function tambah_sistem($jenis_lokasi, $nama_berkas, $alamat, $accessText)
	{
		$explScriptName = explode('/', dirname($_SERVER['SCRIPT_NAME']));
		$bas = $_SERVER['DOCUMENT_ROOT'] . '/' . $explScriptName[1];
		if ($jenis_lokasi == 'controller') {
			$bash_alamat = $bas . '/application/controllers/';
		} else if ($jenis_lokasi == 'view') {
			$bash_alamat = $bas . '/application/views/';
		} else {
			$bash_alamat = $bas . '/application/models/';
		}
		
		if (!mkdir($concurrentDirectory = $bash_alamat . ucwords(str_replace(array('\'', '/', ':', ';', '*', '?', '"', '<', '>', '|', ' '), '_', $nama_berkas))) && !is_dir($concurrentDirectory)) {
			throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
		}
		
		if (file_exists($bash_alamat . $nama_berkas)) {
			chmod($bash_alamat . $nama_berkas, 0777);
			$newDir = $bash_alamat . $nama_berkas;
			
			$access = fopen($newDir . "/Dashboard.php", "w") or die();
			chmod($bash_alamat . $nama_berkas . '/Dashboard.php', 0777);
			fwrite($access, $accessText);
			$ada = true;
		} else {
			$ada = false;
		}
		return $ada;
	}
	
	function buat_id($key, $table, $panjang = 0)
	{
		$CI = &get_instance();
		
		if ($panjang == 0) {
			$id = round(microtime(true) * 1000);
		} else {
			$id = substr(round(microtime(true) * 1000), 4, $panjang);
		}
		$id = $key . $id;
		if (gettabelsql("SELECT * FROM $table WHERE id='$id'")) {
			$id = round(microtime(true) * 1000);
			$id = $key . $id;
			if (gettabelsql("SELECT * FROM $table WHERE id='$id'")) {
				$id = buat_id($key, $table);
			}
		}
		return $id;
	}
	
	function get_tp_aktif(): array
	{
		$CI = &get_instance();
		$dt_tp = $CI->Mabsen->tahun_pelajaran_aktif();
		if (count($dt_tp) == 0) {
			$res = [
				'id_tp' => 0,
				'tahun_pelajaran' => 0,
				'semester' => 0,
			];
		} else {
			$res = [
				'id_tp' => $dt_tp[0]->id,
				'tahun_pelajaran' => $dt_tp[0]->nama,
				'semester' => $dt_tp[0]->semester,
			];
		}
		return $res;
	}
	
	function ambil_user()
	{
		$CI = &get_instance();
		
		$user = $CI->Makses->ambiluser();
		if (count($user)>=1){
			$user = $user[0]['id'];
			return $user;
		}else{
			redirect('admin/logout');
			exit();
		}
	}
	
	function gettabelsql($tabel, $array = 'object')
	{
		// menambahakn get_instance() adalah sebuah fungsi yang didefinisikan di file inti dari CodeIgniter. Anda menggunakannya untuk mendapatkan singleton mengacu pada CodeIgniter super objek ketika anda berada dalam lingkup luar super objek.
		$CI = &get_instance();
		
		$query = $CI->db->query($tabel);
		
		if ($query->num_rows() > 0) {
			return $array == 'object' ? $query->result() : $query->result_array();
		} else {
			return $array == 'object' ? 0 : [];
		}
	}
	
	function get_pengaturan($ket, $id)
	{
		$CI = &get_instance();
		
		// $dt = $CI->Mapi_barang->pengaturan($ket, $id);
		$dt = gettabelsql("select pen.nilai from pengaturan as pen where pen.id='$id'");
		if ($dt) {
			if (count($dt) > 0) {
				return $dt[0]->nilai;
			}
		}
		return 0;
	}
	
	function cektabelsql($tabel)
	{
		// menambahakn get_instance() adalah sebuah fungsi yang didefinisikan di file inti dari CodeIgniter. Anda menggunakannya untuk mendapatkan singleton mengacu pada CodeIgniter super objek ketika anda berada dalam lingkup luar super objek.
		$CI = &get_instance();
		
		$query = $CI->db->query($tabel);
		
		if ($query->num_rows() > 0) {
			return 1;
		}
		return 0;
	}
	
	function counttabelsql($tabel)
	{
		// menambahakn get_instance() adalah sebuah fungsi yang didefinisikan di file inti dari CodeIgniter. Anda menggunakannya untuk mendapatkan singleton mengacu pada CodeIgniter super objek ketika anda berada dalam lingkup luar super objek.
		$CI = &get_instance();
		
		$query = $CI->db->query($tabel);
		
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}
	
	function modal_profil_helper($iduser, $namauser, $usrnama, $lvluser)
	{
		$CI = &get_instance();
		return '<div class="modal fade modal-primary" id="modal-profil" aria-hidden="true" aria-labelledby="modal-profil" role="dialog" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span></button>
						<h4 class="modal-title">Profil</h4>
					</div>
					<div class="modal-body">
						<div class="card-block p-10">
							<a class="avatar avatar-100 float-left mr-20" href="javascript:void(0)">
								<img src="' . base_url('assets/profil/' . $iduser . '.jpg') . '" alt="...">
							</a>
							<div class="vertical-align h-100 text-truncate">
								<div class="vertical-align-middle">
									<div class="font-size-20 mb-5 blue-600 text-truncate">' . $namauser . '</div>
									<div class="font-size-14 text-truncate">ID: ' . $iduser . '</div>
									<div class="font-size-14 text-truncate">Username: ' . $usrnama . '</div>
									<div class="font-size-14 text-truncate">Level: ' . $lvluser . '</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>';
	}
	
	function cek_validasi($data = [], $methode = 'POST')
	{
		$CI = &get_instance();
		if (count($data) > 0) {
			$CI->load->library('form_validation');
			foreach ($data as $k => $v) {
				$CI->form_validation->set_rules($v, $v, 'required');
				if ($CI->form_validation->run() == false) {
					$response = res_error($_REQUEST, 'Gagal', 'Permintaan kurang lengkap.');
					echo json_encode($response);
					exit();
				}
			}
		}
	}
	
	function array_to_keterangan($data = [], $metod = 'tanpa tabel', $jenis = 'log')
	{
		$CI = &get_instance();
		if (count($data) == 0) {
			handlerFilter('array_to_keterangan data array kosong.', 'custom');
		}
		$hasil = "";
		$br = "<br> \n ";
		foreach ($data as $k => $v) {
			$v_slug = url_title($v, 'dash');
			$k_slug = url_title($k, 'dash');
			$vv = str_replace("'", ' ', $v_slug);
			$kk = str_replace("'", ' ', $k_slug);
			$k = str_replace("-", ' ', $kk);
			$v = str_replace("-", ' ', $vv);
			
			if ($metod == "tanpa tabel") {
				$hasil .= "$k: $v, $br";
			} else {
				$hasil .= "$k $metod: $v, $br";
			}
		}
		return $hasil;
	}
	
	function cek_validasi_base64($data = [])
	{
		$CI = &get_instance();
		if (count($data) > 0) {
			$CI->load->library('form_validation');
			foreach ($data as $k => $v) {
				$CI->form_validation->set_rules($v, $v, 'required');
				if ($CI->form_validation->run() == false) {
					echo base64_encode("0|error|Gagal|Maaf Permintaan tidak lengkap");
					exit();
				}
			}
		}
	}
	
	function cek_level($jenis = 'id_level')
	{
		$CI = &get_instance();
		$a = ambil_user();
		$sql_akses = "SELECT level FROM akses WHERE id='$a'";
		$querySQL = $CI->db->query($sql_akses);
		$dt_akses = $querySQL->row();
		if ($jenis == 'id_level') {
			$h = $dt_akses->level;
		} else {
			$h = $dt_akses->nama;
		}
		return $h;
	}
	
	function format_number_wa($nomor)
	{
		$CI = &get_instance();
		$n = " +62 813-0000-0767 ";
		$n2 = " 0813-123-345-324 ";
		
		$rep_car = preg_replace('/[^\dxX]/', '', $nomor);
		// echo $rep_car;
		// echo "<br>";
		$no = $rep_car;
		if ($rep_car[0] == '0') {
			$rep_nol = ltrim($rep_car, '0');
			$no = '62' . $rep_nol;
		}
		
		return $no;
	}
	
	function get_pengaturan_absensi($id = 'PAB1642769666296', $bagian = 'all')
	{
		$CI = &get_instance();
		$sql_akses = "SELECT * FROM pengaturan_absensi where id='$id' limit 1";
		$querySQL = $CI->db->query($sql_akses);
		if ($bagian == 'all') {
			$h = $querySQL->row();
		} else if ($bagian == 'pulang') {
			$h = $querySQL->row()->jam_pulang;
		} else if ($bagian == 'datang') {
			$h = $querySQL->row()->jam_datang;
		} else if ($bagian == 'keterangan') {
			$h = $querySQL->row()->keterangan;
		}
		return $h;
	}
	
	function get_pelanggaran($id = 'PEL1656235098265', $bagian = 'all')
	{
		$CI = &get_instance();
		$sql_akses = "SELECT * FROM m_pelanggaran where id='$id' limit 1";
		$querySQL = $CI->db->query($sql_akses);
		if ($bagian == 'all') {
			$h = $querySQL->row();
		} else {
			$h = $querySQL->row()->point;
		}
		return $h;
	}
	
	function encripsisendiri($id)
	{
		$CI = &get_instance();
		$id = $CI->encryption->encrypt($id);
		// $id = base64_encode($id);
		// mengembalikan nilai
		return $id;
	}
	
	function decripsisendiri($id)
	{
		$CI = &get_instance();
		// $id = base64_decode($id);
		$id = $CI->encryption->decrypt($id);
		// mengembalikan nilai
		return $id;
	}
	
	function selisih_time($tanggal, $date_time, $jenis = 'menit')
	{
		$tz = new DateTimeZone('Asia/Jakarta');
		$tgl_awal = $tanggal; // '2022-05-18 00:00:01';
		$tgl_sekarang = $date_time; // '2022-05-18 00:06:10';
		$dt1 = new DateTime($tgl_awal, $tz);
		$dt2 = new DateTime($tgl_sekarang, $tz);
		$selisih_akhir = $dt1->diff($dt2)->format('%r%y years, %m months, %d days, %h hours, %i minutes, %s seconds');
		$karakter = '-';
		if (strtotime($tgl_awal) <= strtotime($tgl_sekarang)) {
			$karakter = '+';
		}
		$menit = $karakter . $dt1->diff($dt2)->format('%h.%i.%s');
		return $menit;
	}
	
	function notifjs($icon, $ket)
	{
		$data = "
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 10000
		});Toast.fire({icon: '" . $icon . "',title: '" . $ket . "'});";
		// mengembalikan nilai
		return $data;
	}
	
	function show_tp_angkatan($angkatan, $kel_nama_tingkat)
	{
		$tempuh_pendidikan = 3;
		$simpan_tp = [];
		$msg_tp = "";
		$simpan_tingkatan_sesuai_post_tp = "";
		for ($i = 1; $i <= $tempuh_pendidikan; $i++) {
			if ($i == 1) {
				$an_tingkatan = "X";
				$simpan_tp[] = $angkatan . "/" . ($i + $angkatan) . "_$an_tingkatan";
				$msg_tp .= $simpan_tp[0] . " Kelas: X\n";
				if ($kel_nama_tingkat == $an_tingkatan) {
					$simpan_tingkatan_sesuai_post_tp = $an_tingkatan;
				}
			} else if ($i == 2) {
				$an_tingkatan = "XI";
				$simpan_tp[] = ($i + ($angkatan - 1)) . "/" . ($i + $angkatan) . "_$an_tingkatan";
				$msg_tp .= $simpan_tp[1] . " Kelas: XI\n";
				if ($kel_nama_tingkat == $an_tingkatan) {
					$simpan_tingkatan_sesuai_post_tp = $an_tingkatan;
				}
			} else {
				$an_tingkatan = "XII";
				$simpan_tp[] = ($i + ($angkatan - 1)) . "/" . ($i + $angkatan) . "_$an_tingkatan";
				$msg_tp .= $simpan_tp[2] . " Kelas: XII\n";
				if ($kel_nama_tingkat == $an_tingkatan) {
					$simpan_tingkatan_sesuai_post_tp = $an_tingkatan;
				}
			}
		}
		return [
			"data" => $simpan_tp,
			"tingkatan" => $simpan_tingkatan_sesuai_post_tp
		];
	}
	
	function excel_teks_style($teks, $style)
	{
		
		$t = $style['tebal'] ?? false;
		$c = $style['center'] ?? false;
		$m = $style['midle'] ?? false;
		$border_true = $style['border'][0] ?? false;
		$b_true = $style['bg'][0] ?? false;
		$b_b = $style['bg'][1] ?? "#FFFF00";
		$b_c = $style['bg'][2] ?? "#0000FF";
		$b_b = $b_b != '' ? $b_b : "#FFFF00";
		$b_c = $b_c != '' ? $b_c : "#0000FF";
		
		$hasil_t = $teks;
		if ($t) {
			$hasil_t = '<b>' . $teks . '</b>';
		}
		if ($c) {
			$hasil_t = '<center>' . $hasil_t . '</center>';
		}
		if ($m) {
			$hasil_t = '<middle>' . $hasil_t . '</middle>';
		}
		if ($b_true) {
			$hasil_t = '<style bgcolor="' . $b_b . '" color="' . $b_c . '">' . $hasil_t . '</style>';
			// $hasil_t = str_replace("x_x", $teks, $hasil_t);
		}
		return $hasil_t;
	}
	
	function hapus_petik($a)
	{
		$hasil = str_replace("'", '', $a);
		$hasil = str_replace('"', '', $hasil);
		return $hasil;
	}
	
}
