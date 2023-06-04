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
						<a href="#">Agenda</a>
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
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">

							<form method="post" action="<?= $rootss . 'proses_add' ?>">

								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="lembaga">Lembaga</label>
										<select required <?= $lembagaAttribute ?? "" ?> class="form-control"
												id="lembaga" name="lembaga">
											<option value="">--Pilih Lembaga--</option>
											<?= $dtLembaga ?>
										</select>
									</div>

									<div class="form-group col-md-6">
										<label for="n">Biodata</label>
										<select class="form-control" id="biodata" name="biodata" required>
											<?= $dtBiodata ?? "" ?>
										</select>
									</div>
								</div>

								<div class="form-row ">
									<div class="form-group col-md-8">
										<label for="dari">Dari</label>
										<input required autofocus maxlength="150" type="text" class="form-control"
											   id="dari" name="dari" placeholder="Masukan data yang sesuai">
										<small for="dari" class="form-text text-muted">Surat Masuk dari siapa?</small>
									</div>

									<div class="form-check col-md-4">
										<label>Jenis?</label><br>
										<label class="form-radio-label">
											<input class="form-radio-input" type="radio" name="jenis" value="public"
												   checked="">
											<span for="jenis" class="form-radio-sign">Public</span>
										</label>
										<label class="form-radio-label ml-3">
											<input class="form-radio-input" type="radio" name="jenis" value="private">
											<span for="jenis" class="form-radio-sign">Private</span>
										</label>
										<small class="form-text text-muted">public: data agenda akan terlihat di website
											depan</small>
									</div>
								</div>

								<div class="form-row">
									<div class="form-group col-md-5">
										<div class="form-row">
											<div class="form-group col-sm-12 col-md-6">
												<label for="tgl">Tgl Agenda</label>
												<input required type="date" value="<?= date('Y-m-d') ?>"
													   class="form-control" id="tgl" name="tgl">
											</div>
											<div class="form-group col-sm-12 col-md-6">
												<label for="tgl">Jam Agenda</label>
												<input required type="time" value="07:00" class="form-control" id="jam"
													   name="jam">
											</div>

											<div class="form-group col-md-12">
												<label for="durasi">Durasi Pengingat, Sebelum kegiatan</label>
												<input required maxlength="5" type="number" class="form-control"
													   id="durasi" name="durasi" placeholder="isikan durasi perdetik">
												<small class="form-text text-muted">*note: perjam</small>
											</div>

											<div class="form-group col-md-12">
												<button class="btn btn-primary" id="btnSimpan" type="submit">Simpan
												</button>
											</div>
										</div>
									</div>
									<div class="form-group col-md-7">

										<div class="form-group">
											<label for="keterangan">Keterangan...</label>
											<textarea rows="5" required class="form-control" id="keterangan"
													  name="keterangan"
													  placeholder="Isi deskripsi / keterangan lengkap"></textarea>
											<small class="form-text text-muted">Pastikan sejelas mungkin, ini yang akan
												di
												kirim ke biodata melalui WA.</small>
										</div>
									</div>
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
				let wrap = document.getElementById('liAgenda');
				wrap.classList.add('active');

				<?php if($this->session->userdata('session_level') != 'petugas'){?>
				const lembaga = document.getElementById('lembaga');
				lembaga.addEventListener('change', prosesCek);
				<?php } ?>
			});

			let httpRequest;
			const prosesCek = () => {

				if (lembaga.value == '') return;

				let frmData = new FormData();
				frmData.append('lembaga', lembaga.value)
				httpRequest = new XMLHttpRequest();

				if (!httpRequest) {
					alert("jaringan bermasalah, ulangi lagi");
					return false;
				}
				httpRequest.onreadystatechange = alertContents;
				httpRequest.open("POST", "<?=base_url()?>admin/agenda/biodata_filter?__=true", true);
				httpRequest.send(frmData);
			}

			function alertContents() {
				if (httpRequest.readyState === XMLHttpRequest.DONE) {
					if (httpRequest.status === 401) {
						// alert("Authentication gagal");
						Swal.fire({
							icon: resData.icon,
							title: resData.title,
							text: resData.message,
						}).then(() => {
							window.location = '';
						})
					}
					let resData = JSON.parse(httpRequest.responseText);
					if (httpRequest.status === 200) {
						document.getElementById('biodata').innerHTML = resData.data;
					} else {
						Swal.fire({
							icon: resData.icon,
							title: resData.title,
							text: resData.message,
						})
						document.getElementById('biodata').innerHTML = "";
					}
				}
			}

		})();
	</script>
