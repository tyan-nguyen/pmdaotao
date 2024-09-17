<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\modules\kholuutru\models\LoaiFile;

class FileDisplayTypeWidget extends Widget{
    public $doiTuong;
    public $idDoiTuong;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        $fileTypes = LoaiFile::getAllByDoiTuong($this->doiTuong);
        if($fileTypes){
            return $this->render('@app/widgets/views/files/by_type', [
                'fileTypes'=>$fileTypes,
                'doiTuong'=>$this->doiTuong,
                'idDoiTuong'=>$this->idDoiTuong
            ]);
        } else {
            return '<div class="text-dark mb-2 ms-1 fs-20 tx-medium">File đính kèm</div><div class="alert alert-primary" role="alert">Chưa có file</div>';
        }
    }
}
?>