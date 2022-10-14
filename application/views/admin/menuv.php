<?php if ($this->session->userdata('session_id')) { ?>
	<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
		<li class="nav-item toggle-nav-search hidden-caret">
			<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
				<i class="fa fa-search"></i>
			</a>
		</li>
		<li class="nav-item dropdown hidden-caret">
			<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
				<div class="avatar-sm">
					<img src="<?= base_url() ?>assets-admin/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
				</div>
			</a>
			<ul class="dropdown-menu dropdown-user animated fadeIn">
				<div class="dropdown-user-scroll scrollbar-outer">
					<li>
						<div class="user-box">
							<div class="avatar-lg">
								<img src="<?= base_url() ?>assets-admin/img/profile.jpg" alt="image profile" class="avatar-img rounded">
							</div>
							<div class="u-text">
								<h4><?= $this->session->userdata('session_namafull') ?></h4>
								<p class="text-muted"><?= $this->session->userdata('session_level') ?></p>
							</div>
						</div>
					</li>
					<li>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" id="mnlogout" href="#">Logout</a>
					</li>
				</div>
			</ul>
		</li>
	</ul>
<?php } ?>

</div>
</nav>
<!-- End Navbar -->
</div>
<!-- Sidebar -->
<div class="sidebar sidebar-style-2">

	<div class="sidebar-wrapper scrollbar scrollbar-inner">
		<div class="sidebar-content">

			<?php if ($this->session->userdata('session_id')) { ?>
				<div class="user">
					<div class="avatar-sm float-left mr-2">
						<img src="<?= base_url() ?>assets-admin/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
					</div>
					<div class="info">
						<a data-toggle="collapse" href="#collapseExample" aria-expanded="true" title="<?= $this->session->userdata('session_namafull') ?>">
								<span>
									<?= substr($this->session->userdata('session_namafull'), 0, 20) ?>
									<span class="user-level"><?= $this->session->userdata('session_level') ?></span>
								</span>
						</a>
						<div class="clearfix"></div>
					</div>
				</div>
			<?php } ?>

			<ul class="nav nav-primary">
				<?php
				$aksesPetugas = ['liJabatan', 'liDashboard', 'liAgenda','liBiodata'];
				foreach (dtMenu() as $k) {
					if (!$k['isShow']) continue;
					if ($k['jenisMenu'] == 'public') continue;
					if (!$this->session->userdata('session_id')) {
						continue;
					}

					$sessionLevel = $this->session->userdata('session_level');
					if ($sessionLevel == 'petugas') {
						if (!in_array($k['idMenuLi'], $aksesPetugas)) {
							continue;
						}
					}
					?>
					<li class="nav-item" id="<?= $k['idMenuLi'] ?>">
						<a href="<?= $k['url'] ?>">
							<i class="fas <?= $k['icon'] ?>"></i>
							<p><?= $k['nama'] ?></p>
						</a>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
	</div>
</div>
