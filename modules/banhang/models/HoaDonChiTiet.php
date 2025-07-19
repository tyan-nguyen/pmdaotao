<?php
namespace app\modules\banhang\models;

use yii\helpers\ArrayHelper;
use app\modules\banhang\models\base\HoaDonChiTietBase;

class HoaDonChiTiet extends HoaDonChiTietBase{
    /**
     * tính tổng tiền của 1 sản phẩm trong hóa đơn (lấy số lượng * đơn giá - chiết khấu)
     * @return number
     */
    public function getThanhTien(){
        return round( $this->soLuong * $this->donGia - $this->chietKhau ); 
    }
    
    public function danhSachJson(){
        return [
            /* 'id'=>$this->id,
            'idHoaDon'=>$this->id_hoa_don,
            'idVatTu'=>$this->id_vat_tu,
            'loaiVatTu'=>$this->loai_vat_tu,
            'soLuong'=>$this->so_luong,
            'donGia'=>$this->don_gia,
            'ghiChu'=>$this->ghi_chu, */
            'id'=>$this->id,
            'idHoaDon'=>$this->id_don_hang,
            'idHangHoa'=>$this->id_hang_hoa,
            'tenHangHoa'=>$this->hangHoa->ten_hang_hoa,
            'tenLoaiHangHoa'=>$this->hangHoa->loaiHangHoa->ten_loai_hang_hoa,
            'dvt'=>$this->hangHoa->donViTinh->ten_dvt,
            'soLuong'=>$this->so_luong,
            'donGia'=>$this->don_gia,
            'chietKhau'=>$this->chiet_khau,
            'ghiChu'=>$this->ghi_chu,
            'thanhTien'=>$this->thanhTien
        ];
        
    }
}