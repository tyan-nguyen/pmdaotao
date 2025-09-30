<?php
namespace app\modules\thuexe\models;

use app\modules\thuexe\models\base\LichThueBase;
use yii\helpers\ArrayHelper;

class LichThue extends LichThueBase
{
    /**
     * lấy danh sách giờ của 01 ngày
     * @return string[]|number[]
     */
    public static function getListHoursOfDay(){
        $listHours = array();
        for($h=0;$h<=23;$h++){
            $hourStr = $h<10 ? ('0'.$h) : $h;
            $listHours[$hourStr] = $hourStr;
        }
        return $listHours;
    }
    /**
     * lấy danh sách phút của 01 giờ
     * @return string[]|number[]
     */
    public static function getListMinutesOfHour(){
        $listHours = array();
        for($i=0;$i<=59;$i++){
            $minuteStr = $i<10 ? ('0'.$i) : $i;
            $listHours[$minuteStr] = $minuteStr;
        }
        return $listHours;
    }
    /**
     * lấy danh sách phút 00,15,30,45 của 01 giờ
     * @return string[]|number[]
     */
    public static function getList15MinutesOfHour(){
        $listHours = array();
        $listHours['00'] = '00';
        $listHours['15'] = '15';
        $listHours['30'] = '30';
        $listHours['45'] = '45';
        return $listHours;
    }
    
    /**
     * get danh muc xe cam ung
     */
    public static function getDsXeCamUng(){
        $dsXe = Xe::find()->where(['phan_loai'=>Xe::PHANLOAI_SATHACH])->all();
        // Thêm dấu + vào trước tên nhân viên
        return ArrayHelper::map($dsXe, 'id', function($model) {
            return '+ ' . $model->tenXeLong;
        });
    }
    
    /**
     * get danh muc loai xe cam ung
     * su dung trong lich thu xe cam ung
     */
    public static function getDsLoaiXeCamUng(){
        //$dsXe = LoaiXe::find()->where('id IN (2,3,4,6,7,8,9,10)')->all();
        $dsXe = LoaiXe::find()->where('id IN (2,3,4,6,10)')->all();
        // Thêm dấu + vào trước tên nhân viên
        return ArrayHelper::map($dsXe, 'id', function($model) {
            return '+ Hạng ' . $model->ten_loai_xe;
        });
    }
    
    /**
     * Danh muc trang thai xe đang sử dụng, sắp sử dụng hay rảnh label
     * @param int $val
     * @return string
     */
    public static function getLabelTrangThaiSuDungXeBadge($idXe)
    {
        $label = '';
        $xeModel = Xe::findOne($idXe);
        if($xeModel){
            $xeRanh = true;
            
            //check xe sắp đến lịch thuê trong 30 phút tới
            $now = date('Y-m-d H:i:s');
            $next30 = date('Y-m-d H:i:s', strtotime('+30 minutes'));
            $checkXe = LichThue::find()->where([
                'trang_thai' => LichThue::TT_LENLICH,
                'id_xe' => $idXe
            ])->andWhere(['<', 'thoi_gian_bat_dau', $next30])
            ->andWhere(['>', 'thoi_gian_ket_thuc', $now])
            ->exists();
            if($checkXe){
                $xeRanh = false;
                $label .= '<span class="badge bg-danger">30 phút nữa</span>';
            }
            
            //check xe đang sử dụng (thuê) nhưng chưa đổi trạng thái
            $checkXe = LichThue::find()->where([
                'trang_thai' => LichThue::TT_LENLICH,
                'id_xe' => $idXe
            ])->andWhere(['<=', 'thoi_gian_bat_dau', $now])
            ->andWhere(['>=', 'thoi_gian_ket_thuc', $now])
            ->exists();
            if($checkXe){
                $xeRanh = false;
                $label .=  ($label==''?'':'<br/>') . '<span class="badge bg-warning">Đang thuê (chưa HĐ)</span>';
            }
            
            //check xe đang sử dụng (thuê) đã đổi trạng thái
            $checkXe = LichThue::find()->where([
                'trang_thai' => LichThue::TT_XUATHOADON,
                'id_xe' => $idXe
            ])->andWhere(['<=', 'thoi_gian_bat_dau', $now])
            ->andWhere(['>=', 'thoi_gian_ket_thuc', $now])
            ->exists();
            if($checkXe){
                $xeRanh = false;
                $label .=  ($label==''?'':'<br/>') . '<span class="badge bg-success">Đang thuê</span>';
            }
            
            if($xeRanh){
                $label = '<span class="badge bg-info">Xe rảnh</span>';
            }
            
            return $label;
            
        } else {
            return null;
        }        
    }
    /**
     * check lich thue hien tai co dang active không
     */
    public static function checkLichDangHieuLucChuaXuatHoaDon($idLich){
        $now = date('Y-m-d H:i:s');
        $checkLich = LichThue::find()->where([
            'id'=>$idLich,
            'trang_thai' => LichThue::TT_LENLICH,
        ])->andWhere(['<=', 'thoi_gian_bat_dau', $now])
        ->andWhere(['>=', 'thoi_gian_ket_thuc', $now])
        ->exists();
        if($checkLich)
            return true;
        else 
            return false;
    }
    /**
     * check lich thue hien tai co dang active không
     */
    public static function checkLichDangHieuLucDaXuatHoaDon($idLich){
        $now = date('Y-m-d H:i:s');
        $checkLich = LichThue::find()->where([
            'id'=>$idLich,
            'trang_thai' => LichThue::TT_XUATHOADON,
        ])->andWhere(['<=', 'thoi_gian_bat_dau', $now])
        ->andWhere(['>=', 'thoi_gian_ket_thuc', $now])
        ->exists();
        if($checkLich)
            return true;
            else
                return false;
    }
    /**
     * check lich thue hien tai co dang chuan bi hieu luc 30 phut toi
     */
    public static function checkLichSapToi($idLich){
        $now = date('Y-m-d H:i:s');
        $next30 = date('Y-m-d H:i:s', strtotime('+30 minutes'));
        $checkLich = LichThue::find()->where([
            'id'=>$idLich
        ])->andWhere(['<', 'thoi_gian_bat_dau', $next30])
        ->andWhere(['>', 'thoi_gian_ket_thuc', $now])
        ->exists();
        if($checkLich)
            return true;
            else
                return false;
    }
    
}