<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\thuexe\models\LoaiXe;
use kartik\date\DatePicker;

?>

<?php $form = ActiveForm::begin([
        'id' => 'myFilterForm',
        'method' => 'get', 
        'options' => [
            'class' => 'myFilterForm'
        ]
]); ?>

<div class="row" style="text-align:left;" >
    <div class="col-md-3">
       <?= $form->field($model, 'loai_hinh_thue')->dropDownList(
          [
             'Giờ ' => 'Giờ ',
             'Buổi ' => 'Buổi ',
             'Ngày ' => 'Ngày ',
             '1 Ngày 1 Đêm '=>'1 Ngày 1 Đêm ',
             'Đêm '=>'Đêm ' 
          ],
          [
              'prompt' => 'Chọn loại hình thuê', 
          ]
        ) ?>
    </div>
    <div class="col-md-3">
            <?= $form->field($model, 'id_loai_xe')->widget(Select2::classname(), [
                 'data' => LoaiXe::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn loại xe...','id'=>'loai_xe_id'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
             ]);?>
    </div>
    <div class="col-md-3">    
         <?= $form->field($model, 'gia_thue')->textInput() ?>
    </div>
    <div class="col-md-3">
           <?= $form->field($model, 'ngay_ap_dung')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày áp dụng  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
    </div>
    <div class="col-md-3">
            <?= $form->field($model, 'ngay_ket_thuc')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày kết thúc  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
    </div>
    <div class="col-md-3">
             <?= $form->field($model, 'dang_ap_dung', [
                  'template' => "{label}<br>{input}\n{error}",
                   ])->checkbox(['class' => 'form-check-input ','id'=>'gray-checkbox'], false) ?>
    </div>
</div>

    <?php if (!Yii::$app->request->isAjax){ ?>
    <div class="col-md-12>
        <div class="form-group mb-0">
	        <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
	    </div>
    </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<style>
.loai-hinh-thue-search label {
    font-weight: bold;

}
.select2-container {
        width: 100% !important;  
        display: block; 
    }
</style>
