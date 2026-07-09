<?php

namespace app\modules\taisan\models;

use app\modules\kholuutru\models\File;
use app\modules\taisan\models\base\TaiSanBase;

class TaiSan extends TaiSanBase
{
    public function getListHinhAnh()
    {
        $listImg = [];
        $files = File::getAllByDoiTuongAndImages(self::MODEL_ID, $this->id);
        foreach ($files as $fileVB) {
            $listImg[] = 'https://qltl.nguyentrinh.com.vn' . File::FOLDER_DOCUMENTS . $fileVB->fileSaveName;
        }
        return $listImg;
    }
}
