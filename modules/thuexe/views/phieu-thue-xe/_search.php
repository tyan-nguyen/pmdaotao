<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\modules\nhanvien\models\NhanVien;
use app\modules\user\models\User;
use app\modules\thuexe\models\Xe;
use kartik\date\DatePicker;
use app\modules\hocvien\models\HocVien;
use app\custom\CustomFunc;

?>


<div class="phieu-thue-xe-search">

<?php $form = ActiveForm::begin([
        'id' => 'myFilterForm',
        'method' => 'get', 
        'options' => [
            'class' => 'myFilterForm'
        ]
]); ?>
    <div class="row">
        <div class="col-md-3">
               <?= $form->field($model, 'ngay_thue_xe')->widget(DatePicker::classname(), [
                  'options' => ['placeholder' => 'Chọn ngày thuê xe  ...'],
                  'pluginOptions' => [
                  'autoclose' => true,
                  'format' => 'dd/mm/yyyy',
                   ]
                ]); ?>
        </div>
        <div class="col-md-3">
               <?= $form->field($model, 'id_hoc_vien')->widget(Select2::classname(), [
                  'data' => ArrayHelper::map(HocVien::find()->all(), 'id', 'ho_ten'), 
                  'language' => 'vi', 
                  'options' => ['placeholder' => 'Chọn học viên...'], 
                  'pluginOptions' => [
                      'allowClear' => true,
                     ],
                ]); ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'ho_ten_nguoi_thue')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'so_cccd_nguoi_thue')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'dia_chi_nguoi_thue')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'so_dien_thoai_nguoi_thue')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
           <?= $form->field($model, 'id_xe')->widget(Select2::classname(), [
                  'data' => ArrayHelper::map(Xe::find()->all(), 'id', 'hieu_xe'), 
                  'language' => 'vi', 
                  'options' => ['placeholder' => 'Chọn xe thuê...',  'id' => 'xe'], 
                  'pluginOptions' => [
                      'allowClear' => true,
                     ],
                
            ]); ?>
        </div>
        <div class="col-md-3">
                <?= $form->field($model, 'id_loai_hinh_thue')->widget(Select2::classname(), [
                  'data' => [],
                  'language' => 'vi',
                  'options' => ['placeholder' => 'Chọn loại hình thuê...', 'id' => 'loai-hinh-thue'],
                  'pluginOptions' => [
                  'allowClear' => true,
                     ],
                ]); ?>
        </div>
        <div class="col-md-3">
                <?= $form->field($model, 'id_nhan_vien_cho_thue')->widget(Select2::classname(), [
                  'data' => ArrayHelper::map(NhanVien::find()->all(), 'id', 'ho_ten'), 
                  'language' => 'vi', 
                  'options' => ['placeholder' => 'Chọn nhân viên...'], 
                  'pluginOptions' => [
                      'allowClear' => true,
                     ],
                ]); ?>
        </div>
        <div class="col-md-3">
               <?= $form->field($model, 'ngay_tra_xe')->widget(DatePicker::classname(), [
                  'options' => ['placeholder' => 'Chọn ngày trả xe  ...', 'id' => 'ngay-tra-xe'],
                  'pluginOptions' => [
                  'autoclose' => true,
                  'format' => 'dd/mm/yyyy',
                   ]
                ]); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_nhan_vien_ky_tra')->widget(Select2::classname(), [
                  'data' => ArrayHelper::map(NhanVien::find()->all(), 'id', 'ho_ten'), 
                  'language' => 'vi', 
                  'options' => ['placeholder' => 'Chọn nhân viên...'], 
                  'pluginOptions' => [
                      'allowClear' => true, 
                     ],
            ]); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_nguoi_gui')->widget(Select2::classname(), [
                  'data' => ArrayHelper::map(User::find()->all(), 'id', 'username'), 
                  'language' => 'vi', 
                  'options' => ['placeholder' => 'Chọn người gửi...'], 
                  'pluginOptions' => [
                      'allowClear' => true, 
                     ],
            ]); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_nguoi_duyet')->widget(Select2::classname(), [
                  'data' => ArrayHelper::map(User::find()->all(), 'id', 'username'), 
                  'language' => 'vi', 
                  'options' => ['placeholder' => 'Chọn người duyệt...'], 
                  'pluginOptions' => [
                      'allowClear' => true, 
                     ],
            ]); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'trang_thai')->dropDownList(
              [
                 'Đã nhập' => 'Đã nhập', 
                 'Đã gửi' => 'Đã gửi',
                 'Đã duyệt' =>'Đã duyệt',
                 'Không duyệt'=>'Không duyệt',
                 'Đã trả'=>'Đã trả',
              ],
             ['prompt' => 'Chọn trạng thái']  // 
            ) ?>
        </div>
    </div>
 
    <?php if (!Yii::$app->request->isAjax){ ?>
    <div class="col-md-12 text-center">
        <div class="form-group mb-0">
	        <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
	    </div>
    </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<script>
    // Xử lý sự kiện loading loại hình thuê dựa trên xe mà người dùng chọn 
$(document).ready(function() {
    $('#xe').change(function() {
        var idXe = $(this).val(); 
        if (idXe) {
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['phieu-thue-xe/get-loai-hinh-thue']) ?>', 
                data: {id_xe: idXe}, 
                success: function(data) {
                    $('#loai-hinh-thue').html(data).trigger('change');
                }
            });
        } else {
            $('#loai-hinh-thue').html('<option></option>').trigger('change');
        }
    });
});
</script>


<style>
.phieu-thue-xe-search label {
    font-weight: bold;
}
.select2-container {
        width: 100% !important;  /* Đảm bảo rằng Select2 chiếm hết chiều rộng của phần tử */
        display: block; /* Đảm bảo Select2 xuống dòng */
    }
</style>

