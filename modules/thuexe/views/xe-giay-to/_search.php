<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\modules\thuexe\models\XeGiayTo;
use app\modules\thuexe\models\LoaiGiayTo;
use app\modules\thuexe\models\base\XeGiayToBase;
use app\modules\thuexe\models\search\XeGiayToSearch;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\search\XeGiayToSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="xe-giay-to-search">

    <?php $form = ActiveForm::begin([
        'id' => 'myFilterForm',
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'class' => 'myFilterForm'
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-2">
            <label>Biển số xe</label>
            <?= $form->field($model, 'id_xe')->widget(Select2::classname(), [
                'data' => XeGiayTo::getListXe(),
                'options' => [
                    'placeholder' => '-- Chọn biển số xe --',
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'bsx-dropdown'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false) ?>
        </div>
        <div class="col-md-2">
            <label>Loại giấy tờ</label>
            <?= $form->field($model, 'id_loai_giay_to')->widget(Select2::classname(), [
                'data' => LoaiGiayTo::getListLoaiGiayTo(),
                'options' => [
                    'placeholder' => '-- Chọn loại giấy tờ --',
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'ldg-dropdown'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'tinh_trang_han')->dropDownList(
                XeGiayToSearch::getDmTinhTrangHan(),
                ['prompt' => '-- Tất cả --']
            )->label('Tình trạng hạn') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'is_active')->dropDownList(
                XeGiayToBase::getDmIsActive(),
                ['prompt' => '-- Tất cả --']
            )->label('Hiệu lực') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'ngay_ket_thuc')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'dd/mm/yyyy'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                ],
            ])->label('Ngày hết hạn') ?>
        </div>
        <div class="col-md-2">
            <br />
            <?= Html::submitButton('<i class="fa fa-search"></i> Tìm kiếm', ['class' => 'btn btn-primary btn-sm me-2', 'style' => 'margin-top:8px;']) ?>
            <?= Html::a('<i class="fa fa-refresh"></i> Xóa tìm kiếm', ['index'], ['class' => 'btn btn-outline-secondary btn-sm', 'data-pjax' => 1, 'style' => 'margin-top:8px;']) ?>
        </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>