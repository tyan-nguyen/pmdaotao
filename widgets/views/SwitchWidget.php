<?php
namespace app\widgets\views;

use yii\base\Widget;

class SwitchWidget extends Widget{
    public $label;
    public $value;
    public $disabled=false;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        return '
        <div class="form-group">
        <label class="custom-switch">' .
         	
    		'<input type="checkbox" class="custom-switch-input" value="1"'
    		
    		    . ($this->value==1?" checked":"")
    		    
    		    . ($this->disabled==true?" disabled":"")
    		    
    		    . '>
    		<span class="custom-switch-indicator"></span>
    		<span class="custom-switch-description">'.
    		  $this->label
    		.'</span>
	   </label>
        </div>
        ';
    }
}
?>