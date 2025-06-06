<?php

use app\modules\hocvien\models\HocVien;

?>
<li class="slide">
	<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
		
		<span class="side-menu__label"><i class="fa fa-folder"></i> Quản lý học viên</span><i class="angle fa fa-caret-right"></i>
	</a>
	<ul class="slide-menu" data-menu="hv">
		<li class="panel sidetab-menu">
			<div class="tab-menu-heading p-0 pb-2 border-0">
				<div class="tabs-menu ">
					<ul class="nav panel-tabs">
						<li><a href="#side3" class="active" data-bs-toggle="tab"><i class="bi bi-house"></i>
								<p>Home</p>
							</a></li>
						<li><a href="#side4" data-bs-toggle="tab"><i class="bi bi-box"></i>
								<p>Activity</p>
							</a></li>
					</ul>
				</div>
			</div>

			<div class="panel-body tabs-menu-body p-0 border-0">
				<div class="tab-content">
					<div class="tab-pane active" id="side3">
						<ul class="sidemenu-list">
							<li><a href="/hocvien/hv-ho-so?menu=hv4" class="slide-item" data-menu="hv4"> <i class="fe fe-file-text"></i> Hồ sơ học viên</a></li>
							<li><a href="/daotao/ke-hoach?menu=hv5" class="slide-item" data-menu="hv5"> <i class="fe fe-file-text"></i> Kế hoạch giảng dạy</a></li>
						</ul>
						<div class="menutabs-content px-0">
							<!-- menu tab here -->
						</div>
					</div>
					<div class="tab-pane" id="side4">
						<!-- activity here -->
					</div>
				</div>
			</div>
		</li>

	</ul>
</li>