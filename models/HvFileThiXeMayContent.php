<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_file_thi_xe_may_content".
 *
 * @property int $id
 * @property int $id_hoc_vien
 * @property int $id_file
 * @property string $sbd
 * @property string|null $ho_ten
 * @property string|null $ngay_sinh
 * @property string|null $cccd
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property HvFileThiXeMay $file
 */
class HvFileThiXeMayContent extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_file_thi_xe_may_content';
    }

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
            [['id_file'], 'exist', 'skipOnError' => true, 'targetClass' => HvFileThiXeMay::class, 'targetAttribute' => ['id_file' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hoc_vien' => 'Id Hoc Vien',
            'id_file' => 'Id File',
            'sbd' => 'Sbd',
            'ho_ten' => 'Ho Ten',
            'ngay_sinh' => 'Ngay Sinh',
            'cccd' => 'Cccd',
            'ghi_chu' => 'Ghi Chu',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(HvFileThiXeMay::class, ['id' => 'id_file']);
    }

}
