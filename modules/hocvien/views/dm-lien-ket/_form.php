<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\hocvien\models\DmLienKet;

/* @var $this yii\web\View */
/* @var $model app\modules\hocvien\models\DmLienKet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-lien-ket-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
            <div class="col-md-4">
        <?= $form->field($model, 'loai_lien_ket')->dropDownList(DmLienKet::getDmLoaiLienKet(), []) ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'ten_lien_ket')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
        <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>
        </div>
        
  
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
