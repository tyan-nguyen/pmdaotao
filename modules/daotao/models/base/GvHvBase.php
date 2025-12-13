<?php

namespace app\modules\daotao\models\base;

use Yii;
use app\models\GdGvHv;
use app\modules\giaovien\models\GiaoVien;
use app\modules\hocvien\models\HocVien;

/**
 * This is the model class for table "gd_gv_hv".
 *
 * @property int $id
 * @property int $id_giao_vien
 * @property int $id_hoc_vien
 * @property int|null $da_hoan_thanh
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property NvNhanVien $giaoVien
 * @property HvHocVien $hocVien
 */
class GvHvBase extends GdGvHv
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_giao_vien', 'id_hoc_vien'], 'required'],
            [['id_giao_vien', 'id_hoc_vien', 'nguoi_tao', 'da_hoan_thanh'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['id_giao_vien'], 'exist', 'skipOnError' => true, 'targetClass' => GiaoVien::class, 'targetAttribute' => ['id_giao_vien' => 'id']],
            [['id_hoc_vien'], 'exist', 'skipOnError' => true, 'targetClass' => HocVien::class, 'targetAttribute' => ['id_hoc_vien' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_giao_vien' => 'Giáo viên',
            'id_hoc_vien' => 'Học viên',
            'da_hoan_thanh' => 'Đã hoàn thành',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }
    
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->da_hoan_thanh = 0;
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Gets query for [[GiaoVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGiaoVien()
    {
        return $this->hasOne(GiaoVien::class, ['id' => 'id_giao_vien']);
    }
    
    /**
     * Gets query for [[HocVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocVien()
    {
        return $this->hasOne(HocVien::class, ['id' => 'id_hoc_vien']);
    }
    
}
