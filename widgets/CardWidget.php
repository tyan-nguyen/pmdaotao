<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
/**
 * This is widget display view group form item to card container
 *
 *
 */
class CardWidget extends Widget{
    public $title = 'Title';
    public $summary = '';
    public $content = '';
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        
        //$content = ob_get_clean();
        $html = $this->render('@app/widgets/views/card/begin', [
            'title' => $this->title,
            'summary' => $this->summary,
            'content' => $this->content
        ]);
        
        //$html .= $content;
        
        $html .= $this->render('@app/widgets/views/card/end', [
            'title' => $this->title,
            'summary' => $this->summary,
            'content' => $this->content
        ]);
        
        return $html;
    }
}
?>