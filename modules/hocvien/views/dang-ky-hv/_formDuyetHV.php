<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\hocvien\models\HangDaoTao;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\widgets\CardWidget;
/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile('@web/css/dkHocVien.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);
?>
<?php
$model->ngay_sinh = CustomFunc::convertYMDToDMY($model->ngay_sinh);
?>
<div class="hv-hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>
      <?php CardWidget::begin(['title'=>'Kiểm duyệt học viên']) ?>
   <div class ='row'>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'trang_thai_duyet')->dropDownList([
             'DA_DUYET' => 'Duyệt',
             'KHONG_DUYET' => 'Không duyệt',
             ], ['prompt' => 'Kiểm duyệt', 'class' => 'form-control dropdown-with-arrow']) ?>
        </div>  
    <?php CardWidget::end() ?>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
