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
        <div class="col-md-6">
			<?= $form->field($modelNhapKho, 'so_luong')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
        	<label>Đơn vị cung cấp</label>
			<?= $form->field($modelNhapKho, 'id_nha_cung_cap')->widget(Select2::classname(), [
                'data' => NhaCungCap::getDmNhaCungCap(),
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn nhà cung cấp...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'loai-hh-dropdown'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    'width'=>'100%'
                ],
            ])->label(false); ?>
        </div>
        <div class="col-md-12">
        	<?= $form->field($modelNhapKho, 'ghi_chu')->textarea(['rows' => 6]) ?>
        </div>
        
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($modelNhapKho->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $modelNhapKho->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
