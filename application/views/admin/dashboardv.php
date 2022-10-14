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
						<a href="#">Login</a>
					</li>
				</ul>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6">
					<div class="card">
						<div class="card-body">
							<form id="formLogin">
								<div class="form-group">
									<label for="username">Username</label>
									<input maxlength="25" type="text" class="form-control" name="u" id="username" placeholder="Masukan username">
									<small id="usernameHelp" class="form-text text-muted">Gunakan username yang
										terdaftar</small>
								</div>
								<div class="form-group">
									<button class="btn btn-primary" type="submit">Masuk</button>
								</div>
							</form>
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
			  let liMenu = document.getElementById('liDashboard');
			  liMenu.classList.add('active');
		  });
	  })();
	</script>
