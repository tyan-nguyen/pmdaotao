<?php

namespace app\modules\taisan\models;

use app\models\CpLoaiTaiSan;
use Yii;

class LoaiTaiSan extends CpLoaiTaiSan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'nguoi_tao'], 'default', 'value' => null],
            [['ten'], 'required'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['nguoi_tao'], 'integer'],
            [['ten'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten' => 'Tên',
            'ghi_chu' => 'Ghi chú',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
        ];
    }
    //hàm beforeSave, set nguoi_tao
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[CpTaiSans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaiSans()
    {
        return $this->hasMany(TaiSan::class, ['loai_tai_san_id' => 'id']);
    }
    //get list danh muc tai san để điền vào dropdown
    public static function getList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', function ($model) {
            return '+ ' . $model->ten;
        });
    }
}
