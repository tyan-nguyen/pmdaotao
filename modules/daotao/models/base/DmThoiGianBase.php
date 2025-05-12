<?php

namespace app\modules\daotao\models\base;

use Yii;
use app\models\GdDmThoiGian;
use app\custom\CustomFunc;
use app\modules\daotao\models\TietHoc;

/**
 * This is the model class for table "gd_dm_thoi_gian".
 *
 * @property int $id
 * @property string $ten_thoi_gian
 * @property int $stt
 * @property string $thoi_gian_bd
 * @property string $thoi_gian_kt
 * @property string|null $ghi_chu
 * @property int|null $active
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property GdTietHoc[] $gdTietHocs
 */
class DmThoiGianBase extends GdDmThoiGian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['ten_thoi_gian', 'stt', 'thoi_gian_bd', 'thoi_gian_kt'], 'required'],
            [['stt', 'nguoi_tao', 'active'], 'integer'],
            [['thoi_gian_bd', 'thoi_gian_kt', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['ten_thoi_gian'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_thoi_gian' => 'Tên thời gian',
            'stt' => 'STT',
            'thoi_gian_bd' => 'Bắt đầu',
            'thoi_gian_kt' => 'Kết thúc',
            'ghi_chu' => 'Ghi chú',
            'active' => 'Hiển thị',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }
    
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->thoi_gian_bd = CustomFunc::convertDMYHISToYMDHIS($this->thoi_gian_bd);
            $this->thoi_gian_kt = CustomFunc::convertDMYHISToYMDHIS($this->thoi_gian_kt);
            if($this->active==null){
                $this->active = 0;
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[GdTietHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGdTietHocs()
    {
        return $this->hasMany(TietHoc::class, ['id_thoi_gian_hoc' => 'id']);
    }

}
