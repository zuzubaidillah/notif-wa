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
						<a href="#">Detail</a>
					</li>
				</ul>
			</div>
			<div class="row justify-content-center">

				<div class="col-md-6">
					<div class="card full-height">
						<div class="card-body">
							<div class="card-title">Data Statistik Agenda</div>
							<!--<div class="card-category">Berikut</div>-->
							<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
								<div class="px-2 pb-2 pb-md-0 text-center">
									<div id="circles-1"></div>
									<h6 class="fw-bold mt-3 mb-0">Agenda Menunggu</h6>
								</div>
								<div class="px-2 pb-2 pb-md-0 text-center">
									<div id="circles-2"></div>
									<h6 class="fw-bold mt-3 mb-0">Agenda Selesai</h6>
								</div>
								<div class="px-2 pb-2 pb-md-0 text-center">
									<div id="circles-3"></div>
									<h6 class="fw-bold mt-3 mb-0">Seluruh Kegiatan</h6>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="card">
						<div class="card-body">
							<form id="formLogin">
								<div class="form-group">
									<label for="username">Lembaga</label>
									<input style="font-size: 1.5rem;" disabled type="text" class="form-control" value="<?= $labelLembaga ?? "Seluruh lembaga" ?>">
								</div>
							</form>
						</div>
					</div>
				</div>
				<!---->
				<!--<div class="col-md-6">-->
				<!--	<div class="card full-height">-->
				<!--		<div class="card-header">-->
				<!--			<div class="card-title">Agenda yang akan datang</div>-->
				<!--		</div>-->
				<!--		<div class="card-body">-->
				<!--			<ol class="activity-feed">-->
				<!--				<li class="feed-item feed-item-secondary">-->
				<!--					<time class="date" datetime="9-25">Sep 25</time>-->
				<!--					<span class="text">Responded to need <a href="#">"Volunteer opportunity"</a></span>-->
				<!--				</li>-->
				<!--				<li class="feed-item feed-item-success">-->
				<!--					<time class="date" datetime="9-24">Sep 24</time>-->
				<!--					<span class="text">Added an interest <a href="#">"Volunteer Activities"</a></span>-->
				<!--				</li>-->
				<!--				<li class="feed-item feed-item-info">-->
				<!--					<time class="date" datetime="9-23">Sep 23</time>-->
				<!--					<span class="text">Joined the group <a href="single-group.php">"Boardsmanship Forum"</a></span>-->
				<!--				</li>-->
				<!--				<li class="feed-item feed-item-warning">-->
				<!--					<time class="date" datetime="9-21">Sep 21</time>-->
				<!--					<span class="text">Responded to need <a href="#">"In-Kind Opportunity"</a></span>-->
				<!--				</li>-->
				<!--				<li class="feed-item feed-item-danger">-->
				<!--					<time class="date" datetime="9-18">Sep 18</time>-->
				<!--					<span class="text">Created need <a href="#">"Volunteer Opportunity"</a></span>-->
				<!--				</li>-->
				<!--				<li class="feed-item">-->
				<!--					<time class="date" datetime="9-17">Sep 17</time>-->
				<!--					<span class="text">Attending the event <a href="single-event.php">"Some New Event"</a></span>-->
				<!--				</li>-->
				<!--			</ol>-->
				<!--		</div>-->
				<!--	</div>-->
				<!--</div>-->
				<!---->
			</div>
		</div>
	</div>

	<script>
	  (() => {
		  'use strict';

		  document.addEventListener('DOMContentLoaded', function () {
			  let liMenu = document.getElementById('liDashboard');
			  liMenu.classList.add('active');

			  Circles.create({
				  id: 'circles-1',
				  radius: 45,
				  value: <?=$jsHitungAgendaMenunggu ?? 0?>,
				  maxValue: <?=$jsHitungAgendaAll ?? 100?>,
				  width: 7,
				  text: <?=$jsHitungAgendaMenunggu ?? 0?>,
				  colors: ['#f1f1f1', '#FF9E27'],
				  duration: 400,
				  wrpClass: 'circles-wrp',
				  textClass: 'circles-text',
				  styleWrapper: true,
				  styleText: true
			  })

			  Circles.create({
				  id: 'circles-2',
				  radius: 45,
				  value: <?=$jsHitungAgendaSelesai ?? 0?>,
				  maxValue: <?=$jsHitungAgendaAll ?? 100?>,
				  width: 7,
				  text: <?=$jsHitungAgendaSelesai ?? 0?>,
				  colors: ['#f1f1f1', '#2BB930'],
				  duration: 400,
				  wrpClass: 'circles-wrp',
				  textClass: 'circles-text',
				  styleWrapper: true,
				  styleText: true
			  })

			  Circles.create({
				  id: 'circles-3',
				  radius: 45,
				  value: <?=$jsHitungAgendaAll ?? 0?>,
				  maxValue: <?=$jsHitungAgendaAll ?? 100?>,
				  width: 7,
				  text: <?=$jsHitungAgendaAll ?? 0?>,
				  colors: ['#f1f1f1', '#F25961'],
				  duration: 400,
				  wrpClass: 'circles-wrp',
				  textClass: 'circles-text',
				  styleWrapper: true,
				  styleText: true
			  })
		  });
	  })();
	</script>
