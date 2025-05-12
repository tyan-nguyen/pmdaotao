<?php

namespace app\modules\daotao\models\base;

use Yii;
use app\models\GdMonHoc;
use app\modules\daotao\models\HangMonHoc;
use app\modules\daotao\models\TietHoc;

/**
 * This is the model class for table "gd_mon_hoc".
 *
 * @property int $id
 * @property string|null $ma_mon
 * @property string|null $ten_mon
 * @property string|null $ten_mon_sub
 * @property float|null $so_gio_qd
 * @property float|null $so_gio_tt
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property GdHangMonHoc[] $gdHangMonHocs
 * @property GdTietHoc[] $gdTietHocs
 */
class MonHocBase extends GdMonHoc
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma_mon', 'ten_mon', 'ten_mon_sub', 'so_gio_qd', 'so_gio_tt', 'ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['so_gio_qd', 'so_gio_tt'], 'number'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ma_mon'], 'string', 'max' => 20],
            [['ten_mon', 'ten_mon_sub'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_mon' => 'Mã môn',
            'ten_mon' => 'Tên môn',
            'ten_mon_sub' => 'Tên môn sub',
            'so_gio_qd' => 'Số giờ theo QĐ',
            'so_gio_tt' => 'Số giờ thực tế',
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
     * Gets query for [[GdHangMonHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGdHangMonHocs()
    {
        return $this->hasMany(HangMonHoc::class, ['id_mon' => 'id']);
    }

    /**
     * Gets query for [[GdTietHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGdTietHocs()
    {
        return $this->hasMany(TietHoc::class, ['id_mon_hoc' => 'id']);
    }

}
