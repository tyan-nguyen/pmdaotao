<?php

namespace app\modules\user\components;

use yii\web\User;
use Yii;

/**
 * Class UserConfig
 * @package webvimark\modules\UserManagement\components
 */
class UserConfig extends \webvimark\modules\UserManagement\components\UserConfig
{
	/**
	 * @inheritdoc
	 */
	public $loginUrl = ['/user/auth/login'];

}
