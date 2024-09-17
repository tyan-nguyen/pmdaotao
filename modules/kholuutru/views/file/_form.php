<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\kholuutru\models\LoaiFile;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\File */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'loai_file')->dropDownList(LoaiFile::getAllByDoiTuongArr($model->doi_tuong), [
   	        'prompt' => '-Chọn loại file-'
   	    ])?>

    <?= $form->field($model, 'file_name')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'file_type')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'file_size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file_display_name')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'nguoi_tao')->textInput() ?>

    <?php // $form->field($model, 'thoi_gian_tao')->textInput() ?>

    <?php // $form->field($model, 'doi_tuong')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'id_doi_tuong')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>