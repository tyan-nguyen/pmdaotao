<?php
namespace app\widgets\forms;

use yii\base\Widget;

class RadioWidget extends Widget{
    public $model;
    public $attr;
    public $type;
    public $list;
    public $isNew=false;
    public $disabled=false;
    public $showHelpBlock=true;
    public $showInline=false;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        
        if($this->type=='VIEW'){
            $this->disabled=true;
            $this->showHelpBlock=false;
            $this->showInline = true;
        }
        
        $modelName = \yii\helpers\StringHelper::basename(get_class($this->model));
        $attr = $this->attr;
        
        $maHtml = '';
        $maHtml .= ($this->showHelpBlock==true?'<div class="form-group field-'.strtolower($modelName).'-' . $attr . '">':'');
        
        $fistElement = true;
        foreach ($this->list as $val=>$lab){         
            $maHtml .= '<label class="custom-control custom-radio' . ($this->showInline==true?' custom-inline-radio' : '') . '">';
            $maHtml .= '<input type="radio" name="'.$modelName.'['.$this->attr.']" class="custom-control-input" value="'. $val .'"'
        		
                . ($this->isNew==true?
                    ($fistElement==true?" checked":"")
                    :($this->model->$attr==$val?" checked":"")
        		  )  
        		    . ($this->disabled==true?" disabled":"")
        		    
        		    . '>';
        	$maHtml .=	'<span class="custom-control-label">';
        	$maHtml .= $lab;
        	$maHtml .=	'</span>';
            
        	$maHtml .= '</label>';
        	
        	$fistElement = false;
        }
        $maHtml .= ($this->showHelpBlock==true?'<div class="help-block"></div>':'');
        
        $maHtml .= ($this->showHelpBlock==true?'</div>':'');
        
        return $maHtml;
    }
}
?>