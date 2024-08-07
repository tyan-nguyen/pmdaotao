<?php
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class CayThietBiWidget extends Widget{
    public $ss;
    public $link;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        return Html::a($this->label, $this->link,
            ['role'=>'modal-remote','title'=> $this->label, 'class'=>'btn-open-link']);
    }
}
?>