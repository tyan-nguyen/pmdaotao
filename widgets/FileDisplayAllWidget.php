<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\modules\kholuutru\models\File;

class FileDisplayAllWidget extends Widget{
    public $doiTuong;
    public $idDoiTuong;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        $files = File::getAllByDoiTuong($this->doiTuong, $this->idDoiTuong);
        if($files){
            return $this->render('@app/widgets/views/files/by_all', [
                'files'=>$files,
            ]);
        } else {
            return '<div class="text-dark mb-2 ms-1 fs-20 tx-medium">File đính kèm</div><div class="alert alert-primary" role="alert">Chưa có file</div>';
        }
    }
}
?>