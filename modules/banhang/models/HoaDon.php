<?php
namespace app\modules\banhang\models;

use yii\helpers\ArrayHelper;
use app\modules\banhang\models\base\HoaDonBase;
use app\modules\banhang\models\HangHoa;
use app\modules\banhang\models\HangHoaLichSu;

class HoaDon extends HoaDonBase{
    public function getTongTien(){
        $sum = 0;
        foreach ($this->hoaDonChiTiets as $hdct){
            $sum += $hdct->thanhTien;
        }
        return $sum;
    }
    
    public function dsHangHoa(){
        $result = array();
        foreach ($this->hoaDonChiTiets as $iVt=>$vatTu){
            $result[] = [
                'id'=>$vatTu->id,
                'idHoaDon'=>$vatTu->id_don_hang,
                'idHangHoa'=>$vatTu->id_hang_hoa,
                'tenHangHoa'=>$vatTu->hangHoa->ten_hang_hoa,
                'tenLoaiHangHoa'=>$vatTu->hangHoa->loaiHangHoa->ten_loai_hang_hoa,
                'dvt'=>$vatTu->hangHoa->donViTinh->ten_dvt,
                'soLuong'=>$vatTu->so_luong?$vatTu->so_luong:0,
                'donGia'=>$vatTu->don_gia?$vatTu->don_gia:0,
                'chietKhau'=>$vatTu->chiet_khau?$vatTu->chiet_khau:0,
                'ghiChu'=>$vatTu->ghi_chu?$vatTu->ghi_chu:'',
                'thanhTien'=>$vatTu->thanhTien?$vatTu->thanhTien:0
            ];
        }
        return [
            'tongTien' => $this->getTongTien(),
            'dsVatTu' => $result
        ];
    }
    
    /**
     * xuất hàng khi chuyển trạng thái hóa đơn từ bản nháp -> đã xuất
     */
    public function xuatHang(){
        foreach ($this->hoaDonChiTiets as $iVt=>$chiTiet){
            //sua so luong
            $vatTuModel = HangHoa::findOne($chiTiet->id_hang_hoa);
            $vatTuModel->so_luong = $chiTiet->hangHoa->so_luong - $chiTiet->so_luong;
            if($vatTuModel->save()){
                //luu lich su
                if($chiTiet->so_luong > 0){
                    $lichSuTonKho = new HangHoaLichSu();
                    $lichSuTonKho->id_hang_hoa = $chiTiet->id_hang_hoa;
                    $lichSuTonKho->id_nha_cung_cap = 1; //1 la chua phan loai, khong duoc xoa danh muc id 1
                    $lichSuTonKho->loai_thay_doi = HangHoaLichSu::LOAI_BANLE;
                    $lichSuTonKho->ghi_chu = 'Xuất kho theo đơn hàng bán lẻ ' . $this->soHoaDon;
                    $lichSuTonKho->so_luong = -($chiTiet->so_luong);
                    $lichSuTonKho->so_luong_cu = $chiTiet->hangHoa->so_luong;
                    $lichSuTonKho->so_luong_moi = $vatTuModel->so_luong;
                    $lichSuTonKho->save();                        
                }
            } 
        }
    }
}