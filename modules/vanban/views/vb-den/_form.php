<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\vanban\models\LoaiVanBan;
use kartik\date\DatePicker;
use app\custom\CustomFunc;

/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
$model->ngay_ky = CustomFunc::convertYMDToDMY($model->ngay_ky);
?>

<div class="van-ban-den-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_loai_van_ban')->dropDownList(LoaiVanBan::getList(), ['prompt'=>'Chọn loại văn bản']) ?>

    <?= $form->field($model, 'so_vb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ngay_ky')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày ký ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
    ]); ?>
    
    <?= $form->field($model, 'trich_yeu')->textarea(['rows' => 5]) ?>

    <?= $form->field($model, 'nguoi_ky')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vbden_ngay_den')->textInput() ?>

    <?= $form->field($model, 'vbden_so_den')->textInput() ?>

    <?= $form->field($model, 'vbden_nguoi_nhan')->textInput() ?>

    <?= $form->field($model, 'vbden_ngay_chuyen')->textInput() ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 5]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
