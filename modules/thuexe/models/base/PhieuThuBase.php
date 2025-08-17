<?php

namespace app\modules\thuexe\models\base;

use Yii;
use app\modules\user\models\User;
use app\custom\CustomFunc;
use app\models\PtxPhieuThu;
use app\modules\thuexe\models\LichThue;
use app\modules\thuexe\models\PhieuThu;

/**
 * This is the model class for table "banle_phieu_thu".
 *
 * @property int $id
 * @property int $id_lich_thue
 * @property string|null $loai_phieu PHIEUTHU;PHIEUCHI
 * @property float $so_tien
 * @property float|null $chiet_khau
 * @property float|null $so_tien_con_lai
 * @property int|null $ma_so_phieu
 * @property int|null $so_lan_in_phieu
 * @property string|null $hinh_thuc_thanh_toan
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $ghi_chu
 *
 * @property BanleDonHang $donHang
 */
class PhieuThuBase extends PtxPhieuThu
{
    public $tongTienNop;//su dung trong report
    public $tongChietKhau;//su dung trong report
    
    const PHIEUTHULABEL = 'PHIEUTHU';
    const PHIEUCHILABEL = 'PHIEUCHI';
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai_phieu', 'chiet_khau', 'so_tien_con_lai', 'ma_so_phieu', 'so_lan_in_phieu', 'hinh_thuc_thanh_toan', 'nguoi_tao', 'thoi_gian_tao', 'ghi_chu'], 'default', 'value' => null],
            [['id_lich_thue', 'so_tien', 'hinh_thuc_thanh_toan'], 'required'],
            [['id_lich_thue', 'ma_so_phieu', 'so_lan_in_phieu', 'nguoi_tao'], 'integer'],
            [['so_tien', 'chiet_khau', 'so_tien_con_lai'], 'number'],
            [['thoi_gian_tao', 'tongTienNop', 'tongChietKhau', 'tongGioThue'], 'safe'],
            [['ghi_chu'], 'string'],
            [['loai_phieu', 'hinh_thuc_thanh_toan'], 'string', 'max' => 20],
            [['id_lich_thue'], 'exist', 'skipOnError' => true, 'targetClass' => LichThue::class, 'targetAttribute' => ['id_lich_thue' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_lich_thue' => 'Lịch thuê',
            'loai_phieu' => 'Loại phiếu',
            'so_tien' => 'Số tiền',
            'chiet_khau' => 'Chiết khấu',
            'so_tien_con_lai' => 'Số tiền còn lại',
            'ma_so_phieu' => 'Mã số phiêu',
            'so_lan_in_phieu' => 'Số lần in phiếu',
            'hinh_thuc_thanh_toan' => 'Hình thức thanh toán',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'ghi_chu' => 'Ghi chú',
        ];
    }
    
    /**
     * Gets query for [[LichThue]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLichThue()
    {
        return $this->hasOne(LichThue::class, ['id' => 'id_lich_thue']);
    }
    /**
     * get người tạo (bảng User)
     * @return \yii\db\ActiveQuery
     */
    public function getNguoiTao(){
        return $this->hasOne(User::class, ['id' => 'nguoi_tao']);
    }
    
    public function getMaSoPhieu($loaiPhieu)
    {
        if($loaiPhieu==null){
            $loaiPhieu = self::PHIEUTHULABEL;
        }
        $maxMaSoPhieu = self::find()->select('MAX(ma_so_phieu)')->where(['loai_phieu'=>$loaiPhieu])->scalar();
        $newMaSoPhieu = $maxMaSoPhieu ? $maxMaSoPhieu + 1 : 1;
        return $newMaSoPhieu;
    }
    
    public function beforeSave($insert) {
        //$this->ngay_nop = CustomFunc::convertDMYToYMD($this->ngay_nop);
        if ($this->isNewRecord) {
            if($this->nguoi_tao == NULL)
                $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->so_lan_in_phieu = 0;
            if($this->chiet_khau==null){
                $this->chiet_khau = 0;
            }
            if($this->so_tien < 0){
                $this->loai_phieu = self::PHIEUCHILABEL;
            } else{
                $this->loai_phieu = self::PHIEUTHULABEL;
            }
            $this->ma_so_phieu = $this->getMaSoPhieu($this->loai_phieu);
        }
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if($this->so_tien_con_lai == null){
            $tongDaDong = PhieuThu::find()->where(['id_lich_thue'=>$this->id_lich_thue])->sum('so_tien');
            $tongChietKhau = PhieuThu::find()->where(['id_lich_thue'=>$this->id_lich_thue])->sum('chiet_khau');
            $this->so_tien_con_lai = $this->lichThue->tongTien - $tongChietKhau - $tongDaDong;
            $this->updateAttributes(['so_tien_con_lai']);
        }
        if($this->so_tien_con_lai <= 0){
            $lichThue = LichThue::findOne($this->id_lich_thue);
            if($lichThue && $lichThue->trang_thai != LichThue::TT_XUATHOADON){
                $lichThue->trang_thai = LichThue::TT_XUATHOADON;
                $lichThue->updateAttributes(['trang_thai']);
            }
        }
    }
    
    /**
     * Danh muc hinh thuc chuyen khoan
     * @return string[]
     */
    public static function getDmHinhThucThanhToan()
    {
        return [
            'TM' => 'Tiền mặt',
            'CK' => 'Chuyển khoản',
        ];
    }
    
    /**
     * Danh muc trang thai label
     * @param int $val
     * @return string
     */
    public function getHinhThucThanhToan($val = NULL)
    {
        if ($val == NULL) {
            $val = $this->hinh_thuc_thanh_toan;
        }
        switch ($val) {
            case 'CK':
                $label = "Chuyển khoản";
                break;
            case 'TM':
                $label = "Tiền mặt";
                break;
            default:
                $label = '';
        }
        return $label;
    }
    
    /**
     * Danh muc loai phieu label
     * @param int $val
     * @return string
     */
    public function getTenLoaiPhieu($val = NULL)
    {
        if ($val == NULL) {
            $val = $this->loai_phieu;
        }
        switch ($val) {
            case self::PHIEUTHULABEL:
                $label = "Phiếu thu";
                break;
            case self::PHIEUCHILABEL:
                $label = "Phiếu chi";
                break;
            default:
                $label = '';
        }
        return $label;
    }
    
}