<?php

namespace app\modules\khoahoc\models;

use app\modules\user\models\User;
use Yii;
use yii\helpers\ArrayHelper;

class NhomHangDaoTao extends \app\models\HvNhomHangDaoTao
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma_nhom_hang', 'nguoi_tao', 'thoi_gian_tao', 'ghi_chu'], 'default', 'value' => null],
            [['stt'], 'default', 'value' => 0],
            [['ten_nhom_hang'], 'required'],
            [['stt', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['ma_nhom_hang'], 'string', 'max' => 50],
            [['ten_nhom_hang'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_nhom_hang' => 'Nhóm hạng',
            'ten_nhom_hang' => 'Tên nhóm hạng',
            'stt' => 'STT',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'ghi_chu' => 'Ghi chú',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }

    public static function getList()
    {
        $model = NhomHangDaoTao::find()->orderBy(['stt' => SORT_ASC])->all();
        return ArrayHelper::map($model, 'id', function ($model) {
            return '+ ' . $model->ma_nhom_hang . ' (' . $model->ten_nhom_hang . ')';
        });
    }

    public function getNguoiTao()
    {
        return $this->hasOne(User::class, ['id' => 'nguoi_tao']);
    }
}
