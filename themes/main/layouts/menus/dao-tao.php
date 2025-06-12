<?php

use app\modules\hocvien\models\HocVien;

?>
<li class="slide">
	<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
		
		<span class="side-menu__label"><i class="fa fa-folder"></i> Quản lý đào tạo</span><i class="angle fa fa-caret-right"></i>
	</a>
	<ul class="slide-menu" data-menu="dt">
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
							<li><a href="/daotao/ke-hoach?menu=dt5" class="slide-item" data-menu="dt5"> <i class="fe fe-file-text"></i> Kế hoạch giảng dạy</a></li>							
							<li><a href="/hocvien/hoc-vien?menu=dt2" class="slide-item" data-menu="dt2"> <i class="fe fe-file-text"></i> Quản lý học viên</a></li>
							<li><a href="/giaovien/giao-vien?menu=dt6" class="slide-item" data-menu="dt6"> <i class="fe fe-file-text"></i> Quản lý giáo viên</a></li>
							<li><a href="/thuexe/xe?menu=dt3" class="slide-item" data-menu="dt3"> <i class="fe fe-file-text"></i> Quản lý xe</a></li>
							<li><a href="/daotao/mon-hoc?menu=dt4" class="slide-item" data-menu="dt4"> <i class="fe fe-file-text"></i> Module học</a></li>
							<li><a href="/daotao/thoi-gian?menu=dt1" class="slide-item" data-menu="dt1"> <i class="fe fe-file-text"></i> Thời gian</a></li>
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