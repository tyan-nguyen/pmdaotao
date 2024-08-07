<?php
namespace app\widgets\views;

use Yii;
use yii\base\Widget;
use app\modules\dungchung\models\TaiLieu;

class DocumentListWidget extends Widget{
    public $loai;
    public $id_tham_chieu;
    
    public function init(){
        parent::init();
    }
    
    public function run(){

        $data = TaiLieu::getTaiLieuThamChieu($this->loai, $this->id_tham_chieu);
        if($data==null){
            $maHtml = ' Chưa có tài liệu.';
        } else {
            $maHtml = '';
            foreach ($data as $key=>$val){
                $maHtml .= '<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">';
                $maHtml .= '<div class="card overflow-hidden custom-card">';
                $maHtml .= '<a href="'. $val->fileUrl .'" class="mx-auto my-4" target="_blank"><img src="'. $val->extUrl .'" alt="img"></a>';
                $maHtml .= '<div class="card-footer py-2 px-3">';
                $maHtml .= '<div class="d-flex">';
                $maHtml .= '<div class="d-flex text-break">';
                $maHtml .= '<i class="mdi mdi-file-pdf tx-20 text-danger me-1"></i>';
                $maHtml .= '<h6 class="mb-0 mt-2 text-muted">'.$val->ten_file_luu.'</h6>';
                $maHtml .= '</div>';
               /*  $maHtml .= '<div class="ms-auto mt-2">';
                $maHtml .= '<h6 class="text-muted">'. $val->sizeKB .'</h6>';
                $maHtml .= '</div>'; */
                $maHtml .= '</div>';
                $maHtml .= '</div>';
                $maHtml .= '</div>';
                $maHtml .= '</div>';
            }
        }
        return $maHtml;
    }
}
?>