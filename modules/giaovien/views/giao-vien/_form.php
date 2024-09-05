<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\nhanvien\models\PhongBan;
use app\modules\user\models\User;
use yii\helpers\ArrayHelper;
use app\modules\nhanvien\models\NhanVien;

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
     
        <div class="col-md-6">
            <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'gioi_tinh')->radioList([
                1 => 'Nam',
                0 => 'Nữ',
                ], [
                     'item' => function($index, $label, $name, $checked, $value) {
                         return "<div class='form-check form-check-inline'>"
                             . "<input class='form-check-input' type='radio' name='{$name}' value='{$value}'" . ($checked ? ' checked' : '') . " id='gioi-tinh-{$index}'>"
                             . "<label class='form-check-label' for='gioi-tinh-{$index}' style='font-weight: normal;'>{$label}</label>"
                             . "</div>";
                         }
                   ]) ?>
        </div>
        
    </div>
    
     
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
        </div>
      
      
    </div>

    <div class="row">
    <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'dien_thoai')->textInput(['maxlength' => true]) ?>
        </div>
      
    </div>

    <div class="row">
    <div class="col-md-6">
    <?= $form->field($model, 'chuc_vu')->dropDownList(
        [
            'Giáo viên' => 'Giáo viên ',
            'Nhân viên / Giáo viên' => 'Nhân viên / Giáo viên',
        ],
        ['prompt' => 'Chọn chức vụ']
    ) ?>
</div>

    <div class="col-md-6">
        <?= $form->field($model, 'tai_khoan')->dropDownList(
            $listTaiKhoan,
            ['prompt' => 'Chọn tài khoản...']
        ) ?>
    </div>
    
</div>


    <div class="row">
      
    <div class="col-md-6">
        <?= $form->field($model, 'trinh_do')->dropDownList(
            NhanVien::getListTD(), // Gọi phương thức để lấy danh sách trình độ
            [
                'prompt' => 'Chọn trình độ', // Placeholder hiển thị khi chưa chọn giá trị
                'class' => 'form-control', // Thay đổi lớp CSS nếu cần
            ]
        ) ?>
    </div>
        <div class="col-md-6">
            <?= $form->field($model, 'ma_so_thue')->textInput(['maxlength' => true]) ?>
        </div>
       
      
    </div>

    <div class="row">
    <div class="col-md-6">
            <?= $form->field($model, 'trang_thai')->dropDownList([
                'Đang làm việc' => 'Đang làm việc',
                'Đã nghỉ việc' => 'Đã nghỉ việc',
            ], ['prompt' => 'Chọn trạng thái']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'kinh_nghiem_lam_viec')->textInput(['rows' => 3]) ?>
        </div>
</div>


<div class="card-body text-center">
        <button class="btn btn-primary btn-block" data-bs-target="#createfile"
            data-bs-toggle="modal"><i class="fe fe-plus mx-2"></i>Add New File</button>
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
    input[type="text"], input[type="email"], select, textarea {
    border: none;
    border-bottom: 1px solid #000; /* Màu của đường gạch dưới */
    border-radius: 0;
    box-shadow: none;
    outline: none;
}

input[type="text"]:focus, input[type="email"]:focus, select:focus, textarea:focus {
    border-bottom: 2px solid #007bff; /* Đổi màu khi focus */
    box-shadow: none;
    outline: none;
}
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

    </style>


<div class="modal" id="createfile" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h5 class="mt-2">Add New File</h5>
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                        </div>
                        <div class="ff_fileupload_wrap p-3">
                            <input id="demo" type="file" name="files" accept="image/jpg, image/png, image/zip" multiple="" class="ff_fileupload_hidden">
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="button">Add</button>
                            <button class="btn ripple btn-danger" data-bs-dismiss="modal" type="button">Cancel</button>
                        </div>
                    </div>
                </div>
</div>
       