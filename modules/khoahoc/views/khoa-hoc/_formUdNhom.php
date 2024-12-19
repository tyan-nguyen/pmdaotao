<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\khoahoc\models\NhomHoc;



/* @var $this yii\web\View */
/* @var $model app\modules\khoahoc\models\KhoaHoc */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile('@web/css/hocphiKH.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);
$idKhoaHoc= $model->id_khoa_hoc;
?>
                 

<div class="nhom-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'id_nhom')->dropDownList(
                    NhomHoc::getList($idKhoaHoc), 
                     [
                         'prompt' => 'Chọn nhóm',
                         'class' => 'form-control dropdown-with-arrow',
                     ]
                ) ?>
             </div>
        </div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
    .select2-dropdown {
     z-index: 12000 !important; 
}
</style>
