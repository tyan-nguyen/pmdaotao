<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use kartik\select2\Select2;
use app\modules\thuexe\models\LoaiXe;
use app\modules\thuexe\models\DonViSoHuu;
use yii\bootstrap5\Modal;
use app\modules\thuexe\models\Xe;
use app\custom\CustomFunc;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\Xe */
/* @var $form yii\widgets\ActiveForm */

if (!$model->isNewRecord) {
    $model->ngay_dang_kiem = CustomFunc::convertYMDToDMY($model->ngay_dang_kiem);
}
$checkKhongChon = false;
if (empty($model->ma_mau)) {
    $checkKhongChon = true;
}
?>

<div class="xe-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php CardWidget::begin(['title' => 'Thông tin Xe']) ?>

    <div class="row">
        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'id_loai_xe')->widget(Select2::classname(), [
                'data' => LoaiXe::getList(),
                'language' => 'vi',
                'options' => ['placeholder' => 'Chọn loại xe...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                ],
            ]); ?>
        </div>

        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'id_don_vi_so_huu')->widget(Select2::classname(), [
                'data' => DonViSoHuu::getList(),
                'language' => 'vi',
                'options' => ['placeholder' => '-- Chọn đơn vị sở hữu (không bắt buộc) --'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                ],
            ]); ?>
        </div>

        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'phan_loai')->widget(Select2::classname(), [
                'data' => Xe::getDmPhanLoaiXe(),
                'language' => 'vi',
                'options' => ['placeholder' => 'Phân loại xe...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                ],
            ]); ?>
        </div>

        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'hieu_xe')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'bien_so_xe')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'ma_bien_so')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1 col-md-6">
            <?= $form->field($model, 'ma_so')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1 col-md-6">
            <?= $form->field($model, 'stt')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'tinh_trang_xe')->dropDownList(
                Xe::getDmTinhTrangXe(),
                ['prompt' => 'Chọn tình trạng xe']
            ) ?>
        </div>
        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'trang_thai')->dropDownList(
                [
                    'Khả dụng' => 'Khả dụng',
                    'Không khả dụng' => 'Không khả dụng'
                ],
                ['prompt' => 'Chọn trạng thái']
            ) ?>
        </div>

        <div class="col-lg-4 col-md-6">
            <?= $form->field($model, 'ngay_dang_kiem')->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder' => 'Ngày đăng kiểm...',
                    'autocomplete' => 'off'
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'zIndexOffset' => '9999',
                    'todayHighlight' => true,
                    'todayBtn' => true
                ]
            ]); ?>
        </div>

        <div class="col-lg-3 col-md-6">
            <label>&nbsp;</label>
            <?= $form->field($model, 'la_xe_cu')->checkbox() ?>
        </div>

        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'so_khung')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'so_may')->textInput(['maxlength' => true]) ?>
        </div>


        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'mau_sac')->textInput(['maxlength' => true, 'placeholder' => 'Ví dụ: Trắng - Đen, Đỏ...']) ?>
        </div>

        <div class="col-lg-4 col-md-6">
            <label class="form-label" style="font-weight:bold;">Mã màu (Chọn 1 hoặc nhiều màu)</label>
            <?= $form->field($model, 'ma_mau', ['options' => ['style' => 'margin-bottom:0']])->hiddenInput(['id' => 'xe-ma-mau-input'])->label(false) ?>

            <div id="xe-color-palette-wrapper" style="<?= $checkKhongChon ? 'display:none;' : '' ?>">
                <div class="d-flex align-items-center mb-2">
                    <input type="color" id="picker-add-color" value="#ffffff" class="form-control form-control-color" style="width:40px; height:32px; padding:2px; cursor:pointer;" title="Chọn mã màu">
                    <button type="button" class="btn btn-sm btn-outline-primary ms-2" id="btn-add-color" title="Thêm màu vào danh sách">
                        <i class="fa fa-plus"></i> Thêm màu
                    </button>
                    <div class="ms-3 d-flex align-items-center">
                        <span style="font-size:12px; color:#64748b; margin-right:6px;">Xem trước:</span>
                        <span id="color-preview-circle" style="width:26px; height:26px; border-radius:50%; display:inline-block; border:1px solid #cbd5e1; box-shadow:0 1px 2px rgba(0,0,0,0.2);"></span>
                    </div>
                </div>

                <div id="selected-colors-list" class="d-flex flex-wrap align-items-center mb-1" style="min-height:28px;">
                    <!-- Chips màu được render tự động qua JS -->
                </div>
            </div>

            <label class="mt-1 d-block">
                <input type="checkbox" id="no-color-checkbox" name="no_color" <?= $checkKhongChon ? 'checked' : '' ?>>
                <span style="color:var(--primary-bg-color); font-size:13px;">Không sử dụng màu</span>
            </label>
        </div>

        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'so_hoa_don')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'so_hop_dong')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'so_km_ban_dau')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3 col-md-6">
            <label for="ngay_cap_nhat_km">Ngày cập nhật KM</label>
            <?= Html::textInput(
                'ngay_cap_nhat_km',
                CustomFunc::convertYMDHISToDMY($model->ngay_cap_nhat_km),
                ['class' => 'form-control', 'disabled' => true]
            ) ?>
        </div>
        <div class="col-lg-6 col-md-6">
            <?= $form->field($model, 'nha_cung_cap')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-md-6">
            <?= $form->field($model, 'dac_diem')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-2 col-md-3">
            <?= $form->field($model, 'nam_san_xuat')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-2 col-md-3">
            <?= $form->field($model, 'nam_mua')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3 col-md-3">
            <?= $form->field($model, 'imei_gps')->textInput(['maxlength' => true, 'placeholder' => 'Nhập số IMEI GPS...']) ?>
        </div>

        <div class="col-lg-5 col-md-3">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 2]) ?>
        </div>
    </div>
    <?php CardWidget::end() ?>
    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>

<?php Modal::begin([
    'options' => [
        'id' => 'ajaxCrudModal2',
        'tabindex' => false // important for Select2 to work properly
    ],
    // 'dialogOptions'=>['class'=>'modal-lg'],
    'closeButton' => ['label' => '<span aria-hidden=\'true\'>×</span>'],
    'id' => 'ajaxCrudModal2',
    'footer' => '', // always need it for jquery plugin
    'size' => Modal::SIZE_LARGE
]) ?>
<?php Modal::end(); ?>
<style>
    .xe-form label {
        font-weight: bold;
    }
</style>

<?php
$currentColorsJson = json_encode($model->getDanhSachMaMau());
$this->registerJs("
    var currentColors = {$currentColorsJson};

    function updateMultiColorUI() {
        $('#xe-ma-mau-input').val(currentColors.join(','));
        var container = $('#selected-colors-list');
        container.empty();

        if (currentColors.length === 0) {
            container.html('<span class=\"text-muted\" style=\"font-size:12px;\">Chưa chọn màu nào</span>');
        } else {
            $.each(currentColors, function(idx, hex) {
                var chip = $('<span class=\"badge bg-light text-dark border me-1 mb-1\" style=\"font-size:11px; padding:4px 7px; display:inline-flex; align-items:center;\">' +
                    '<span style=\"width:13px; height:13px; border-radius:50%; background:' + hex + '; border:1px solid #94a3b8; display:inline-block; margin-right:5px;\"></span>' +
                    hex +
                    '<a href=\"javascript:void(0)\" class=\"text-danger ms-2 btn-remove-color\" data-index=\"' + idx + '\" style=\"text-decoration:none; font-weight:bold; font-size:14px; line-height:1;\" title=\"Xóa màu\">&times;</a>' +
                '</span>');
                container.append(chip);
            });
        }

        // Cập nhật vòng tròn xem trước (Preview)
        var preview = $('#color-preview-circle');
        var n = currentColors.length;
        if (n === 0) {
            preview.css({
                'background': '#f8fafc',
                'border': '1px dashed #94a3b8'
            });
            preview.attr('title', 'Chưa có màu');
        } else if (n === 1) {
            preview.css({
                'background': currentColors[0],
                'border': '1px solid #cbd5e1'
            });
            preview.attr('title', currentColors[0]);
        } else {
            // Chia đều 360 độ góc cho N màu
            var step = 360 / n;
            var segments = [];
            for (var i = 0; i < n; i++) {
                var startDeg = Math.round(i * step * 10) / 10;
                var endDeg = Math.round((i + 1) * step * 10) / 10;
                segments.push(currentColors[i] + ' ' + startDeg + 'deg ' + endDeg + 'deg');
            }
            preview.css({
                'background': 'conic-gradient(' + segments.join(', ') + ')',
                'border': '1px solid #cbd5e1'
            });
            preview.attr('title', currentColors.join(', '));
        }
    }

    updateMultiColorUI();

    $('#btn-add-color').on('click', function(e) {
        e.preventDefault();
        var hex = $('#picker-add-color').val();
        if (hex) {
            hex = hex.toLowerCase();
            if (currentColors.indexOf(hex) === -1) {
                currentColors.push(hex);
            }
            $('#no-color-checkbox').prop('checked', false);
            $('#xe-color-palette-wrapper').show();
            updateMultiColorUI();
        }
    });

    $(document).off('click', '.btn-remove-color').on('click', '.btn-remove-color', function(e) {
        e.preventDefault();
        var idx = $(this).data('index');
        if (idx !== undefined && idx >= 0 && idx < currentColors.length) {
            currentColors.splice(idx, 1);
            updateMultiColorUI();
        }
    });

    $('#no-color-checkbox').on('change', function() {
        if ($(this).is(':checked')) {
            currentColors = [];
            $('#xe-color-palette-wrapper').hide();
            updateMultiColorUI();
        } else {
            $('#xe-color-palette-wrapper').show();
            if (currentColors.length === 0) {
                currentColors.push('#ffffff');
            }
            updateMultiColorUI();
        }
    });
");
?>