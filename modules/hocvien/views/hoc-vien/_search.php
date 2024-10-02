
<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

use app\modules\hocvien\models\HangDaoTao;
use app\modules\khoahoc\models\KhoaHoc;

use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hoc-vien-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'get',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>

<?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'gioi_tinh')->dropDownList([
             1 => 'Nam',
             0 => 'Nữ',
             ], ['prompt' => 'Chọn giới tính', 'class' => 'form-control dropdown-with-arrow']) ?>

<?= $form->field($model, 'ngay_sinh')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Chọn ngày sinh  ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy',
        ]
        ]); ?>
<?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'id_hang')->dropDownList(HangDaoTao::getList(), ['prompt'=>'Chọn hạng']) ?>
<?= $form->field($model, 'id_khoa_hoc')->dropDownList(KhoaHoc::getList(), ['prompt'=>'Chọn khóa học']) ?>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	<?php } ?>


    <?php ActiveForm::end(); ?>
    
</div>
<style>
    .hoc-vien-search label {
    font-weight: bold;
}
</style>