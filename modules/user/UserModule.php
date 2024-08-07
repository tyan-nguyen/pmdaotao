<?php

namespace app\modules\user;

/**
 * user module definition class
 */
//class UserModule extends \yii\base\Module
class UserModule extends \webvimark\modules\UserManagement\UserManagementModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\user\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
