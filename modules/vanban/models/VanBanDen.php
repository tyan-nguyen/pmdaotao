<?php

namespace app\modules\vanban\models;

use app\modules\nhanvien\models\NhanVien;
use app\custom\CustomFunc;
use app\modules\kholuutru\models\File;
use app\modules\kholuutru\models\LoaiFile;
use app\modules\kholuutru\models\LuuKho;

class VanBanDen extends VanBan
{
    CONST MODEL_ID = 'VBDEN';
    public function getPubName(){
        return $this->vbden_so_den;
    }
    
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->so_loai_van_ban = $this::VBDEN_VALUE;
        }
        if($this->vbden_ngay_den != null){
            $this->vbden_ngay_den = CustomFunc::convertDMYToYMD($this->vbden_ngay_den);
        }
        if($this->vbden_ngay_chuyen != null){
            $this->vbden_ngay_chuyen = CustomFunc::convertDMYToYMD($this->vbden_ngay_chuyen);
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
    
    /**
     * get file van ban
     */
    /* public function getFileVB(){
        return File::getOneByLoaiFile(1, $this::MODEL_ID, $this->id);//1 is file vb
    } */
    /**
     * get file dinh kem
     */
    public function getFiles(){
        //return File::getAllByLoaiFile(2, $this::MODEL_ID, $this->id);//2 is vb dinh kem
        return File::getAllByDoiTuong($this::MODEL_ID, $this->id);
    }
    /**
     * get file dinh kem
     */
    public function getFileTypes(){
        //return File::getAllByLoaiFile(2, $this::MODEL_ID, $this->id);//2 is vb dinh kem
        return LoaiFile::getAllByDoiTuong($this::MODEL_ID);
    }
}