<?php

use app\modules\khoahoc\models\NhomHangDaoTao;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\khoahoc\models\HangDaoTao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hang-dao-tao-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class='row'>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'id_nhom_hang')->dropDownList(NhomHangDaoTao::getList(), [
                'prompt' => '-Chọn-'
            ]) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'ma_hang')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'check_phan_hang')->dropDownList(
                [
                    'MOTO' => 'Mô tô',
                    'OTO' => 'Ô tô',
                ],
                [
                    'prompt' => 'Chọn phân hạng',
                    'id' => 'hoc-phan-dropdown',
                ]
            ) ?>
        </div>

        <div class="col-md-5">
            <?= $form->field($model, 'ten_hang')->textInput(['maxlength' => true]) ?>
        </div>




        <div class="col-md-6">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 3]) ?>
        </div>






    </div>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
<style>
    .hang-dao-tao-form label {
        font-weight: bold;
    }
</style>