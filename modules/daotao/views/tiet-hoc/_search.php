<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\daotao\models\TietHoc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tiet-hoc-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'post',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
	<div class="row">
<div class="col-md-4">    <?= $form->field($model, 'id_ke_hoach')->textInput() ?>

</div><div class="col-md-4">    <?= $form->field($model, 'id_hoc_vien')->textInput() ?>

</div><div class="col-md-4">    <?= $form->field($model, 'id_giao_vien')->textInput() ?>

</div><div class="col-md-4">    <?= $form->field($model, 'id_xe')->textInput() ?>

</div><div class="col-md-4">    <?= $form->field($model, 'id_mon_hoc')->textInput() ?>

</div><div class="col-md-4">    <?= $form->field($model, 'id_thoi_gian_hoc')->textInput() ?>

</div><div class="col-md-4">    <?= $form->field($model, 'so_gio')->textInput() ?>

</div><div class="col-md-4">    <?= $form->field($model, 'thoi_gian_bd')->textInput() ?>

</div><div class="col-md-4">    <?= $form->field($model, 'thoi_gian_kt')->textInput() ?>

</div><div class="col-md-4">    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

</div><div class="col-md-4">    <?= $form->field($model, 'trang_thai')->textInput(['maxlength' => true]) ?>

</div><div class="col-md-4">    <?= $form->field($model, 'trang_thai_duyet')->textInput(['maxlength' => true]) ?>

</div><div class="col-md-4">    <?= $form->field($model, 'ngay_duyet')->textInput() ?>

</div><div class="col-md-4">    <?= $form->field($model, 'id_nguoi_duyet')->textInput() ?>

</div><div class="col-md-4">    <?= $form->field($model, 'nguoi_tao')->textInput() ?>

</div><div class="col-md-4">    <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>

</div>  
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
