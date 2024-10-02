<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\modules\kholuutru\models\File;
/**
 * This is widget display file by doiTuong and idDoiTuong
 *
 * @property string|null $type (ALL-show all, LOAIHOSO-show by group loai ho so)
 * @property string $doiTuong
 * @property int $idDoiTuong
 * @property string $display (THUMB-show thumbnail, LIST-show list)
 * @property string $typeUpload (BOTH-2 option, SINGLE-just upload single file, MULTI-just upload multiple file)
 * 
 */
class FileDisplayWidget extends Widget{    
    public $type = 'ALL';
    public $doiTuong;
    public $idDoiTuong;
    public $display = 'THUMB';
    public $typeUpload = 'BOTH';
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        $blockButton = $this->render('@app/widgets/views/files/buttons', [
            'doiTuong'=>$this->doiTuong,
            'idDoiTuong'=>$this->idDoiTuong,
        ]);
        $html = '<div id="blockVanBan' . $this->idDoiTuong . '" class="">';
        if($this->type == 'ALL'){
            $html .= FileDisplayAllWidget::widget([
                'doiTuong'=>$this->doiTuong,
                'idDoiTuong'=>$this->idDoiTuong,
            ]);
        } else if($this->type == 'LOAIHOSO'){
            $html .= FileDisplayTypeWidget::widget([
                'doiTuong'=>$this->doiTuong,
                'idDoiTuong'=>$this->idDoiTuong,
            ]);
        }
        $html .= '</div>';        
        return $blockButton . $html;
    }
}
?>