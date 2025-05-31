<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\modules\khoahoc\models\NhomHoc;
use app\modules\lichhoc\models\PhongHoc;
use kartik\select2\Select2;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\modules\lichhoc\models\LichHoc */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
    $model->ngay = CustomFunc::convertYMDToDMY($model->ngay);
?>
<div class="lich-hoc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php CardWidget::begin(['title'=>'Cập nhật lịch học']) ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'hoc_phan')->dropDownList(
               [
                  'Lý thuyết' => 'Lý thuyết',
                  'Thực hành' => 'Thực hành',
               ],
               [
                  'prompt' => 'Chọn học phần', 
                  'id' => 'hoc-phan-dropdown',
               ]
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model,'id_nhom')->widget(Select2::classname(),[
                'data'=>NhomHoc::getList($idKhoaHoc),
                'language'=>'vi',
                'options'=>['placeholder'=>'Chọn nhóm học...'],
                'pluginOptions'=>[
                    'allowClear'=>true,
                ],
            ]);?>
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
        <?= $form->field($model, 'id_giao_vien')->dropDownList($giaoVienList, [
              'id' => 'giao-vien-dropdown',
              'prompt' => 'Chọn giáo viên...', 
              'options' => [
                    $model->id_giao_vien => ['Selected' => true], 
             ],
       ]) ?>

        </div>
        <div class="col-md-4">
                <?= $form->field($model, 'ngay')->widget(DatePicker::classname(), [
                  'options' => ['placeholder' => 'Chọn ngày học  ...','id'=>'ngay-input'],
                  'pluginOptions' => [
                  'autoclose' => true,
                  'format' => 'dd/mm/yyyy',
                   ]
                ]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'thu', [
                  'template' => '{label}{input}{error}'
                  ])->textInput([
                    'id' => 'thu-input', 
                    'maxlength' => true, 
                    'readonly' => true, 
                    'value' => '',
                  ]); ?>
                    <?= Html::activeHiddenInput($model, 'thu', ['id' => 'thu-hidden']) ?>
        </div>


        <div class="col-md-4">
           <?= $form->field($model, 'tiet_bat_dau')->textInput([
             'type' => 'number',
             'min' => 1, 
             'max' => 13,
             'step' => 1, 
             'required' => true,
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
             'required' => true,
             'id' => 'tiet-ket-thuc',
             'placeholder' => 'Nhập tiết kết thúc (1-13)',
           ]) ?>
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

<?php
$this->registerJs(<<<JS
    function updateThu() {
        const ngayValue = $('#ngay-input').val(); 
        if (!ngayValue) {
            $('#thu-input').val('');
            return;
        }
        const parts = ngayValue.split('/');
        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10) - 1; 
        const year = parseInt(parts[2], 10);
        const date = new Date(year, month, day);
        const dayOfWeek = date.getDay(); 
        
        const daysMap = {
            1: 'Thứ 2', 2: 'Thứ 3', 3: 'Thứ 4', 4: 'Thứ 5',
            5: 'Thứ 6', 6: 'Thứ 7', 0: 'Chủ Nhật'
        };
        
        const thuMap = {
            1: 2, 2: 3, 3: 4, 4: 5, 5: 6, 6: 7, 0: 8
        };

        const thuText = daysMap[dayOfWeek];
        const thuNumber = thuMap[dayOfWeek];

        $('#thu-input').val(thuText); 
        $('#thu-hidden').val(thuNumber);
    }
    updateThu();
    $('#ngay-input').on('change', function() {
        updateThu();
    });
JS
);
?>
<?php
$this->registerJs(" 
    var currentGiaoVien = $('#giao-vien-dropdown').val(); 
    function updateGiaoVienDropdown() {
        var idKhoaHoc = $idKhoaHoc;
        var hocPhan = $('#hoc-phan-dropdown').val();

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

                    // Cập nhật dropdown với các option mới
                    $('#giao-vien-dropdown').html(options);

                    // Sau khi cập nhật, nếu giá trị giáo viên hiện tại có trong options, chọn nó
                    if (currentGiaoVien) {
                        $('#giao-vien-dropdown').val(currentGiaoVien); 
                    }
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
            // Nếu chưa chọn đủ hai dropdown, reset dropdown giao vien
            $('#giao-vien-dropdown').html('<option value=\"\">Chọn giáo viên...</option>');
        }
    }
    $('#hoc-phan-dropdown').change(updateGiaoVienDropdown);
    // Gọi hàm updateGiaoVienDropdown ngay khi trang được tải nếu đã có giá trị sẵn cho hoc-phan
    updateGiaoVienDropdown();
");
?>



<style> 
   .select2-dropdown {
    z-index: 9999 !important; 
     }
</style>


