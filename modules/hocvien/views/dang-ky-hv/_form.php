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
?>
<?php
$model->ngay_sinh = CustomFunc::convertYMDToDMY($model->ngay_sinh);
?>
<div class="hv-hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>
      <?php CardWidget::begin(['title'=>'Thông tin cá nhân học viên']) ?>
   <div class ='row'>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'gioi_tinh')->dropDownList([
             1 => 'Nam',
             0 => 'Nữ',
             ], ['prompt' => 'Chọn giới tính', 'class' => 'form-control dropdown-with-arrow']) ?>
        </div>
 
            <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ngay_sinh')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày sinh  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
            </div>
            <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>
            </div>
           
    </div>
    <?php CardWidget::end() ?>

    <?php CardWidget::begin(['title'=>'Thông tin hạng đào tạo']) ?>
    <div class ='row'>
    <div class="col-lg-3 col-md-6">
        <?= $form->field($model, 'id_hang')->dropDownList(
    HangDaoTao::getList(), 
    [
        'prompt' => 'Chọn hạng',
        'class' => 'form-control dropdown-with-arrow',
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
     .hv-hoc-vien-form label {
    font-weight: bold;
}

.dropdown-with-arrow {
    position: relative;
    padding-right: 30px; /* Đảm bảo có khoảng trống cho mũi tên */
}

.dropdown-with-arrow:after {
    content: "\f078"; /* Font Awesome chevron-down */
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    pointer-events: none;
}
.dropdown-with-arrow {
    position: relative;
    padding-right: 30px;
    appearance: none; /* Loại bỏ mũi tên mặc định */
    background: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24"%3E%3Cpath d="M7 10l5 5 5-5z"%3E%3C/path%3E%3C/svg%3E') no-repeat right 10px center;
    background-size: 12px;
}
</style>