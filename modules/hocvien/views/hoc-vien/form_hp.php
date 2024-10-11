<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use kartik\select2\Select2;
use app\widgets\CardWidget;
use app\modules\nhanvien\models\NhanVien;
/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$model->ngay_nop = CustomFunc::convertYMDToDMY($model->ngay_nop);
?>
<div class="hp-hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php CardWidget::begin(['title'=>'Thông tin học phí']) ?>
   <div class='row'>
      <!-- Cột 1: Họ tên học viên -->
      <div class="col-md-4">
         <label>Họ tên học viên</label>
         <?= $form->field($model, 'id_hoc_vien')->hiddenInput()->label(false) ?>
         <input style="color: blue;" type="text" class="form-control" value="<?= $hoTenHocVien ?>" readonly style="border-color: red; color: red;">
      </div>

      <!-- Cột 2: Hạng xe -->
      <div class="col-md-4">
         <label>Hạng xe</label>
         <?= $form->field($model, 'id_hoc_vien')->hiddenInput()->label(false) ?>
         <input  style="color: blue;"  type="text" class="form-control" value="<?= $tenHang ?>" readonly>
      </div>

      <!-- Cột 3: Học phí -->
      <div class="col-md-4">
         <label>Học phí</label>
         <?= $form->field($model, 'id_hoc_vien')->hiddenInput()->label(false) ?>
         <input style="color: blue;" type="text" class="form-control" value="<?= number_format($hocPhi->hoc_phi, 0, ',', '.') . ' VNĐ'; ?>" readonly style="border-color: red; color: red;">
      </div>
   </div>
<?php CardWidget::end() ?>

   <hr style="width:400px; border-width:2px; border-color:black; margin-left:auto; margin-right:auto;">
   <?php CardWidget::begin(['title'=>'Chi tiết']) ?>
   <div class ='row'>
        <div class="col-lg-4 col-md-6">
        <?= $form->field($model, 'ngay_nop')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày nộp  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
        </div>
        <div class="col-lg-4 col-md-6">
            <?= $form->field($model, 'so_tien_nop')->textInput(['placeholder' => 'VNĐ ...']) ?>
        </div>

        <div class="col-lg-4 col-md-6">
        <?= $form->field($model, 'nguoi_thu')->widget(Select2::classname(), [
                 'data' => NhanVien::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn người thu...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    ],
             ]);?>
        </div>
        <div class="col-lg-4 col-md-6">
            <?= $form->field($model, 'file')->fileInput(['class' => 'form-control'])->label('Chọn biên lai') ?>
               <div class="form-group">
                   <label>&nbsp;</label> <!-- Tạo một nhãn rỗng để tạo không gian -->
               </div>
        </div>
        <?php CardWidget::end() ?>
   </div>
   
 
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
       .hp-hoc-vien-form label {
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


   





