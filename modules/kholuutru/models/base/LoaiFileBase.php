<?php

namespace app\modules\kholuutru\models\base;

use Yii;

/**
 * This is the model class for table "kho_loai_file".
 *
 * @property int $id
 * @property string $loai
 * @property int $ho_so_bat_buoc
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $doi_tuong
 */
class LoaiFileBase extends \app\models\KhoLoaiFile
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai', 'ho_so_bat_buoc'], 'required'],
            [['ho_so_bat_buoc', 'nguoi_tao'], 'integer'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['loai'], 'string', 'max' => 255],
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
            'loai' => 'Loai',
            'ho_so_bat_buoc' => 'Ho So Bat Buoc',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'doi_tuong' => 'Doi Tuong',
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
