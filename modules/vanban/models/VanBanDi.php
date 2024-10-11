<?php

namespace app\modules\vanban\models;

use app\modules\kholuutru\models\LuuKho;
use app\modules\kholuutru\models\File;
use app\custom\CustomFunc;
class VanBanDi extends VanBan
{
    CONST MODEL_ID = 'Văn bản đi';
    public function getPubName(){
        return $this->so_vao_so;
    } 
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->so_loai_van_ban = $this::VBDI_LABEL;
        }
	    if($this->vbdi_ngay_chuyen != null){
            $this->vbdi_ngay_chuyen = CustomFunc::convertDMYToYMD($this->vbdi_ngay_chuyen);
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
        LuuKho::deleteKhoThamChieu($this::MODEL_ID, $this->id); 
        return parent::afterDelete();
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nguoi_ky','ngay_ky','vbdi_so_luong_ban'], 'required'],
            [['id_loai_van_ban','vbdi_so_luong_ban', 'nguoi_tao'], 'integer'],
            [['ngay_ky','vbdi_ngay_chuyen', 'thoi_gian_tao'], 'safe'],
            [['so_vb', 'trich_yeu', 'nguoi_ky', 'vbdi_noi_nhan', 'ghi_chu'], 'string', 'max' => 255],
            [['id_loai_van_ban'], 'exist', 'skipOnError' => true, 'targetClass' => DmLoaiVanBan::class, 'targetAttribute' => ['id_loai_van_ban' => 'id']],
            [['so_vao_so'], 'validateUniqueVbdenSoDen'],
        ];
    }
    
    public function validateUniqueVbdenSoDen($attribute)
    {
        $query = self::find()->where([$attribute => $this->$attribute]);
        if (!$this->isNewRecord) {
            $query->andFilterWhere(['so_loai_van_ban'=>VanBanDi::MODEL_ID, 'nam'=>$this->nam]);
            $query->andWhere(['<>', 'id', $this->id]);
        }
        $existingRecord = $query->exists();
        
        if ($existingRecord) {
            $this->addError($attribute, 'Số đến đã tồn tại trong cơ sở dữ liệu.');
        }
        
        
    }
    
}