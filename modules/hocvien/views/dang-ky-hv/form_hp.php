<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use yii\widgets\MaskedInput;
use app\modules\nhanvien\models\NhanVien;
/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$model->ngay_nop = CustomFunc::convertYMDToDMY($model->ngay_nop);
?>
<div class="hv-hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>
   <div class ='row'>
   <div class="col-md-6">
    <label >Họ tên học viên</label>
    <?= $form->field($model, 'id_hoc_vien')->hiddenInput()->label(false) ?>
    <input style="color: blue;" type="text" class="form-control" value="<?= $hoTenHocVien ?>" readonly style="border-color: red; color: red;">
</div>

       
   </div>
   <hr style="width:400px; border-width:2px; border-color:black; margin-left:auto; margin-right:auto;">

   <div class ='row'>
      
        <div class="col-md-6">
        <?= $form->field($model, 'ngay_nop')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày nộp  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
        </div>
  
        <div class="col-md-6">
            <?= $form->field($model, 'so_tien_nop')->textInput() ?>
        </div>


           
       
    </div>
    <div class ='row'>
    <div class="col-md-6">
            <?= $form->field($model, 'nguoi_thu')->dropDownList(
                 NhanVien::getList(), 
                     [
                      'prompt' => 'Chọn người thu',
                      'class' => 'form-control dropdown-with-arrow',
                     ]
            ) ?>
        </div>
   </div>
   <div class='row'>
       <div class="col-md-12" style="text-align:center;">
          
            <br/>
            <div class='row'>
                <div class="col-md-6" style="text-align:center;">
                    <div id="my_camera" style="text-align:center;"></div>
                    <?= $form->field($model, 'bien_lai')->hiddenInput(['id' => 'bien_lai'])->label(false) ?>
                </div>
                <div class="col-md-6" style="text-align:center;">
                    <div id="results" style="text-align:center;"></div>
                </div>
            </div>
            <div class='row'>
                <div class="col-md-12" style="text-align:center;">
                <button onClick="take_snapshot()" class="btn ripple btn-primary btn-sm">
                   <i class="fa fa-camera" style="font-size: 16px;"></i> Chụp biên lai
               </button>
                </div>
            </div>
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
       .hv-hoc-vien-form label {
    font-weight: bold;

}
</style>
<script language="JavaScript">
    // Cấu hình Webcam
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach('#my_camera');

    // Hàm chụp ảnh
    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            // Hiển thị ảnh xem trước
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            // Gán dữ liệu ảnh vào input ẩn
            document.getElementById('bien_lai').value = data_uri;
            event.preventDefault();
        });
    }
</script>

   





