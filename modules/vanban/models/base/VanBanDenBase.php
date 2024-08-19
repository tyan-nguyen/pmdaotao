<?php

namespace app\modules\vanban\models\base;

use Yii;
use app\modules\vanban\models\DmLoaiVanBan;
use app\modules\nhanvien\models\NhanVien;
use app\modules\user\models\User;
use app\modules\vanban\models\FileVanBan;
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
class VanBanDenBase extends VanBanBase
{
    /**
     * {@inheritdoc}
     */
  
    public function rules()
    {
        return [
            [['so_vb','trich_yeu','nguoi_ky','ngay_ky','vbden_so_den'], 'required'],
            [['id_loai_van_ban', 'vbden_so_den', 'vbden_nguoi_nhan','nguoi_tao'], 'integer'],
            [['ngay_ky', 'vbden_ngay_den', 'vbden_ngay_chuyen', 'thoi_gian_tao'], 'safe'],
            [['so_vb', 'trich_yeu', 'nguoi_ky', 'ghi_chu','so_loai_van_ban', 'string', 'max' => 255],
            [['id_loai_van_ban'], 'exist', 'skipOnError' => true, 'targetClass' => DmLoaiVanBan::class, 'targetAttribute' => ['id_loai_van_ban' => 'id']],
            [['vbden_nguoi_nhan'], 'exist', 'skipOnError' => true, 'targetClass' => NhanVien::class, 'targetAttribute' => ['vbden_nguoi_nhan' => 'id']],
            [['vbden_so_den'], 'validateUniqueVbdenSoDen'],
        
        ];
    }
    public function validateUniqueVbdenSoDen($attribute)
    {
        $query = self::find()->where([$attribute => $this->$attribute]);
        if (!$this->isNewRecord) {
            $query->andWhere(['<>', 'id', $this->id]);
        }
        $existingRecord = $query->exists();
    
        if ($existingRecord) {
            $this->addError($attribute, 'Số đến đã tồn tại trong cơ sở dữ liệu.');
        }
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

  
     */

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->loai_so_van_ban = VanBanBase::VBDEN_LABEL;
                $this->nguoi_tao = Yii::$app->user->identity->id;
                $this->thoi_gian_tao = date('Y-m-d H:i:s');    
            }        
            return true;
        }
        return false;
    }
    
    
    
}
