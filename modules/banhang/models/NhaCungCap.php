<?php
namespace app\modules\banhang\models;

use app\modules\banhang\models\base\NhaCungCapBase;
use yii\helpers\ArrayHelper;



class NhaCungCap extends NhaCungCapBase
{
    //get dm nhà cung cấp
    public static function getDmNhaCungCap(){
        $ds = NhaCungCap::find()->all();
        return ArrayHelper::map($ds, 'id', function($model) {
            return '+ ' . $model->ten_nha_cung_cap;
        });
    }
    
    public function getCongNoNhaCungCap()
    {
        return $this->hasMany(CongNoNhaCungCap::class, ['id_nha_cung_cap' => 'id']);
    }

    public function getNccDonHangNhaCungCaps()
    {
        return $this->hasMany(DonHangNhaCungCap::class, ['id_nha_cung_cap' => 'id']);
    }

}