<?php

namespace app\modules\user\models;

use app\custom\CustomFunc;
use Yii;
use app\widgets\views\HistoryWidget;
use app\modules\thuexe\models\LichThue;
use app\modules\user\models\User;

class History extends HistoryBase
{
    /**
    * get lich su thuoc id tham chieu
    * @param string $loai
    * @param int $idthamchieu
    * @return \yii\db\ActiveRecord[]
    */
    public static function getHistoryThamChieu($loai, $idthamchieu){
        return History::find()->where([
            'loai'=>$loai,
            'id_tham_chieu'=>$idthamchieu
        ])->orderBy('id DESC')->all();
    }
    
    /**
     * Hien thi lich su cho view cua cac module co cau hinh luu lich su
     * @param string $loai
     * @param int $idthamchieu
     */
    public static function showHistory($loai,$idthamchieu){
        $his = History::getHistoryThamChieu($loai, $idthamchieu);
        echo HistoryWidget::widget([
            'data'=>$his
        ]);
    }
    
    /**
     * xoa tat ca lich su thuoc id tham chieu(khi xoa tham chieu)
     * @param string $loai
     * @param int $idthamchieu
     */
    public static function xoaHistoryThamChieu($loai, $idthamchieu){
        $models = History::getHistoryThamChieu($loai, $idthamchieu);
        foreach ($models as $indexMod=>$model){
            $model->delete();
        }
    }
    
    /**
     * lay link lien ket den id tham chieu (view action)
     * @return string
     */
    public function getShowLink(){
        switch ($this->loai){
            case LichThue::MODEL_ID:
                $module = 'thuexe';
                $control = 'lich-thue';
                break;
            default:
                $module = 'module';
                $control = 'control';
        }

        $link = '/' . $module . '/' . $control;
        return Yii::getAlias('@web') . $link . '/view?id=' . $this->id_tham_chieu;
    }
    
    /**
     * hien thi ten cua id tham chieu de hien thi trong lich su hoat dong
     * @return string
     */
    public function getShowName(){
        $name = '';
        switch ($this->loai){
            case LichThue::MODEL_ID:
                $query = LichThue::findOne($this->id_tham_chieu);
                $name = $query != null ? $query->xe->bien_so_xe : '';
                break;
            default:
                $name = '';
        }
        
        return $name;
    }
    
    /**
     * hien thi ten loai tham chieu de hien thi trong lich su hoat dong
     * @return string
     */
    public function getShowLoai(){
        $name = '';
        switch ($this->loai){
            case LichThue::MODEL_ID:
                $name = 'Dữ liệu lịch thuê xe';
                break;
            default:
                $name = '';
        }
        
        return $name;
    }
    
    /**
     * hien thi thoi gian tao d/m/y H:i:s
     * @return string
     */
    public function getThoiGianTao(){
        return CustomFunc::convertYMDHISToDMYHI($this->thoi_gian_tao);
    }
    
    /**
     * hien thi ten nguoi thuc hien
     * @return string
     */
    public function getNguoiTao(){
        return CustomFunc::getTenTaiKhoan($this->nguoi_tao);
    }
    
}
