<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\hocvien\models\HangDaoTao;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\widgets\CardWidget;
use kartik\select2\Select2;
use app\modules\hocvien\models\DangKyHv;
use app\modules\user\models\User;
use app\modules\danhmuc\models\DmTinh;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
/* @var $form yii\widgets\ActiveForm */

$this->registerCssFile('@web/css/dkHocVien.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);
?>
<?php
$model->ngay_sinh = CustomFunc::convertYMDToDMY($model->ngay_sinh);
$model->ngay_het_han_cccd = CustomFunc::convertYMDToDMY($model->ngay_het_han_cccd);
$model->ngay_cap_cmnd = CustomFunc::convertYMDToDMY($model->ngay_cap_cmnd);
$model->ngay_nhan_ao = CustomFunc::convertYMDToDMY($model->ngay_nhan_ao);
$model->ngay_nhan_tai_lieu = CustomFunc::convertYMDToDMY($model->ngay_nhan_tai_lieu);
$model->ngay_tt_gplx = CustomFunc::convertYMDToDMY($model->ngay_tt_gplx);
$model->ngay_cap_gplx = CustomFunc::convertYMDToDMY($model->ngay_cap_gplx);
$model->ngay_hh_gplx = CustomFunc::convertYMDToDMY($model->ngay_hh_gplx);

if ($model->isNewRecord) {
    $user = User::getCurrentUser();
    if ($user->noi_dang_ky) {
        $model->noi_dang_ky = $user->noi_dang_ky;
    }
}

$initValueXa = '';
if ($model->id_xa) {
    $initValueXa = $model->xa ? $model->xa->tenXaWithTinh : '';
}
$initValueLienKet = '';
if ($model->id_lien_ket > 0) {
    $initValueLienKet = $model->lienKet ? $model->lienKet->ten_lien_ket : '';
} else {
    $model->id_lien_ket = '';
}
$initValueNhanHoSoHo = '';
if ($model->id_nhan_ho_so_ho > 0) {
    $initValueNhanHoSoHo = $model->nhanHoSoHo ? $model->nhanHoSoHo->ten_don_vi : '';
} else {
    $model->id_nhan_ho_so_ho = '';
}
?>

<style>
    .form-select {
        color: var(--color) !important;
    }
</style>

<div class="hv-hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>

    <?php CardWidget::begin(['title' => 'Thông tin cá nhân học viên']) ?>
    <div class='row'>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1 col-md-6">
            <?= $form->field($model, 'gioi_tinh')->dropDownList([
                1 => 'Nam',
                0 => 'Nữ',
            ], ['prompt' => 'Chọn giới tính', 'class' => 'form-control dropdown-with-arrow']) ?>
        </div>

        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ngay_sinh')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày sinh  ...', 'autocomplete' => 'off'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                    'todayBtn' => true
                ]
            ]); ?>
        </div>
        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3 col-md-6">
            <label><?= $model->getAttributeLabel('id_lien_ket') ?></label>
            <?= $form->field($model, 'id_lien_ket')->widget(Select2::classname(), [
                'initValueText' => $initValueLienKet, // This shows selected text on form load
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn dm liên kết...',
                    'class' => 'form-control',
                    'id' => 'idLienKet'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal .modal-body")'),
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
        <?php if (!$model->id_xa && !$model->isNewRecord) { ?>
            <div class="col-lg-12 col-md-12">
                <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
            </div>
        <?php } else { ?>
            <div class="col-lg-4 col-md-6">
                <?= $form->field($model, 'dia_chi_chi_tiet')->textInput(['maxlength' => true])->label('Địa chỉ (số nhà, ấp, khóm...)') ?>
            </div>
            <div class="col-md-4">
                <label>Xã/phường</label>
                <?= $form->field($model, 'id_xa')->widget(Select2::classname(), [
                    'initValueText' => $initValueXa, // This shows selected text on form load
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Chọn xã/phường...',
                        'class' => 'form-control',
                        'id' => 'xa-dropdown'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal .modal-body")'),
                        'width' => '100%',
                        'minimumInputLength' => 0, // ← allow fetch without typing
                        'ajax' => [
                            'url' => '/danhmuc/dvhc/search-xa',
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
            <div class="col-md-4">
                <label>Tỉnh/thành</label>
                <?= $form->field($model, 'id_tinh')->widget(Select2::classname(), [
                    'data' => DmTinh::getList(),
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Chọn tỉnh/thành...',
                        'id' => 'tinh-dropdown'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal .modal-body")'),
                        'width' => '100%'
                    ],
                ])->label(false); ?>
            </div>
        <?php } //end if id_xa
        ?>

        <div class="col-lg-2 col-md-4">
            <?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3 col-md-4">
            <?= $form->field($model, 'ngay_cap_cmnd')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete' => 'off'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                    'todayBtn' => true
                ]
            ]); ?>
        </div>
        <div class="col-lg-2 col-md-4">
            <?= $form->field($model, 'noi_cap_cmnd')->dropDownList(
                DangKyHv::getDmNoiCapCccd(),
                ['prompt' => 'Chọn nơi cấp...']
            ) ?>
        </div>
        <div class="col-lg-3 col-md-4">
            <?= $form->field($model, 'ngay_het_han_cccd')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete' => 'off'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                    'todayBtn' => true
                ]
            ]); ?>
        </div>

        <div class="col-lg-2 col-md-4">
            <?= $form->field($model, 'noi_dang_ky')->dropDownList(
                DangKyHv::getDmNoiDangKy(),
                ['prompt' => '- Nơi đăng ký -']
            ) ?>
        </div>

    </div>

    <!--
    <div class="row">
        <div class="col-lg-3 col-md-4">
            <?= $form->field($model, 'hang_gplx_da_co')->dropDownList(
                [
                    'Mới' => [
                        'A.01' => 'A.01',
                        'A.02' => 'A.02',
                        'A.03' => 'A.03',
                        'A.04' => 'A.04',
                        'A1m' => 'A1m',
                        'Am' => 'Am',
                        'B' => 'B',
                        'B.01' => 'B.01',
                        'B.02' => 'B.02',
                        'B.03' => 'B.03',
                        'B.04' => 'B.04',
                        'B.05' => 'B.05',
                        'B1m' => 'B1m',
                        'BE' => 'BE',
                        'C1' => 'C1',
                        'C1E' => 'C1E',
                        'CE' => 'CE',
                        'Cm' => 'Cm',
                        'D1' => 'D1',
                        'D1E' => 'D1E',
                        'D2' => 'D2',
                        'D2E' => 'D2E',
                        'DE' => 'DE',
                        'Dm' => 'Dm',
                    ],
                    'Cũ' => [
                        'A1' => 'A1',
                        'A2' => 'A2',
                        'A3' => 'A3',
                        'B1' => 'B1',
                        'B11' => 'B11',
                        'B12' => 'B12',
                        'B13' => 'B13',
                        'B14' => 'B14',
                        'B15' => 'B15',
                        'B2' => 'B2',
                        'C' => 'C',
                        'D' => 'D',
                        'E' => 'E',
                        'FB2' => 'FB2',
                        'FC' => 'FC',
                        'FD' => 'FD',
                        'FE' => 'FE',
                    ]
                ],
                ['prompt' => 'Hạng GPLX đã có...']
            ) ?>
        </div>
        <div class="col-lg-3 col-md-4">
            <?= $form->field($model, 'so_gplx_da_co')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3 col-md-4">
            <?= $form->field($model, 'ngay_cap_gplx')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete' => 'off'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                    'todayBtn' => true
                ]
            ]); ?>
        </div>
        <div class="col-lg-3 col-md-4">
            <?= $form->field($model, 'ngay_hh_gplx')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete' => 'off'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                    'todayBtn' => true
                ]
            ]); ?>
        </div>
        <div class="col-lg-3 col-md-4">
            <?= $form->field($model, 'ngay_tt_gplx')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete' => 'off'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                    'todayBtn' => true
                ]
            ]); ?>
        </div>
        <div class="col-lg-3 col-md-4">
            <?= $form->field($model, 'don_vi_cap_gplx')->dropDownList(
                DangKyHv::getDmNoiCapGplx(),
                ['prompt' => 'Chọn nơi cấp...']
            ) ?>
        </div>
    </div> -->

    <?php CardWidget::end() ?>

    <?php CardWidget::begin(['title' => 'Thông tin hạng đào tạo']) ?>
    <div class='row'>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'id_hang')->dropDownList(
                HangDaoTao::getList(),
                [
                    'prompt' => 'Chọn hạng',
                    'class' => 'form-control dropdown-with-arrow',
                    // 'disabled' => !$model->isNewRecord,
                ]
            ) ?>
            <?php /* !$model->isNewRecord ? Html::activeHiddenInput($model, 'id_hang') : '' */
            ?>
        </div>
        <div class="col-lg-3 col-md-6">
            <label><?= $model->getAttributeLabel('id_khoa_hoc') ?></label>
            <?= $form->field($model, 'id_khoa_hoc')->widget(Select2::classname(), [
                'data' => !empty($model->id_khoa_hoc) ? [
                    $model->id_khoa_hoc => \app\modules\khoahoc\models\KhoaHoc::findOne($model->id_khoa_hoc)->ten_khoa_hoc
                ] : /* \app\modules\khoahoc\models\KhoaHoc::getList(1) */ \app\modules\khoahoc\models\KhoaHoc::getListWithParent(1), //an khoa hoc da du hoc vien
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn Khóa học...',
                    'class' => 'form-control',
                    'id' => 'khoa-hoc-dropdown'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal .modal-body")'),
                    'width' => '100%'
                ],
            ])->label(false); ?>
        </div>
        <div class="col-lg-3 col-md-6">
            <label><?= $model->getAttributeLabel('id_nhan_ho_so_ho') ?></label>
            <?= $form->field($model, 'id_nhan_ho_so_ho')->widget(Select2::classname(), [
                'initValueText' => $initValueNhanHoSoHo, // This shows selected text on form load
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn dm nhận hs hộ...',
                    'class' => 'form-control',
                    'id' => 'idNhanHoSoHo'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal .modal-body")'),
                    'width' => '100%',
                    'minimumInputLength' => 0, // ← allow fetch without typing
                    'ajax' => [
                        'url' => '/hocvien/dm-nhan-ho-so-ho/search-dm-nhan-ho-so-ho',
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
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 1, 'style' => 'width:100%']) ?>
        </div>
        <!-- 
    <div class="col-lg-3 col-md-6">
        <?= $form->field($model, 'label')->dropDownList(
            ['VOUCHERT11' => 'VOUCHERT11'],
            [
                'prompt' => '--Không có---',
                'class' => 'form-control dropdown-with-arrow',
            ]
        )->label('Voucher T11 3 triệu') ?>
    </div> -->


    </div>
    <?php CardWidget::end() ?>

    <?php CardWidget::begin(['title' => 'Thông tin Giấy phép lái xe đã có']) ?>
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end align-items-center mb-3">
                <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-gplx">
                    <i class="fa fa-plus"></i> Thêm giấy phép lái xe đã có
                </button>
            </div>

            <?php
            $existingGplxs = !$model->isNewRecord ? $model->hocVienGplxs : [];
            ?>

            <?php if (!empty($existingGplxs)): ?>
                <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered table-hover align-middle text-center mb-0" id="tbl-existing-gplx">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;">STT</th>
                                <th style="width: 120px;">Hạng GPLX</th>
                                <th style="width: 140px;">Số GPLX</th>
                                <th style="width: 130px;">Ngày cấp</th>
                                <th style="width: 130px;">Ngày T.tuyển</th>
                                <th style="width: 130px;">Ngày hết hạn</th>
                                <th>Nơi cấp</th>
                                <th style="width: 60px;">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($existingGplxs as $idx => $gplx): ?>
                                <tr id="gplx-exist-row-<?= $gplx->id ?>">
                                    <td><?= $idx + 1 ?></td>
                                    <td>
                                        <?= Html::dropDownList("HocVienGplx[{$gplx->id}][hang_gplx]", $gplx->hang_gplx, [
                                            'Mới' => [
                                                'A.01' => 'A.01',
                                                'A.02' => 'A.02',
                                                'A.03' => 'A.03',
                                                'A.04' => 'A.04',
                                                'A1m' => 'A1m',
                                                'Am' => 'Am',
                                                'B' => 'B',
                                                'B.01' => 'B.01',
                                                'B.02' => 'B.02',
                                                'B.03' => 'B.03',
                                                'B.04' => 'B.04',
                                                'B.05' => 'B.05',
                                                'B1m' => 'B1m',
                                                'BE' => 'BE',
                                                'C1' => 'C1',
                                                'C1E' => 'C1E',
                                                'CE' => 'CE',
                                                'Cm' => 'Cm',
                                                'D1' => 'D1',
                                                'D1E' => 'D1E',
                                                'D2' => 'D2',
                                                'D2E' => 'D2E',
                                                'DE' => 'DE',
                                                'Dm' => 'Dm',
                                            ],
                                            'Cũ' => [
                                                'A1' => 'A1',
                                                'A2' => 'A2',
                                                'A3' => 'A3',
                                                'B1' => 'B1',
                                                'B11' => 'B11',
                                                'B12' => 'B12',
                                                'B13' => 'B13',
                                                'B14' => 'B14',
                                                'B15' => 'B15',
                                                'B2' => 'B2',
                                                'C' => 'C',
                                                'D' => 'D',
                                                'E' => 'E',
                                                'FB2' => 'FB2',
                                                'FC' => 'FC',
                                                'FD' => 'FD',
                                                'FE' => 'FE',
                                            ]
                                        ], ['class' => 'form-select form-select-sm', 'prompt' => 'Chọn hạng...']) ?>
                                    </td>
                                    <td>
                                        <input type="text" name="HocVienGplx[<?= $gplx->id ?>][so_gplx]" value="<?= Html::encode($gplx->so_gplx) ?>" class="form-control form-control-sm text-center" placeholder="Số GPLX...">
                                    </td>
                                    <td>
                                        <input type="text" name="HocVienGplx[<?= $gplx->id ?>][ngay_cap_gplx]" value="<?= CustomFunc::convertYMDToDMY($gplx->ngay_cap_gplx) ?>" class="form-control form-control-sm text-center date-input-gplx" placeholder="dd/mm/yyyy" autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="text" name="HocVienGplx[<?= $gplx->id ?>][ngay_tt_gplx]" value="<?= CustomFunc::convertYMDToDMY($gplx->ngay_tt_gplx) ?>" class="form-control form-control-sm text-center date-input-gplx" placeholder="dd/mm/yyyy" autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="text" name="HocVienGplx[<?= $gplx->id ?>][ngay_hh_gplx]" value="<?= CustomFunc::convertYMDToDMY($gplx->ngay_hh_gplx) ?>" class="form-control form-control-sm text-center date-input-gplx" placeholder="dd/mm/yyyy" autocomplete="off">
                                    </td>
                                    <td>
                                        <?= Html::dropDownList("HocVienGplx[{$gplx->id}][don_vi_cap_gplx]", $gplx->don_vi_cap_gplx, DangKyHv::getDmNoiCapGplx(), ['class' => 'form-select form-select-sm', 'prompt' => 'Chọn nơi cấp...']) ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-existing-gplx" data-id="<?= $gplx->id ?>" title="Xóa giấy này">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <!-- Container cho dòng GPLX thêm mới động -->
            <div id="gplx-dynamic-container"></div>
        </div>
    </div>
    <?php CardWidget::end() ?>

    <?php CardWidget::begin(['title' => 'Thông tin nhận đồng phục/tài liệu']) ?>
    <div class='row'>
        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'da_nhan_ao')->checkbox([
                'disabled' => (bool)$model->da_nhan_ao,
            ]) ?>
        </div>
        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'size')->dropDownList(
                [
                    'S' => 'Size S',
                    'M' => 'Size M',
                    'L' => 'Size L',
                    'XL' => 'Size XL',
                    '2XL' => 'Size 2XL',
                    '3XL' => 'Size 3XL',
                    '4XL' => 'Size 4XL'
                ],
                [
                    'prompt' => 'Chọn size áo',
                    'class' => 'form-control dropdown-with-arrow',
                    'disabled' => (bool)$model->da_nhan_ao,
                ]
            ) ?>
        </div>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ngay_nhan_ao')->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder' => 'Chọn ngày  ...',
                    'autocomplete' => 'off',
                    'disabled' => (bool)$model->da_nhan_ao
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                    'todayBtn' => true
                ]
            ]); ?>
        </div>

        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'da_nhan_tai_lieu')->checkbox([
                'disabled' => (bool)$model->da_nhan_tai_lieu,
            ]) ?>
        </div>

        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ngay_nhan_tai_lieu')->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder' => 'Chọn ngày  ...',
                    'autocomplete' => 'off',
                    'disabled' => (bool)$model->da_nhan_tai_lieu,
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                    'todayBtn' => true
                ]
            ]); ?>
        </div>

    </div>
    <?php CardWidget::end() ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton(
                $model->isNewRecord ? 'Create' : 'Update',
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
            ) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>

<?php
$hangGplxSelectTemplate = Html::dropDownList(
    'HocVienGplx[INDEX_KEY][hang_gplx]',
    null,
    [
        'Mới' => [
            'A.01' => 'A.01',
            'A.02' => 'A.02',
            'A.03' => 'A.03',
            'A.04' => 'A.04',
            'A1m' => 'A1m',
            'Am' => 'Am',
            'B' => 'B',
            'B.01' => 'B.01',
            'B.02' => 'B.02',
            'B.03' => 'B.03',
            'B.04' => 'B.04',
            'B.05' => 'B.05',
            'B1m' => 'B1m',
            'BE' => 'BE',
            'C1' => 'C1',
            'C1E' => 'C1E',
            'CE' => 'CE',
            'Cm' => 'Cm',
            'D1' => 'D1',
            'D1E' => 'D1E',
            'D2' => 'D2',
            'D2E' => 'D2E',
            'DE' => 'DE',
            'Dm' => 'Dm',
        ],
        'Cũ' => [
            'A1' => 'A1',
            'A2' => 'A2',
            'A3' => 'A3',
            'B1' => 'B1',
            'B11' => 'B11',
            'B12' => 'B12',
            'B13' => 'B13',
            'B14' => 'B14',
            'B15' => 'B15',
            'B2' => 'B2',
            'C' => 'C',
            'D' => 'D',
            'E' => 'E',
            'FB2' => 'FB2',
            'FC' => 'FC',
            'FD' => 'FD',
            'FE' => 'FE',
        ]
    ],
    ['class' => 'form-select form-select-sm', 'prompt' => 'Chọn hạng...']
);

$donViCapGplxSelectTemplate = Html::dropDownList(
    'HocVienGplx[INDEX_KEY][don_vi_cap_gplx]',
    null,
    DangKyHv::getDmNoiCapGplx(),
    ['class' => 'form-select form-select-sm', 'prompt' => 'Chọn nơi cấp...']
);
?>

<script>
    $('#xa-dropdown').on("select2:select", function(e) {
        if (this.value != '') {
            $.ajax({
                url: '/danhmuc/dvhc/get-tinh-by-xa',
                type: 'POST',
                data: {
                    idxa: this.value
                },
                success: function(response) {
                    var newValue = response.value; // giá trị trả về để gán vào select2
                    var option = new Option(response.text, newValue, true, true);
                    $('#tinh-dropdown').append(option).trigger('change');
                }
            });
        } else {
            $('#tinh-dropdown').val(null).trigger('change');
        }
    });
    $('#xa-dropdown').on('select2:clear', function(e) {
        $('#tinh-dropdown').val(null).trigger('change');
    });

    /* --- Logic Quản lý GPLX Động --- */
    var gplxCounter = 0;
    var hangGplxTpl = <?= json_encode($hangGplxSelectTemplate) ?>;
    var donViCapTpl = <?= json_encode($donViCapGplxSelectTemplate) ?>;

    $(document).off('click', '#btn-add-gplx').on('click', '#btn-add-gplx', function() {
        gplxCounter++;
        var key = 'new_' + gplxCounter;
        var hangSelect = hangGplxTpl.replace(/INDEX_KEY/g, key);
        var donViSelect = donViCapTpl.replace(/INDEX_KEY/g, key);

        var html = '<div class="card card-body bg-light border p-2 mb-2 gplx-dynamic-item" id="gplx-item-' + key + '">' +
            '<div class="d-flex justify-content-between align-items-center mb-2">' +
            '<span class="fw-bold text-primary small"><i class="fa fa-id-card text-success me-1"></i> Thêm mới GPLX số #' + gplxCounter + '</span>' +
            '<button type="button" class="btn btn-sm btn-link text-danger p-0 btn-remove-dynamic-gplx" data-target="#gplx-item-' + key + '">' +
            '<i class="fa fa-times-circle"></i> Xóa dòng' +
            '</button>' +
            '</div>' +
            '<div class="row g-2">' +
            '<div class="col-lg-2 col-md-4">' +
            '<label class="form-label small mb-1">Hạng GPLX</label>' +
            hangSelect +
            '</div>' +
            '<div class="col-lg-2 col-md-4">' +
            '<label class="form-label small mb-1">Số GPLX</label>' +
            '<input type="text" name="HocVienGplx[' + key + '][so_gplx]" class="form-control form-control-sm" placeholder="Nhập số GPLX...">' +
            '</div>' +
            '<div class="col-lg-2 col-md-4">' +
            '<label class="form-label small mb-1">Ngày cấp</label>' +
            '<input type="text" name="HocVienGplx[' + key + '][ngay_cap_gplx]" class="form-control form-control-sm date-input-gplx" placeholder="dd/mm/yyyy" autocomplete="off">' +
            '</div>' +
            '<div class="col-lg-2 col-md-4">' +
            '<label class="form-label small mb-1">Ngày trúng tuyển</label>' +
            '<input type="text" name="HocVienGplx[' + key + '][ngay_tt_gplx]" class="form-control form-control-sm date-input-gplx" placeholder="dd/mm/yyyy" autocomplete="off">' +
            '</div>' +
            '<div class="col-lg-2 col-md-4">' +
            '<label class="form-label small mb-1">Ngày hết hạn</label>' +
            '<input type="text" name="HocVienGplx[' + key + '][ngay_hh_gplx]" class="form-control form-control-sm date-input-gplx" placeholder="dd/mm/yyyy" autocomplete="off">' +
            '</div>' +
            '<div class="col-lg-2 col-md-4">' +
            '<label class="form-label small mb-1">Nơi cấp</label>' +
            donViSelect +
            '</div>' +
            '</div>' +
            '</div>';

        $('#gplx-dynamic-container').append(html);
        initGplxDatePicker('#gplx-item-' + key + ' .date-input-gplx');
    });

    $(document).off('click', '.btn-remove-dynamic-gplx').on('click', '.btn-remove-dynamic-gplx', function() {
        var target = $(this).data('target');
        $(target).remove();
    });

    $(document).off('click', '.btn-delete-existing-gplx').on('click', '.btn-delete-existing-gplx', function() {
        var id = $(this).data('id');
        if (confirm('Bạn có chắc chắn muốn xóa giấy phép lái xe này không?')) {
            $.ajax({
                url: '/hocvien/dang-ky-hv/delete-gplx-ajax?id=' + id,
                type: 'POST',
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        $('#gplx-exist-row-' + id).fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        alert(res.message || 'Xóa thất bại');
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra khi xóa!');
                }
            });
        }
    });

    function initGplxDatePicker(selector) {
        if (typeof $.fn.kvDatepicker !== 'undefined') {
            $(selector).kvDatepicker({
                autoclose: true,
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                todayBtn: true,
                language: 'vi'
            });
        } else if (typeof $.fn.datepicker !== 'undefined') {
            $(selector).datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                todayBtn: true,
                language: 'vi'
            });
        }
    }

    initGplxDatePicker('.date-input-gplx');

    $('#ajaxCrudModal .modal-body').off('scroll.select2Fix').on('scroll.select2Fix', function() {
        $('.select2-hidden-accessible').select2('close');
    });
</script>