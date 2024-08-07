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
                ?'<h5><span class="badge bg-primary"><i class="ti-check"></i></span></h5>'
                :'<h5><span class="badge bg-gray"><i class="ti-close"></i></span></h5>';
        } else {
            return 'Giá trị không thuộc kiểu Boolean!';
        }
    }
}
?>