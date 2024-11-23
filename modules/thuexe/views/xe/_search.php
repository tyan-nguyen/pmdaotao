<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\thuexe\models\LoaiXe;
use kartik\select2\Select2;

?>

<div class="xe-search">

<?php $form = ActiveForm::begin([
        'id' => 'myFilterForm',
        'method' => 'get', 
        'options' => [
            'class' => 'myFilterForm'
        ]
]); ?>

<div class="row"  style="text-align: left;">
    <div class="col-md-3">
           <?= $form->field($model, 'id_loai_xe')->widget(Select2::classname(), [
                 'data' => LoaiXe::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn loại xe...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
             ]);?>
    </div>
    <div class="col-md-3">
         <?= $form->field($model, 'hieu_xe')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
         <?= $form->field($model, 'bien_so_xe')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
            <?= $form->field($model, 'trang_thai')->dropDownList(
              [
                 'Khả dụng' => 'Khả dụng', 
                 'Không khả dụng' => 'Không khả dụng'  
              ],
             ['prompt' => 'Chọn trạng thái']  // 
            ) ?>
    </div>
</div>

<?php if (!Yii::$app->request->isAjax){ ?>
    <div class="col-md-12 text-left">
        <div class="form-group mb-0">
	        <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
	    </div>
    </div>
<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<style>
.xe-search label {
    font-weight: bold;
 
}
.select2-container {
        width: 100% !important;  
        display: block; 
    }
</style>
