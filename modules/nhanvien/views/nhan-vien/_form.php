<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\nhanvien\models\PhongBan;
use app\modules\user\models\User;
use yii\helpers\ArrayHelper;
use app\modules\nhanvien\models\NhanVien;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\NhanVien */
/* @var $form yii\widgets\ActiveForm */


$phongBans = PhongBan::find()->all();
$listPhongBan = ArrayHelper::map($phongBans, 'id', 'ten_phong_ban');


$taiKhoans = User::find()->all();
$listTaiKhoan = ArrayHelper::map($taiKhoans, 'id', 'username');

?>

<div class="nhan-vien-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
     
        <div class="col-md-4">
            <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'gioi_tinh')->dropDownList([
             1 => 'Nam',
             0 => 'Nữ',
             ], ['prompt' => 'Chọn giới tính', 'class' => 'form-control']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'ngay_sinh')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày sinh  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
            </div>
      
    </div>
    
     
  

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
        </div>
      
        <div class="col-md-4">
            <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'dien_thoai')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">

        <?= $form->field($model, 'tai_khoan')->dropDownList(
            $listTaiKhoan,
            ['prompt' => 'Chọn tài khoản...']
        ) ?>
      
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'id_phong_ban')->dropDownList(
                $listPhongBan,
                [
                    'prompt' => 'Chọn phòng ban...',
                    'id' => 'phong-bans-dropdown'
                ]
            ) ?>
        </div>
    </div>

    <div class="row">
       <div class="col-md-4">
            <?= $form->field($model, 'id_to')->dropDownList(
                [],  
                ['prompt' => 'Chọn tổ...', 'id' => 'to-dropdown']
            ) ?>
        </div>
        <div class="col-md-4">
             <?= $form->field($model, 'chuc_vu')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
             <?= $form->field($model, 'trinh_do')->textInput(['maxlength' => true]) ?>
       </div> 
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'chuyen_nganh')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'vi_tri_cong_viec')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'ma_so_thue')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
       <div class="col-md-4">
            <?= $form->field($model, 'kinh_nghiem_lam_viec')->textarea(['rows' => 6]) ?>
        </div>
       <div class="col-md-4">
            <?= $form->field($model, 'trang_thai')->dropDownList([
                'Đang làm việc' => 'Đang làm việc',
                'Đã nghỉ việc' => 'Đã nghỉ việc',
            ], ['prompt' => 'Chọn trạng thái']) ?>
        </div>
</div>




    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJs("
    $('#phong-bans-dropdown').change(function() {
        var idPhongBan = $(this).val();
        $.ajax({
            url: '" . \yii\helpers\Url::to(['get-to-list']) . "',
            data: {id_phong_ban: idPhongBan},
            success: function(data) {
                var response = $.parseJSON(data);
                var options = '';
                if (response.no_to) {
                    options = '<option value=\"\">' + response.no_to + '</option>';
                } else {
                    options = '<option value=\"\">Chọn tổ...</option>';
                    $.each(response, function(id, ten_to) {
                        options += '<option value=\"' + id + '\">' + ten_to + '</option>';
                    });
                }
                $('#to-dropdown').html(options);
            }
        });
    });
");
?>
<style>
 
.nhan-vien-form label {
    font-weight: bold;
}

select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background: transparent;
    border: 1px solid #ced4da; 
    border-radius: 0.25rem;
    padding: 0.375rem 0.75rem;
    background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6"><path fill="%23000000" d="M1 1l4 4 4-4"/></svg>');
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 10px;
}

select:focus {
    outline: none;
    box-shadow: none;
}
.form-check-label {
        font-weight: normal; 
    }
.nhan-vien-form .form-control {
    border-color: #0000FF; 
    border-width: 1px; 
}
    </style>




