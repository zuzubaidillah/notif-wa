<?php
//function set_enkripsi($ps){return base64_encode(openssl_encrypt($ps, "AES-128-CBC", kunci_ssl, 0, "0123456789abcdef"));}
//function set_dekripsi($ps){return openssl_decrypt(base64_decode($ps), "AES-128-CBC", kunci_ssl, 0, "0123456789abcdef");}

function enkripsi($ps)
{
	return base64_encode(openssl_encrypt($ps, "AES-256-CBC", kunci_ssl, 0, "0123456789abcdef"));
}

function dekripsi($ps)
{
	return openssl_decrypt(base64_decode($ps), "AES-256-CBC", kunci_ssl, 0, "0123456789abcdef");
}

function tgl_indo($xy)
{
	$tgl = substr($xy, 8, 2);
	$bln = substr($xy, 5, 2);
	$thn = substr($xy, 0, 4);
	return $tgl . "-" . $bln . "-" . $thn;
}

function tgl_slash($xy)
{
	$tgl = substr($xy, 8, 2);
	$bln = substr($xy, 5, 2);
	$thn = substr($xy, 0, 4);
	return $tgl . "/" . $bln . "/" . $thn;
}

function tgl_indo_lengkap($xy)
{
	$tgl = substr($xy, 8, 2);
	$thn = substr($xy, 0, 4);
	switch (substr($xy, 5, 2)) {
		case "01":
			$bln = "Jan";
			break;
		case "02":
			$bln = "Feb";
			break;
		case "03":
			$bln = "Mar";
			break;
		case "04":
			$bln = "Apr";
			break;
		case "05":
			$bln = "Mei";
			break;
		case "06":
			$bln = "Jun";
			break;
		case "07":
			$bln = "Jul";
			break;
		case "08":
			$bln = "Agu";
			break;
		case "09":
			$bln = "Sep";
			break;
		case "10":
			$bln = "Okt";
			break;
		case "11":
			$bln = "Nov";
			break;
		default:
			$bln = "Des";
			break;
	}
	return $tgl . " " . $bln . " " . $thn;
}

function tgl_indo_lengkap2($xy)
{
	$tgl = substr($xy, 8, 2);
	$thn = substr($xy, 0, 4);
	switch (substr($xy, 5, 2)) {
		case "01":
			$bln = "Jan";
			break;
		case "02":
			$bln = "Feb";
			break;
		case "03":
			$bln = "Mar";
			break;
		case "04":
			$bln = "Apr";
			break;
		case "05":
			$bln = "Mei";
			break;
		case "06":
			$bln = "Jun";
			break;
		case "07":
			$bln = "Jul";
			break;
		case "08":
			$bln = "Agu";
			break;
		case "09":
			$bln = "Sep";
			break;
		case "10":
			$bln = "Okt";
			break;
		case "11":
			$bln = "Nov";
			break;
		default:
			$bln = "Des";
			break;
	}
	$c = explode(" ", $xy);
	return $tgl . " " . $bln . " " . $thn . " " . $c[1];
}

function tgl_indo_hari_dmy($xy)
{
	$tgl = substr($xy, 8, 2);
	$thn = substr($xy, 0, 4);
	switch (substr($xy, 5, 2)) {
		case "01":
			$bln = "Januari";
			break;
		case "02":
			$bln = "Februari";
			break;
		case "03":
			$bln = "Maret";
			break;
		case "04":
			$bln = "April";
			break;
		case "05":
			$bln = "Mei";
			break;
		case "06":
			$bln = "Juni";
			break;
		case "07":
			$bln = "Juli";
			break;
		case "08":
			$bln = "Agustus";
			break;
		case "09":
			$bln = "September";
			break;
		case "10":
			$bln = "Oktober";
			break;
		case "11":
			$bln = "November";
			break;
		default:
			$bln = "Desember";
			break;
	}
	return hari_indo($xy) . ", $tgl $bln $thn";
}

function get_bulan_saja($xy = 1)
{
	switch ($xy) {
		case "1":
			$bln = "Januari";
			break;
		case "2":
			$bln = "Februari";
			break;
		case "3":
			$bln = "Maret";
			break;
		case "4":
			$bln = "April";
			break;
		case "5":
			$bln = "Mei";
			break;
		case "6":
			$bln = "Juni";
			break;
		case "7":
			$bln = "Juli";
			break;
		case "8":
			$bln = "Agustus";
			break;
		case "9":
			$bln = "September";
			break;
		case "10":
			$bln = "Oktober";
			break;
		case "11":
			$bln = "November";
			break;
		default:
			$bln = "Desember";
			break;
	}
	return $bln;
}

function datetime_to_time($xy, $jenis = 'all')
{
	$c = explode(" ", $xy);
	$b = explode(":", $c[1]);
	$h = $b[0] . ":" . $b[1];
	if ($jenis == 'all') {
		$h = $c[1];
	}
	return $h;
}

function hari_indo($xy)
{
	$h = date("w", strtotime($xy));
	$hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
	return $hari[$h];
}

function tgl_terakhir_bulan_lalu($xy)
{
	$bln = substr($xy, 5, 2);
	$thn = substr($xy, 0, 4);
	$h = date("Y-m-d", strtotime($thn . "-" . $bln . "-00"));
	return $h;
}

function tgl_terakhir_bulan_ini($xy)
{
	$bln = substr($xy, 5, 2);
	$thn = substr($xy, 0, 4);
	$h = date("t", strtotime($xy));
	return $thn . "-" . $bln . "-" . $h;
}

function datetime_to_date($date = null)
{
	$h_date = date('Y-m-d');
	if ($date != null) {
		$h_date = date('Y-m-d', strtotime($date));
	}
	return $h_date;
}

function format_time($date = null)
{
	if ($date == null) {
		$jam = date('H:i:s');
	} else {
		$jam = date('H:i:s', strtotime($date));
	}
	$formatTanggal = $jam;
	return $formatTanggal;
}

function kode_oto()
{
	date_default_timezone_set("Asia/Jakarta");
	return strtotime(date("Y-m-d H:i:s"));
}

function random_background()
{
	$bgku = ["bg-success", "bg-primary", "bg-warning", "bg-info", "bg-danger"];
	return $bgku[rand(0, 4)];
}

function selisih_tanggal($aw, $ak, $jenis = '')
{
	// string(18) "2025-5-20 06:07:24"
	// string(19) "2022-05-21 06:07:24"
	// string(2) "-2"
	// string(2) "11"
	// string(2) "30"
	
	// string(18) "2023-5-20 06:07:13"
	// string(19) "2022-05-21 06:07:13"
	// string(2) "-0"
	// string(2) "11"
	// string(2) "30"
	
	//string(18) "2022-5-21 06:08:53"
	// string(19) "2022-05-21 06:08:53"
	// string(1) "0"
	// string(1) "0"
	// string(1) "0"
	
	//string(18) "2022-5-22 06:10:22"
	// string(19) "2022-05-21 06:10:22"
	// string(2) "-0"
	// string(1) "0"
	// string(1) "1"
	
	// string(18) "2022-5-20 06:11:02"
	// string(19) "2022-05-21 06:11:02"
	// string(1) "0"
	// string(1) "0"
	// string(1) "1"
	
	$tz = new DateTimeZone('Asia/Jakarta');
	//cek jika tgl sudah melewati tgl sekarang
	$tgl_awal = $aw; //'2022-04-21 00:00:01';
	// $tgl_awal = "2022-5-20 ".jam_sendiri();
	$tgl_sekarang = $ak; // '2022-05-18 00:06:10';
	$dt1 = new DateTime($tgl_awal, $tz);
	$dt2 = new DateTime($tgl_sekarang, $tz);
	
	// $selisih_akhir = $dt1->diff($dt2)->format('%r%y years, %m months, %d days, %h hours, %i minutes, %s seconds');
	$selisih_akhir = $dt1->diff($dt2);
	$s_year = $selisih_akhir->format('%r%y');
	$s_months = $selisih_akhir->format('%m');
	$s_days = $selisih_akhir->format('%d');
	
	if ((int)$s_year == 0 && (int)$s_months == 0 && (int)$s_days == 0) {
		return 'sekarang';
	}
	
	if ($s_year === '-0') {
		return 'besok';
	}
	
	if ((int)$s_year >= 0 && (int)$s_months >= 0 && (int)$s_days >= 0) {
		return 'kemarin';
	}
}
