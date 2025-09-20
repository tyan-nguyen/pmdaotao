<?php
namespace app\modules\banhang\models;

use app\modules\banhang\models\base\LoaiHangHoaBase;
use yii\helpers\ArrayHelper;

class LoaiHangHoa extends LoaiHangHoaBase{
    //get dm loại hàng hóa
    public static function getDmLoaiHangHoa(){
        $ds = LoaiHangHoa::find()->all();
        return ArrayHelper::map($ds, 'id', function($model) {
            return '+ ' . $model->ten_loai_hang_hoa;
        });
    }
    
    //get dm loại hàng hóa trong bán hàng
    public static function getDmLoaiHangHoaBanHang(){
        $ds = LoaiHangHoa::find()->where('id NOT IN (1,10)')->all();
        return ArrayHelper::map($ds, 'id', function($model) {
            return '+ ' . $model->ten_loai_hang_hoa;
        });
    }
}