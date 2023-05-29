<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (!function_exists('systems')) {
	
	function format_api($url = "http://103.163.226.154:30022/kirimpesan", $data = [], $methode = 'GET', $headers = '')
	{
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, "http://103.163.226.154:30021/kirimpesan");
		curl_setopt($handle, CURLOPT_POST, true);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($handle, CURLOPT_HTTPHEADER, [
			'Content-Type: application/x-www-form-urlencoded',
		]);
		
		curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
		
		//for debug only!
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		
		$resp = curl_exec($handle);
		$httpcode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		
		curl_close($handle);
		return [$resp, $httpcode];
	}
	
	function link_api_v1($url = '')
	{
		$s = "http://103.163.226.154:8001/kirimpesan";
		return $s;
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
	
	function dtLabels()
	{
		$h = [
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
		return $h;
	}
	
	function dtMenu()
	{
		$dtMenu = [
			[
				"nama" => "Home",
				"idMenuLi" => "liHome",
				"idMenuA" => "aHome",
				"url" => base_url() . "",
				"jenisMenu" => "public",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "LogIn",
				"idMenuLi" => "liLogin",
				"idMenuA" => "aLogin",
				"url" => base_url() . "admin/login",
				"jenisMenu" => "public",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "Dashboard",
				"idMenuLi" => "liDashboard",
				"idMenuA" => "aDashboard",
				"url" => base_url() . "admin/dashboard",
				"jenisMenu" => "admin-panel",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "Lembaga",
				"idMenuLi" => "liLembaga",
				"idMenuA" => "aLembaga",
				"url" => base_url() . "admin/lembaga",
				"jenisMenu" => "admin-panel",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "Jabatan",
				"idMenuLi" => "liJabatan",
				"idMenuA" => "aJabatan",
				"url" => base_url() . "admin/jabatan",
				"jenisMenu" => "admin-panel",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "Biodata",
				"idMenuLi" => "liBiodata",
				"idMenuA" => "aBiodata",
				"url" => base_url() . "admin/biodata",
				"jenisMenu" => "admin-panel",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "Agenda",
				"idMenuLi" => "liAgenda",
				"idMenuA" => "aAgenda",
				"url" => base_url() . "admin/agenda",
				"jenisMenu" => "admin-panel",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
			[
				"nama" => "Akses",
				"idMenuLi" => "liAkses",
				"idMenuA" => "aAkses",
				"url" => base_url() . "admin/akses",
				"jenisMenu" => "admin-panel",
				"isShow" => 1,
				"icon" => "fa-layer-group",
			],
		];
		return $dtMenu;
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
	
	function ambil_user()
	{
		$CI = &get_instance();
		
		$user = $CI->Makses->ambiluser();
		if (count($user) >= 1) {
			$user = $user[0]['id'];
			return $user;
		} else {
			redirect('admin/logout');
			exit();
		}
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
	
	
	function gettabelsql($tabel, $jenis = 'result')
	{
		// menambahakn get_instance() adalah sebuah fungsi yang didefinisikan di file inti dari CodeIgniter. Anda menggunakannya untuk mendapatkan singleton mengacu pada CodeIgniter super objek ketika anda berada dalam lingkup luar super objek.
		$CI = &get_instance();
		
		$query = $CI->db->query($tabel);
		
		if ($query->num_rows() > 0) {
			if ($jenis == 'result') {
				return $query->result();
			} else {
				return $query->row();
			}
		} else {
			return 0;
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
}
