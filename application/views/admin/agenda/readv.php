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
							</div>
						</div>
						<div class="card-body">

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
													<a href="<?= $rootss . 'update/' . $id ?>" class="btn btn-warning btn-sm">Edit</a>
													<button class="btn btn-danger btn-sm" onclick="clickHapus('<?= $rootss . 'proses_delete/' . $id ?>')">
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
			  liMenu.classList.add('active');
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

