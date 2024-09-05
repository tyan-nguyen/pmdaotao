<?php
namespace app\modules\kholuutru\models;

use app\modules\kholuutru\models\base\LoaiFileBase;

class LoaiFile extends LoaiFileBase{
    
    /**
     * get tất cả loại file theo đối tượng
     * @param string $doiTuong
     */
    public function getAllByDoiTuong($doiTuong){
        return $this::find()->where(['doi_tuong'=>$doiTuong])->all();
    }
}