<?php

use app\modules\hocvien\models\HocVien;

?>
<li class="slide">
	<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
		
		<span class="side-menu__label"><i class="fa fa-folder-o"></i> Quản lý học viên</span><i class="angle fa fa-caret-right"></i>
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
							<li class="side-menu__label1"><a href="javascript:void(0)">Danh mục chức năng</a></li>
							<li><a href="/hocvien/dang-ky-hv?menu=hv1" class="slide-item" data-menu="hv1"> <i class="fe fe-file-text"></i> Học viên đăng ký</a></li>
							<li><a href="/hocvien/hoc-vien?menu=hv2" class="slide-item" data-menu="hv2"> <i class="fe fe-file-text"></i> Danh sách học viên</a></li>
							<li><a href="/kholuutru/loai-file/index?doiTuong=<?= HocVien::MODEL_ID ?>&menu=hv3" class="slide-item" data-menu="hv3"> <i class="fe fe-file-text"></i> Loại hồ sơ</a></li>
							
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