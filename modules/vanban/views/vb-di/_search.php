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

<div class="van-ban-den-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'get',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>

<div class="row">
	<div class="col-md-3">
		 <?= $form->field($model, 'id_loai_van_ban')->dropDownList(LoaiVanBan::getList(), ['prompt'=>'Chọn loại văn bản']) ?>
	</div>
	<div class="col-md-3">
		 <?= $form->field($model, 'nam')->dropDownList($model->getListSo(), [
	    'prompt'=>'Chọn sổ VB'
	]) ?>
	</div>
     <div class="col-md-3">
         <?= $form->field($model, 'so_vao_so')->textInput() ?>
     </div>
     <div class="col-md-3">
         <?= $form->field($model, 'so_vb')->textInput() ?>
     </div>
    <div class="col-md-3">
         <?= $form->field($model, 'nguoi_ky')->textInput() ?>
    </div>
    <div class="col-md-3">
         <?= $form->field($model, 'vbdi_noi_nhan')->textInput() ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'vbdi_ngay_chuyen')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày chuyển  ...'],
            'pluginOptions' => [
                'orientation' => 'bottom left',
                'todayHighlight' => true,
                'todayBtn' => true,
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
        ]); ?>
    </div>

    <div class="col-md-3">
         <?= $form->field($model, 'trich_yeu')->textInput() ?>
    </div>   
    
   
    <?php if (!Yii::$app->request->isAjax){ ?>
    <div class="col-md-12 text-center">
        <div class="form-group mb-0">
	        <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
	    </div>
    </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
</div>
<style>
    .van-ban-den-search label {
    font-weight: bold;
}
.select2-container {
        width: 100% !important;  /* Đảm bảo rằng Select2 chiếm hết chiều rộng của phần tử */
        display: block; /* Đảm bảo Select2 xuống dòng */
    }
</style>