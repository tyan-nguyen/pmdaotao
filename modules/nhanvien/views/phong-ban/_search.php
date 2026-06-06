<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\PhongBan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phong-ban-search">

    <?php $form = ActiveForm::begin([
        'id' => 'myFilterForm',
        'method' => 'post',
        'options' => [
            'class' => 'myFilterForm'
        ]
    ]); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'ten_phong_ban')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>