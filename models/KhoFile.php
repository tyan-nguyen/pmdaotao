<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kho_file".
 *
 * @property int $id
 * @property int $loai_file
 * @property string|null $file_name
 * @property string|null $file_type
 * @property string|null $file_size
 * @property string $file_display_name
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $doi_tuong
 * @property int $id_doi_tuong
 * @property string|null $ghi_chu
 *
 * @property KhoLoaiFile $loaiFile
 */
class KhoFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kho_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai_file', 'file_display_name', 'id_doi_tuong'], 'required'],
            [['loai_file', 'nguoi_tao', 'id_doi_tuong'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['file_name', 'file_type', 'file_size', 'file_display_name'], 'string', 'max' => 255],
            [['doi_tuong'], 'string', 'max' => 20],
            [['loai_file'], 'exist', 'skipOnError' => true, 'targetClass' => KhoLoaiFile::class, 'targetAttribute' => ['loai_file' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai_file' => 'Loai File',
            'file_name' => 'File Name',
            'file_type' => 'File Type',
            'file_size' => 'File Size',
            'file_display_name' => 'File Display Name',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'doi_tuong' => 'Doi Tuong',
            'id_doi_tuong' => 'Id Doi Tuong',
            'ghi_chu' => 'Ghi Chu',
        ];
    }

    /**
     * Gets query for [[LoaiFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiFile()
    {
        return $this->hasOne(KhoLoaiFile::class, ['id' => 'loai_file']);
    }
}
