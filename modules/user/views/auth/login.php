<?php
/**
 * @var $this yii\web\View
 * @var $model webvimark\modules\UserManagement\models\forms\LoginForm
 */

use webvimark\modules\UserManagement\components\GhostHtml;
use app\modules\user\UserModule;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use kartik\datetime\DateTimePicker;

$this->title = "Đăng nhập"
?>

<!-- <h4 class="text-center">Đăng nhập phần mềm</h4>     -->
    
    <?php $form = ActiveForm::begin([
			'id' => 'login-form',
			'options'=>['autocomplete'=>'off'],
			'validateOnBlur'=>false,
			'fieldConfig' => [
			    'options' => ['class' => 'form-group text-start'],
				'template'=>"{label}\n{input}\n{error}",
			],
		]) ?>

			<?= $form->field($model, 'username')
				->textInput(['placeholder'=>'Tài khoản', 'autocomplete'=>'off'])->label('Tài khoản') ?>

			<?= $form->field($model, 'password')
				->passwordInput(['placeholder'=>'Mật khẩu', 'autocomplete'=>'off'])->label('Mật khẩu') ?>


			<!-- <?= (isset(Yii::$app->user->enableAutoLogin) && Yii::$app->user->enableAutoLogin) ? $form->field($model, 'rememberMe')->checkbox(['value'=>true]) : '' ?> -->

			<?= Html::submitButton(
				UserModule::t('front', '<i class="fa fa-unlock"></i> &nbsp;ĐĂNG NHẬP'),
				['class' => 'btn btn-lg btn-primary btn-block']
			) ?>

			<!-- <div class="row registration-block">
				<div class="col-sm-6">
					<?= GhostHtml::a(
						UserModule::t('front', "Registration"),
						['/user-management/auth/registration']
					) ?>
				</div>
				<div class="col-sm-6 text-right">
					<?= GhostHtml::a(
						UserModule::t('front', "Forgot password ?"),
						['/user-management/auth/password-recovery']
					) ?>
				</div>
			</div> -->

		<?php ActiveForm::end() ?>
