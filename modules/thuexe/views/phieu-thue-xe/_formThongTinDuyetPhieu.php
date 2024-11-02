<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\PhieuThueXe */
/* @var $form yii\widgets\ActiveForm */

// Đăng ký tệp CSS
$this->registerCssFile('@web/css/approve-ptx.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);
?>

<div class="phieu-thue-xe-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    <div class="col-md-6">
    <!-- Yêu cầu duyệt phiếu -->
    <div class="card mb-4">
        <div class="card-header bg-success" style="color: white;">
           Thông tin yêu cầu duyệt phiếu
       </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= Html::label('Người gửi', 'nguoi-gui') ?>
                    <?= Html::textInput('nguoi-gui', $model->nguoiGui ? $model->nguoiGui->fullname : '(Không có tên)', ['class' => 'form-control', 'readonly' => true]) ?>
                    <?= $form->field($model, 'id_hoc_vien')->hiddenInput()->label(false) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'thoi_gian_gui')->textInput([
                     'value' => Yii::$app->formatter->asDatetime($model->thoi_gian_gui, 'php:d-m-Y | H:i:s'),
                     'disabled' => true
                      ])->label('Thời gian gửi') ?>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'ghi_chu_nguoi_gui')->textarea(['rows' => 6, 'readonly' => true]) ?>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-3">
                       
                        <?= Html::a('<i class="fas fa-eye icon-white"></i>', 
                            ['/thuexe/phieu-thue-xe/view','id' => $model->id, 'modalType' => 'modal-remote-2'], 
                            ['class' => 'btn btn-sm btn-primary', 'title' => 'Xem phiếu', 'role' => 'modal-remote-2']
                        ); ?>   
                 </div>
            </div>
        </div>
    </div>
    <</div>
    <div class="col-md-6">
    <!-- Kiểm duyệt phiếu -->
    <div class="card mb-4">
       <div class="card-header bg-warning" style="color: white;">
           Thông tin kiểm duyệt phiếu
       </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= Html::label('Người kiểm duyệt', 'nguoi-kiem-duyet') ?>
                    <?= Html::textInput('nguoi-kiem-duyet', $model->nguoiKiemDuyet ? $model->nguoiKiemDuyet->fullname : '(Không có tên)', ['class' => 'form-control', 'readonly' => true]) ?>
                    <?= $form->field($model, 'id_hoc_vien')->hiddenInput()->label(false) ?>
                </div>
                <div class="col-md-6">
                   <?= $form->field($model, 'thoi_gian_duyet')->textInput([
                     'value' => Yii::$app->formatter->asDatetime($model->thoi_gian_duyet, 'php:d-m-Y | H:i:s'),
                     'disabled' => true
                      ])->label('Thời gian duyệt') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <?= $form->field($model, 'trang_thai')->radioList([
                  'Đã duyệt' => 'Duyệt',
                  'Không duyệt' => 'Không duyệt',
                 ], [
                    'item' => function($index, $label, $name, $checked, $value) {
                     $checked = $checked ? 'checked' : '';
                     return '<div class="form-check text-center" style="display: inline-block; margin: 10px;">
                     <input class="form-check-input square-radio" type="radio" name="' . $name . '" value="' . $value . '" id="' . $value . '" ' . $checked . ' disabled>
                     <div><label class="form-check-label" for="' . $value . '">' . $label . '</label></div>
                   </div>';
             }
            ])->label('Trạng thái'); ?>


                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'ghi_chu_nguoi_duyet')->textarea(['rows' => 6,'readonly' => true]) ?>
                </div>
            </div>
        </div>
    </div>
    </div>
  </div>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
</div>
