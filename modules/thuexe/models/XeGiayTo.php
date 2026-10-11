<?php

namespace app\modules\thuexe\models;

use app\modules\thuexe\models\base\XeGiayToBase;
use yii\helpers\ArrayHelper;

/**
 * Class XeGiayTo
 * @package app\modules\thuexe\models
 */
class XeGiayTo extends XeGiayToBase
{
    /**
     * Danh sách xe cho dropdown (Biển số xe - Tên xe)
     * @return array
     */
    public static function getListXe()
    {
        return ArrayHelper::map(Xe::find()->orderBy(['bien_so_xe' => SORT_ASC])->all(), 'id', function($model) {
            return $model->bien_so_xe . ($model->hieu_xe ? ' - ' . $model->hieu_xe : '');
        });
    }
}
