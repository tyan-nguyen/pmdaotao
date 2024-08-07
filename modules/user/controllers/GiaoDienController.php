<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;

/**
 * Default controller for the `user` module
 */
class GiaoDienController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        Yii::$app->params['moduleID'] = 'Module Quản lý tài khoản';
        Yii::$app->params['modelID'] = 'Tùy chỉnh giao diện';
        return parent::beforeAction($action);
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
