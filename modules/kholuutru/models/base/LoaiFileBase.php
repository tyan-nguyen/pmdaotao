<?php

namespace app\modules\kholuutru\models\base;

use Yii;

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
            'ten_loai' => 'Tên loại file',
            'ho_so_bat_buoc' => 'Là hồ sơ bắt buộc',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'doi_tuong' => 'Đối tượng',//<hocvien/giangvien/vanbanden...>
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            if($this->nguoi_tao == null){
                $this->nguoi_tao = Yii::$app->user->id;
            }
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }        
        return parent::beforeSave($insert);
    }
}
