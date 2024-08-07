<?php
namespace cangak\ajaxcrud;

use yii\base\Widget;
use yii\helpers\Html;

class BulkButtonWidget extends Widget{

	public $buttons;
	
	public function init(){
		parent::init();
		
	}
	
	public function run(){
		$content = '<div class="pull-left">'.
                   //'<span class="fas fa fa-arrow-right" aria-hidden="true"></span>&nbsp;&nbsp;With selected&nbsp;&nbsp;'.
                   $this->buttons.
                   '</div>';
		return $content;
	}
}
?>
