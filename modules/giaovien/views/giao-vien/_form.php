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
        <?= $form->field($model, 'tai_khoan')->dropDownList(
            $listTaiKhoan,
            ['prompt' => 'Chọn tài khoản...']
        ) ?>
    </div>
    
    <div class="col-md-6">
        <?= $form->field($model, 'trinh_do')->dropDownList(
            NhanVien::getListTD(), // Gọi phương thức để lấy danh sách trình độ
            [
                'prompt' => 'Chọn trình độ', // Placeholder hiển thị khi chưa chọn giá trị
                'class' => 'form-control', // Thay đổi lớp CSS nếu cần
            ]
        ) ?>
    </div>
</div>


    <div class="row">
      
       
        <div class="col-md-6">
            <?= $form->field($model, 'ma_so_thue')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'kinh_nghiem_lam_viec')->textInput(['rows' => 3]) ?>
        </div>
      
    </div>

    <div class="row">
    <div class="col-md-6">
            <?= $form->field($model, 'trang_thai')->dropDownList([
                'Đang làm việc' => 'Đang làm việc',
                'Đã nghỉ việc' => 'Đã nghỉ việc',
            ], ['prompt' => 'Chọn trạng thái']) ?>
        </div>
</div>


<div class="row">
    <div class="col-md-12">
        <!-- Ẩn tiêu đề và bảng bằng CSS -->
        <h4 id="file-title" style="display: none; color: #ffffff; background-color: #007bff; padding: 10px; text-align: center; border-radius: 5px;">
    Thêm hồ sơ
</h4>

        <table id="file-table" class="table table-bordered" style="display: none;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Loại hồ sơ</th>
                    <th>Hồ sơ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dòng dữ liệu động sẽ được thêm vào đây -->
            </tbody>
        </table>
        <button type="button" class="btn btn-secondary" onclick="addFileRow()">Thêm hồ sơ</button>
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

<script>
    let fileCount = 0;

    function addFileRow() {
        fileCount++;

        // Hiển thị tiêu đề và bảng nếu đây là lần nhấn đầu tiên
        document.getElementById('file-title').style.display = 'block';
        document.getElementById('file-table').style.display = 'table'; // Sử dụng 'table' thay vì 'block' cho thẻ <table>

        let table = document.getElementById('file-table').getElementsByTagName('tbody')[0];
        let newRow = table.insertRow();

        let cell1 = newRow.insertCell(0);
        let cell2 = newRow.insertCell(1);
        let cell3 = newRow.insertCell(2);
        let cell4 = newRow.insertCell(3);

        cell1.innerHTML = fileCount;
 // Tạo dropdown select từ danh sách loại hồ sơ
let selectHtml = '<select name="HsNhanVien[' + fileCount + '][id_loai_ho_so]" class="form-control">';
selectHtml += '<option value="">Chọn loại hồ sơ</option>'; // Tùy chọn mặc định

for (let id in listLoaiHoSo) {
    selectHtml += '<option value="' + id + '"> + ' + listLoaiHoSo[id] + '</option>';
}

selectHtml += '</select>';

cell2.innerHTML = selectHtml;


        cell3.innerHTML = '<input type="file" name="HSNhanVien[' + fileCount + '][file_display_name]" class="form-control" />';
        cell4.innerHTML = '<button type="button" class="btn btn-danger" onclick="removeFileRow(this)">Xóa</button>';
    }

    function removeFileRow(button) {
        let row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);

        // Kiểm tra nếu không còn dòng nào thì ẩn tiêu đề và bảng đi
        let table = document.getElementById('file-table').getElementsByTagName('tbody')[0];
        if (table.rows.length === 0) {
            document.getElementById('file-title').style.display = 'none';
            document.getElementById('file-table').style.display = 'none';
        }
    }
</script>



