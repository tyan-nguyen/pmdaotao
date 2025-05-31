<?php

use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\KhoaHoc;

?>
<li class="slide">
	<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
		
		<span class="side-menu__label"><i class="fa fa-folder"></i> CHỨC NĂNG</span><i class="angle fa fa-caret-right"></i>
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
							<li><a href="/daotao/ke-hoach-giao-vien?menu=hv1" class="slide-item" data-menu="hv1"> <i class="fe fe-file-text"></i> Lập kế hoạch</a></li>
							<li><a href="/daotao/ql-hoc-vien?menu=hv2" class="slide-item" data-menu="hv2"> <i class="fe fe-file-text"></i> Danh sách học viên</a></li>
							
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

<?php /* ?>
<li class="slide">
	<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
		
		<span class="side-menu__label"><i class="fa fa-folder"></i> Khóa học</span><i class="angle fa fa-caret-right"></i>
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
						
							<?php 
							     $khoaHocs = KhoaHoc::find()->all();
							     foreach ($khoaHocs as $indexKhoaHoc=>$khoaHoc){
							?>
						
							<li><a href="/giao-vien/ql-hoc-vien?khoahoc=<?= $khoaHoc->id ?>&menu=hv1<?= $khoaHoc->id ?>" class="slide-item" data-menu="hv1<?= $khoaHoc->id ?>"> <i class="fe fe-file-text"></i> <?= $khoaHoc->ten_khoa_hoc ?></a></li>
							
							<?php } ?>
							
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
<?php */ ?>