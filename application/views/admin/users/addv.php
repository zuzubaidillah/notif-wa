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
						<a href="#">Tambah</a>
					</li>
				</ul>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6">
					<div class="card">
						<div class="card-body">
							
							<form method="post" action="<?=$rootss.'proses_add'?>">
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
			
		</div>
	</div>
	
	
	<script>
		let coba;
		(() => {
			'use strict';

			document.addEventListener('DOMContentLoaded', function () {
				let wrap = document.getElementById('liAkses');
				wrap.classList.add('active');
			});
		})();
	</script>
