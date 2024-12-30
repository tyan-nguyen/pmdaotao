<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use app\modules\khoahoc\models\KhoaHoc;
use kartik\select2\Select2;
use app\modules\lichhoc\models\PhongHoc;
use app\modules\nhanvien\models\NhanVien;
use kartik\datetime\DateTimePicker;
use app\custom\CustomFunc;
/* @var $this yii\web\View */
/* @var $model app\modules\lichhoc\models\LichThi */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
    $model->thoi_gian_thi = CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_thi);
?>
<div class="lich-thi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php CardWidget::begin(['title'=>'']) ?>

    <div class ="row">
         <div class="col-md-4">
             <?= $form->field($model, 'id_khoa_hoc')->widget(Select2::classname(), [
                 'data' => KhoaHoc::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn khóa học...','id'=>'khoa-hoc-dropdown'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    ],
             ]);?>
         </div>
         <div class="col-md-4">
            <?= $form->field($model, 'id_nhom')->dropDownList([], [
                'id' => 'nhom-dropdown', 
                'prompt' => 'Chọn nhóm...',
             ]) ?>
         </div>

         <div class="col-md-4">
            <?= $form->field($model, 'id_phong_thi')->widget(Select2::classname(), [
                 'data' => PhongHoc::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn phòng học...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    ],
             ]);?>
         </div>
         <div class="col-md-4">
             <?= $form->field($model, 'id_giao_vien_gac')->widget(Select2::classname(), [
                 'data' => NhanVien::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn cán bộ coi thi...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    ],
             ]);?>
         </div>
         <div class="col-md-4">
                   <?= $form->field($model, 'thoi_gian_thi')->widget(\kartik\datetime\DateTimePicker::classname(), [
                     'options' => ['placeholder' => 'Chọn thời gian thi...'],
                     'name' => 'dp_2',
                     'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                     'language' => 'vi',
                     'pluginOptions' => [
                     'autoclose' => true,
                     'format' => 'hh:ii dd-mm-yyyy',
                     ]
                  ]); ?>
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
$this->registerJs("
    $('#khoa-hoc-dropdown').change(function() {
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
                $('#nhom-dropdown').html(options); 
            },
          error: function(jqXHR, textStatus, errorThrown) {
             alert('Lỗi: ' + jqXHR.status + ' - ' + jqXHR.responseText);
             console.error('Chi tiết lỗi:', textStatus, errorThrown);
}

        });
    });
");
?>


<style>
 .lich-thi-form label {
    font-weight: bold;
}
.select2-dropdown {
    z-index: 9999 !important; 
     }
</style>
<script id="fontawesome-script" src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>