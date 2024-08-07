<?php
namespace app\widgets\forms;

use yii\base\Widget;

class SwitchWidget extends Widget{
    public $model;
    public $attr;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        $modelName = \yii\helpers\StringHelper::basename(get_class($this->model));
        $attr = $this->attr;
        return '
        <div class="form-group field-'.strtolower($modelName).'-' . $attr . '">
        <label class="custom-switch">
         	<input type="hidden" name="'. $modelName .'['.$this->attr.']" value="0">
    		<input type="checkbox" name="'.$modelName.'['.$this->attr.']" class="custom-switch-input" value="1" '. 
    		  ($this->model->$attr==1?"checked":"") . '>
    		<span class="custom-switch-indicator"></span>
    		<span class="custom-switch-description">'.
    		  $this->model->getAttributeLabel($attr)
    		.'</span>
	   </label>
        <div class="help-block"></div>
        </div>
        ';
    }
}
?>