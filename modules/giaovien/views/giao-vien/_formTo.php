<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\nhanvien\models\PhongBan;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\To */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="to-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id_phong_ban')->widget(Select2::classname(), [
                 'data' => PhongBan::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn phòng ban...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
             ]);?>
        </div>
        <div class="col-md-6">
              <?= $form->field($model, 'ten_to')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
 .to-form label {
    font-weight: bold;
}
.select2-dropdown {
    z-index: 9999 !important; 
}
</style>
