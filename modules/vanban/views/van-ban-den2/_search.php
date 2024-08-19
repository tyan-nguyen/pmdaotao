<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */
use app\modules\vanban\models\DmLoaiVanBan;
// Lấy danh sách loại văn bản 
$dmloaivanBans = DmLOaiVanBan::find()->all();
$listDmLoaiVanBan = ArrayHelper::map($dmloaivanBans, 'id', 'ten_loai');
?>

<div class="van-ban-den-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'post',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>

<?= $form->field($model, 'id_loai_van_ban')->dropDownList(
                $listDmLoaiVanBan, 
                ['prompt' => 'Chọn loại văn bản...'] 
            ) ?>

    <?= $form->field($model, 'so_vb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ngay_ky')->textInput() ?>

    <?= $form->field($model, 'trich_yeu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nguoi_ky')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vbden_ngay_den')->textInput() ?>

    <?= $form->field($model, 'vbden_so_den')->textInput() ?>

    <?= $form->field($model, 'vbden_nguoi_nhan')->textInput() ?>

    <?= $form->field($model, 'vbden_ngay_chuyen')->textInput() ?>

    <?= $form->field($model, 'ghi_chu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nguoi_tao')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
