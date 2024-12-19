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
$this->registerCssFile('@web/css/dkHocVienHP.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);
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
         <input style="color: blue;" type="text" class="form-control" value="<?= $hocPhi->hoc_phi; ?>" readonly style="border-color: red; color: red;">
      </div>
   </div>
<?php CardWidget::end() ?>
   <hr style="width:400px; border-width:2px; border-color:black; margin-left:auto; margin-right:auto;">
   <?php CardWidget::begin(['title'=>'Thông tin học phí']) ?>
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
   </div>
   <div class='row'>
       <div class="col-md-12" >
          
            <br/>
            <div class='row'>
                <div class="col-lg-4 col-md-12" style="text-align:center;">
                    <div id="my_camera" style="text-align:center;"></div>
                    <?= $form->field($model, 'bien_lai')->hiddenInput(['id' => 'bien_lai'])->label(false) ?>
                </div>
                <div class="col-lg-4 col-md-12" style="text-align:center;">
                    <div id="results" style="text-align:center; width: 100%; height: 240px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center;">
               </div>
          </div>

                <div class="col-lg-4 col-md-12">
                    <?= $form->field($model, 'file')->fileInput(['class' => 'form-control','id' => 'fileInput'])->label('Chọn biên lai') ?>
                        <div class="form-group">
                        <label>&nbsp;</label> <!-- Tạo một nhãn rỗng để tạo không gian -->
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class="col-md-8" >
                <button id="takeSnapshotButton"  onClick="take_snapshot()" class="btn ripple btn-primary btn-sm" >
                   <i class="fa fa-camera" style="font-size: 16px;"></i> Chụp biên lai
               </button>
               <button onClick="clear_snapshot()" class="btn ripple btn-danger btn-sm">
                    <i class="fa fa-trash" style="font-size: 16px;"></i> Xóa ảnh
                </button>
                </div>
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

<script language="JavaScript">
       var fileInput = document.getElementById('fileInput'); // Tham chiếu đến trường file input
       var takeSnapshotButton = document.getElementById('takeSnapshotButton');
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
            check_bien_lai();
            event.preventDefault();
        });
    }
    function clear_snapshot() {
        // Xóa nội dung ảnh trong #results
        document.getElementById('results').innerHTML = '';
        // Đặt lại giá trị input hidden 'bien_lai' thành rỗng
        document.getElementById('bien_lai').value = '';
        check_bien_lai();
        event.preventDefault();
    }
    function check_bien_lai() {
    var bienLai = document.getElementById('bien_lai');  // Tham chiếu đến phần tử 'bien_lai'
    var fileInput = document.getElementById('fileInput'); // Tham chiếu đến trường file input
    // Kiểm tra nếu 'bien_lai' có giá trị (có ảnh từ webcam)
    if (bienLai.value !== '') {  
        fileInput.disabled = true;
    } else {
        fileInput.disabled = false;
    }
    event.preventDefault();
}
   // Hàm kiểm tra và vô hiệu hóa hoặc kích hoạt nút chụp biên lai
   function checkFileInput() {
        if (fileInput.value !== '') {
            takeSnapshotButton.disabled = true; // Vô hiệu hóa nút chụp biên lai
        } else {
            takeSnapshotButton.disabled = false; // Kích hoạt lại nút chụp biên lai
        }
    }
     // Lắng nghe sự kiện thay đổi trên input file
     fileInput.addEventListener('change', checkFileInput);

// Gọi kiểm tra lần đầu khi tải trang để chắc chắn trạng thái đúng
checkFileInput();
 

</script>
<style> 
   .select2-dropdown {
    z-index: 9999 !important; 
     }
</style>

   





