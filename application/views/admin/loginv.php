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
									<input autofocus maxlength="25" type="text" class="form-control" name="u" id="username" placeholder="Masukan username">
									<small id="usernameHelp" class="form-text text-muted">Gunakan username yang
										terdaftar</small>
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" name="p" id="password" placeholder="Password">
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
		  const frmLogin = document.getElementById('formLogin');
		  let httpRequest;

		  document.addEventListener('DOMContentLoaded', function () {
			  // let liMenu = document.getElementById('liLogin');
			  // liMenu.classList.add('active');

			  let wrap = document.getElementById('htmlWrapper');
			  wrap.classList.add('sidebar_minimize');
			  frmLogin.addEventListener('submit', function (event) {
				  event.preventDefault()
				  prosesCek();
			  })
		  });

		  const prosesCek = () => {
			  let frmData = new FormData(frmLogin);
			  httpRequest = new XMLHttpRequest();

			  if (!httpRequest) {
				  alert("jaringan bermasalah, ulangi lagi");
				  return false;
			  }
			  httpRequest.onreadystatechange = alertContents;
			  httpRequest.open("POST", "<?=base_url()?>admin/login/proses-login?__=true", true);
			  httpRequest.send(frmData);
		  }

		  function alertContents() {
			  if (httpRequest.readyState === XMLHttpRequest.DONE) {
				  let resData = JSON.parse(httpRequest.responseText);
				  if (httpRequest.status === 200) {
					  Swal.fire({
						  icon: resData.icon,
						  title: resData.title,
						  text: resData.message,
					  }).then(() => {
						  window.location = '';
					  })
				  } else {
					  Swal.fire({
						  icon: resData.icon,
						  title: resData.title,
						  text: resData.message,
					  })
				  }
				  if (httpRequest.status === 401) {
					  // alert("Authentication gagal");
					  Swal.fire({
						  icon: resData.icon,
						  title: resData.title,
						  text: resData.message,
					  })
					  window.location = '';
				  }
			  }
		  }

	  })();
	</script>
