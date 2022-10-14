
</div>
</nav>
<!-- End Navbar -->
</div>
<!-- Sidebar -->

<div class="sidebar sidebar-style-2">

		<div class="sidebar-wrapper scrollbar scrollbar-inner">
			<div class="sidebar-content">
				<ul class="nav nav-primary">
					<?php
					foreach (dtMenu() as $k){
						if (!$k['isShow']) continue;
						if ($k['jenisMenu'] == 'admin-panel') continue;
						if ($this->session->userdata('session_id')) {
							if ($k['idMenuLi'] == 'liLogin') continue;
						}else{
							if ($k['idMenuLi'] == 'liDashboard') continue;
						}
					?>
					<li class="nav-item">
						<a href="<?=$k['url']?>">
							<i class="fas <?=$k['icon']?>"></i>
							<p><?=$k['nama']?></p>
						</a>
					</li>
					<?php
					}
					?>
				</ul>
			</div>
		</div>
	</div>
