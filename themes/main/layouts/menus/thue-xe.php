<li class="slide">
	<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
		<!-- <span class="side-menu__icon"><i class="bi bi-arrow-left-right side_menu_img"></i></span>
		<span class="side-menu__label">Quản lý thuê xe</span><i class="angle fe fe-chevron-right"></i> -->
		<span class="side-menu__label"><i class="fa fa-folder"></i> Quản lý xe</span><i class="angle fa fa-caret-right"></i>
	</a>
	<ul class="slide-menu" data-menu="dc">
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
							
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/lich-thue?menu=dc6') ?>" class="slide-item" data-menu="dc6"><i class="fe fe-file-text"></i> Lên lịch thuê xe (C.Biến)</a></li>
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/xe-cam-ung?menu=dc7') ?>" class="slide-item" data-menu="dc7"><i class="fe fe-file-text"></i> K.T tình trạng xe (C.Biến)</a></li>
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/lich-thue/xe-schedule?menu=dc8&id=4') ?>" class="slide-item" data-menu="dc8"><i class="fe fe-file-text"></i> Xem lịch theo xe (C.Biến)</a></li>
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/lich-thue/loai-xe-schedule?menu=dc9&id=2') ?>" class="slide-item" data-menu="dc9"><i class="fe fe-file-text"></i> Xem lịch hạng xe (C.Biến)</a></li>
							
							<!--  <li class=""><a href="<?= Yii::getAlias('@web/thuexe/phieu-thue-xe?menu=dc4') ?>" class="slide-item" data-menu="dc4"><i class="fe fe-file-text"></i> Phiếu thuê xe</a></li>
							 -->
							<!--  <li class=""><a href="<?= Yii::getAlias('@web/thuexe/muon-xe?menu=dc5') ?>" class="slide-item" data-menu="dc5"><i class="fe fe-file-text"></i> Mượn xe</a></li> -->
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/xe?menu=dc1') ?>" class="slide-item" data-menu="dc1"><i class="fe fe-file-text"></i> Quản lý tất cả xe</a></li>
							<!--   <li class=""><a href="<?= Yii::getAlias('@web/thuexe/loai-hinh-thue?menu=dc2') ?>" class="slide-item" data-menu="dc2"><i class="fe fe-file-text"></i> Loại hình thuê</a></li> -->
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/loai-xe?menu=dc3') ?>" class="slide-item" data-menu="dc3"><i class="fe fe-file-text"></i> Loại Xe</a></li>

							
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