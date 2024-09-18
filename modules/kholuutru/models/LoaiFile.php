<?php
namespace app\modules\kholuutru\models;

use app\modules\kholuutru\models\base\LoaiFileBase;
use yii\helpers\ArrayHelper;

class LoaiFile extends LoaiFileBase
{
    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoFiles()
    {
        return $this->hasMany(File::class, ['loai_file' => 'id']);
    }
    /**
     * get tất cả loại file theo đối tượng
     * @param string $doiTuong
     */
    public static function getAllByDoiTuong($doiTuong){
        return LoaiFile::find()->where(['doi_tuong'=>$doiTuong])->all();
    }
    /**
     * get tất cả loại file theo đối tượng để fill dropdown
     * @param string $doiTuong
     */
    public static function getAllByDoiTuongArr($doiTuong){
        return ArrayHelper::map(LoaiFile::getAllByDoiTuong($doiTuong), 'id', 'ten_loai');
    }
    
}