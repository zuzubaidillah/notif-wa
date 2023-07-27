<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="--><!--global/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="<?= base_url() ?>assets-admin/print-style.css">
    <style>
        .report_invoice_content {
            /*padding-top: 0 !important;*/
        }

        .list-group-item.active {
            background: #4D678C;
            color: white;
        }

        .page_break {
            /*page-break-after: auto;*/
            page-break-before: always;
            /*page-break-inside: auto;*/

        }

        .table > :not(caption) > * > * {
            padding: 0.1rem 0.1rem;
        }

        hr.bor {
            position: absolute;
            top: 0;
            width: 100%;
            border: none;
            height: 2px;
            background-color: black;
        }
    </style>
</head>
<body>
<div class="report_invoice">
    <div class="report_invoice_main ff-monst">
        <div class="report_invoice_content">
            <div class="report_invoice_header">
                <div class="row">
                    <div class="col-8 m-auto" style="text-align: center;letter-spacing: 8px;">
                        <h2 class="" style="font-size: 2rem; line-height: 1; color:#da251d;">
                            DATA AGENDA
                        </h2>
                    </div>
                    <!--<div class="col-12 pt-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-4 text-right font-weight-bold">Invoice</div>
                                    <div class="col-8">08111009185</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-4 font-weight-bold">Date</div>
                                    <div class="col-8">11-07-2023 09:00:00</div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
            <div class="report_invoice_isi">
                <div class="row loopresep " id="loopresep0">
                    <div class="col-12">
                        <table class="table caption-top">
                            <caption>Tanggal: <span> <?= date('m-d-Y') ?></span></caption>
                            <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 20%;">Lembaga</th>
                                <th style="width: 20%;">Pengguna</th>
                                <th style="width: 15%;">Agenda Dari</th>
                                <th style="width: 10%;">Tanggal</th>
                                <th style="width: 20%;">Keterangan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 0;
                            foreach ($data ?? [] as $item) {
                                ++$no;
                                if ($item['status'] < 0) {
                                    $formatStatus = ' <span class="text-success pl-3">selesai</span>';
                                } else {
                                    $formatStatus = ' <span class="text-warning pl-3">menunggu</span>';
                                }
                                ?>
                                <tr>
                                    <th class="align-middle" scope="row"><?= $no ?></th>
                                    <td class="align-middle" scope="row"><?= $item['nama_lembaga'] ?></td>
                                    <td class="align-middle" scope="row"><?= $item['nama_pengguna'] ?></td>
                                    <td class="align-middle" scope="row">
                                        <?= $item['dari'] ?> <br>
                                        Status: <span class=""><?= $formatStatus ?></span>
                                    </td>
                                    <td class="align-middle" scope="row"><?= $item['waktu'] ?></td>
                                    <td class="align-middle" scope="row"><?= $item['deskripsi'] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-button d-print-none">
        <button onclick="window.print()" type="button" class="btn btn-primary btn-sm">
            <span>Cetak</span>
        </button>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.min.js"></script>
<!-- <script src="vue_2.6.11_vue.min.js"></script> -->
<script>
    var a4HeightInPx = 1122; // ketinggian A4 dalam piksel
    var htmlHeight = document.body.offsetHeight;
    var numOfLines = Math.ceil(htmlHeight / a4HeightInPx);
    let jmlPageBreak = 1;
    let pageHeight = 1122; // tinggi kertas A4
    var app = new Vue({
        el: '#app', data() {
            return {
                baseUrlServer: "<?=base_url()?>",
                dataMaster: [],
            }
        },//
        computed: {},//
        async mounted() {
            await this.getData();
            document.title = `Export Data Agenda`
        },//
        methods: {
            showLoading(msg = "Sedang Mengakses Data.....") {
                swal(msg, {
                    button: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    timer: 60000
                });
            },//
            prosesWidth(data) {
                return {
                    width: `${data}%`, "vertical-align": `inherit`,
                };
            },//
            getData() {
                let params = {
                    page: 1,
                }
                const queryStringParams = Object.keys(params).map(key => `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`).join('&')

                fetch(`${this.baseUrlServer}json_cetak_cs/${this.urlIdEventOrder}?${queryStringParams}`)
                    .then(response => response.json())
                    .then(data => this.responseLaporanTransaksiKlinik(data))
                    .catch(error => console.log(error))
                return;
            }, //
            validateDateRange(startDate, endDate) {
                // Mengubah string tanggal menjadi objek Date
                let startDateObj = new Date(startDate);
                let endDateObj = new Date(endDate);

                // Membandingkan nilai tanggal
                if (startDateObj.getTime() > endDateObj.getTime()) {
                    return false; // Tanggal awal lebih besar dari tanggal akhir
                }
                return true; // Tanggal awal lebih kecil atau sama dengan tanggal akhir
            }, //
            formatDate(date, format = "Y-m-d") {
                let d = new Date(date);
                let year = d.getFullYear();
                let month = ('0' + (d.getMonth() + 1)).slice(-2);
                let day = ('0' + d.getDate()).slice(-2);
                if (format == "d-m-Y") {
                    return `${day}-${month}-${year}`;
                }
                return `${year}-${month}-${day}`;
            }, //
            checkMinus(selisih) {
                const regex = /-\d+(\.\d+)?/g;
                const result = selisih.match(regex);

                if (result) {
                    return true;
                }
                console.log('Tidak ada nilai negatif ditemukan');
                return false;
            },//
            deleteRow(index, rows) {
                rows.splice(index, 1);
            }
        }
    })
</script>
</body>
</html>
