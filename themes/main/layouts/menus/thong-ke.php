<?php

use app\modules\hocvien\models\HocVien;

?>
<li class="slide">
	<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">		
		<span class="side-menu__label"><i class="fa fa-folder"></i> Tổng hợp - Thống kê</span><i class="angle fa fa-caret-right"></i>
	</a>
	<ul class="slide-menu" data-menu="thongke">
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
							<!-- <li><a href="/hocvien/thong-ke/luu-luong?menu=thongke4" class="slide-item" data-menu="thongke4"> <i class="fe fe-file-text"></i> Thống kê lưu lượng <span class="badge bg-warning">New</span></a></li> -->
							<li><a href="/hocvien/hv-ho-so/index-simple?menu=thongke5" class="slide-item" data-menu="thongke5"> <i class="fe fe-file-text"></i> Hồ sơ học viên</a></li>
							<li><a href="/hocvien/hv-ho-so?menu=thongke4" class="slide-item" data-menu="thongke4"> <i class="fe fe-file-text"></i> Hồ sơ học viên</a></li>
							<li><a href="/hocvien/thong-ke/thong-ke-ho-so-moi?menu=thongke1" class="slide-item" data-menu="thongke1"> <i class="fe fe-file-text"></i>Thống kê đăng ký mới</a></li>
							<li><a href="/hocvien/thong-ke/thong-ke-thu-tien?menu=thongke2" class="slide-item" data-menu="thongke2"> <i class="fe fe-file-text"></i> Thống kê thu tiền</a></li> 
							<li><a href="/hocvien/thong-ke/thong-ke-cong-no?menu=thongke3" class="slide-item" data-menu="thongke3"> <i class="fe fe-file-text"></i> Công nợ</a></li>
							
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