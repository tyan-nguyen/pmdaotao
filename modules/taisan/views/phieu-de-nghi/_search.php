<?php

use app\custom\CustomFunc;
use app\modules\banhang\models\HoaDon;
use app\modules\taisan\models\DmDonVi;
use app\modules\taisan\models\PhieuDeNghi;
use app\modules\thuexe\models\Xe;
use app\modules\user\models\User;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

$model->ngay_bat_dau = CustomFunc::convertYMDToDMY($model->ngay_bat_dau);
$model->ngay_hoan_thanh = CustomFunc::convertYMDToDMY($model->ngay_hoan_thanh);
$model->ngay_thanh_toan = CustomFunc::convertYMDToDMY($model->ngay_thanh_toan); //ymd his nhưng theo search là Y-m-d

/* @var $this yii\web\View */
/* @var $model app\modules\taisan\models\PhieuDeNghi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phieu-de-nghi-search">

	<?php $form = ActiveForm::begin([
		'id' => 'myFilterForm',
		'method' => 'get',
		'options' => [
			'class' => 'myFilterForm'
		]
	]); ?>

	<div class="row">
		<div class="col-md-2">
			<?= $form->field($model, 'id_dot_tong_hop')->textInput() ?>
		</div>

		<div class="col-md-2">
			<?= $form->field($model, 'loai_phieu')->widget(Select2::class, [
				'data' =>  PhieuDeNghi::getLoaiPhieuList(),
				'language' => 'vi',
				'options' => [
					'placeholder' => 'Chọn loại phiếu...',
					'class' => 'form-control dropdown-with-arrow',
					'id' => 'idLoaiPhieu-search'
				],
				'pluginOptions' => [
					'allowClear' => true,
					'width' => '100%'
				],
			]); ?>
		</div>

		<div class="col-md-2">
			<?= $form->field($model, 'loai_tai_san')->widget(Select2::class, [
				'data' =>  PhieuDeNghi::getLoaiTaiSanList(),
				'language' => 'vi',
				'options' => [
					'placeholder' => 'Chọn loại tài sản...',
					'class' => 'form-control dropdown-with-arrow',
					'id' => 'idLoaiTaiSan-search'
				],
				'pluginOptions' => [
					'allowClear' => true,
					'width' => '100%'
				],
			]); ?>
		</div>

		<div class="col-md-2">
			<?= $form->field($model, 'id_tham_chieu')->widget(Select2::classname(), [
				'data' =>  Xe::getListAll(),
				'language' => 'vi',
				'options' => [
					'placeholder' => 'Chọn xe...',
					'id' => 'xe-dropdown'
				],
				'pluginOptions' => [
					'allowClear' => true,
					'width' => '100%'
				],
			]); ?>
		</div>

		<div class="col-md-2">
			<?= $form->field($model, 'nguoi_de_nghi')->widget(Select2::classname(), [
				'data' =>  User::getList(),
				'language' => 'vi',
				'options' => [
					'placeholder' => 'Chọn người đề nghị...',
					'id' => 'nguoi-de-nghi-dropdown'
				],
				'pluginOptions' => [
					'allowClear' => true,
					'width' => '100%'
				],
			]); ?>
		</div>

		<div class="col-md-2">

			<?= $form->field($model, 'loai_yeu_cau')->widget(Select2::class, [
				'data' =>  PhieuDeNghi::getLoaiSuaXeList(),
				'language' => 'vi',
				'options' => [
					'placeholder' => 'Chọn loại yêu cầu...',
					'class' => 'form-control dropdown-with-arrow',
					'id' => 'idLoaiYeuCau-search'
				],
				'pluginOptions' => [
					'allowClear' => true,
					'width' => '100%'
				],
			]); ?>
		</div>

		<!-- 
		<div class="col-md-1">
			<label>Có chi tiết</label>
			<?= $form->field($model, 'phieu_co_chi_tiet')->checkbox(['label' => false]) ?>
		</div> -->

		<div class="col-md-2">
			<?= $form->field($model, 'ngay_bat_dau')->widget(DatePicker::classname(), [
				'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete' => 'off'],
				'pluginOptions' => [
					'autoclose' => true,
					'format' => 'dd/mm/yyyy',
					'todayHighlight' => true,
					'todayBtn' => true
				]
			]) ?>
		</div>

		<div class="col-md-2">
			<?= $form->field($model, 'ngay_hoan_thanh')->widget(DatePicker::classname(), [
				'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete' => 'off'],
				'pluginOptions' => [
					'autoclose' => true,
					'format' => 'dd/mm/yyyy',
					'todayHighlight' => true,
					'todayBtn' => true
				]
			]) ?>
		</div>

		<div class="col-md-2">
			<?= $form->field($model, 'trang_thai')->widget(Select2::class, [
				'data' =>  PhieuDeNghi::getTrangThaiList(),
				'language' => 'vi',
				'options' => [
					'placeholder' => 'Chọn trạng thái...',
					'class' => 'form-control dropdown-with-arrow',
					'id' => 'idTrangThai-search'
				],
				'pluginOptions' => [
					'allowClear' => true,
					'width' => '100%'
				],
			]); ?>
		</div>

		<div class="col-md-2">
			<?= $form->field($model, 'nguoi_duyet')->widget(Select2::classname(), [
				'data' =>  User::getListUserDuyetKeHoach(),
				'language' => 'vi',
				'options' => [
					'placeholder' => 'Chọn người duyệt...',
					'id' => 'nguoi-duyet-dropdown'
				],
				'pluginOptions' => [
					'allowClear' => true,
					'width' => '100%'
				],
			]); ?>
		</div>

		<div class="col-md-2">
			<?= $form->field($model, 'ngay_duyet')->widget(DatePicker::classname(), [
				'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete' => 'off'],
				'pluginOptions' => [
					'autoclose' => true,
					'format' => 'dd/mm/yyyy',
					'todayHighlight' => true,
					'todayBtn' => true
				]
			]) ?>
		</div>

		<div class="col-md-2">
			<?= $form->field($model, 'ghi_chu_duyet')->textInput() ?>
		</div>

		<div class="col-md-2">
			<?= $form->field($model, 'da_thanh_toan')->widget(Select2::class, [
				'data' =>  [1 => 'Đã thanh toán', 0 => 'Chưa thanh toán'],
				'language' => 'vi',
				'options' => [
					'placeholder' => 'Chọn...',
					'class' => 'form-control dropdown-with-arrow',
					'id' => 'idDaThanhToan-search'
				],
				'pluginOptions' => [
					'allowClear' => true,
					'width' => '100%'
				],
			]); ?>
		</div>

		<div class="col-md-2">
			<?= $form->field($model, 'hinh_thuc_thanh_toan')->widget(Select2::class, [
				'data' =>  HoaDon::getDmHinhThucThanhToan(),
				'language' => 'vi',
				'options' => [
					'placeholder' => 'Chọn TM/CK...',
					'class' => 'form-control dropdown-with-arrow',
					'id' => 'idHinhThucThanhToan-search'
				],
				'pluginOptions' => [
					'allowClear' => true,
					'width' => '100%'
				],
			]); ?>
		</div>

		<div class="col-md-2">
			<?= $form->field($model, 'ngay_thanh_toan')->widget(DatePicker::classname(), [
				'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete' => 'off'],
				'pluginOptions' => [
					'autoclose' => true,
					'format' => 'dd/mm/yyyy',
					'todayHighlight' => true,
					'todayBtn' => true
				]
			]) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'id_don_vi_thuc_hien')->widget(Select2::class, [
				'data' =>  DmDonVi::getList(),
				'language' => 'vi',
				'options' => [
					'placeholder' => 'Chọn đơn vị...',
					'class' => 'form-control dropdown-with-arrow',
					'id' => 'idDonViThucHien-search'
				],
				'pluginOptions' => [
					'allowClear' => true,
					'width' => '100%'
				],
			]); ?>
		</div>
		<div class="col-md-4">
			<br />
			<?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm', ['class' => 'btn btn-primary', 'style' => 'margin-top:5px']) ?>
			<?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary', 'style' => 'margin-top:5px']) ?>
		</div>

	</div>

	<?php ActiveForm::end(); ?>

</div>