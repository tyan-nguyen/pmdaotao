<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\kholuutru\models\Kho;
use kartik\depdrop\DepDrop;
use app\modules\kholuutru\models\Ke;
use yii\helpers\Url;
use app\modules\kholuutru\models\Hop;
use app\modules\kholuutru\models\Ngan;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\LuuKho */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="luu-kho-form">

    <?php $form = ActiveForm::begin(); ?>

 	<?= $form->errorSummary($model) ?>

     <?= $form->field($model, 'id_kho')->widget(Select2::classname(), [
            'data' => Kho::getList(),
            'language' => 'vi',
            'options' => ['id'=>'id-kho', 'placeholder' => 'Chọn Kho...'],
            'pluginOptions' => [
                'allowClear' => true,
                'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal2")'),
            ],
    ]);?>
    
    <?= $form->field($model, 'id_ke')->widget(DepDrop::classname(), [
            'options'=>[
                'id'=>'id-ke',
                'placeholder' => 'Chọn Kệ ...'
            ],
            'data' => ($model->isNewRecord 
                ? Ke::getList()
                :($model->id_ke?[$model->id_ke=>$model->ke->ten_ke]:[])),
            'type'=>DepDrop::TYPE_SELECT2,
            'select2Options'=>[
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal2")'),
                ],
            ],
            'pluginOptions'=>[
                'depends'=>['id-kho'],
                //'initialize' => true,
                'url'=>Url::to(['/kholuutru/luu-kho/get-ke-by-kho']),
            ],
        ]);
   ?>
   
   <?= $form->field($model, 'id_ngan')->widget(DepDrop::classname(), [
            'options'=>[
                'id'=>'id-ngan',
                'placeholder' => 'Chọn Ngăn ...'
            ],
            'data' => ($model->isNewRecord 
                ? Ngan::getList()
                :($model->id_ngan?[$model->id_ngan=>$model->ngan->ten_ngan]:[])),
            'type'=>DepDrop::TYPE_SELECT2,
            'select2Options'=>[
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal2")'),
                ],
            ],
            'pluginOptions'=>[
                'depends'=>['id-ke'],
                //'initialize' => true,
                'url'=>Url::to(['/kholuutru/luu-kho/get-ngan-by-ke']),
            ],
        ]);
   ?>
   
   <?= $form->field($model, 'id_hop')->widget(DepDrop::classname(), [
            'options'=>[
                'id'=>'id-hop',
                'placeholder' => 'Chọn Hộp...'
            ],
            'data' => ($model->isNewRecord 
                ? Hop::getList()
                :($model->id_hop?[$model->id_hop=>$model->hop->ten_hop]:[])),
            'type'=>DepDrop::TYPE_SELECT2,
            'select2Options'=>[
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal2")'),
                ],
            ],
            'pluginOptions'=>[
                'depends'=>['id-ngan'],
                //'initialize' => true,
                'url'=>Url::to(['/kholuutru/luu-kho/get-hop-by-ngan']),
            ],
        ]);
   ?>
    
    <?= $form->field($model, 'doi_tuong')->textInput(['readonly'=>true]) ?>
    
    <?= $form->field($model, 'id_doi_tuong')->dropDownList($model->getListDoiTuong($model->doi_tuong, $model->id_doi_tuong),['readonly'=>true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
