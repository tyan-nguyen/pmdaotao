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
        	<td>Họ và tên</td>
        	<td>Số CCCD</td>
        	<td>Ngày sinh</td>
        	<td>Hạng đào tạo</td>
        	<td>Khóa</td>
        </tr>
    </thead>
    <tbody>
        <tr>
        	<td style="text-align:center;vertical-align:middle">1</td>
        	<td style="text-align:center;vertical-align:middle"><?= $model->ho_ten ?></td>
        	<td style="vertical-align:middle"><?= $model->so_cccd ?></td>
        	<td style="vertical-align:middle"><?= CustomFunc::convertYMDToDMY($model->ngay_sinh)  ?></td>
        	<td style="vertical-align:middle"><?= $model->hangDaoTao ? $model->hangDaoTao->ten_hang : '' ?></td>
        	<td style="vertical-align:middle"><?= $model->khoaHoc ? $model->khoaHoc->ten_khoa_hoc : '' ?></td>
        </tr>
    </tbody>
</table>

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

<?php ActiveForm::end(); ?>
