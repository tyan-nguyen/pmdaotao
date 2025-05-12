<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\giaovien\models\GiaoVien;
use kartik\select2\Select2;
use app\custom\CustomFunc;
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->errorSummary($model) ?>

<table class="table table-bordered">
    <thead style="font-weight: bold">
        <tr>
        	<td>STT</td>
        	<td>Loại xe</td>
        	<td>Biển số</td>
        	<td>Tình trạng xe</td>
        </tr>
    </thead>
    <tbody>
        <tr>
        	<td style="text-align:center;vertical-align:middle">1</td>
        	<td style="text-align:center;vertical-align:middle"><?= $model->loaiXe->ten_loai_xe ?></td>
        	<td style="vertical-align:middle"><?= $model->bien_so_xe ?></td>
        	<td style="vertical-align:middle"><?= $model->tinh_trang_xe  ?></td>
        </tr>
    </tbody>
</table>

<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'id_giao_vien')->widget(Select2::classname(), [
               'data' => GiaoVien::getList(),
               'language' => 'vi',
               'options' => [
                    'placeholder' => 'Chọn giáo viên...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'gv-dropdown-popup'
                ],
               'pluginOptions' => [
                  'allowClear' => true,
                  'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
              ],
        ]); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
