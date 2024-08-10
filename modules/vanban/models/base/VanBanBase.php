<?php

namespace app\modules\vanban\models\base;

use Yii;
use app\modules\vanban\models\DmLoaiVanBan;
use app\modules\nhanvien\models\NhanVien;
/**
 * This is the model class for table "van_ban".
 *
 * @property int $id
 * @property int $id_loai_van_ban
 * @property string $so_vb
 * @property string $ngay_ky
 * @property string $trich_yeu
 * @property string $nguoi_ky
 * @property string|null $vbden_ngay_den
 * @property int|null $vbden_so_den
 * @property int|null $vbden_nguoi_nhan
 * @property string|null $vbden_ngay_chuyen
 * @property string|null $vbdi_noi_nhan
 * @property int|null $vbdi_so_luong_ban
 * @property string|null $vbdi_ngay_chuyen
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property FileVanBan[] $fileVanBans
 * @property DmLoaiVanBan $loaiVanBan
 * @property VbDinhKem[] $vbDinhKems
 * @property NhanVien $vbdenNguoiNhan
 */
class VanBanBase extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'vb_van_ban';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['so_vb','trich_yeu','nguoi_ky','ngay_ky'], 'required'],
            [['id_loai_van_ban', 'vbden_so_den', 'vbden_nguoi_nhan', 'vbdi_so_luong_ban', 'nguoi_tao'], 'integer'],
            [['ngay_ky', 'vbden_ngay_den', 'vbden_ngay_chuyen', 'vbdi_ngay_chuyen', 'thoi_gian_tao'], 'safe'],
            [['so_vb', 'trich_yeu', 'nguoi_ky', 'vbdi_noi_nhan', 'ghi_chu'], 'string', 'max' => 255],
            [['id_loai_van_ban'], 'exist', 'skipOnError' => true, 'targetClass' => DmLoaiVanBan::class, 'targetAttribute' => ['id_loai_van_ban' => 'id']],
            [['vbden_nguoi_nhan'], 'exist', 'skipOnError' => true, 'targetClass' => NhanVien::class, 'targetAttribute' => ['vbden_nguoi_nhan' => 'id']],
        ];
    }
 
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loai_van_ban' => 'Id Loai Van Ban',
            'so_vb' => 'Số văn bản',
            'ngay_ky' => 'Ngày ký',
            'trich_yeu' => 'Trích yếu',
            'nguoi_ky' => 'Người ký',
            'vbden_ngay_den' => 'Ngày đến',
            'vbden_so_den' => 'Số đến',
            'vbden_nguoi_nhan' => 'Người nhận',
            'vbden_ngay_chuyen' => 'Ngày chuyển',
            'vbdi_noi_nhan' => 'Nơi nhận',
            'vbdi_so_luong_ban' => 'Số lượng bản',
            'vbdi_ngay_chuyen' => 'Ngày chuyển',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    /**
     * Gets query for [[FileVanBans]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*
    public function getFileVanBans()
    {
     return $this->hasMany(FileVanBan::class, ['id_van_ban' => 'id']);
    }

    /**
     * Gets query for [[LoaiVanBan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiVanBan()
    {
        return $this->hasOne(DmLoaiVanBan::class, ['id' => 'id_loai_van_ban']);
    }

    /**
     * Gets query for [[VbDinhKems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVbDinhKems()
    {
        return $this->hasMany(VbDinhKem::class, ['id_van_ban' => 'id']);
    }

    /**
     * Gets query for [[VbdenNguoiNhan]].
     *
     * @return \yii\db\ActiveQuery
     */
   

    public function getVbdenNguoiNhan()
    {
        return $this->hasOne(NhanVien::class, ['id' => 'vbden_nguoi_nhan']);
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->id_loai_van_ban = 1;

                $this->nguoi_tao = Yii::$app->user->identity->id; // hoặc một cách khác để lấy thông tin người dùng
                $this->thoi_gian_tao = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }
    
}
