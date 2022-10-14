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
									<label for="n">Jabatan</label>
									<input autofocus maxlength="150" type="text" class="form-control" id="n" name="n" placeholder="Masukan Jabatan">
									<small id="n" class="form-text text-muted">Pastikan Jabatan Tidak Sama</small>
								</div>

								<div class="form-group">
									<button class="btn btn-primary" id="btnSimpan" type="submit">Simpan</button>
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
				let wrap = document.getElementById('liJabatan');
				wrap.classList.add('active');
			});
		})();
	</script>
