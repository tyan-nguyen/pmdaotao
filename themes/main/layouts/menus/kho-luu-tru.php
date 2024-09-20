<li class="slide">
	<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
		<span class="side-menu__icon"><i class="fe fe-folder side_menu_img"></i></span>
		<span class="side-menu__label">Danh mục kho</span><i class="angle fe fe-chevron-right"></i>
	</a>
	<ul class="slide-menu" data-menu="klt">
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
							<li class=""><a href="<?= Yii::getAlias('@web/kholuutru/luu-kho?menu=kho') ?>" class="slide-item" data-menu="kho">Kho lưu trữ</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/kholuutru/kho?menu=kho') ?>" class="slide-item" data-menu="kho">Danh sách Kho</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/kholuutru/ke?menu=kho') ?>" class="slide-item" data-menu="kho">Danh sách Kệ</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/kholuutru/ngan?menu=kho') ?>" class="slide-item" data-menu="kho">Danh sách Ngăn</a>
							</li>
							<li class=""><a href="<?= Yii::getAlias('@web/kholuutru/hop?menu=kho') ?>" class="slide-item" data-menu="kho"> Danh sách Hộp</a>
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