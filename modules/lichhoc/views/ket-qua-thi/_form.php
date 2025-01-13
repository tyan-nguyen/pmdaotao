<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\lichhoc\models\KetQuaThi $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ket-qua-thi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_hoc_vien')->textInput() ?>

    <?= $form->field($model, 'id_lich_thi')->textInput() ?>

    <?= $form->field($model, 'id_phan_thi')->textInput() ?>

    <?= $form->field($model, 'diem_so')->textInput() ?>

    <?= $form->field($model, 'ket_qua')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trang_thai')->textInput() ?>

    <?= $form->field($model, 'nguoi_tao')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
