<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use app\custom\CustomFunc;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\modules\thuexe\models\LoaiXe;
/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LoaiHinhThue */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$model->ngay_ap_dung = CustomFunc::convertYMDToDMY($model->ngay_ap_dung);
$model->ngay_ket_thuc = CustomFunc::convertYMDToDMY($model->ngay_ket_thuc);
?>

<div class="loai-hinh-thue-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php CardWidget::begin(['title'=>'Thông tin Loại hình thuê']) ?>
    <div class="row">
         <div class="col-lg-3 col-md-6">
         <?= $form->field($model, 'loai_hinh_thue')->dropDownList(
          [
             'Giờ ' => 'Giờ ',
             'Buổi ' => 'Buổi ',
             'Ngày ' => 'Ngày ',
             '1 Ngày 1 Đêm '=>'1 Ngày 1 Đêm ',
             'Đêm '=>'Đêm ' ,
             'Tuần'=>'Tuần ',
          ],
          [
              'prompt' => 'Chọn loại hình thuê', 
          ]
        ) ?>
         </div>
         <div class="col-lg-3 col-md-6">
         <?= $form->field($model, 'id_loai_xe')->widget(Select2::classname(), [
                 'data' => LoaiXe::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn loại xe...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    ],
             ]);?>
         </div>
         <div class="col-lg-3 col-md-6">
             <?= $form->field($model, 'gia_thue')->textInput() ?>
         </div>
         <div class="col-lg-3 col-md-6">
         <?= $form->field($model, 'ngay_ap_dung')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày áp dụng  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
         </div>
         <div class="col-lg-3 col-md-6">
         <?= $form->field($model, 'ngay_ket_thuc')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày kết thúc  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
         </div>
         <div class="col-lg-3 col-md-6">
               <?= $form->field($model, 'dang_ap_dung', [
                  'template' => "{label}<br>{input}\n{error}",
                   ])->checkbox(['class' => 'form-check-input ','id'=>'gray-checkbox'], false) ?>
               </div>
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
<style>
.loai-hinh-thue-form label {
    font-weight: bold;
}

.select2-container {
        width: 100% !important;  
        display: block;
    }


</style>
