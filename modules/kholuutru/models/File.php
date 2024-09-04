<?php
namespace app\modules\kholuutru\models;

use app\modules\kholuutru\models\base\FileBase;

class File extends FileBase{
    /**
     * get icon for file
     */
    public function getIcon(){
        return 'url';
    }
}