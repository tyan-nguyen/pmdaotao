<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\banhang\models\NhaCungCap;

/* @var $this yii\web\View */
/* @var $model app\modules\hanghoa\models\LoaiHangHoa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="border-bottom btn-list pt-0 pb-3">
    <h4><?= $model->ten_hang_hoa ?> (<?= $model->ma_hang_hoa ?>)</h4>
	<h6>Tồn kho hiện tại: <?= $model->so_luong ?> (<?= $model->donViTinh->ten_dvt ?>)</h6>
</div>
                                            
<div class="loai-hang-hoa-form" style="margin-top:30px">
	
    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
        <div class="col-md-2">
			<?= $form->field($modelXuatKho, 'so_luong')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-10">
        	<?= $form->field($modelXuatKho, 'ghi_chu')->textarea(['rows' => 6]) ?>
        </div>
        
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($modelXuatKho->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $modelXuatKho->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
