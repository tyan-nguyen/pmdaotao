<?php

use webvimark\modules\UserManagement\UserManagementModule;

/**
 * @var yii\web\View $this
 */

$this->title = 'Thay đổi mật khẩu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="change-own-password-success">

	<div class="alert alert-success text-center">
		<?= UserManagementModule::t('back', 'Mật khẩu đã được thay đổi thành công!') ?>
	</div>

</div>
