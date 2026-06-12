<?php

namespace app\modules\taisan\models;

use app\models\CpDanhMucTaiSan;
use Yii;

class DanhMucTaiSan extends CpDanhMucTaiSan
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
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
            'ghi_chu' => 'Ghi Chú',
            'nguoi_tao' => 'Người Tạo',
            'thoi_gian_tao' => 'Thời Gian Tạo',
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
        return $this->hasMany(TaiSan::class, ['danh_muc_id' => 'id']);
    }

    //get list danh muc tai san để điền vào dropdown
    public static function getList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', function ($model) {
            return '+ ' . $model->ten;
        });
    }
}
