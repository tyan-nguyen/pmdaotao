<li class="slide">
	<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
		<span class="side-menu__icon"><i class="bi bi-arrow-left-right side_menu_img"></i></span>
		<span class="side-menu__label">Quản lý thuê xe</span><i class="angle fe fe-chevron-right"></i>
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
							
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/phieu-thue-xe?menu=dc1') ?>" class="slide-item" data-menu="dc">Phiếu thuê xe</a>
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/xe?menu=dc1') ?>" class="slide-item" data-menu="dc1">Danh sách Xe</a>
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/loai-xe?menu=dc3') ?>" class="slide-item" data-menu="dc3">Loại Xe</a>
							<li class=""><a href="<?= Yii::getAlias('@web/thuexe/loai-hinh-thue?menu=dc2') ?>" class="slide-item" data-menu="dc2">Loại hình thuê</a>

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