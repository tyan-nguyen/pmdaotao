<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\vanban\models\LoaiVanBan;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\modules\nhanvien\models\NhanVien;

/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
$model->ngay_ky = CustomFunc::convertYMDToDMY($model->ngay_ky);
$model->vbden_ngay_chuyen = CustomFunc::convertYMDToDMY($model->vbden_ngay_chuyen);
$model->vbden_ngay_den = CustomFunc::convertYMDToDMY($model->vbden_ngay_den);
$currentYear = date('Y');
?>

<div class="van-ban-den-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_loai_van_ban')->dropDownList(
    LoaiVanBan::getList(), 
    [
        'prompt' => 'Chọn loại văn bản',
        'class' => 'form-control dropdown-with-arrow',
    ]
    ) ?>


    <?= $form->field($model, 'so_vb')->textInput(['maxlength' => true,'oninput' => "if (!this.value.includes('/')) { this.value = '/' + '$currentYear'; }",]) ?>

    <?= $form->field($model, 'ngay_ky')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày ký ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
    ]); ?>
    
    <?= $form->field($model, 'trich_yeu')->textarea(['rows' => 5]) ?>

    <?= $form->field($model, 'nguoi_ky')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'vbden_ngay_den')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày đến ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
    ]); ?>

    <?= $form->field($model, 'vbden_so_den')->textInput() ?>
    <?= $form->field($model, 'vbden_nguoi_nhan')->dropDownList(
    NhanVien::getList(), 
    [
        'prompt' => 'Chọn người nhận',
        'class' => 'form-control dropdown-with-arrow',
    ]
    ) ?>
    <?= $form->field($model, 'vbden_ngay_chuyen')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày chuyển  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
    ]); ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 5]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
    .van-ban-den-form label {
    font-weight: bold;
}
.dropdown-with-arrow {
    position: relative;
    padding-right: 30px; /* Đảm bảo có khoảng trống cho mũi tên */
}

.dropdown-with-arrow:after {
    content: "\f078"; /* Font Awesome chevron-down */
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    pointer-events: none;
}
.dropdown-with-arrow {
    position: relative;
    padding-right: 30px;
    appearance: none; /* Loại bỏ mũi tên mặc định */
    background: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24"%3E%3Cpath d="M7 10l5 5 5-5z"%3E%3C/path%3E%3C/svg%3E') no-repeat right 10px center;
    background-size: 12px;
}

</style>