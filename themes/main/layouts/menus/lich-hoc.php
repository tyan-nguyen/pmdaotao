<li class="slide">
	<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
		<!-- <span class="side-menu__icon"><i class="bi bi-arrow-left-right side_menu_img"></i></span>
		<span class="side-menu__label">Quản lý thuê xe</span><i class="angle fe fe-chevron-right"></i> -->
		<span class="side-menu__label"><i class="fa fa-folder"></i> Quản lý lịch học/thi</span><i class="angle fa fa-caret-right"></i>
	</a>
	<ul class="slide-menu" data-menu="lh">
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

							<li class=""><a href="<?= Yii::getAlias('@web/lichhoc/lich-hoc?menu=lh1') ?>" class="slide-item" data-menu="lh1"><i class="fe fe-file-text"></i> Sắp lịch học</a>

							<li class=""><a href="<?= Yii::getAlias('@web/lichhoc/lich-thi?menu=lh3') ?>" class="slide-item" data-menu="lh3"><i class="fe fe-file-text"></i> Sắp lịch thi</a>

							<li class=""><a href="<?= Yii::getAlias('@web/lichhoc/phan-thi?menu=lh4') ?>" class="slide-item" data-menu="lh4"><i class="fe fe-file-text"></i> Cài đặt phần thi</a>
                              
							<li class=""><a href="<?= Yii::getAlias('@web/lichhoc/phong-hoc?menu=lh2') ?>" class="slide-item" data-menu="lh2"><i class="fe fe-file-text"></i> Phòng học</a>
							
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