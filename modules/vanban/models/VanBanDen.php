<?php

namespace app\modules\vanban\models;

use app\modules\nhanvien\models\NhanVien;

class VanBanDen extends VanBan
{
    
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->so_loai_van_ban = $this::VBDEN_VALUE;
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['so_vb', 'nguoi_ky', 'ngay_ky', 'vbden_so_den'], 'required'],
            [['id_loai_van_ban', 'vbden_so_den', 'vbden_nguoi_nhan', 'nguoi_tao'], 'integer'],
            [['ngay_ky', 'vbden_ngay_den', 'vbden_ngay_chuyen', 'thoi_gian_tao'], 'safe'],
            [['so_vb', 'trich_yeu', 'nguoi_ky', 'ghi_chu', 'so_loai_van_ban'], 'string', 'max' => 255],
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
    public function getLoaiVanBan() {
        return $this->hasOne(LoaiVanBan::class, ['id' => 'id_loai_van_ban']);
    }
}