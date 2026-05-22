<?php

namespace app\modules\hocvien\models;

use app\modules\hocvien\models\base\DmLienKetBase;
use yii\helpers\ArrayHelper;

class DmLienKet extends DmLienKetBase
{
    /**
     * get danh sách liên kết
     */
    public function getListLienKet($loaiLienKet = NULL)
    {
        $query = self::find()->select(['id', 'ten_lien_ket'])->orderBy(['ten_lien_ket' => SORT_ASC]);
        if ($loaiLienKet) {
            $query->andWhere(['loai_lien_ket' => $loaiLienKet]);
        }
        return ArrayHelper::map($query->all(), 'id', function ($model) {
            return '+ ' . $model->ten_lien_ket;
        });
    }
}
