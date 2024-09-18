<?php
namespace app\widgets;

use yii\base\Widget;

class BoolViewWidget extends Widget{
    public $value;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        if($this->value==0 || $this->value==1){
            return $this->value==1
                ?'<i class="fe fe-check text-primary"></i>'
                :'<i class="fe fe-x text-gray"></i>';
        } else {
            return 'Giá trị không thuộc kiểu Boolean!';
        }
    }
}
?>