<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\FileUploadForm;
use yii\web\UploadedFile;
use app\modules\demxe\models\FileTrichXuat;

class FileUploadController extends Controller
{
    public function behaviors()
    {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }
    
    public function actionImport()
    {
        $model = new FileUploadForm();
        
        if (Yii::$app->request->isPost) {
            
            $model->file = UploadedFile::getInstance($model, 'file');
            
            if ($model->validate()) {
                $filename = date('Ymd_His') . '_' . uniqid() . '.' . pathinfo($model->file->name, PATHINFO_EXTENSION);
                $filePath = Yii::getAlias('@webroot') . '/uploads/dem-xe/' . $filename;
                if($model->file->saveAs($filePath)){
                    $newFile = new FileTrichXuat();
                    $newFile->thoi_gian_tu = '';
                    $newFile->thoi_gian_den = '';
                    $newFile->url = $filename;
                    $newFile->filename = $model->file->name;
                    $newFile->ghi_chu = '';
                    if($newFile->save()){
                        return $this->redirect('/demxe/file-trich-xuat/index?menu=demxe1');
                    }
                }               
            }
        }
        
        return $this->render('import', ['model' => $model]);
    }
    
    
}