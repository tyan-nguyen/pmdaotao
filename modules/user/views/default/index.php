<?php

use app\modules\user\models\Dashboard;
use yii\bootstrap5\Modal;
use cangak\ajaxcrud\CrudAsset;
use app\modules\user\models\User;
use app\modules\daotao\models\HinhAnh;

Yii::$app->params['showTopSearch'] = false;
Yii::$app->params['moduleID'] = 'Home';
Yii::$app->params['modelID'] = 'Dashboard';
CrudAsset::register($this);
$dash = new Dashboard();
?>

<?php Modal::begin([
	'options' => [
		'id' => 'ajaxCrudModal',
		'tabindex' => false // important for Select2 to work properly
	],
	'dialogOptions' => ['class' => 'modal-xl'],
	'headerOptions' => ['class' => 'text-primary'],
	'titleOptions' => ['class' => 'text-primary'],
	'closeButton' => ['label' => '<span aria-hidden=\'true\'>×</span>'],
	'id' => 'ajaxCrudModal',
	'footer' => '', // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>

<?php if (User::hasRole('nGiaoVien', false)): ?>
	<?php
	$userModel = User::findOne(Yii::$app->user->id);
	$idGiaoVien = ($userModel && method_exists($userModel, 'getIdGiaoVien')) ? $userModel->getIdGiaoVien() : null;
	$hinhAnhDi = null;
	$hinhAnhVe = null;
	if ($idGiaoVien) {
		$hinhAnhDi = HinhAnh::find()
			->where([
				'id_giao_vien' => $idGiaoVien,
				'date' => date('Y-m-d'),
				'loai' => HinhAnh::LOAI_KEHOACH,
				'luot' => HinhAnh::LUOT_DI
			])
			->orderBy(['id' => SORT_DESC])
			->one();
		$hinhAnhVe = HinhAnh::find()
			->where([
				'id_giao_vien' => $idGiaoVien,
				'date' => date('Y-m-d'),
				'loai' => HinhAnh::LOAI_KEHOACH,
				'luot' => HinhAnh::LUOT_VE
			])
			->orderBy(['id' => SORT_DESC])
			->one();
	}
	?>
	<div class="row">
		<!-- Khối Chụp ảnh đi -->
		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<?php if (empty($hinhAnhDi)): ?>
							<div class="text-center mb-2 text-primary"><i class="ion-camera"></i></div>
							<div class="item-box-wrap">
								<h5 class="mb-2">
									<a href="/daotao/cham-cong-anh?loai=KEHOACH&luot=DI">Chụp ảnh đi</a>
								</h5>
								<p class="text-muted mb-0">Hình ảnh xe đi</p>
							</div>
						<?php else: ?>
							<div class="text-center mb-2 text-success"><i class="fa fa-check-circle fs-3"></i></div>
							<div class="item-box-wrap">
								<h5 class="mb-2">
									<a href="javascript:void(0);" class="text-success fw-bold" onclick="showHinhAnhPopup('<?= $hinhAnhDi->getUrlAnh() ?>')">Đã chấm công đi</a>
								</h5>
								<p class="text-muted mb-0">
									<a href="/daotao/cham-cong-anh?loai=KEHOACH&luot=DI" class="text-primary"><i class="fa fa-camera me-1" style="font-size:12px"></i> Chụp ảnh lại</a>
								</p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Khối Chụp ảnh về -->
		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<?php if (empty($hinhAnhVe)): ?>
							<div class="text-center mb-2 text-primary"><i class="ion-camera"></i></div>
							<div class="item-box-wrap">
								<h5 class="mb-2">
									<a href="/daotao/cham-cong-anh?loai=KEHOACH&luot=VE">Chụp ảnh về</a>
								</h5>
								<p class="text-muted mb-0">Hình ảnh xe về</p>
							</div>
						<?php else: ?>
							<div class="text-center mb-2 text-success"><i class="fa fa-check-circle fs-3"></i></div>
							<div class="item-box-wrap">
								<h5 class="mb-2">
									<a href="javascript:void(0);" class="text-success fw-bold" onclick="showHinhAnhPopup('<?= $hinhAnhVe->getUrlAnh() ?>')">Đã chấm công về</a>
								</h5>
								<p class="text-muted mb-0">
									<a href="/daotao/cham-cong-anh?loai=KEHOACH&luot=VE" class="text-primary"><i class="fa fa-camera me-1" style="font-size:12px"></i>Chụp ảnh lại</a>
								</p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<!--<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center text-primary mb-2"><i class="fa fa-users"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/daotao/ql-hoc-vien?menu=hv2">Danh sách học viên</a>
							</h5>
							<p class="text-muted mb-0">Danh sách học viên phụ trách</p>
						</div>
					</div>
				</div>
			</div>
		</div>-->

		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center mb-2 text-primary"><i class="fa fa-calendar-check-o"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/daotao/ke-hoach-giao-vien?menu=hv1">Kế hoạch giảng dạy</a>
							</h5>
							<p class="text-muted mb-0">Sắp xếp lịch học thực hành</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center mb-2 text-primary"><i class="fa fa-calendar-check-o"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/thuexe/lich-dung-xe?menu=hv3">Đăng ký lịch sử dụng xe</a>
							</h5>
							<p class="text-muted mb-0">Đăng ký lịch sử dụng xe</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center mb-2 text-primary"><i class="fa fa-user-circle-o"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/user/auth/change-own-password">Đổi mật khẩu</a>
							</h5>
							<p class="text-muted mb-0">Thay đổi mật khẩu</p>
						</div>
					</div>
				</div>
			</div>
		</div>-->

	</div>
<?php elseif (User::hasRole('nToThueXe', false)): ?>
	<div class="row">
		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center text-primary mb-2"><i class="ion-model-s"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/thuexe/lich-thue/xe-schedule?menu=ttx1&id=4">Lịch theo xe</a>
							</h5>
							<p class="text-muted mb-0">Xem lịch thuê theo từng xe cụ thể</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center mb-2 text-primary"><i class="fa fa-bars"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/thuexe/lich-thue/index-public?menu=ttx4">Danh sách hôm nay</a>
							</h5>
							<p class="text-muted mb-0">Xem danh sách thuê xe hôm nay</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center mb-2 text-primary"><i class="fa fa-calendar"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/thuexe/lich-thue/loai-xe-schedule-by-columns?menu=ttx3&id=2">Lịch (theo cột)</a>
							</h5>
							<p class="text-muted mb-0">Xem lịch thuê tổng hợp theo hạng xe</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center mb-2 text-primary"><i class="fa fa-user-circle-o"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/user/auth/change-own-password">Đổi mật khẩu</a>
							</h5>
							<p class="text-muted mb-0">Thay đổi mật khẩu</p>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
<?php elseif (User::hasRole('nThue', false)): ?>
	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
		<div class="card custom-card service">
			<div class="card-body">
				<div class="item-box text-center">
					<div class=" text-center mb-2 text-primary"><i class="fa fa-user-circle-o"></i>
					</div>
					<div class="item-box-wrap">
						<h5 class="mb-2">
							<a href="/user/auth/change-own-password">Đổi mật khẩu</a>
						</h5>
						<p class="text-muted mb-0">Thay đổi mật khẩu</p>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php elseif (User::hasRole('nDaoTao', false)): ?>
	<div class="row">
		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center text-primary mb-2"><i class="fa fa-users"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/taisan/phieu-sua-xe/index?menu=dksdx2">PHIẾU SỬA XE</a>
							</h5>
							<p class="text-muted mb-0">Đăng ký sửa xe, bảo dưỡng</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center text-primary mb-2"><i class="fa fa-users"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/hocvien/hv-ho-so?menu=hv4">QUẢN LÝ HỌC VIÊN</a>
							</h5>
							<p class="text-muted mb-0">Quản lý thông tin học viên,
								học phí</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center mb-2 text-primary"><i class="fa fa-calendar-check-o"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/daotao/ke-hoach?menu=hv5">KẾ HOẠCH DẠY</a>
							</h5>
							<p class="text-muted mb-0">Sắp xếp lịch học thực hành GV-HV</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center mb-2 text-primary"><i class="fa fa-user-circle-o"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/user/auth/change-own-password">ĐỔI MẬT KHẨU</a>
							</h5>
							<p class="text-muted mb-0">Thay đổi mật khẩu</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php elseif (User::hasRole('nXem', false)): ?>
	<div class="row">
		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center text-primary mb-2"><i class="fa fa-users"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/hocvien/hv-ho-so?menu=thongke4">Quản lý học viên</a>
							</h5>
							<p class="text-muted mb-0">Quản lý thông tin học viên, khóa học, hạng đào tạo</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center mb-2 text-primary"><i class="fa fa-users"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/hocvien/thong-ke/thong-ke-ho-so-moi?menu=thongke1">Thống kê học viên đăng ký mới</a>
							</h5>
							<p class="text-muted mb-0">Xem thống kê số lượng học viên đăng ký theo ngày</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center mb-2 text-primary"><i class="fa fa-user-circle-o"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/user/auth/change-own-password">Đổi mật khẩu</a>
							</h5>
							<p class="text-muted mb-0">Thay đổi mật khẩu</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="row">

		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center mb-2 text-primary"><i class="fa fa-line-chart"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/hocvien/thong-ke/tong-hop?menu=hv8">Thống kê - Công nợ</a>
							</h5>
							<p class="text-muted mb-0">Thống kê học viên, công nợ</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center text-primary mb-2"><i class="fa fa-users"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/hocvien/dang-ky-hv?menu=hv1">Quản lý học viên đăng ký</a>
							</h5>
							<p class="text-muted mb-0">Quản lý thông tin học viên,
								học phí</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center text-primary mb-2"><i class="fa fa-file-text-o"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/hocvien/hoc-phi/phieu-thu?menu=hv6">Quản lý phiếu thu</a>
							</h5>
							<p class="text-muted mb-0">Quản lý phiếu thu tiền học phí</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
			<div class="card custom-card service">
				<div class="card-body">
					<div class="item-box text-center">
						<div class=" text-center mb-2 text-primary"><i class="fa fa-calendar-check-o"></i>
						</div>
						<div class="item-box-wrap">
							<h5 class="mb-2">
								<a href="/daotao/ke-hoach?menu=dt5">Kế hoạch giảng dạy</a>
							</h5>
							<p class="text-muted mb-0">Sắp xếp lịch học thực hành GV-HV</p>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
<?php endif; ?>

<div class="row">
	<div class="col-sm-12">
		<div class="card custom-card">
			<div class="card-body" style="width: 100%; height:450px">
				<img src="/libs/images/anhtruonglai.jpg" alt="img" style="width: 100%; height: 100%; object-fit: cover;">
			</div>
		</div>
	</div>
</div>

<!-- Modal Popup xem hình ảnh chấm công -->
<div class="modal fade" id="hinhAnhPopupModal" tabindex="-1" aria-labelledby="hinhAnhPopupModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header d-flex justify-content-between align-items-center">
				<h5 class="modal-title m-0" id="hinhAnhPopupModalLabel"><i class="fa fa-image me-2 text-primary"></i>Hình ảnh đã chấm công</h5>
				<button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Đóng">&times;</button>
			</div>
			<div class="modal-body text-center p-3">
				<img id="popup-hinh-anh-img" src="" class="img-fluid rounded shadow" alt="Hình ảnh chấm công" style="max-height: 75vh;">
			</div>
		</div>
	</div>
</div>

<script>
	function showHinhAnhPopup(imgUrl) {
		if (!imgUrl) return;
		document.getElementById('popup-hinh-anh-img').src = imgUrl;
		var modalEl = document.getElementById('hinhAnhPopupModal');
		var myModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
		myModal.show();
	}
</script>