<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\hocvien\models\DmNhanHoSoHo;

/* @var $this yii\web\View */
/* @var $model app\modules\hocvien\models\DmNhanHoSoHo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-lien-ket-search">

	<?php $form = ActiveForm::begin([
		'id' => 'myFilterForm',
		'method' => 'post',
		'options' => [
			'class' => 'myFilterForm'
		]
	]); ?>
	<div class="row">
		<div class="col-md-2">
			<?= $form->field($model, 'loai_don_vi')->dropDownList(DmNhanHoSoHo::getDmNhanHoSo(), ['prompt' => 'Tất cả']) ?>
		</div>
		<div class="col-md-3">
			<?= $form->field($model, 'ten_don_vi')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-3">
			<?= $form->field($model, 'ghi_chu')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-4">
			<label>&nbsp;</label>
			<p>
				<?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
				<?= Html::resetButton('Xóa TK', ['class' => 'btn btn-outline-secondary']) ?>
			</p>
		</div>
	</div>


	<?php ActiveForm::end(); ?>

</div>