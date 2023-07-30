<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="page-header">
                <h4 class="page-title">
                    <?= $body_label_content ?? "Content Default" ?>
                </h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Data Agenda</a>
                    </li>
                </ul>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title">Data Agenda</div>
                            <div class="">
                                <a class="btn btn-primary btn-sm" href="<?= $rootss . 'add' ?>">Add</a>
                                <a class="btn btn-info btn-sm" href="javascript:void(0)" id="btn_export">Export</a>
                                <a class="btn btn-warning btn-sm" href="javascript:void(0)" id="btn_broadcast">Broadcas
                                    Whatsapp</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row border" id="html_export" style="display: none;">
                                <div class="col-12 form-inline">
                                    <div class="form-group form-inline">
                                        <span>Filter Data</span>
                                    </div>
                                    <div class="form-group form-inline">
                                        <label for="txtawal">Tanggal Awal</label>
                                        <input type="date" id="txtawal" name="txtawal" value="<?= date('Y-m-d') ?>"
                                               class="form-control ml-3">
                                    </div>
                                    <div class="form-group form-inline">
                                        <label for="txtakhir">Tanggal Ahir</label>
                                        <input type="date" id="txtakhir" name="txtakhir" value="<?= date('Y-m-d') ?>"
                                               class="form-control ml-3">
                                    </div>
                                    <div class="form-group form-inline">
                                        <button class="btn btn-primary" id="btn_proses">Proses</button>
                                        <button class="btn btn-danger ml-3" id="btn_export_batal">Batal</button>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-hover table-responsive-sm table-responsive-md">
                                <thead>
                                <tr>
                                    <th style="width: 5%" scope="col">#</th>
                                    <th style="width: 25%" scope="col">Data Agenda</th>
                                    <th style="width: 15%" scope="col">Dari</th>
                                    <th style="width: 30%" scope="col">Keterangan</th>
                                    <th style="width: 10%" scope="col">Lembaga</th>
                                    <th style="width: 10%" scope="col">Pengguna</th>
                                    <th style="width: 5%" scope="col">...</th>
                                </tr>
                                </thead>
                                <tbody id="htmlTbody">
                                <?php
                                if (count($dtTabel) >= 1) {
                                    $no = 0;
                                    foreach ($dtTabel as $v) {
                                        $id = $v['id'];
                                        $dari = $v['dari'];
                                        $deskripsi = $v['deskripsi'];
                                        $waktu = tgl_indo_lengkap2($v['waktu']);
                                        $menit_sebelum_notif = $v['menit_sebelum_notif'];
                                        $notif_ke = $v['notif_ke'];
                                        $jenis_agenda = $v['jenis_agenda'];
                                        $nama_lembaga = $v['nama_lembaga'];
                                        $id_biodata = $v['id_biodata'];
                                        $status = $v['status'];
                                        if ($status < 0) {
                                            $formatStatus = ' <span class="text-success pl-3">selesai</span>';
                                        } else {
                                            $formatStatus = ' <span class="text-warning pl-3">menunggu</span>';
                                        }
                                        $nama_pengguna = "<a href=\"" . base_url('admin/biodata/detail/' . $id_biodata) . "\">$v[nama_pengguna]</a>";
                                        // $hasilStyle = "background: #f25961!important;color: #fff!important;";
                                        $hasilStyle = "";
                                        ?>
                                        <tr style="<?= $hasilStyle ?>">
                                            <td><?= ++$no ?></td>
                                            <td>
                                                <b><?= $dari ?></b> <?= $formatStatus ?><br>
                                                <?= $waktu ?> -- <?= $menit_sebelum_notif ?>jam
                                            </td>
                                            <td>
                                                Notif ke : <?= $notif_ke ?> <br>
                                                Sifat: <?= $jenis_agenda ?>
                                            </td>
                                            <td><?= $deskripsi ?></td>
                                            <td><?= $nama_lembaga ?></td>
                                            <td><?= $nama_pengguna ?></td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <a href="<?= $rootss . 'update/' . $id ?>"
                                                       class="btn btn-warning btn-sm">Edit</a>
                                                    <button class="btn btn-danger btn-sm"
                                                            onclick="clickHapus('<?= $rootss . 'proses_delete/' . $id ?>')">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>Data Kosong</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        (() => {
            'use strict';

            document.addEventListener('DOMContentLoaded', function () {
                let liMenu = document.getElementById('liAgenda');
                let html_export = document.getElementById('html_export');
                liMenu.classList.add('active');

                const exportt = document.getElementById('btn_export');
                exportt.addEventListener('click', function () {
                    html_export.style.display = 'block';
                });

                const btn_broadcast = document.getElementById('btn_broadcast');
                btn_broadcast.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Kirim Whatsapp',
                        text: "Proses ini akan melakukan kirim whatsapp secara masal pada agenda yang masih aktif. Yakin ingin proses?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Proses'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.get("<?=base_url('api/kirimwaidagendabroadcast')?>").done(function (data) {
                                Swal.fire({
                                    icon: data.icon,
                                    title: data.message,
                                    showConfirmButton: true,
                                });
                            });
                        }
                        ;
                    })
                });

                const exportt_batal = document.getElementById('btn_export_batal');
                exportt_batal.addEventListener('click', function () {
                    html_export.style.display = 'none';
                });

                const btnProses = document.getElementById('btn_proses');
                const txtAwal = document.getElementById('txtawal');
                const txtAkhir = document.getElementById('txtakhir');

                btnProses.addEventListener('click', function () {
                    // Ambil nilai tanggal awal dan tanggal akhir
                    const tanggalAwal = new Date(txtAwal.value);
                    const tanggalAkhir = new Date(txtAkhir.value);

                    // Validasi tanggal akhir tidak kurang dari tanggal awal
                    if (tanggalAkhir < tanggalAwal) {
                        Swal.fire('Informasi', 'Tanggal akhir tidak boleh kurang dari tanggal awal!', 'info');
                        // alert("Tanggal akhir tidak boleh kurang dari tanggal awal!");
                        // Atau Anda bisa melakukan tindakan lain, seperti mengosongkan tanggal akhir atau menetapkan tanggal akhir sama dengan tanggal awal
                        // txtAkhir.value = txtAwal.value;
                        // atau
                        // txtAkhir.value = tanggalAwal.toISOString().slice(0, 10);
                    } else {
                        // Lakukan proses lain jika tanggal akhir valid
                        // Misalnya, eksekusi fungsi untuk memproses data
                        // Konversi tanggal ke format YYYY-MM-DD untuk URL
                        const awalParam = tanggalAwal.toISOString().slice(0, 10);
                        const akhirParam = tanggalAkhir.toISOString().slice(0, 10);

                        // Redirect ke URL dengan tanggal yang valid
                        window.location.href = `<?=base_url()?>admin/agenda/export?awal=${awalParam}&akhir=${akhirParam}`;
                    }
                });

                function prosesData() {
                    // Logika untuk memproses data dengan tanggal yang sudah valid
                    // Contoh: Mengirim data ke server, mengolah data lokal, dsb.
                    console.log('aman proses export')
                }

                const btnBatal = document.getElementById('btn_export_batal');
                btnBatal.addEventListener('click', function () {
                    // Tindakan jika tombol Batal ditekan
                    // Contoh: Menyembunyikan form atau mereset nilai tanggal
                    txtAwal.value = '<?=date('Y-m-d')?>';
                    txtAkhir.value = '<?=date('Y-m-d')?>';
                });
            });
        })();

        'use strict';

        function clickHapus(url) {
            Swal.fire({
                title: 'Hapus Data',
                text: "Data akan dilakukan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya...Hapus'
            }).then((result) => {
                if (result.isConfirmed) window.location = url;
            })
        }
    </script>

