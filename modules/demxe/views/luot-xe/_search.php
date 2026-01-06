<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\demxe\models\DemXe;
use kartik\select2\Select2;
use app\modules\thuexe\models\Xe;

/* @var $this yii\web\View */
/* @var $model app\modules\demxe\models\DemXe */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="dem-xe-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'get',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
	<div class="row">
		<div class="col-md-2">
             <?= $form->field($model, 'loaiXe')->widget(Select2::classname(), [
                    'data' =>  ['xeNha'=>'Xe nội bộ', 'xeLa'=>'Xe lạ'],
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Chọn xe...',
                        'id' => 'loai-xe-dropdown'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '100%'
                    ],
            ])->label('Nhóm xe');?> 
                
        </div>
        
    	<div class="col-md-2">
             <?= $form->field($model, 'id_xe')->widget(Select2::classname(), [
                 'data' =>  Xe::getListAll(),
                        'language' => 'vi',
                        'options' => [
                            'placeholder' => 'Chọn xe...',
                            'id' => 'xe-dropdown'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'width' => '100%'
                    ],
            ])->label();?> 
                
        </div>
        <div class="col-md-2">
			<?= $form->field($model, 'ma_xe')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
			<?= $form->field($model, 'ma_cong')->dropDownList(DemXe::getTram(), [
      	         'prompt' => '-Tất cả-'
			]) ?>
    	</div>
    	
    	
    	<div class="col-md-2">
			<?= $form->field($model, 'thoi_gian_bd')->textInput()->label('Thời gian đi') ?>
    	</div>
    	
    	<div class="col-md-2">
			<?= $form->field($model, 'thoi_gian_kt')->textInput()->label('Thời gian về') ?>
    	</div>

    	
    	<div class="col-md-2">
			<?= $form->field($model, 'bd_tu')->textInput()->label('Đi từ') ?>
    	</div>
    	<div class="col-md-2">
			<?= $form->field($model, 'bd_den')->textInput()->label('Đi đến') ?>
    	</div>
    	<div class="col-md-2">
			<?= $form->field($model, 'kt_tu')->textInput()->label('Về từ') ?>
    	</div>
    	<div class="col-md-2">
			<?= $form->field($model, 'kt_den')->textInput()->label('Về đến') ?>
    	</div>
    	
    	<div class="col-md-2">
			<?= $form->field($model, 'status')->dropDownList(DemXe::getDmTrangThaiPhien(), 
			    ['prompt'=>'-Tất cả-'])->label('Lọc theo trạng thái') ?>
    	</div>
    	
    	<!--<div class="col-md-4">
			<?= $form->field($model, 'so_gio')->textInput() ?>
    	</div>
    	<div class="col-md-4">
    		<?= $form->field($model, 'so_phut')->textInput(['maxlength' => true]) ?>
   		</div>-->
   		<!--<div class="col-md-4">
   			<?= $form->field($model, 'nguoi_tao')->textInput() ?>
   		</div>
   		<div class="col-md-4">
   			<?= $form->field($model, 'thoi_gian_tao')->textInput() ?>
    	</div>-->
    	<!--
    	<div class="col-md-4">
    		<?= $form->field($model, 'id_file')->textInput() ?>
    	</div> -->
    	<!-- <div class="col-md-4">
    		<?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>
        </div>   -->
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group" style="text-align: center">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
