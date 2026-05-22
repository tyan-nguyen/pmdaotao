<?php

namespace app\modules\taisan\models\base;

use app\modules\taisan\models\DmHangMuc;
use app\modules\taisan\models\PhieuDeNghi;
use Yii;

/**
 * This is the model class for table "cp_phieu_chi_tiet".
 *
 * @property int $id
 * @property int $id_phieu_de_nghi
 * @property int $id_hang_muc
 * @property string|null $chi_tiet
 * @property float|null $so_luong
 * @property float|null $don_gia
 * @property float $chiet_khau
 * @property float|null $thanh_tien
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property DmHangMuc $hangMuc
 * @property PhieuDeNghi $phieuDeNghi
 */
class PhieuChiTietBase extends \app\models\CpPhieuChiTiet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chi_tiet', 'thanh_tien', 'ghi_chu', 'nguoi_tao'], 'default', 'value' => null],
            [['chiet_khau'], 'default', 'value' => 0],
            [['id_phieu_de_nghi', 'id_hang_muc'], 'required'],
            [['id_phieu_de_nghi', 'id_hang_muc', 'nguoi_tao'], 'integer'],
            [['chi_tiet', 'ghi_chu'], 'string'],
            [['so_luong', 'don_gia', 'chiet_khau', 'thanh_tien'], 'number'],
            [['thoi_gian_tao'], 'safe'],
            [['id_phieu_de_nghi'], 'exist', 'skipOnError' => true, 'targetClass' => PhieuDeNghi::class, 'targetAttribute' => ['id_phieu_de_nghi' => 'id']],
            [['id_hang_muc'], 'exist', 'skipOnError' => true, 'targetClass' => DmHangMuc::class, 'targetAttribute' => ['id_hang_muc' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_phieu_de_nghi' => 'Phiếu đề nghị',
            'id_hang_muc' => 'Hạng mục',
            'chi_tiet' => 'Chi tiết',
            'so_luong' => 'Số lượng',
            'don_gia' => 'Đơn giá',
            'chiet_khau' => 'Chiết khấu',
            'thanh_tien' => 'Thành tiền',
            'ghi_chu' => 'Ghi chú',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
        ];
    }

    /**
     * Gets query for [[HangMuc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHangMuc()
    {
        return $this->hasOne(DmHangMuc::class, ['id' => 'id_hang_muc']);
    }

    /**
     * Gets query for [[PhieuDeNghi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhieuDeNghi()
    {
        return $this->hasOne(PhieuDeNghi::class, ['id' => 'id_phieu_de_nghi']);
    }

    /**
     * tính tổng tiền của 1 hạng mục trong phiếu đề nghị (lấy số lượng * đơn giá - chiết khấu)
     * @return number
     */
    public function getThanhTien()
    {
        $result = round($this->so_luong * $this->don_gia - $this->chiet_khau, 2);
        return $result > 0 ? $result : 0;
    }
    //lấy model dạng JSON
    public function danhSachJson()
    {
        return [
            'id' => $this->id,
            'idPhieuDeNghi' => $this->id_phieu_de_nghi,
            'idHangMuc' => $this->id_hang_muc,
            'tenHangMuc' => $this->hangMuc->ten,
            'tenLoaiHangHoa' => $this->hangMuc->loaiHangMuc->ten,
            'dvt' => $this->hangMuc->dvt,
            'soLuong' => $this->so_luong ? $this->so_luong : 0,
            'donGia' => $this->don_gia ? $this->don_gia : 0,
            'chietKhau' => $this->chiet_khau ? $this->chiet_khau : 0,
            'ghiChu' => $this->ghi_chu ? $this->ghi_chu : '',
            'thanhTien' => $this->thanhTien ? $this->thanhTien : 0
        ];
    }
}
