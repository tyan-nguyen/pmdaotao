<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class FileUploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;
    
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => ['xlsx', 'xls']],
        ];
    }
}