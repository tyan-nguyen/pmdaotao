<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\vanban\models\LoaiVanBan;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\modules\nhanvien\models\NhanVien;

/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDi */
/* @var $form yii\widgets\ActiveForm */

?>

<?php 
$model->ngay_ky = CustomFunc::convertYMDToDMY($model->ngay_ky);
$model->vbdi_ngay_chuyen = CustomFunc::convertYMDToDMY($model->vbdi_ngay_chuyen);

$currentYear = date('Y');
?>

<div class="van-ban-di-form">

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'needs-validation ', // Thêm class vào thuộc tính options
        'novalidate' => true, // Bỏ qua xác thực của trình duyệt (nếu cần)
    ],
]); ?>

      <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id_loai_van_ban')->dropDownList(
                 LoaiVanBan::getList(), 
                     [
                         'prompt' => 'Chọn loại văn bản',
                         'class' => 'form-control dropdown-with-arrow',
                     ]
             ) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'so_vb')->textInput(['maxlength' => true,'oninput' => "if (!this.value.includes('/')) { this.value = '/' + '$currentYear'; }",]) ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'ngay_ky')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày ký ...'],
                'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
                ]
            ]); ?>
        </div>
        <div class="col-md-6"> 
            <?= $form->field($model, 'trich_yeu')->textarea(['rows' => 5]) ?>
        </div>
      </div>
        <div class="row">
            <div class="col-md-6">
                 <?= $form->field($model, 'nguoi_ky')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'vbdi_noi_nhan')->textInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'vbdi_so_luong_ban')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'vbdi_ngay_chuyen')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Chọn ngày chuyển  ...'],
                    'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                     ]
                 ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 5]) ?>
            </div>
        </div>
    
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
    .van-ban-di-form label {
    font-weight: bold;
}
.van-ban-di-form .form-control {
    border-color: #0000FF; /* Thay đổi màu viền */
    border-width: 1px; /* Độ dày viền */
}
</style>
