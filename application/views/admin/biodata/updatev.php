<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			<div class="page-header">
				<h4 class="page-title">
					<?= $body_label_content ?? "Content Default" ?>
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
						<a href="#">Biodata</a>
					</li>
					<li class="separator">
						<i class="flaticon-right-arrow"></i>
					</li>
					<li class="nav-item">
						<a href="#">Update</a>
					</li>
				</ul>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">

							<form method="post" action="<?= $rootss . 'proses_update/' . $id ?>">

								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="n">Lembaga</label>
										<select class="form-control" id="lembaga" name="lembaga" required>
											<option value="">--Pilih Lembaga--</option>
											<?= $dtLembaga ?>
										</select>
									</div>

									<div class="form-group col-md-6">
										<label for="n">Jabatan</label>
										<select class="form-control" id="jabatan" name="jabatan" required>
											<option value="">--Pilih Jabatan--</option>
											<?= $dtJabatan ?>
										</select>
									</div>
								</div>

								<div class="form-row ">
									<div class="form-group col-md-8">
										<label for="n">Nama</label>
										<input value="<?= $nam ?>" required autofocus maxlength="150" type="text" class="form-control" id="n" name="n" placeholder="Masukan Jabatan">
										<small id="n" class="form-text text-muted">Pastikan Jabatan Tidak Sama</small>
									</div>

									<div class="form-check col-md-4">
										<label>JK</label><br>
										<label class="form-radio-label">
											<input <?= $hLak ?> class="form-radio-input" type="radio" name="jk" value="Laki-Laki">
											<span class="form-radio-sign">Laki-Laki</span>
										</label>
										<label class="form-radio-label ml-3">
											<input <?= $hPer ?> class="form-radio-input" type="radio" name="jk" value="Perempuan">
											<span class="form-radio-sign">Perempuan</span>
										</label>
									</div>
								</div>

								<div class="form-row">
									<div class="form-group col-md-5">
										<label for="kel">Kelahiran</label>
										<input value="<?= $kel ?>" required type="text" class="form-control" id="kel" name="kel" placeholder="Isi Kelahiran">
										<small class="form-text text-muted">Pastikan Jabatan Tidak Sama</small>
									</div>

									<div class="form-group col-md-3">
										<label for="tgl">Tgl Lahir</label>
										<input required type="date" value="<?= date('Y-m-d') ?>" class="form-control" id="tgl" name="tgl" placeholder="Masukan Jabatan">
									</div>

									<div class="form-group col-md-4">
										<label for="nomor">Nomor Telpon (Whatsapp)</label>
										<input value="<?= $nom ?>" required maxlength="16" type="text" class="form-control" id="nomor" name="nomor" placeholder="Nomor Telpon sesuai Whatsapp">
									</div>
								</div>

								<div class="form-group">
									<label for="n">Password</label>
									<input <?= $passwordRequired ?> type="password" class="form-control" id="p" name="p" placeholder="Password masukan disini">
									<small class="form-text text-muted"><?= $passwordMessageSmall ?></small>
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
			  let wrap = document.getElementById('liBiodata');
			  wrap.classList.add('active');
		  });
	  })();
	</script>
