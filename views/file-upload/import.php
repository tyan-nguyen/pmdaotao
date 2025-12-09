<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Import file từ camera đếm xe';
?>

<div class="card border-default" id="divFilterExtend">
	<div class="card-header rounded-bottom-0 card-header text-dark" id="simple">
		<h5 class="mt-2"><i class="fe fe-file"></i> Import Excel</h5>
	</div>
	<div class="card-body">
		<div class="expanel expanel-default">
			<div class="expanel-body">
				<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>    
                <?= $form->field($model, 'file')->fileInput() ?>                
                <?= Html::submitButton('Import', ['class' => 'btn btn-primary']) ?>                
                <?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>