<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\hocvien\models\HocVien;
use app\modules\nhanvien\models\NhanVien;
use yii\helpers\ArrayHelper;
use app\widgets\CardWidget;
use kartik\datetime\DateTimePicker;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\modules\thuexe\models\Xe;
use app\custom\CustomFunc;
/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\PhieuThueXe */
/* @var $form yii\widgets\ActiveForm */
?>

<?php

$model->ngay_thue_xe = CustomFunc::convertYMDToDMY($model->ngay_thue_xe);
$model->thoi_gian_bat_dau_thue = CustomFunc:: convertYMDHISToDMYHIS($model->thoi_gian_bat_dau_thue);
$model->thoi_gian_tra_xe_du_kien = CustomFunc:: convertYMDHISToDMYHIS($model->thoi_gian_tra_xe_du_kien);
?>

<div class="phieu-thue-xe-form">

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'needs-validation ', // Thêm class vào thuộc tính options
        'novalidate' => true, // Bỏ qua xác thực của trình duyệt (nếu cần)
    ],
]); ?>
  <!-- Chọn đối tượng thuê -->

   <div class="row">
      <div class="col-md-4">
      <?php CardWidget::begin(['title'=>'Thông tin người thuê']) ?>
        <div class="form-group">
              <?= Html::label('Đối tượng thuê', 'doi_tuong_thue') ?>
              <?= Html::dropDownList('doi_tuong_thue', null, [
                 'hoc_vien' => 'Học viên',
                 'khong_hoc_vien' => 'Khác'
                ], [
                   'prompt' => 'Chọn đối tượng',
                   'id' => 'doi_tuong_thue',
                   'class' => 'form-control',
                ]) ?>
        <br>

    <!-- Thông tin học viên -->
    <div id="thong_tin_hoc_vien" style="display:none;">
         <?= $form->field($model, 'id_hoc_vien')->widget(Select2::classname(), [
           'data' => ArrayHelper::map(HocVien::find()->all(), 'id', 'ho_ten'), 
           'language' => 'vi', 
           'options' => ['placeholder' => 'Chọn học viên...'],
           'pluginOptions' => [
           'allowClear' => true, 
           'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
           ],
         ]); ?>
    </div>

    <!-- Thông tin người không phải học viên -->
    <div id="thong_tin_khong_hoc_vien" style="display:none;">
        <?= $form->field($model, 'ho_ten_nguoi_thue')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'so_cccd_nguoi_thue')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'dia_chi_nguoi_thue')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'so_dien_thoai_nguoi_thue')->textInput(['maxlength' => true]) ?>
    </div>

    </div>
    <?php CardWidget::end() ?>
    
</div>
    <div class="col-md-8">
         <?php CardWidget::begin(['title'=>'Thông tin thuê xe']) ?>
             <div class="row">
                <div class="col-md-6">
                <?= $form->field($model, 'ngay_thue_xe')->widget(DatePicker::classname(), [
                  'options' => ['placeholder' => 'Chọn ngày thuê xe  ...'],
                  'pluginOptions' => [
                  'autoclose' => true,
                  'format' => 'dd/mm/yyyy',
                   ]
                ]); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'id_xe')->widget(Select2::classname(), [
                      'data' => Xe::getList(),
                      'language' => 'vi',
                      'options' => ['placeholder' => 'Chọn xe...','id' => 'xe-id'],
                      'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                       ],
                    ]);?>
                </div>
     
                <div class="col-md-6">
                <?= $form->field($model, 'id_loai_hinh_thue')->widget(Select2::classname(), [
                  'data' => [],
                  'language' => 'vi',
                  'options' => ['placeholder' => 'Chọn loại hình thuê...', 'id' => 'loai-hinh-thue-id'],
                  'pluginOptions' => [
                  'allowClear' => true,
                  'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                     ],
                ]); ?>
                </div>

                <div class="col-md-6" id="field-buoi" style="display: none;">
                      <?= $form->field($model, 'buoi')->dropDownList([
                         'Sáng' => 'Sáng',
                         'Trưa' => 'Chiều',
                         'Chiều' => 'Tối'
                      ], [
                        'prompt' => 'Chọn buổi...',
                        'class' => 'form-control',
                     ]) ?>
                </div>


                <div class="col-md-6">
                <?= $form->field($model, 'thoi_gian_bat_dau_thue')->widget(\kartik\datetime\DateTimePicker::classname(), [
                     'options' => ['placeholder' => 'Chọn thời gian bắt đầu thuê...','id'=>'phieu_thue_xe-thoi_gian_bat_dau_thue'],
                     'pluginOptions' => [
                     'autoclose' => true,
                     'format' => 'yyyy-mm-dd hh:ii:ss ',
                     'todayHighlight' => true,
                     'todayBtn' => true,
                     'minuteStep' => 5,  
                     'secondStep' => 10, 
                     'language' => 'vi',
                     'showMeridian' => false,
                     ]
                  ]); ?>


                </div>
      
            <div class="col-md-6">
            <?= $form->field($model, 'thoi_gian_tra_xe_du_kien')->widget(\kartik\datetime\DateTimePicker::classname(), [
                     'options' => ['placeholder' => 'Chọn thời gian trả xe dự kiến...','id'=>'phieu_thue_xe-thoi_gian_tra_xe_du_kien'],
                     'pluginOptions' => [
                     'autoclose' => true,
                     'format' => 'yyyy-mm-dd hh:ii:ss ',
                     'todayHighlight' => true,
                     'todayBtn' => true,
                     'minuteStep' => 5,  
                     'secondStep' => 10, 
                     'language' => 'vi',
                     'showMeridian' => false,
                     ]
                  ]); ?>
            </div>
            <div class="col-md-6">
                  <?= $form->field($model, 'chi_phi_thue_du_kien')->textInput(['id'=>'chi_phi_thue_du_kien'])?>
            </div>
    
            <div class="col-md-6">
            <?= $form->field($model, 'id_nhan_vien_cho_thue')->widget(Select2::classname(), [
                  'data' => ArrayHelper::map(NhanVien::find()->all(), 'id', 'ho_ten'), 
                  'language' => 'vi', 
                  'options' => ['placeholder' => 'Chọn nhân viên...'], 
                  'pluginOptions' => [
                      'allowClear' => true, 
                      'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'), 
                      'containerCssClass' => 'select2-dropdown-adjustment', 
                     ],
            ]); ?>
            </div>
            <div class="col-md-6">
                  <?= $form->field($model, 'noi_dung_thue')->textarea(['rows' => 6]) ?>
            </div>
        </div>
    </div>
         <?php CardWidget::end() ?>
    </div>
</div>
   

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<script>
    //Xử lý sự kiện chọn đối tượng người thuê
document.getElementById('doi_tuong_thue').addEventListener('change', function () {
    var selectedValue = this.value;
    if (selectedValue === 'hoc_vien') {
        document.getElementById('thong_tin_hoc_vien').style.display = 'block';
        document.getElementById('thong_tin_khong_hoc_vien').style.display = 'none';
    } else if (selectedValue === 'khong_hoc_vien') {
        document.getElementById('thong_tin_hoc_vien').style.display = 'none';
        document.getElementById('thong_tin_khong_hoc_vien').style.display = 'block';
    } else {
        document.getElementById('thong_tin_hoc_vien').style.display = 'none';
        document.getElementById('thong_tin_khong_hoc_vien').style.display = 'none';
    }
});
// Xử lý sự kiện loading loại hình thuê dựa trên xe mà người dùng chọn 
$(document).ready(function() {
    $('#xe-id').change(function() {
        var idXe = $(this).val(); 
        if (idXe) {
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['phieu-thue-xe/get-loai-hinh-thue']) ?>', 
                data: {id_xe: idXe}, 
                success: function(data) {
                    $('#loai-hinh-thue-id').html(data).trigger('change');
                }
            });
        } else {
            $('#loai-hinh-thue-id').html('<option></option>').trigger('change');
        }
    });
});

//Xử lý sự kiện tính toán chi phí thuê xe
$(document).ready(function() {
    function calculateCost() {
        var loaiHinhThue = $('#loai-hinh-thue-id').val();
        var thoiGianBatDau = $('#phieu_thue_xe-thoi_gian_bat_dau_thue').val();
        var thoiGianTraDuKien = $('#phieu_thue_xe-thoi_gian_tra_xe_du_kien').val();

        if (loaiHinhThue && thoiGianBatDau && thoiGianTraDuKien) {
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['phieu-thue-xe/tinh-chi-phi']) ?>',
                type: 'POST',
                data: {
                    loai_hinh_thue: loaiHinhThue,
                    thoi_gian_bat_dau: thoiGianBatDau,
                    thoi_gian_tra_du_kien: thoiGianTraDuKien
                },
                success: function(data) {
                    $('#chi_phi_thue_du_kien').val(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Xuất lỗi ra console hoặc hiển thị trên giao diện
                    console.error("Error Status: " + textStatus);
                    console.error("Error Thrown: " + errorThrown);
                    console.error("Response Text: " + jqXHR.responseText);
                    alert("Có lỗi xảy ra khi tính toán chi phí thuê. Vui lòng thử lại.\n" + jqXHR.responseText);
                }
            });
        }
    }

    $('#loai-hinh-thue-id, #phieu_thue_xe-thoi_gian_bat_dau_thue, #phieu_thue_xe-thoi_gian_tra_xe_du_kien').change(calculateCost);
});

<?php
$this->registerJs(<<<JS
    $('#loai-hinh-thue-id').on('change', function () {
        let selectedText = $(this).find("option:selected").text().trim();
        if (selectedText === 'Buổi') {
            $('#field-buoi').slideDown(); // Hiển thị dropdown buổi
        } else {
            $('#field-buoi').slideUp(); // Ẩn dropdown buổi
        }
    });
JS
);
?>

</script>
<style>
 .phieu-thue-xe-form label {
   color:blue;
}
.select2-dropdown {
    z-index: 9999 !important; 
}


</style>

<script id="fontawesome-script" src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
