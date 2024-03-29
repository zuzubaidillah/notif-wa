<?php
defined('BASEPATH') or exit('No direct script access allowed');

header('Content-Type: Application/json');
date_default_timezone_set("Asia/Jakarta");

class Api extends CI_Controller
{
    public function index()
    {
        $res = res_custom('', '', '', 500, "");
        http_response_code($res['code']);
        echo json_encode($res);
        exit();
    }

    public function cekAgenda($getId = '', $jenisResponse = 'json')
    {
        $Magenda = new Magenda();
        if ($getId == '') {
            $tgl = datetime_sendiri();
            $cek = $Magenda->cekAgenda($tgl);
        } else {
            $cek = $Magenda->getDataRelasi($getId);
        }
        if (count($cek) == 0) {
            if ($jenisResponse == 'json') {
                $res = res_error(null, 'Berhasil', 'Tidak Ditemukan Agenda');
                http_response_code($res['code']);
                echo json_encode($res);
                exit();
            }
            return ['data' => []];
        }
        $row = [];
        $resultWa = 0;
        foreach ($cek as $l) {
            if ($jenisResponse == 'json') {
                if ($l['status'] < 0) {
                    if ($getId == '') {
                        $row[] = 409;
                        continue;
                    } else {
                        $this->session->set_flashdata('notifikasi', jsHandlerCustom('Maaf Agenda Sudah Selesai.', false));
                        redirect('admin/agenda/update/' . $getId);
                        exit();
                    }
                }
            }
            $tgl = tgl_indo($l['waktu']);
            $jam = format_time($l['waktu']);
            $pesan = <<<PESAN
Pengingat

Nama: *$l[nama_pengguna]*
Dari: *$l[dari]*
Tanggal: *$tgl*
Jam: *$jam*
keterangan: $l[deskripsi]

Pesan ini tidak perlu dibalas, otomatis oleh sistem
PESAN;

            $data = [
                "pesan" => $pesan,
                "target" => $l['nomor_wa'],
            ];
            $resApi = format_api("", $data, 'POST');
            $row[0] = $resApi[0];
            $row[1] = $resApi[1];
            if ($resApi[1] == 200) {
                $jml = $l['notif_ke'] + 1;
                $update = [
                    "notif_ke" => $jml
                ];
                $resultWa++;
                $this->Makses->update('agenda', $update, 'id', $l['id']);
            }
        }
        if ($jenisResponse !== 'json') {
            if ($resultWa) {
                return ['data' => [$cek, $tgl, $row]];
            }
            return ['data' => []];
        }
        if ($getId == '') {
            $res = res_success([$cek, $tgl, $row], '', '');
            http_response_code($res['code']);
            echo json_encode($res);
            exit();
        } else {
            return $resApi[1];
        }
    }

    public function kirimwaidagenda($id = '0')
    {
        if ($id == '0') {
            $this->session->set_flashdata('notifikasi', jsHandlerIdKosong());
            redirect('admin/agenda');
            exit();
        }
        $has = $this->cekAgenda($id);
        if ($has == 200) {
            $this->session->set_flashdata('notifikasi', jsHandlerCustom('Berhasil Terkirim', true));
            redirect('admin/agenda/update/' . $id);
            exit();
        } else {
            $this->session->set_flashdata('notifikasi', jsHandler('u', false));
            redirect('admin/agenda/update/' . $id);
            exit();
        }
    }

    public function kirimwaidagendabroadcast()
    {
        $Magenda = new Magenda();
        $data = $Magenda->cekAgendaBelumSelesai();
        if (!count($data)) {
            $res = res_error(null, 'Info', 'Data agenda yang menunggu tidak ditemukan');
            http_response_code($res['code']);
            echo json_encode($res);
            exit();
        }
        $totalAgenda = sizeof($data);
        $result = [];
        foreach ($data as $item) {
            $id = $item['id'];
            $hasil = $this->cekAgenda($id, 'return');
            if (count($hasil['data'])) {
                $result[] = [
                    "agenda" => $item['dari'],
                    "message" => "Berhasil"
                ];
            } else {
                $result[] = [
                    "agenda" => $item['dari'],
                    "message" => "Gagal"
                ];
            }
        }
        $resultString = '';
        foreach ($result as $item) {
            $resultString .= "agenda: " . $item['agenda'] . " (" . $item['message'] . ")\n ";
        }

        // Remove the trailing comma and space from the end of the string
        $resultString = rtrim($resultString, ', ');
        $res = res_custom($result, 'Hasil', $resultString, 200, 'info');
        http_response_code($res['code']);
        echo json_encode($res);
    }
}
