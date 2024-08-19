<?php

namespace app\modules\hocvien\models\base;

use Yii;

/**
 * This is the model class for table "hv_loai_ho_so".
 *
 * @property int $id
 * @property string $ten_ho_so
 * @property string $loai
 * @property int $ho_so_bat_buot
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoI_gian_tao
 * @property int|null $doi_tuong
 *
 * @property HvHoSoHocVien[] $hvHoSoHocViens
 * @property NvHoSoNhanVien[] $nvHoSoNhanViens
 */
class LoaiHoSoBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_loai_ho_so';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_ho_so', 'loai', 'ho_so_bat_buot'], 'required'],
            [['ho_so_bat_buot', 'nguoi_tao', 'doi_tuong'], 'integer'],
            [['ghi_chu'], 'string'],
            [['thoI_gian_tao'], 'safe'],
            [['ten_ho_so', 'loai'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'ten_ho_so' => 'Tên hồ sơ',
            'loai' => 'Loại',
            'ho_so_bat_buot' => 'Hồ sơ bắt buộc',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoI_gian_tao' => 'Thời gian tạo',
            'doi_tuong' => 'Đối tượng',
        ];
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
              

                $this->nguoi_tao = Yii::$app->user->identity->id; 
                $this->thoi_gian_tao = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }
    /**
     * Gets query for [[HvHoSoHocViens]].
     *
     * @return \yii\db\ActiveQuery
     */
   // public function getHvHoSoHocViens()
   // {
   //     return $this->hasMany(HoSoHocVien::class, ['id_loai_ho_so' => 'id']);
   // }

    /**
     * Gets query for [[NvHoSoNhanViens]].
     *
     * @return \yii\db\ActiveQuery
     */
   // public function getNvHoSoNhanViens()
  // {
   //     return $this->hasMany(NvHoSoNhanVien::class, ['id_loai_ho_so' => 'id']);
   // }
}
