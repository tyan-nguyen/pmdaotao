<?php

namespace app\modules\nhanvien\models;
use Yii;
use app\modules\nhanvien\models\base\NhanVienBase;
use yii\helpers\ArrayHelper;
use app\custom\CustomFunc;
use app\modules\kholuutru\models\File;
use app\modules\kholuutru\models\LuuKho;

class NhanVien extends NhanVienBase
{
    CONST MODEL_ID = 'NHANVIEN';
    public function getPubName(){
        return $this->ho_ten;
    } 
    
    public function afterDelete()
    {
        File::deleteFileThamChieu($this::MODEL_ID, $this->id); 
        LuuKho::deleteKhoThamChieu($this::MODEL_ID, $this->id); 
        return parent::afterDelete();
    }

    public static function getList()
    {
        $dsnhanVien = NhanVien::find()
            ->where(['trang_thai' => 'Đang làm việc']) 
            ->orderBy(['ho_ten' => SORT_ASC])
            ->all();
    
        return ArrayHelper::map($dsnhanVien, 'id', function ($model) {
            return '+ ' . $model->ho_ten;
        });
    }
    

    public static function getListTD()
    {
        $trinhDoList = [
            'Đại học' => 'Đại học',
            'Cao đẳng' => 'Cao đẳng',
            'Trung cấp' => 'Trung cấp',
            'Khác' => 'Khác',
        ];
        return $trinhDoList;
    }
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->ngay_sinh = CustomFunc::convertDMYToYMD($this->ngay_sinh);
            
        }
        return parent::beforeSave($insert);
    }
    public static function getTenNhanVienByID($id){
        $model = NhanVien::findOne($id);
        return $model?$model->ho_ten:'-';
    }

}