<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\kholuutru\models\Ke;
/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\Ngan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ngan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ten_ngan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_ke')->dropDownList(
                    Ke::getList(), 
                     [
                         'prompt' => 'Chọn Kệ',
                         'class' => 'form-control dropdown-with-arrow',
                     ]
                ) ?>

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
.ngan-form label {
    font-weight: bold;
}
.ngan-form .form-control {
    border-color: #0000FF; 
    border-width: 1px; 
}
</style>