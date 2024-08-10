<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\modules\nhanvien\models\NhanVien;
use yii\helpers\ArrayHelper;


$nhanViens = NhanVien::find()->all();
$listNhanVien = ArrayHelper::map($nhanViens, 'id', 'ho_ten');
?>

<div class="van-ban-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'so_vb')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'ngay_ky')->widget(DatePicker::classname(), [
                 'options' => ['placeholder' => 'Chọn ngày ký ...'],
                 'pluginOptions' => [
                     'autoclose' => true,
                     'format' => 'yyyy-mm-dd',
                    ]
        ]); ?>
        </div>
        <div class="col-md-4">
      
<?= $form->field($model, 'vbdi_ngay_chuyen')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Chọn ngày chuyển ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'trich_yeu')->textarea(['rows' => 6])?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'nguoi_ky')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'vbdi_noi_nhan')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
        <?= $form->field($model, 'vbdi_so_luong_ban')->textInput(['maxlength' => true]) ?>
        </div>
        
       
        <div class="col-md-4">
        <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>
    </div>
    </div>


       

  

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
