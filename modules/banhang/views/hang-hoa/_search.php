<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\banhang\models\LoaiHangHoa;

/* @var $this yii\web\View */
/* @var $model app\modules\banhang\models\HangHoa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hang-hoa-search">
    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'post',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
	<div class="row">
        <div class="col-md-2">
        	<label>Loại hàng hóa</label>
        	<?= $form->field($model, 'id_loai_hang_hoa')->widget(Select2::classname(), [
                'data' => LoaiHangHoa::getDmLoaiHangHoa(),
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn loại hàng hóa...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'loai-hh-search-dropdown'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width'=>'100%'
                ],
            ])->label(false); ?>
        </div>
        <div class="col-md-2">
        	<?= $form->field($model, 'ma_hang_hoa')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
        	<?= $form->field($model, 'ten_hang_hoa')->textInput(['maxlength' => true]) ?>
        </div>
        <!-- <div class="col-md-2">
        	<?= $form->field($model, 'co_ton_kho')->dropDownList([
        	    1=>'Có quản lý tồn kho',
        	    0=>'Không quản lý tồn kho'
        	], ['prompt'=>'-Tất cả-']) ?>
        </div>-->
        <div class="col-md-2">
        	<label>Có quản lý kho</label>
        	<?= $form->field($model, 'co_ton_kho')->widget(Select2::classname(), [
        	    'data' => [
        	        1=>'Có quản lý tồn kho',
        	        0=>'Không quản lý tồn kho'
        	    ],
                'language' => 'vi',
                'options' => [
                    'placeholder' => '-Tất cả-',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'co-ton-kho-search-dropdown'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width'=>'100%'
                ],
            ])->label(false); ?>
        </div>
        <div class="col-md-3">
        	<label>&nbsp;</label>
            <div class="form-group">
    	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
    	        <?= Html::resetButton('Xóa TK', ['class' => 'btn btn-outline-secondary']) ?>
    	    </div>
        </div>
	</div>

    <?php ActiveForm::end(); ?>
    
</div>
