<?php

namespace app\modules\hocvien\models;

use app\models\HvFileThiXeMayContent;
use Yii;

class FileThiXeMayContent extends HvFileThiXeMayContent
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ho_ten', 'ngay_sinh', 'cccd', 'ghi_chu', 'thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['id_hoc_vien', 'id_file', 'sbd'], 'required'],
            [['id_hoc_vien', 'id_file', 'nguoi_tao'], 'integer'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['sbd', 'ngay_sinh', 'cccd'], 'string', 'max' => 50],
            [['ho_ten'], 'string', 'max' => 100],
            [['id_file'], 'exist', 'skipOnError' => true, 'targetClass' => FileThiXeMay::class, 'targetAttribute' => ['id_file' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hoc_vien' => 'Học viên',
            'id_file' => 'File',
            'sbd' => 'SBD',
            'ho_ten' => 'Họ tên',
            'ngay_sinh' => 'Ngày sinh',
            'cccd' => 'CCCD',
            'ghi_chu' => 'Ghi chú',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->nguoi_tao = Yii::$app->user->getId();
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(FileThiXeMay::class, ['id' => 'id_file']);
    }
    /**
     * Gets query for [[DangKyHv]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocVien()
    {
        return $this->hasOne(DangKyHv::class, ['id' => 'id_hoc_vien']);
    }
}
