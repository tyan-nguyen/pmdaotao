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
							<li class="side-menu__label1"><a href="javascript:void(0)">Danh mục chức năng</a></li>
							<li><a href="/hocvien/hv-thue?menu=hv5" class="slide-item" data-menu="hv5"> <i class="fe fe-file-text"></i> Hồ sơ học viên</a></li>
							<li><a href="/hocvien/hoc-phi/phieu-thu?menu=hv6" class="slide-item" data-menu="hv6"> <i class="fe fe-file-text"></i> Phiếu thu</a></li>
							<li><a href="/hocvien/hoc-phi/phieu-chi?menu=hv7" class="slide-item" data-menu="hv7"> <i class="fe fe-file-text"></i> Phiếu chi</a></li>

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

<li class="slide">
	<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
		<!-- <span class="side-menu__icon"><i class="fe fe-users side_menu_img"></i></span>
		<span class="side-menu__label">Quản lý giáo viên</span><i class="angle fe fe-chevron-right"></i> -->
		<span class="side-menu__label"><i class="fa fa-folder"></i> Quản lý bán hàng</span><i class="angle fa fa-caret-right"></i>
	</a>
	<ul class="slide-menu" data-menu="bh">
		<li class="panel sidetab-menu">
			<div class="tab-menu-heading p-0 pb-2 border-0">
				<div class="tabs-menu ">
					<ul class="nav panel-tabs">
						<li><a href="#side5" class="active" data-bs-toggle="tab"><i
									class="bi bi-house"></i>
								<p>Home</p>
							</a></li>
						<li><a href="#side6" data-bs-toggle="tab"><i class="bi bi-box"></i>
								<p>Activity</p>
							</a></li>
					</ul>
				</div>
			</div>
			<div class="panel-body tabs-menu-body p-0 border-0">
				<div class="tab-content">
					<div class="tab-pane active" id="side5">
						<ul class="sidemenu-list">
							<li class="side-menu__label1"><a href="javascript:void(0)">Danh mục chức năng</a>
							</li>
							<li><a href="<?= Yii::getAlias('@web/banhang/hoa-don-ban-hang?menu=bh5') ?>" class="slide-item" data-menu="bh5"><i class="fe fe-file-text"></i> Bán hàng</a></li>
							<li><a href="<?= Yii::getAlias('@web/banhang/hang-hoa?menu=bh3') ?>" class="slide-item" data-menu="bh3"><i class="fe fe-file-text"></i> Hàng hóa</a></li>
							<li><a href="<?= Yii::getAlias('@web/banhang/nha-cung-cap?menu=bh1') ?>" class="slide-item" data-menu="bh1"><i class="fe fe-file-text"></i> Nhà cung cấp</a></li>
							<li><a href="<?= Yii::getAlias('@web/banhang/loai-hang-hoa?menu=bh2') ?>" class="slide-item" data-menu="bh2"><i class="fe fe-file-text"></i> Loại hàng hóa</a></li>
							<li><a href="<?= Yii::getAlias('@web/banhang/dvt?menu=bh4') ?>" class="slide-item" data-menu="bh4"><i class="fe fe-file-text"></i> Đơn vị tính</a></li>
							<li><a href="<?= Yii::getAlias('@web/banhang/khach-hang?menu=bh6') ?>" class="slide-item" data-menu="bh6"><i class="fe fe-file-text"></i> Khách hàng</a></li>
							<li><a href="<?= Yii::getAlias('@web/banhang/loai-khach-hang?menu=bh7') ?>" class="slide-item" data-menu="bh7"><i class="fe fe-file-text"></i> Loại khách hàng</a></li>
						</ul>
						<div class="menutabs-content px-0">
							<!-- menu tab here -->
						</div>
					</div>
					<div class="tab-pane" id="side6">
						<!-- activity here -->
					</div>
				</div>
			</div>
		</li>

	</ul>
</li>