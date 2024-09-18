<?php

namespace app\modules\kholuutru\models\base;

use Yii;
use app\modules\nhanvien\models\NhanVien;
use app\modules\hocvien\models\HocVien;
use app\modules\giaovien\models\GiaoVien;
use app\modules\vanban\models\VanBanDen;
use app\modules\vanban\models\VanBanDi;

/**
 * This is the model class for table "kho_loai_file".
 *
 * @property int $id
 * @property string $ten_loai
 * @property int $ho_so_bat_buoc
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $doi_tuong
 *
 * @property KhoFile[] $khoFiles
 */
class LoaiFileBase extends \app\models\KhoLoaiFile
{
    public static function listDoiTuong(){
        return [NhanVien::MODEL_ID, HocVien::MODEL_ID, GiaoVien::MODEL_ID, VanBanDen::MODEL_ID];
    }
    public static function listDoiTuongLabel($doiTuong){
        if(in_array($doiTuong, LoaiFileBase::listDoiTuong())){
            if($doiTuong == NhanVien::MODEL_ID)
                return 'Nhân viên';
            else if($doiTuong == HocVien::MODEL_ID)
                return 'Học viên';
            else if($doiTuong == GiaoVien::MODEL_ID)
                return 'Giáo viên';
            else if($doiTuong == VanBanDen::MODEL_ID)
                return 'Văn bản đến';
            else if($doiTuong == VanBanDi::MODEL_ID)
                return 'Văn bản đi';
            else 
                return 'Không xác định';
        }
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_loai', 'ho_so_bat_buoc'], 'required'],
            [['ho_so_bat_buoc', 'nguoi_tao'], 'integer'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_loai'], 'string', 'max' => 255],
            [['doi_tuong'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai' => 'Tên loại hồ sơ',
            'ho_so_bat_buoc' => 'Là hồ sơ bắt buộc',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'doi_tuong' => 'Đối tượng',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            if($this->id < 100){
                $last = $this::find()->orderBy(['id'=>SORT_DESC])->one();
                $this->id = $last->id < 100 ? 100 : ($last->id+1);
            }
            if($this->nguoi_tao == null){
                $this->nguoi_tao = Yii::$app->user->id;
            }
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            if($this->ho_so_bat_buoc == null){
                $this->ho_so_bat_buoc = 0;
            }
        }        
        return parent::beforeSave($insert);
    }
}
