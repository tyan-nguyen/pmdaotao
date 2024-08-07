<?php

namespace app\modules\user\components;

use webvimark\modules\UserManagement\models\rbacDB\Route;
use app\modules\user\models\User;
use yii\base\Action;
use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class GhostAccessControl extends \webvimark\modules\UserManagement\components\GhostAccessControl
{

}
