<?php

namespace app\modules\danhmuc\models;

use Yii;
use yii\helpers\ArrayHelper;

class DmXa extends \app\models\DmXa
{
    //lấy danh sách fill dropdown
    public static function getList($idtinh=NULL)
    {
        if($idtinh){
            $ds = DmXa::find()->where(['id_tinh'=>$idtinh])->orderBy(['stt' => SORT_ASC])->all();
        }else {
            $ds = DmXa::find()->orderBy(['stt' => SORT_ASC])->all();
        }
        return ArrayHelper::map($ds, 'id', function($model) {
            return '+ ' . $model->ten_xa_full . ' (' . $model->tinh->ten_tinh . ')';
        }, function($model) {
            return $model->tinh->ten_tinh_full;
        });
    }
    
    public static function getTenXa($id){
        $model = self::findOne($id);
        return $model?$model->ten_xa_full:'';
    }
}
