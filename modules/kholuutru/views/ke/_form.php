<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\kholuutru\models\Kho;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\Ke */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ke-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ten_ke')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_kho')->widget(Select2::classname(), [
                 'data' => Kho::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn kho...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    ],
             ]);?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
    .dropdown-with-arrow {
    position: relative;
    padding-right: 30px; /* Đảm bảo có khoảng trống cho mũi tên */
}

.dropdown-with-arrow:after {
    content: "\f078"; /* Font Awesome chevron-down */
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    pointer-events: none;
}
.dropdown-with-arrow {
    position: relative;
    padding-right: 30px;
    appearance: none; /* Loại bỏ mũi tên mặc định */
    background: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24"%3E%3Cpath d="M7 10l5 5 5-5z"%3E%3C/path%3E%3C/svg%3E') no-repeat right 10px center;
    background-size: 12px;
}
.ke-form label {
    font-weight: bold;
}
.ke-form .form-control {
    border-color: #0000FF; 
    border-width: 1px; 
}
.select2-container {
        width: 100% !important;  
        display: block;
    }
</style>