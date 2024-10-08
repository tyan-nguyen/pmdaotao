<?php

namespace app\modules\vanban\models\base;

use Yii;
use app\modules\vanban\models\DmLoaiVanBan;
use app\modules\nhanvien\models\NhanVien;
use app\custom\CustomFunc;
use app\modules\vanban\models\VanBanDen;
use app\modules\vanban\models\VanBanDi;
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
 * @property int|null $so_vao_so
 * @property int|null $vbden_nguoi_nhan
 * @property string|null $vbden_ngay_chuyen
 * @property string|null $vbdi_noi_nhan
 * @property int|null $vbdi_so_luong_ban
 * @property string|null $vbdi_ngay_chuyen
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $so_loai_van_ban
 *
 * @property FileVanBan[] $fileVanBans
 * @property DmLoaiVanBan $loaiVanBan
 * @property VbDinhKem[] $vbDinhKems
 * @property NhanVien $vbdenNguoiNhan
 */
class VanBanBase extends \app\models\VbVanBan
{
    CONST VBDEN_LABEL = 'Văn bản đến';
    CONST VBDI_LABEL = 'Văn bản đi';
    
    /**
     * lấy label cho loại sổ văn bản (đến/đi)
     */
    public function getLoaiSoVBLabel(){
        if($this->so_loai_van_ban == VanBanDen::MODEL_ID)
            return $this::VBDEN_LABEL;
        else if($this->so_loai_van_ban == VanBanDi::MODEL_ID)
            return $this::VBDI_LABEL;
        else 
            return null;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['so_vb', 'nguoi_ky','ngay_ky'], 'required'],
            [['id_loai_van_ban', 'so_vao_so', 'vbden_nguoi_nhan', 'vbdi_so_luong_ban', 'nguoi_tao', 'nam'], 'integer'],
            [['ngay_ky', 'vbden_ngay_den', 'vbden_ngay_chuyen', 'vbdi_ngay_chuyen', 'thoi_gian_tao'], 'safe'],
            [['so_vb', 'trich_yeu', 'nguoi_ky', 'vbdi_noi_nhan', 'ghi_chu','so_loai_van_ban'], 'string', 'max' => 255],
            [['so_loai_van_ban'], 'string', 'max'=>20],
            [['id_loai_van_ban'], 'exist', 'skipOnError' => true, 'targetClass' => DmLoaiVanBan::class, 'targetAttribute' => ['id_loai_van_ban' => 'id']],
            [['vbden_nguoi_nhan'], 'exist', 'skipOnError' => true, 'targetClass' => NhanVien::class, 'targetAttribute' => ['vbden_nguoi_nhan' => 'id']],
        ];
    }
 
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loai_van_ban' => 'Loại văn bản',
            'so_vb' => 'Số văn bản',
            'ngay_ky' => 'Ngày ký',
            'trich_yeu' => 'Trích yếu',
            'nguoi_ky' => 'Người ký',
            'vbden_ngay_den' => 'Ngày đến',
            'so_vao_so' => 'Số vào sổ',
            'vbden_nguoi_nhan' => 'Người nhận',
            'vbden_ngay_chuyen' => 'Ngày chuyển',
            'vbdi_noi_nhan' => 'Nơi nhận',
            'vbdi_so_luong_ban' => 'Số bản',
            'vbdi_ngay_chuyen' => 'Ngày chuyển',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'so_loai_van_ban' => 'Loại sổ văn bản',//phân biệt văn bản đến hoặc đi
            'nam'=>'Sổ văn bản'
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            if($this->nam == NULL){
                $this->nam = date('Y'); 
            }
        }
        
        if($this->ngay_ky != null){
            $this->ngay_ky = CustomFunc::convertDMYToYMD($this->ngay_ky);
        }
  
        return parent::beforeSave($insert);
    }

    
}