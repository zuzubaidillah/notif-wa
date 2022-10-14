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
						<a href="#">Data Pengguna</a>
					</li>
				</ul>
			</div>

			<div class="row justify-content-center">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header d-flex justify-content-between">
							<div class="card-title">Data Pengguna</div>
							<div class="">
								<a class="btn btn-primary btn-sm" href="<?=$rootss.'add'?>">Add</a>
							</div>
						</div>
						<div class="card-body">

							<table class="table table-hover table-responsive-sm table-responsive-md">
								<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Data Pengguna</th>
									<th scope="col">Telpon</th>
									<th scope="col">Kelahiran</th>
									<th scope="col">Lembaga</th>
									<th scope="col">Jabatan</th>
									<th scope="col">...</th>
								</tr>
								</thead>
								<tbody id="htmlTbody">
								<?php
								if (count($dtTabel) >=1 ){
									$no = 0;
									foreach ($dtTabel as $v){
										$id = $v['id'];
										$jenis_kelamin = $v['jenis_kelamin'];
										$kelahiran = $v['kelahiran'];
										$nama = $v['nama'];
										$no_telp = $v['no_telp'];
										$tgl_lahir = $v['tgl_lahir'];
										$nama_lembaga = $v['nama_lembaga'];
										$nama_jabatan = $v['nama_jabatan'];
										$tampilUsername = ($v['password'] == '' ? "" : " <br><b>username: $id</b>");
										$bisaLogin = ($v['password'] == '' ? "Data, Tidak Bisa Login" : "Data, Bisa Login");
										?>
										<tr>
											<td><?=++$no?></td>
											<td>
												<b><?=$nama?></b> <br>
												<?=$tgl_lahir?> - <?=$jenis_kelamin?>
											</td>
											<td>
												<?=$no_telp?>
												<?=$tampilUsername?>

											</td>
											<td>
												<?=$kelahiran?> <br>
												<?=$bisaLogin?>
											</td>
											<td><?=$nama_lembaga?></td>
											<td><?=$nama_jabatan?></td>
											<td>
												<div class="d-flex justify-content-between">
													<a href="<?=$rootss.'update/'.$id?>" class="btn btn-warning btn-sm">Edit</a>
													<button class="btn btn-danger btn-sm" onclick="clickHapus('<?=$rootss.'proses_delete/'.$id?>')">Hapus</button>
												</div>
											</td>
										</tr>
										<?php
									}}else{
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
			  let liMenu = document.getElementById('liBiodata');
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

