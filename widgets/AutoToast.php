<?php
namespace app\widgets;

use yii\base\Widget;

class AutoToast extends Widget{
    public $id;
    public $title;
    public $time;
    public $message;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        return '
        <div class="toast-container position-fixed top-0 end-0 p-3">
        <div ' . ($this->id!=null?'id="'. $this->id .'"': '') . ' class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
        <strong class="me-auto">'. ($this->title!=null?$this->title: 'Thông báo') .'</strong>
        <small>' . ($this->title!=null?$this->title: 'Vừa xong') . '</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">'.($this->message!=null?$this->message: '').'</div>
        </div>
        </div>
        ';
        
    }
}
?>