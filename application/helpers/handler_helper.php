<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (!function_exists('handler')) {
	
	function res_success($d, $t, $m)
	{
		$response = [
			'data' => $d,
			'message' => $m,
			'title' => $t,
			'code' => 200,
			'icon' => 'success',
		];
		return $response;
	}
	
	function res_error($d, $t, $m)
	{
		$response = [
			'data' => $d,
			'message' => $m,
			'title' => $t,
			'code' => 400,
			'icon' => 'error',
		];
		return $response;
	}
	
	function res_custom($d, $t, $m, $c, $i)
	{
		$response = [
			'data' => $d,
			'message' => $m,
			'title' => $t,
			'code' => $c,
			'icon' => $i,
		];
		return $response;
	}
	
	function handlerDatatableEmpty($jenis = 'json')
	{
		if ($jenis == 'json') {
			$res = res_error([], 'Gagal', 'data kosong');
			http_response_code($res['code']);
			echo json_encode($res);
			exit();
		}
		$dtJSON = '{"data": []}';
		echo $dtJSON;
		exit();
	}
	
	function handlerHakakses($dataHakakses, $jenis = 'json')
	{
		if ($dataHakakses != "1") {
			$mes = 'Maaf level anda tidak memiliki Hak Akses.';
			$tit = 'Gagal';
			if ($jenis == 'json') {
				$res = res_error([], $tit, $mes);
				http_response_code($res['code']);
				echo json_encode($res);
				exit();
			}
			$dtJSON = "0|$tit|error|$mes";
			echo base64_encode($dtJSON);
			exit();
		}
		return true;
	}
	
	function handlerFilter($data, $message = 'default', $jenis = 'json')
	{
		$mes = "Data $data tidak ditemukan, Ulangi lagi.";
		$tit = 'Gagal';
		if ($message == 'custom') {
			$mes = $data;
			$tit = 'Gagal';
		}
		if ($jenis == 'json') {
			$res = res_error([], $tit, $mes);
			http_response_code($res['code']);
			echo json_encode($res);
			exit();
		}
		$dtJSON = "0|$tit|error|$mes";
		echo base64_encode($dtJSON);
		exit();
	}
	
	function handlerCrudError($jenis = 'json')
	{
		$mes = 'Proses Eksekusi Lambat. Ulangi lagi.';
		$tit = 'Gagal';
		if ($jenis == 'json') {
			$res = res_error([], $tit, $mes);
			http_response_code($res['code']);
			echo json_encode();
			exit();
		}
		$dtJSON = "0|$tit|error|$mes";
		echo base64_encode($dtJSON);
		exit();
	}
	
	function handlerDataSamaSatu($data, $jenis = 'json')
	{
		$mes = "Data $data Sudah digunakan. Ulangi lagi.";
		$tit = 'Gagal';
		if ($jenis == 'json') {
			$res = res_error([], $tit, $mes);
			http_response_code($res['code']);
			echo json_encode($res);
			exit();
		}
		$dtJSON = "0|$tit|error|$mes";
		echo base64_encode($dtJSON);
		exit();
	}
	
	function handlerProsesCRUD($bagian, $jenis = 'json')
	{
		if ($bagian == 'c') {
			$mes = 'Data Berhasil di Tambahkan';
		} else if ($bagian == 'u') {
			$mes = 'Data Berhasil di Update';
		} else {
			$mes = 'Data Berhasil di Hapus';
		}
		$tit = 'Berhasil';
		if ($jenis == 'json') {
			$res = res_success(null, $tit, $mes);
			http_response_code($res['code']);
			echo json_encode($res);
			exit();
		}
		$dtJSON = "1|$tit|success|$mes";
		echo base64_encode($dtJSON);
		exit();
	}
	
	function handlerCuBintang($jenis = 'tambah', $data = [])
	{
		if ($jenis == 'tambah') {
			if (count($data)) {
				$d['tgl_buat'] = $data[0];
				$d['id_buat'] = $data[2];
				$d['tgl_update'] = $data[1];
				$d['id_update'] = $data[3];
			} else {
				$d['tgl_buat'] = datetime_sendiri();
				$d['id_buat'] = ambil_user();
				$d['tgl_update'] = "0000-00-00 00:00:00";
				$d['id_update'] = "";
			}
		} else {
			if (count($data)) {
				$d['tgl_update'] = $data[1];
				$d['id_update'] = $data[3];
			} else {
				$d['tgl_update'] = datetime_sendiri();
				$d['id_update'] = ambil_user();
			}
		}
		return $d;
	}
	
	function handlerDatatableServer($draw, $countAll, $countFiltered, $dataArray)
	{
		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $countAll,
			"recordsFiltered" => $countFiltered,
			"data" => $dataArray,
			"req" => $_REQUEST,
		]);
		exit();
	}
	
	function jsHandler($jenis, $sukses = true)
	{
		if ($jenis == 'c') {
			return ($sukses == true ? "<script>Swal.fire('Berhasil','Tambah Data Berhasil disimpan','success')</script>" : "<script>Swal.fire('Gagal','Proses Tambah lambat! Ulangi lagi.','error')</script>");
		} else if ($jenis == 'u') {
			return ($sukses == true ? "<script>Swal.fire('Berhasil','Update Data Berhasil','success')</script>" : "<script>Swal.fire('Gagal','Proses Update lambat! Ulangi lagi.','error')</script>");
		} else {
			return ($sukses == true ? "<script>Swal.fire('Berhasil','Hapus Data Berhasil','success')</script>" : "<script>Swal.fire('Gagal','Proses Hapus lambat! Ulangi lagi.','error')</script>");
		}
	}
	
	function jsHandlerCustom($message, $sukses = true)
	{
		return ($sukses == true ? "<script>Swal.fire('Berhasil','$message','success')</script>" : "<script>Swal.fire('Gagal','$message','error')</script>");
	}
	
	function jsHandlerIdKosong()
	{
		return "<script>Swal.fire('Gagal','Maaf Id Tidak ditemukan.','error')</script>";
	}
}
