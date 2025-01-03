<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use app\modules\hocvien\models\HangDaoTao;
/* @var $this yii\web\View */
/* @var $model app\modules\lichhoc\models\PhanThi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phan-thi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php CardWidget::begin(['title'=>'']) ?>
         <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'ten_phan_thi')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'id_hang')->dropDownList(
                   HangDaoTao::getList(), 
                     [
                         'prompt' => 'Chọn hạng',
                         'class' => 'form-control dropdown-with-arrow',
                         'id' => 'hang-dropdown',
                     ]
                ) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'diem_dat_toi_thieu')->textInput(['type' => 'number', 'min' => 0]) ?>
            </div>
            <div class="col-md-3">
            <?= $form->field($model, 'thu_tu_thi')->dropDownList(
               [
                  '1' => '1',
                  '2' => '2',
                  '3' => '3',
                  '4' => '4',
                  '5' => '5',
               ],
               [
                  'prompt' => 'Chọn thứ tự phần thi', 
                  'id' => 'luot-thi-dropdown',
               ]
            ) ?>
            </div>
         </div>
    <?php CardWidget::end() ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
 .phan-thi-form label {
    font-weight: bold;
}
</style>
