<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\hocvien\models\HangDaoTao;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\widgets\CardWidget;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile('@web/css/hocVien.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);
?>
<?php
$model->ngay_sinh = CustomFunc::convertYMDToDMY($model->ngay_sinh);
?>
<div class="hv-hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php CardWidget::begin(['title'=>'Thông tin cá nhân học viên']) ?>
   <div class ='row'>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'gioi_tinh')->dropDownList([
             1 => 'Nam',
             0 => 'Nữ',
             ], ['prompt' => 'Chọn giới tính', 'class' => 'form-control dropdown-with-arrow']) ?>
        </div>
            <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ngay_sinh')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày sinh  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
            </div>
            <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>
            </div>
    </div>
    <?php CardWidget::end() ?>
    <?php CardWidget::begin(['title'=>'Thông tin đào tạo']) ?>
    <div class ='row'>
    <div class="col-lg-3 col-md-6">
        <?= $form->field($model, 'id_hang')->dropDownList(
    HangDaoTao::getList(), 
    [
        'prompt' => 'Chọn hạng',
        'class' => 'form-control dropdown-with-arrow',
        'id' => 'hang-dropdown',
    ]
    ) ?>
         </div>
    <div class="col-lg-3 col-md-6">
           <?= $form->field($model, 'id_khoa_hoc')->widget(Select2::classname(), [
               'data' => [],  
               'language' => 'vi',  
               'options' => [
                   'placeholder' => 'Chọn Khóa học...',  
                   'class' => 'form-control dropdown-with-arrow',  
                   'id' => 'khoa-hoc-dropdown'  
                 ],
                'pluginOptions' => [
                    'allowClear' => true,  
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),  
                  ],
           ]); ?>
    </div>        
    </div>
    <?php CardWidget::end() ?>
</div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<?php

$this->registerJs("
    $('#hang-dropdown').change(function() {
        var idHang = $(this).val();
        $.ajax({
            url: '" . \yii\helpers\Url::to(['get-to-list']) . "',
            data: {id_hang: idHang},
            success: function(data) {
                var response = $.parseJSON(data);
                var options = '';
                if (response.no_khoa_hoc) {
                    options = '<option value=\"\">' + response.no_khoa_hoc + '</option>';
                } else {
                    options = '<option value=\"\">Chọn Khóa học...</option>';
                    $.each(response, function(id, ten_khoa_hoc) {
                        options += '<option value=\"' + id + '\">' + ten_khoa_hoc + '</option>';
                    });
                }
                $('#khoa-hoc-dropdown').html(options);
            }
        });
    });
");
?>
