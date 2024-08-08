<?php

namespace app\modules\vanban\controllers;

use yii\web\Controller;

/**
 * Default controller for the `vanban` module
 */
class VanBanDiController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}