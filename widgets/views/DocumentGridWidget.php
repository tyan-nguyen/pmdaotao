<?php
namespace app\widgets\views;

use Yii;
use yii\base\Widget;
use app\modules\dungchung\models\TaiLieu;

class DocumentGridWidget extends Widget{
    public $loai;
    public $id_tham_chieu;
    
    public function init(){
        parent::init();
    }
    
    public function run(){        
        $data = TaiLieu::getTaiLieuThamChieu($this->loai, $this->id_tham_chieu);
        $divId='docsBlock'.$this->id_tham_chieu;
        $maHtml = '<div id="'.$divId.'"><div class="demo-avatar-group d-flex">';
        
        foreach ($data as $key=>$val){
            $maHtml .= '<div class="main-img-user avatar-xl  m-2 ">
    <a title="'. $val->ten_tai_lieu .'" role="modal-remote-2" data-pjax="0" href="'. Yii::getAlias('@web/dungchung/tai-lieu/update-outer?id='. $val->id) . '">
	<img alt="avatar" class="radius" src="'. $val->extUrl . '" data-bs-placement="top" data-bs-toggle="tooltip-primary" >
    </a>
	<a class="badge rounded-pill avatar-icons bg-secondary" 
		role="modal-remote-2" href="'. Yii::getAlias('@web/dungchung/tai-lieu/delete-outer?id='. $val->id) . '" aria-label="Xóa" data-pjax="0" data-request-method="post" data-toggle="tooltip" data-confirm-title="Xác nhận xóa tài liệu?" data-confirm-message="Bạn có chắc chắn thực hiện hành động này?" data-bs-placement="top" data-bs-toggle="tooltip-secondary" data-bs-original-title="Xóa tài liệu này">
		<i class="fe fe-x fs-12 d-flex"></i></a>
</div>'; 
            
        }
        
        $maHtml .= '</div>';
        return $maHtml;
    }
}
?>