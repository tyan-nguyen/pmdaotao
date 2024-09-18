<?php

namespace app\modules\vanban\models;


use app\modules\kholuutru\models\File;

class VanBanDi extends VanBan
{
    CONST MODEL_ID = 'VBDI';
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->so_loai_van_ban = $this::VBDI_VALUE;
        }
        return parent::beforeSave($insert);
    }
    /**
     * {@inheritdoc}
     * xoa file anh, tai lieu, lich su sau khi xoa du lieu
     */
    public function afterDelete()
    {
        File::deleteFileThamChieu($this::MODEL_ID, $this->id);
        return parent::afterDelete();
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['so_vb','trich_yeu','nguoi_ky','ngay_ky'], 'required'],
            [['id_loai_van_ban','vbdi_so_luong_ban', 'nguoi_tao'], 'integer'],
            [['ngay_ky','vbdi_ngay_chuyen', 'thoi_gian_tao'], 'safe'],
            [['so_vb', 'trich_yeu', 'nguoi_ky', 'vbdi_noi_nhan', 'ghi_chu'], 'string', 'max' => 255],
            [['id_loai_van_ban'], 'exist', 'skipOnError' => true, 'targetClass' => DmLoaiVanBan::class, 'targetAttribute' => ['id_loai_van_ban' => 'id']],
            
        ];
    }
    
}