<?php
namespace app\widgets\views;

use yii\base\Widget;

class StatusWithIconWidget extends Widget{
    public $label;
    public $icon='';
    public $type='primary';
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        return '
        <span class="badge bg-'. $this->type .'" style="font-size:12px"><i class="'. $this->icon .'"></i> '. $this->label .'</span>
        ';
    }
}
?>