<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use kartik\select2\Select2;
use app\modules\thuexe\models\LoaiXe;
use yii\bootstrap5\Modal;
/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\Xe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="xe-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php CardWidget::begin(['title'=>'Thông tin Xe']) ?>

       <div class="row">
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
             <?= $form->field($model, 'hieu_xe')->textInput(['maxlength' => true]) ?>
         </div>
         <div class="col-lg-3 col-md-6">
             <?= $form->field($model, 'bien_so_xe')->textInput(['maxlength' => true]) ?>
         </div>
         <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'trang_thai')->dropDownList(
              [
                 'Khả dụng' => 'Khả dụng', 
                 'Không khả dụng' => 'Không khả dụng'  
              ],
             ['prompt' => 'Chọn trạng thái']  // 
            ) ?>
        </div>

         <div class="col-lg-6 col-md-12">
             <?= $form->field($model, 'tinh_trang_xe')->textarea(['rows' => 8]) ?>
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

<?php Modal::begin([
   'options' => [
        'id'=>'ajaxCrudModal2',
        'tabindex' => false // important for Select2 to work properly
   ],
  // 'dialogOptions'=>['class'=>'modal-lg'],
   'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal2',
    'footer'=>'',// always need it for jquery plugin
    'size'=>Modal::SIZE_LARGE
])?>
<?php Modal::end(); ?>
<style>
.xe-form label {
    font-weight: bold;
}
</style>
