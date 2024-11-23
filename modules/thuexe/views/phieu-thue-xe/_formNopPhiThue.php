<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use app\modules\nhanvien\models\NhanVien;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LoaiHinhThue */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
     $model->ngay_nop = CustomFunc::convertYMDToDMY($model->ngay_nop);
?>

<div class="nop-phi-thue-xe-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php CardWidget::begin(['title'=>'Thông tin người thuê']) ?>
 
      
<div class="row">
    <?php if (!empty($idHocVien)) : ?>
        <!-- Trường hợp người thuê là học viên -->
        <?= $form->field($model, 'id_hoc_vien')->hiddenInput(['value' => $idHocVien])->label(false) ?><!--Trường ẩn dùng để lưu giá trị khi form gửi -->
        <div class="col-md-4">
            <strong>Học viên:</strong> <?= $hotenHV ?>
        </div>
        <div class="col-md-4">
            <strong>Số CCCD:</strong> <?= $cccdHV ?>
        </div>
        <div class="col-md-4">
            <strong>Địa chỉ:</strong> <?= $diachiHV ?>
        </div> <br>
        <div class="col-md-4">
            <strong>Số điện thoại:</strong> <?= $sdtHV ?>
        </div>
    
        <div class="col-md-4">
             <strong>Chi phí thuê:</strong><span style="color: red;"> <?= number_format($chiphithueDK, 0, ',', '.') . ' VND' ?></span>
        </div>

    <?php else : ?>
        <!-- Trường hợp người thuê không phải là học viên -->
        <div class="col-md-4">
            <strong>Họ tên người thuê:</strong> <?= $hotenNT ?>
            <?= $form->field($model, 'ho_ten_nguoi_thue')->hiddenInput(['value' => $hotenNT])->label(false) ?>
        </div>
        <div class="col-md-4">
            <strong>Số CCCD:</strong> <?= $cccdNT ?>
            <?= $form->field($model, 'so_cccd_nguoi_thue')->hiddenInput(['value' => $cccdNT])->label(false) ?>
        </div>
        <div class="col-md-4">
            <strong>Địa chỉ:</strong> <?= $diachiNT ?>
            <?= $form->field($model, 'dia_chi_nguoi_thue')->hiddenInput(['value' => $diachiNT])->label(false) ?>
        </div><br><br>
        <div class="col-md-4">
            <strong>Số điện thoại:</strong> <?= $sdtNT ?>
            <?= $form->field($model, 'so_dien_thoai_nguoi_thue')->hiddenInput(['value' => $sdtNT])->label(false) ?>
        </div>
        <div class="col-md-4">
             <strong>Chi phí thuê:</strong><span style="color: red;"> <?= number_format($chiphithueDK, 0, ',', '.') . ' VND' ?></span>
        </div>
    <?php endif; ?>
</div>


    <?php CardWidget::end() ?>
    <?php CardWidget::begin(['title'=>'Thông tin nộp phí thuê']) ?>
       <div class="row">
           <div class="col-md-4">
                 <?= $form->field($model, 'so_tien_nop')->textInput()?>
           </div>
           <div class="col-md-4">
           <?= $form->field($model, 'ngay_nop')->widget(DatePicker::classname(), [
                  'options' => ['placeholder' => 'Chọn ngày thuê xe  ...'],
                  'pluginOptions' => [
                  'autoclose' => true,
                  'format' => 'dd/mm/yyyy',
                   ]
                ]); ?>
           </div>
           <div class="col-md-4">
           <?= $form->field($model, 'nguoi_thu')->widget(Select2::classname(), [
                  'data' => ArrayHelper::map(NhanVien::find()->all(), 'id', 'ho_ten'), 
                  'language' => 'vi', 
                  'options' => ['placeholder' => 'Chọn nhân viên...'], 
                  'pluginOptions' => [
                      'allowClear' => true, 
                      'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                     ],
            ]); ?>
          
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
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
.nop-phi-thue-xe-form label {
    font-weight: bold;
}
</style>
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





