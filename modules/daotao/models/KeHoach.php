<?php

namespace app\modules\daotao\models;

use Yii;
use app\modules\daotao\models\base\KeHoachBase;

class KeHoach extends KeHoachBase
{
    /**
     * get so luong ke hoach dang cho duyet
     */
    public static function slChoDuyet(){
        return KeHoach::find()->where(['trang_thai_duyet'=>self::TT_CHODUYET])->count();
    }
}
