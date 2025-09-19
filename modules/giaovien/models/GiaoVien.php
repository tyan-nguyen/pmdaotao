<?php

namespace app\modules\giaovien\models;
use Yii;
use app\modules\giaovien\models\base\GiaoVienBase;
use app\custom\CustomFunc;
use app\modules\kholuutru\models\LuuKho;
use app\modules\kholuutru\models\File;
use yii\helpers\ArrayHelper;

class GiaoVien extends GiaoVienBase
{
    CONST MODEL_ID = 'GIAOVIEN';

    public function getPubName(){
        return $this->ho_ten;
    } 
    //get số điện thoại trong phần thuê xe do tên attribute không giống bảng khách hàng (dien_thoai vs so_dien_thoai)
    //sét tạm nên chỉnh lại so_dien_thoai cho đồng bộ
    public function getSo_dien_thoai(){
        return $this->dien_thoai;
    }

    public function afterDelete()
    {
        File::deleteFileThamChieu($this::MODEL_ID, $this->id); 
        LuuKho::deleteKhoThamChieu($this::MODEL_ID, $this->id); 
        return parent::afterDelete();
    }

    public function beforeSave($insert) {
        $this->ngay_sinh = CustomFunc::convertDMYToYMD($this->ngay_sinh);
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->doi_tuong = 1;
        }
        return parent::beforeSave($insert);
    }
 
    public static function getList()
    {
        $dsnhanVien = GiaoVien::find()
            ->where(['doi_tuong' => '1']) 
            ->orderBy(['ho_ten' => SORT_ASC])
            ->all();
    
        return ArrayHelper::map($dsnhanVien, 'id', function ($model) {
            return '+ ' . $model->ho_ten;
        });
    }
    /**
     * use in datatable
     * @return array|unknown[]|mixed|unknown
     */
    public static function getListName()
    {
        $dsnhanVien = GiaoVien::find()
        ->where(['doi_tuong' => '1'])
        ->orderBy(['ho_ten' => SORT_ASC])
        ->all();
        
        return ArrayHelper::map($dsnhanVien, 'ho_ten', function ($model) {
            return '+ ' . $model->ho_ten;
        });
    }
    /*
     * check lại để bỏ
     * */
    /* public function getArrNguoiSuDung(){
        $arr = [];
        foreach ($this->xes as $xe){
            $arr[] = $xe->id;
        }
        return $arr;
    } */
    
    public function getArrXeDuocSuDung(){
        $arr = [];
        foreach ($this->xes as $xe){
            $arr[] = $xe->id_xe;
        }
        return $arr;
    }
    
    public function getArrHvHuongDan(){
        $arr = [];
        foreach ($this->hvs as $hv){
            $arr[] = $hv->id_hoc_vien;
        }
        return $arr;
    }
    
}