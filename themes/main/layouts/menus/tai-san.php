<?php

use app\modules\taisan\models\PhieuDeNghi;
use app\modules\thuexe\models\XeGiayTo;

$slChoDuyet = PhieuDeNghi::slChoDuyet();

$thongKeHanGiayTo = XeGiayTo::getThongKeHetHan();
$tongCanhBaoGiayTo = $thongKeHanGiayTo['tong'];
?>
<li class="slide">
	<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
		<!-- <span class="side-menu__icon"><i class="fa fa-graduation-cap side_menu_img"></i></span>
		<span class="side-menu__label">Khóa học</span><i class="angle fe fe-chevron-right"></i> -->
		<span class="side-menu__label"><i class="fa fa-folder"></i> TÀI SẢN
			<span class="badge bg-warning ms-2"><?= ($slChoDuyet + $tongCanhBaoGiayTo) > 0 ? ($slChoDuyet + $tongCanhBaoGiayTo) : '' ?></span>
		</span><i class="angle fa fa-caret-right"></i>
	</a>
	<ul class="slide-menu" data-menu="taisan">
		<li class="panel sidetab-menu">
			<div class="tab-menu-heading p-0 pb-2 border-0">
				<div class="tabs-menu ">
					<ul class="nav panel-tabs">
						<li><a href="#side7" class="active" data-bs-toggle="tab"><i
									class="bi bi-house"></i>
								<p>Home</p>
							</a></li>
						<li><a href="#side8" data-bs-toggle="tab"><i class="bi bi-box"></i>
								<p>Activity</p>
							</a></li>
					</ul>
				</div>
			</div>
			<div class="panel-body tabs-menu-body p-0 border-0">
				<div class="tab-content">
					<div class="tab-pane active" id="side7">
						<ul class="sidemenu-list">
							<li class="side-menu__label1"><a href="javascript:void(0)">Danh mục chức năng</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/xe/index?menu=taisan7') ?>" class="slide-item" data-menu="taisan7"><i class="fe fe-file-text"></i> Quản lý xe</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/xe-giay-to/index?menu=taisane') ?>" class="slide-item" data-menu="taisane"><i class="fe fe-file-text"></i> Quản lý giấy tờ <span class="badge bg-warning ms-2"><?= $tongCanhBaoGiayTo > 0 ? $tongCanhBaoGiayTo : '' ?></span></a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/taisan/tai-san/index?menu=taisan1') ?>" class="slide-item" data-menu="taisan1"><i class="fe fe-file-text"></i> Tài sản khác</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/taisan/phieu-de-nghi/index?menu=taisan2') ?>" class="slide-item" data-menu="taisan2"><i class="fe fe-file-text"></i> Phiếu đề nghị
									<span class="badge bg-warning ms-2"><?= $slChoDuyet > 0 ? $slChoDuyet : '' ?></span>
								</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/taisan/dm-hang-muc/index?menu=taisan3') ?>" class="slide-item" data-menu="taisan3"><i class="fe fe-file-text"></i> Hạng mục sửa chữa</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/taisan/dm-loai-hang-muc/index?menu=taisan4') ?>" class="slide-item" data-menu="taisan4"><i class="fe fe-file-text"></i> Danh mục loại hạng mục</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/taisan/dm-don-vi/index?menu=taisan6') ?>" class="slide-item" data-menu="taisan6"><i class="fe fe-file-text"></i> Danh mục đơn vị</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/taisan/dot-tong-hop/index?menu=taisan5') ?>" class="
							slide-item" data-menu="taisan5"><i class="fe fe-file-text"></i> Đợt tổng hợp</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/taisan/danh-muc-tai-san/index?menu=taisan8') ?>" class="slide-item" data-menu="taisan8"><i class="fe fe-file-text"></i> Danh mục tài sản</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/taisan/loai-tai-san/index?menu=taisan9') ?>" class="slide-item" data-menu="taisan9"><i class="fe fe-file-text"></i> Loại tài sản</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/taisan/loai-chi-tiet/index?menu=taisana') ?>" class="slide-item" data-menu="taisana"><i class="fe fe-file-text"></i> Loại chi tiết</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/taisan/nhom-chi-tiet/index?menu=taisanb') ?>" class="slide-item" data-menu="taisanb"><i class="fe fe-file-text"></i> Nhóm chi tiết</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/taisan/chi-tiet/index?menu=taisanc') ?>" class="slide-item" data-menu="taisanc"><i class="fe fe-file-text"></i> Chi tiết</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/loai-giay-to/index?menu=taisand') ?>" class="slide-item" data-menu="taisand"><i class="fe fe-file-text"></i> Loại giấy tờ xe</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/don-vi-so-huu/index?menu=taisane') ?>" class="slide-item" data-menu="taisane"><i class="fe fe-file-text"></i> Đơn vị sở hữu xe</a>
							</li>
						</ul>
						<div class="menutabs-content px-0">
							<!-- menu tab here -->
						</div>
					</div>
					<div class="tab-pane" id="side8">
						<!-- activity here -->
					</div>
				</div>
			</div>
		</li>

	</ul>
</li>