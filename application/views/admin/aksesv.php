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
						<a href="#">Data Akses</a>
					</li>
				</ul>
			</div>

			<div class="row justify-content-center">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header d-flex justify-content-between">
							<div class="card-title">Data Akses</div>
							<div class="card-title"><a href="/">Refresh DB</a></div>
						</div>
						<div class="card-body">

							<table class="table table-hover">
								<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Username</th>
									<th scope="col">Nama</th>
									<th scope="col">Level</th>
								</tr>
								</thead>
								<tbody id="htmlTbody">
								<?php

								?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<?php

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
			  let liMenu = document.getElementById('liAkses');
			  liMenu.classList.add('active');
		  });
	  })();
	</script>
