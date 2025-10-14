<?php

use app\modules\hocvien\models\HocVien;

?>
<li class="slide">
	<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">		
		<span class="side-menu__label"><i class="fa fa-folder"></i> Đăng ký - Học phí</span><i class="angle fa fa-caret-right"></i>
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
							<li><a href="/hocvien/thong-ke/tong-hop?menu=hv8" class="slide-item" data-menu="hv8"> <i class="fe fe-file-text"></i>Thống kê - Công nợ</a></li>
							<li><a href="/hocvien/thong-ke/luu-luong?menu=hv2" class="slide-item" data-menu="hv2"> <i class="fe fe-file-text"></i> Thống kê lưu lượng <span class="badge bg-warning">New</span></a></li> 
							<li><a href="/hocvien/dang-ky-hv?menu=hv1" class="slide-item" data-menu="hv1"> <i class="fe fe-file-text"></i> Học viên đăng ký</a></li>
							<li><a href="/hocvien/dang-ky-hv/hoc-vien-doi-hang?menu=hv9&sort=-thoi_gian_thay_doi" class="slide-item" data-menu="hv9"> <i class="fe fe-file-text"></i> Học viên đổi hạng</a></li>
							<li><a href="/hocvien/hoc-phi/phieu-thu?menu=hv6" class="slide-item" data-menu="hv6"> <i class="fe fe-file-text"></i> Phiếu thu</a></li>
							<li><a href="/hocvien/hoc-phi/phieu-chi?menu=hv7" class="slide-item" data-menu="hv7"> <i class="fe fe-file-text"></i> Phiếu chi</a></li>
							<li><a href="/hocvien/hv-ho-so?menu=hv4" class="slide-item" data-menu="hv4"> <i class="fe fe-file-text"></i> Hồ sơ học viên</a></li>
							<li><a href="/hocvien/hv-thue?menu=hv5" class="slide-item" data-menu="hv5"> <i class="fe fe-file-text"></i> Hồ sơ thuế</a></li>
							<!-- <li><a href="/hocvien/hoc-vien?menu=hv2" class="slide-item" data-menu="hv2"> <i class="fe fe-file-text"></i> Danh sách học viên</a></li> -->
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