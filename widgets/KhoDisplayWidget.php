<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\modules\kholuutru\models\LuuKho;
/**
 * This is widget display where save in kho
 *
 * @property string|null $type (ALL-show all, LOAIHOSO-show by group loai ho so)
 * @property string $doiTuong
 * @property int $idDoiTuong
 * @property string $display (THUMB-show thumbnail, LIST-show list)
 * @property string $typeUpload (BOTH-2 option, SINGLE-just upload single file, MULTI-just upload multiple file)
 *
 */
class KhoDisplayWidget extends Widget{
    public $doiTuong;
    public $idDoiTuong;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        $model = LuuKho::getLuuKho($this->doiTuong, $this->idDoiTuong);
        $blockButton = $this->render('@app/widgets/views/kho/buttons', [
            'model'=>$model,
            'doiTuong'=>$this->doiTuong,
            'idDoiTuong'=>$this->idDoiTuong,
        ]);
        $html = '<div id="blockKho' . $this->idDoiTuong . '">';
        $html .= '<div class="text-dark mb-2 ms-1 fs-20 tx-medium">Thông tin lưu kho</div>';
        if($model){
            $html .= $this->render('@app/widgets/views/kho/view', [
                'model'=>$model,
            ]);
        } else {
            $html .= '<div class="alert alert-primary" role="alert">Chưa có lưu kho</div>';
        }
        $html .= '</div>';
        return $blockButton . $html;
    }
}
?>