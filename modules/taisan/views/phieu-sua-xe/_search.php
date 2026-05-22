<?php

use app\custom\CustomFunc;
use app\modules\taisan\models\PhieuDeNghi;
use app\modules\thuexe\models\Xe;
use app\modules\user\models\User;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

$model->ngay_bat_dau = CustomFunc::convertYMDToDMY($model->ngay_bat_dau);
$model->ngay_hoan_thanh = CustomFunc::convertYMDToDMY($model->ngay_hoan_thanh);

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
			<?= $form->field($model, 'loai_yeu_cau')->dropDownList(PhieuDeNghi::getLoaiSuaXeList(), [
				'prompt' => '- Chọn yêu cầu sửa xe -'
			]) ?>
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
			<?= $form->field($model, 'trang_thai')->dropDownList(PhieuDeNghi::getTrangThaiList(), [
				'prompt' => '- Chọn trạng thái -'
			]) ?>
		</div>

	</div>

	<?php if (!Yii::$app->request->isAjax) { ?>
		<div class="form-group mb-0 mt-3">
			<?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
		</div>
	<?php } ?>

	<?php ActiveForm::end(); ?>

</div>