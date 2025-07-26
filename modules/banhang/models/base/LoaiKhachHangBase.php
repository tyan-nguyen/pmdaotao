<?php

namespace app\modules\banhang\models\base;

use Yii;
use app\modules\banhang\models\KhachHang;
use app\models\BanleLoaiKhachHang;

/**
 * This is the model class for table "kh_loai_khach_hang".
 *
* @property int $id
 * @property string $ten_loai_khach_hang
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property KhKhachHang[] $khKhachHangs
 */
class LoaiKhachHangBase extends BanleLoaiKhachHang
{    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['ten_loai_khach_hang'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_loai_khach_hang'], 'string', 'max' => 200],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai_khach_hang' => 'Tên loại KH',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }
    
    public function beforeSave($insert) {
        
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Gets query for [[KhKhachHangs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhachHangs()
    {
        return $this->hasMany(KhachHang::class, ['id_loai_khach_hang' => 'id']);
    }
    
}
