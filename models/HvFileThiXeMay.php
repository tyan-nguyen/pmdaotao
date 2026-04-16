<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_file_thi_xe_may".
 *
 * @property int $id
 * @property string|null $ngay_thi
 * @property string $ten_khoa_thi
 * @property string $filename
 * @property string $url
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $ghi_chu
 * @property int|null $da_doc_file_ok
 *
 * @property HvFileThiXeMayContent[] $hvFileThiXeMayContents
 */
class HvFileThiXeMay extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_file_thi_xe_may';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ngay_thi', 'nguoi_tao', 'thoi_gian_tao', 'ghi_chu', 'da_doc_file_ok'], 'default', 'value' => null],
            [['ngay_thi', 'thoi_gian_tao'], 'safe'],
            [['ten_khoa_thi', 'filename', 'url'], 'required'],
            [['nguoi_tao', 'da_doc_file_ok'], 'integer'],
            [['ghi_chu'], 'string'],
            [['ten_khoa_thi', 'filename', 'url'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ngay_thi' => 'Ngay Thi',
            'ten_khoa_thi' => 'Ten Khoa Thi',
            'filename' => 'Filename',
            'url' => 'Url',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'ghi_chu' => 'Ghi Chu',
            'da_doc_file_ok' => 'Da Doc File Ok',
        ];
    }

    /**
     * Gets query for [[HvFileThiXeMayContents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvFileThiXeMayContents()
    {
        return $this->hasMany(HvFileThiXeMayContent::class, ['id_file' => 'id']);
    }

}
