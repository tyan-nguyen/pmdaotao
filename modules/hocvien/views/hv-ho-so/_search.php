<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

use app\modules\hocvien\models\HangDaoTao;
use kartik\date\DatePicker;
use app\modules\user\models\User;
use app\modules\khoahoc\models\KhoaHoc;
use kartik\select2\Select2;
use app\modules\hocvien\models\DangKyHv;
use app\modules\hocvien\models\DmLienKet;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */

$initValueLienKet = '';
if ($model->id_lien_ket) {
    $lienKet = DmLienKet::findOne($model->id_lien_ket);
    $initValueLienKet = $lienKet ? $lienKet->ten_lien_ket : '';
}

?>

<div class="hoc-vien-search">

    <?php $form = ActiveForm::begin([
        'id' => 'myFilterForm',
        'method' => 'get',
        'options' => [
            'class' => 'myFilterForm'
        ]
    ]); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'gioi_tinh')->dropDownList([
                1 => 'Nam',
                0 => 'Nữ',
            ], ['prompt' => 'Chọn giới tính', 'class' => 'form-control dropdown-with-arrow']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'ngay_sinh')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày sinh  ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                ]
            ]); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
        </div>
        <!--  <div class="col-md-3">
            <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
        </div> -->
        <div class="col-md-2">
            <?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?php // $form->field($model, 'noi_dang_ky')->dropDownList(DangKyHv::getDmNoiDangKy(), ['prompt'=>'Tất cả'])->label('Nơi ĐK') 
            ?>
            <label><?= $model->getAttributeLabel('noi_dang_ky') ?></label>
            <?= $form->field($model, 'noi_dang_ky')->widget(Select2::classname(), [
                'data' => DangKyHv::getDmNoiDangKy(),
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn hạng...',
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'noi-dang-ky-search-dropdown'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '100%'
                ],
            ])->label(false); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_hang')->dropDownList(HangDaoTao::getList(), ['prompt' => 'Tất cả']) ?>
        </div>
        <!-- <div class="col-md-2">
                  <?php // $form->field($model, 'id_khoa_hoc')->dropDownList(KhoaHoc::getList(), ['prompt'=>'Tất cả']) 
                    ?>
            </div> -->

        <div class="col-md-2">
            <?php // $form->field($model, 'id_khoa_hoc')->dropDownList(KhoaHoc::getList(), ['prompt'=>'Tất cả']) 
            ?>
            <label><?= $model->getAttributeLabel('id_khoa_hoc') ?></label>
            <?= $form->field($model, 'id_khoa_hoc')->widget(Select2::classname(), [
                'data' => KhoaHoc::getList(),
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn khóa...',
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'khoa-hoc-search-dropdown'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '100%'
                ],
            ])->label(false); ?>
        </div>

        <!-- <div class="col-md-3">
                  <?= $form->field($model, 'nguoi_tao')->dropDownList(User::getList(), ['prompt' => 'Tất cả'])->label('NV tiếp nhận') ?>
            </div> -->
        <div class="col-md-1">
            <label>&nbsp;</label>
            <?= $form->field($model, 'huy_ho_so')->checkbox() ?>
        </div>

        <div class="col-md-1">
            <label>&nbsp;</label>
            <?= $form->field($model, 'co_lien_ket')->checkbox([]) ?>
        </div>
        <div class="col-md-3">
            <label>DM ĐV liên kết</label>
            <?= $form->field($model, 'id_lien_ket')->widget(Select2::classname(), [
                'initValueText' => $initValueLienKet, // This shows selected text on form load
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn dm liên kết...',
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'idLienKetSearch'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    //'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    'width' => '100%',
                    'minimumInputLength' => 0, // ← allow fetch without typing
                    'ajax' => [
                        'url' => '/hocvien/dm-lien-ket/search-dm-lien-ket',
                        'dataType' => 'json',
                        'delay' => 250,
                        /* 'data' => new JsExpression('function(params) {
                            return {q:params.term};
                        }'), */
                        'data' => new JsExpression('function(params) {
                            return {
                                q: params.term || "", // if empty input, send empty string
                            };
                        }'),
                        'processResults' => new JsExpression('function(data) {
                            return {results:data};
                        }'),
                        'cache' => true
                    ],
                ],
            ])->label(false); ?>

        </div>

    </div>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="col-md-12 text-center">
            <div class="form-group mb-0">
                <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
            </div>
        </div>
    <?php } ?>


    <?php ActiveForm::end(); ?>

</div>
<style>
    .hoc-vien-search label {
        font-weight: bold;
    }
</style>