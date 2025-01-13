<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\lichhoc\models\search\KetQuaThiSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ket-qua-thi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_hoc_vien') ?>

    <?= $form->field($model, 'id_lich_thi') ?>

    <?= $form->field($model, 'id_phan_thi') ?>

    <?= $form->field($model, 'diem_so') ?>

    <?php // echo $form->field($model, 'ket_qua') ?>

    <?php // echo $form->field($model, 'trang_thai') ?>

    <?php // echo $form->field($model, 'nguoi_tao') ?>

    <?php // echo $form->field($model, 'thoi_gian_tao') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
