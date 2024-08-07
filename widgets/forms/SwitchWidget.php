<?php
namespace app\widgets\forms;

use yii\base\Widget;

class SwitchWidget extends Widget{
    public $model;
    public $attr;
    public $type;
    public $inForm=true;
    public $disabled=false;
    public $showLabel=true;
    public $showHelpBlock=true;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        
        if($this->type=='VIEW'){
            $this->inForm=false;
            $this->disabled=true;
            $this->showLabel=false;
            $this->showHelpBlock=false;
        }
        
        $modelName = \yii\helpers\StringHelper::basename(get_class($this->model));
        $attr = $this->attr;
        return ($this->showHelpBlock==true?'<div class="form-group field-'.strtolower($modelName).'-' . $attr . '">':'')
        
        .'<label class="custom-switch">' .
            ($this->inForm==true?('<input type="hidden" name="'. $modelName .'['.$this->attr.']" value="0">'):'') .
         	
    		'<input type="checkbox" name="'.$modelName.'['.$this->attr.']" class="custom-switch-input" value="1"'
    		
    		    . ($this->model->$attr==1?" checked":"")
    		    
    		    . ($this->disabled==true?" disabled":"")
    		    
    		    . '>
    		<span class="custom-switch-indicator"></span>
    		<span class="custom-switch-description">'.
    		  ($this->showLabel==true?$this->model->getAttributeLabel($attr):'')
    		.'</span>
	   </label>'.
        ($this->showHelpBlock==true?'<div class="help-block"></div>':'').
        ($this->showHelpBlock==true?'</div>':'');
    }
}
?>