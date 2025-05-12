<?php

namespace app\modules\daotao\models;

use Yii;
use app\modules\daotao\models\base\MonHocBase;
use yii\helpers\ArrayHelper;

class MonHoc extends MonHocBase
{
    public static function getList()
    {
        $ds = MonHoc::find()->all();
        
        return ArrayHelper::map($ds, 'id', function ($model) {
            return '+ ' . $model->ten_mon . ($model->ten_mon_sub?' ('.$model->ten_mon_sub.')':'');
        });
    }
    
    public function getTenMon(){
        return $this->ten_mon . ($this->ten_mon_sub?(' ('.$this->ten_mon_sub.')'):'');
    }
}
