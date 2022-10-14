<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			<div class="page-header">
				<h4 class="page-title">
					<?=$body_label_content ?? "Content Default"?>
				</h4>
				<ul class="breadcrumbs">
					<li class="nav-home">
						<a href="<?= base_url() ?>">
							<i class="flaticon-home"></i>
						</a>
					</li>
					<li class="separator">
						<i class="flaticon-right-arrow"></i>
					</li>
					<li class="nav-item">
						<a href="#">Login</a>
					</li>
					<li class="separator">
						<i class="flaticon-right-arrow"></i>
					</li>
					<li class="nav-item">
						<a href="#">Registrasi</a>
					</li>
				</ul>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6">
					<div class="card">
						<div class="card-body">

							<form id="formRegistrasi">
								<div class="form-group">
									<label for="username">Username</label>
									<input readonly maxlength="25" type="text" class="form-control" id="username" name="username" placeholder="Username dibuatkan otomatis sistem">
									<small id="usernameHelp" class="form-text text-muted">Gunakan username yang
										terdaftar</small>
								</div>
								<div class="form-group">
									<label for="nama">Nama Lengkap</label>
									<input required autofocus maxlength="150" type="text" class="form-control" id="nama" name="nama" placeholder="Masukan nama lengkap pengguna">
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input required type="password" class="form-control" id="password" name="password" placeholder="Password">
								</div>

								<div class="form-group">
									<button class="btn btn-primary" id="btnDaftarkan" type="submit">Daftarkan</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div id="htmlRes"></div>
		</div>
	</div>


	<script>
	  let coba;
	  (() => {
		  'use strict';

		  document.addEventListener('DOMContentLoaded', function () {
			  let wrap = document.getElementById('htmlWrapper');
			  wrap.classList.add('sidebar_minimize');
		  });

		  let httpRequest;
		  let regis = document.getElementById('formRegistrasi');

		  regis.addEventListener('submit', function (ev) {
			  ev.preventDefault();
			  registrasi();
		  });

		  const registrasi = () => {
			  let frmData = new FormData(regis);
			  httpRequest = new XMLHttpRequest();

			  if (!httpRequest) {
				  alert("jaringan bermasalah, ulangi lagi");
				  return false;
			  }
			  httpRequest.onreadystatechange = alertContents;
			  httpRequest.open("POST", "<?=base_url()?>admin/login/proses-registrasi?__=true", true);
			  httpRequest.send(frmData);
		  }

		  function alertContents() {
			  if (httpRequest.readyState === XMLHttpRequest.DONE) {
				  if (httpRequest.status === 200) {
					  showDetail();
				  } else {
					  alert("There was a problem with the request.");
				  }
				  if (httpRequest.status === 401) {
					  alert("Authentication gagal");
					  window.location = '';
				  }
			  }
		  }

		  function showDetail() {
			  let resData = JSON.parse(httpRequest.responseText);
			  console.log(resData, httpRequest, XMLHttpRequest)

			  let dt = {
				  username: resData.data.username,
				  nama: resData.data.nama,
				  level: resData.data.level,
			  }

			  let res = document.getElementById('htmlRes');
			  res.innerHTML = resRegistrasi('berhasil', dt);
			  document.getElementById('htmlCode').innerText = "Berhasil ";
			  document.getElementById('btnDaftarkan').remove();
		  }

		  function resRegistrasi(status, dt = {}) {
			  let body = null;
			  if (status == 'berhasil') {
				  body = `<div class="form-group">
								<label for="resUsername">Username</label>
								<input value="${dt.username}" readonly maxlength="25" type="text" class="form-control" style="font-size: 1.5rem;" id="resUsername" name="resUsername" placeholder="Username dibuatkan otomatis sistem">
								<small id="usernameHelp" class="form-text text-muted">Ingat baik baik username diatas</small>
							</div>
							<div class="form-group">
								<label for="resNama">Nama Lengkap</label>
								<input value="${dt.nama}" readonly required autofocus maxlength="150" type="text" class="form-control" id="resNama" name="resNama">
							</div>
							<div class="form-group">
								<label for="resLevel">Level</label>
								<input value="${dt.level}" readonly required type="text" class="form-control" id="resLevel" name="resLevel">
							</div>

							<div class="form-group">
								<a class="btn btn-primary" href="<?= base_url('admin/login') ?>">Login</a>
							</div>`;
			  } else {
				  body = `<div class="card-title">Ulangi Registrasi</div>`;
			  }
			  let hasil = `
			<div class="row justify-content-center">
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">
							<div class="card-title" id="htmlCode">Menunggu...</div>
						</div>
						<div class="card-body">
						${body}

						</div>
					</div>
				</div>
			</div>`;
			  return hasil;
		  }

	  })();
	</script>
