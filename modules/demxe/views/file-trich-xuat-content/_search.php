<?php

use app\modules\demxe\models\DemXe;
use kartik\date\DatePicker;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\demxe\models\FileTrichXuatContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-trich-xuat-content-search">

	<?php $form = ActiveForm::begin([
		'id' => 'myFilterForm',
		'method' => 'get',
		'options' => [
			'class' => 'myFilterForm'
		]
	]); ?>
	<div class="row">
		<div class="col-md-1">
			<?= $form->field($model, 'id_file')->textInput() ?>
		</div>
		<div class="col-md-3">
			<?= $form->field($model, 'camera')->dropDownList(DemXe::getDmCong(), ['prompt' => 'Tất cả ...']) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'ma_xe')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'bien_so_xe')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-2">
			<label>Thời gian</label>
			<?= $form->field($model, 'thoi_gian')->widget(DatePicker::classname(), [
				'options' => [
					'placeholder' => 'Chọn ngày  ...',
					'autocomplete' => 'off'
				],
				'pluginOptions' => [
					'autoclose' => true,
					'format' => 'dd/mm/yyyy',
					'zIndexOffset' => '9999',
					'todayHighlight' => true,
					'todayBtn' => true
				]
			])->label(false); ?>
		</div>
		<div class="col-md-2">
			<br />
			<div style="margin-top:5px">
				<?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
				<?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
			</div>
		</div>
	</div>

	<?php ActiveForm::end(); ?>

</div>