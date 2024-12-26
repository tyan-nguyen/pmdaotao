
<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\giaovien\models\GiaoVien;
use kartik\date\DatePicker;
use app\modules\khoahoc\models\KhoaHoc;
use app\modules\lichhoc\models\PhongHoc;
use kartik\select2\Select2;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="khoa-hoc-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'get',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>

<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'id_khoa_hoc')->widget(Select2::classname(), [
             'data' => KhoaHoc::getList(),
                'language' => 'vi',
                'options' => ['placeholder' => 'Chọn khóa học...','id'=>'khoa-hoc2-dropdown'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
         ]);?>
    </div>
    <div class="col-md-4">
            <?= $form->field($model, 'hoc_phan')->dropDownList(
               [
                  'Lý thuyết' => 'Lý thuyết',
                  'Thực hành' => 'Thực hành',
               ],
               [
                  'prompt' => 'Chọn học phần', 
                  'id' => 'hoc-phan2-dropdown',
               ]
            ) ?>
        </div>
        <div class="col-md-4">
             <?= $form->field($model, 'id_nhom')->dropDownList([], [
                'id' => 'nhom2-dropdown', 
                'prompt' => 'Chọn nhóm...',
             ]) ?>
       </div>
        <div class="col-md-4">
             <?= $form->field($model, 'id_phong')->widget(Select2::classname(), [
                 'data' => PhongHoc::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn phòng học...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
             ]);?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'id_giao_vien')->dropDownList([], [
                'id' => 'giao-vien2-dropdown', 
                'prompt' => 'Chọn giáo viên...',
             ]) ?>
        </div>
        <div class="col-md-4">
                <?= $form->field($model, 'ngay')->widget(DatePicker::classname(), [
                  'options' => ['placeholder' => 'Chọn ngày học  ...','id'=>'ngay2-input'],
                  'pluginOptions' => [
                  'autoclose' => true,
                  'format' => 'dd/mm/yyyy',
                   ]
                ]); ?>
        </div>
        <div class="col-md-4">
           <?= $form->field($model, 'tiet_bat_dau')->textInput([
             'type' => 'number',
             'min' => 1, 
             'max' => 13,
             'step' => 1, 
             'id' => 'tiet-bat-dau',
             'placeholder' => 'Nhập tiết bắt đầu (1-13)',
           ]) ?>
        </div>
        <div class="col-md-4">
           <?= $form->field($model, 'tiet_ket_thuc')->textInput([
             'type' => 'number',
             'min' => 1, 
             'max' => 13,
             'step' => 1, 
             'id' => 'tiet-ket-thuc',
             'placeholder' => 'Nhập tiết kết thúc (1-13)',
           ]) ?>
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


<?php
$this->registerJs("
    $('#khoa-hoc2-dropdown').change(function() {
        var idKhoaHoc = $(this).val(); 
        $.ajax({
            url: '" . \yii\helpers\Url::to(['get-nhom-list']) . "', 
            data: {id_khoa_hoc: idKhoaHoc}, 
            success: function(data) {
                var response = $.parseJSON(data); 
                var options = '<option value=\"\">Chọn nhóm...</option>';
                if (response.no_nhom) {
                    options = '<option value=\"\">' + response.no_nhom + '</option>'; 
                } else {
                    $.each(response, function(id, ten_nhom) {
                        options += '<option value=\"' + id + '\">' + ten_nhom + '</option>'; 
                    });
                }
                $('#nhom2-dropdown').html(options); 
            },
          error: function(jqXHR, textStatus, errorThrown) {
             alert('Lỗi: ' + jqXHR.status + ' - ' + jqXHR.responseText);
             console.error('Chi tiết lỗi:', textStatus, errorThrown);
}

        });
    });
");
?>

<?php
$this->registerJs("
    function updateGiaoVienDropdown() {
        var idKhoaHoc = $('#khoa-hoc-dropdown').val();
        var hocPhan = $('#hoc-phan2-dropdown').val();

        if (idKhoaHoc && hocPhan) {
            $.ajax({
                url: '" . Url::to(['get-giao-vien-list']) . "',
                type: 'POST',
                data: {
                    id_khoa_hoc: idKhoaHoc,
                    hoc_phan: hocPhan,
                    _csrf: yii.getCsrfToken() 
                },
                success: function(data) {
                    console.log(data);
                    var response = $.parseJSON(data);
                    console.log(response); 
                    var options = '';
                    if (response.no_giao_vien) {
                        options = '<option value=\"\">' + response.no_giao_vien + '</option>';
                    } else {
                        options = '<option value=\"\">Chọn giáo viên...</option>';
                        $.each(response, function(id, ho_ten) {
                            options += '<option value=\"' + id + '\">' + ho_ten + '</option>';
                        });
                    }
                    $('#giao-vien2-dropdown').html(options);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 403) {
                        alert('Bạn không có quyền truy cập chức năng này.');
                    } else {
                        alert('Lỗi: ' + jqXHR.status + ' - ' + jqXHR.responseText);
                        console.error('Chi tiết lỗi:', textStatus, errorThrown);
                    }
                }
            });
        } else {
            // Nếu chưa chọn đủ hai dropdown, reset dropdown giao viên
            $('#giao-vien2-dropdown').html('<option value=\"\">Chọn giáo viên...</option>');
        }
    }

    // Lắng nghe sự kiện change trên cả hai dropdown
    $('#khoa-hoc2-dropdown').change(updateGiaoVienDropdown);
    $('#hoc-phan2-dropdown').change(updateGiaoVienDropdown);
");
?>

<style>
    .khoa-hoc-search label {
    font-weight: bold;
}
.select2-container {
        width: 100% !important;  
        display: block; 
    }
</style>