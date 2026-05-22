<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\modules\taisan\models\PhieuDeNghi;
use app\modules\user\models\User;
use app\widgets\CardWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\daotao\models\KeHoach */
/* @var $form yii\widgets\ActiveForm */

if (!$model->isNewRecord) {
    if ($model->ngay_duyet != null)
        $model->ngay_duyet = CustomFunc::convertYMDHISToDMYHIS($model->ngay_duyet);
}

?>

<div class="ke-hoach-form">

    <?php CardWidget::begin(['title' => 'Chi tiết phiếu đề nghị']) ?>

    <div class="table-responsive border p-0 pt-3">
        <table class="table table-bordered mg-b-0">
            <thead>
                <tr style="font-weight:bold">
                    <td width="5%" align="center">STT</td>
                    <td width="15%"  align="center">Người tạo</td>
                    <td width="15%" align="center">Người phụ trách</td>
                    <td width="20%" align="center">Tài sản</td>
                    <td width="10%" align="center">Ngày bắt đầu</td>
                    <td width="10%" align="center">Ngày kết thúc</td>
                    <td width="25%" align="center">Nội dung</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td align="center"><?= User::findOne($model->nguoi_tao)->hoTen ?? '' ?></td>
                    <td align="center"><?= User::findOne($model->nguoi_de_nghi)->hoTen ?? '' ?></td>
                    <td></td>
                    <td align="center"><?= CustomFunc::convertYMDHISToDMY($model->ngay_bat_dau) ?></td>
                    <td align="center"><?= CustomFunc::convertYMDHISToDMY($model->ngay_hoan_thanh) ?></td>
                    <td align="center"><?= $model->noi_dung_de_nghi ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php CardWidget::end() ?>

    <?php CardWidget::begin(['title' => 'Duyệt/Không duyệt phiếu']) ?>
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-4">
            <?= $form->field($model, 'trang_thai')->dropDownList(PhieuDeNghi::getDmTrangThaiDuyet(), [
                //'prompt'=>'-Tất cả-'
            ]) ?>
        </div>
        <!-- <div class="col-md-4">
        	<?= $form->field($model, 'nguoi_duyet')->dropDownList(
                [Yii::$app->user->id => User::getCurrentUser()->username],
                ['prompt' => '-Chọn-']
            ) ?>
        </div> -->

        <div class="col-md-8">
            <?= $form->field($model, 'ghi_chu_duyet')->textInput() ?>
        </div>

    </div>
    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    <?php CardWidget::end() ?>

</div>

<script>
    //var fp = flatpickr.localize(flatpickr.l10ns.vn);
    /* var fp = $("#time").flatpickr({
        enableTime: true,
        dateFormat: "d/m/Y H:i:ss",
        time_24hr: true,
        allowInput: true
    });
    fp.setDate(new Date("<?= $model->ngay_duyet ?>")); */
</script>