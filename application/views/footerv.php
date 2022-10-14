<footer class="footer">
	<div class="container-fluid">
		<nav class="pull-left">
			<ul class="nav">

				<li class="nav-item">
					<a class="nav-link" href="<?=$labels['admin-panel']['footerKiriLink']?>">
						<?= $labels['admin-panel']['footerKiri']?>
					</a>
				</li>

			</ul>
		</nav>
		<div class="copyright ml-auto">
			<?= $labels['admin-panel']['footerKananTahun'] ?? "Footer 2022 Default"; ?>, made with <i class="fa fa-heart heart text-danger"></i> by <a href="https://www.themekita.com"><?= $labels['admin-panel']['footerKananBy'] ?? "Footer Apps Default"; ?></a>
		</div>
	</div>
</footer>
</div>
</div>

<!--   Core JS Files   -->
<script src="<?=base_url()?>assets-admin/js/core/jquery.3.2.1.min.js"></script>
<script src="<?=base_url()?>assets-admin/js/core/popper.min.js"></script>
<script src="<?=base_url()?>assets-admin/js/core/bootstrap.min.js"></script>
<!-- jQuery UI -->
<script src="<?=base_url()?>assets-admin/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="<?=base_url()?>assets-admin/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="<?=base_url()?>assets-admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<!-- Atlantis JS -->
<script src="<?=base_url()?>assets-admin/js/atlantis.min.js"></script>
<!-- Atlantis DEMO methods, don't include it in your project! -->
<script src="<?=base_url()?>assets-admin/js/setting-demo2.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
echo $this->session->flashdata('notifikasi');
?>
<script>
	document.addEventListener('DOMContentLoaded', function() {

		// kondisi ketika menu login ditekan maka muncul pertanyaan
		const btnLogOut = document.getElementById('mnlogout');
		btnLogOut.addEventListener('click', function() {
			Swal.fire({
				title: 'Keluar dari sistem?',
				text: "Sesi akan dihilangkan, mengakibatkan harus login lagi.",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya...LogOut'
			}).then((result) => {
				if (result.isConfirmed) window.location = "<?= base_url('admin/logout') ?>";
			})
		})
	})
</script>
</body>
</html>
