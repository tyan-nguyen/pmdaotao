<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\kholuutru\models\Kho;
/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\LuuKho */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="luu-kho-form">

    <?php $form = ActiveForm::begin(); ?>

      <div class="row">
            <div class="col-md-6">
               <?= $form->field($model, 'doi_tuong')->dropDownList(
                   [
                     'VBDEN' => '+ Văn bản đến ',
                     'VBDI' => '+ Văn bản đi',
                     'GIAOVIEN' => '+ Giáo viên',
                     'NHANVIEN' =>'+ Nhân viên',
                     'HOCVIEN' =>'+ Học viên',
                   ],
                 [
                    'prompt' => 'Chọn đối tượng',
                    'class' => 'form-control dropdown-with-arrow',
                 ]
            ) ?>
            </div>
            <div class ="col-md-6">
            <?= $form->field($model, 'loai_file')->dropDownList(
                   [],  
                   [
                      'prompt' => 'Chọn loại file...', 
                      'id' => 'loai-file-dropdown',
                      'class' => 'form-control dropdown-with-arrow',
                   ]
                ) ?>
            </div>
      </div>
      <div class ="row">
            <div class="col-md-6">
            <?= $form->field($model, 'id_file')->dropDownList(
                   [],  
                   [
                      'prompt' => 'Chọn File...', 
                      'id' => 'file-dropdown',
                      'class' => 'form-control dropdown-with-arrow',
                   ]
                ) ?>
            </div>
            <div class="col-md-6">
            <?= $form->field($model, 'id_kho')->dropDownList(
              Kho ::getList(), 
                  [
                   'prompt' => 'Chọn kho', 
                   'class' => 'form-control dropdown-with-arrow',
                    'id' => 'kho-dropdown'
                  ]
            ) ?>
            </div>
      </div>
      <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'id_ke')->dropDownList(
                   [],  
                   [
                      'prompt' => 'Chọn kệ...', 
                      'id' => 'ke-dropdown',
                      'class' => 'form-control dropdown-with-arrow',
                   ]
                ) ?>
            </div>
            <div class="col-md-6">
               <?= $form->field($model, 'id_ngan')->dropDownList(
                   [],  
                   [
                    'prompt' => 'Chọn ngăn...', 
                    'id' => 'ngan-dropdown',
                    'class' => 'form-control dropdown-with-arrow',
                   ]
                ) ?>
            </div>
      </div>
      <div class="row">
            <div class="col-md-6">
               <?= $form->field($model, 'id_hop')->dropDownList(
                   [],  
                   [
                      'prompt' => 'Chọn hộp...', 
                      'id' => 'hop-dropdown',
                      'class' => 'form-control dropdown-with-arrow',
                   ]
                ) ?>
            </div>
      </div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<?php
// Lấy danh sách các kệ dựa trên dropdowlist Kho
$this->registerJs("
    $('#kho-dropdown').change(function() {
        var idKho = $(this).val();
        $.ajax({
            url: '" . \yii\helpers\Url::to(['get-to-list']) . "',
            data: {id_kho: idKho},
            success: function(data) {
                var response = $.parseJSON(data);
                var options = '';
                if (response.no_kho) {
                    options = '<option value=\"\">' + response.no_ke + '</option>';
                } else {
                    options = '<option value=\"\">Chọn kệ...</option>';
                    $.each(response, function(id, ten_ke) {
                        options += '<option value=\"' + id + '\">' + ten_ke + '</option>';
                    });
                }
                $('#ke-dropdown').html(options);
            }
        });
    });
");

// Lấy danh sách các ngăn dựa trên dropdowlist Kệ
$this->registerJs("
    $('#ke-dropdown').change(function() {
        var idKe = $(this).val();
        $.ajax({
            url: '" . \yii\helpers\Url::to(['get-to-list-ke']) . "',
            data: {id_ke: idKe},
            success: function(data) {
                var response = $.parseJSON(data);
                var options = '';
                if (response.no_ke) {
                    options = '<option value=\"\">' + response.no_ngan + '</option>';
                } else {
                    options = '<option value=\"\">Chọn ngăn...</option>';
                    $.each(response, function(id, ten_ngan) {
                        options += '<option value=\"' + id + '\">' + ten_ngan + '</option>';
                    });
                }
                $('#ngan-dropdown').html(options);
            }
        });
    });
");

// Lấy danh sách các hộp dựa trên dropdowlist Ngăn
$this->registerJs("
    $('#ngan-dropdown').change(function() {
        var idNgan = $(this).val();
        $.ajax({
            url: '" . \yii\helpers\Url::to(['get-to-list-ngan']) . "',
            data: {id_ngan: idNgan},
            success: function(data) {
                var response = $.parseJSON(data);
                var options = '';
                if (response.no_ngan) {
                    options = '<option value=\"\">' + response.no_hop + '</option>';
                } else {
                    options = '<option value=\"\">Chọn hộp...</option>';
                    $.each(response, function(id, ten_hop) {
                        options += '<option value=\"' + id + '\">' + ten_hop + '</option>';
                    });
                }
                $('#hop-dropdown').html(options);
            }
        });
    });
");

// Lấy danh sách các loại file thuộc đối tượng đã chọn từ dropdowlist đối tượng
// Ví dụ trên dropdowlist ta chọn đối tượng là Nhân viên <=> NHANVIEN trong CSDL
//Nó sẽ hiển thị danh sách tất cả các loại file thuộc đối tượng NHANVIEN tại dropdowlist loại file
$this->registerJs("
    $('#luukho-doi_tuong').change(function() {
        var doiTuong = $(this).val();
        $.ajax({
            url: '" . \yii\helpers\Url::to(['luu-kho/get-loai-file']) . "',
            data: {doi_tuong: doiTuong},
            success: function(data) {
                var response = $.parseJSON(data);
                var options = '<option value=\"\">Chọn loại file...</option>';
                $.each(response, function(id, ten_loai) {
                    options += '<option value=\"' + id + '\">' + ten_loai + '</option>';
                });
                $('#loai-file-dropdown').html(options); // Cập nhật dropdown loại file
            }
        });
    });
");

// Lấy danh sách các file theo loai_file đã chọn ở dropdowlist loại file
// Ví dụ trên dropdowlist loại file ta chọn loại file là Lý lịch nhân viên thì trong dropdowlist
// file nó sẽ hiển thị tất cả các file thuộc loại_file " Lý lịch nhân viên "
$this->registerJs("
    $('#loai-file-dropdown').change(function() {
        var loaiFile = $(this).val();
        $.ajax({
            url: '" . \yii\helpers\Url::to(['luu-kho/get-file']) . "',
            data: {loai_file: loaiFile},
            success: function(data) {
                var response = JSON.parse(data); // hoặc có thể bỏ nếu data đã là JSON
                var options = '<option value=\"\">Chọn File...</option>';
                $.each(response, function(id, file_name) {
                    options += '<option value=\"' + id + '\">' + file_name + '</option>';
                });
                $('#file-dropdown').html(options);
            }
        });
    });
");
?>


<style>
    .luu-kho-form label {
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
.luu-kho-form .form-control {
    border-color: #0000FF; 
    border-width: 1px; 
}
</style>