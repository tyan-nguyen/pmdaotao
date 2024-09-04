<?php

namespace app\modules\kholuutru\models\base;

use Yii;

/**
 * This is the model class for table "kho_file".
 *
 * @property int $id
 * @property int $id_loai_ho_so
 * @property string|null $file_name
 * @property string|null $file_type
 * @property string|null $file_size
 * @property string $file_display_name
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $doi_tuong
 * @property int $id_doi_tuong
 */
class FileBase extends \app\models\KhoFile
{
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_loai_ho_so', 'file_display_name', 'id_doi_tuong'], 'required'],
            [['id_loai_ho_so', 'nguoi_tao', 'id_doi_tuong'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['file_name', 'file_type', 'file_size', 'file_display_name'], 'string', 'max' => 255],
            [['doi_tuong'], 'string', 'max' => 20],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loai_ho_so' => 'Id Loai Ho So',
            'file_name' => 'File Name',
            'file_type' => 'File Type',
            'file_size' => 'File Size',
            'file_display_name' => 'File Display Name',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'doi_tuong' => 'Doi Tuong',
            'id_doi_tuong' => 'Id Doi Tuong',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($insert);
    }
}
