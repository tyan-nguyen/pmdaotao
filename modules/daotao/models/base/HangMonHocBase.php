<?php

namespace app\modules\daotao\models\base;

use Yii;
use app\models\GdHangMonHoc;
use app\modules\khoahoc\models\HangDaoTao;
use app\modules\daotao\models\MonHoc;

/**
 * This is the model class for table "gd_hang_mon_hoc".
 *
 * @property int $id
 * @property int $id_hang
 * @property int $id_mon
 * @property int|null $dang_hieu_luc
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HvHangDaoTao $hang
 * @property GdMonHoc $mon
 */
class HangMonHocBase extends GdHangMonHoc
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dang_hieu_luc', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_hang', 'id_mon'], 'required'],
            [['id_hang', 'id_mon', 'dang_hieu_luc', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['id_hang'], 'exist', 'skipOnError' => true, 'targetClass' => HangDaoTao::class, 'targetAttribute' => ['id_hang' => 'id']],
            [['id_mon'], 'exist', 'skipOnError' => true, 'targetClass' => MonHocBase::class, 'targetAttribute' => ['id_mon' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hang' => 'Hạng đào tạo',
            'id_mon' => 'Môn học',
            'dang_hieu_luc' => 'Đang hiệu lực',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }
    
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            if($this->dang_hieu_luc==null){
                $this->dang_hieu_luc = 0;
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[Hang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHang()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang']);
    }

    /**
     * Gets query for [[Mon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMon()
    {
        return $this->hasOne(MonHoc::class, ['id' => 'id_mon']);
    }

}
