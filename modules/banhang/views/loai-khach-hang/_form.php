<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\khachhang\models\LoaiKhachHang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loai-khach-hang-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'ten_loai_khach_hang')->textInput() ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows'=>3]) ?>
        </div>
  
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
