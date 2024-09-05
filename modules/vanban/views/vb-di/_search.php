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
            'method' => 'post',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>

    <?= $form->field($model, 'id_loai_van_ban')->dropDownList(LoaiVanBan::getList(), ['prompt'=>'Chọn loại văn bản']) ?>
    
    <?= $form->field($model, 'nguoi_ky')->textInput() ?>
  
    <?= $form->field($model, 'vbdi_noi_nhan')->textInput() ?>
    <?= $form->field($model, 'vbdi_so_luong_ban')->textInput() ?>
    <?= $form->field($model, 'vbdi_ngay_chuyen')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Chọn ngày chuyển  ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy',
        ]
        ]); ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
    .van-ban-den-search label {
    font-weight: bold;
}
</style>