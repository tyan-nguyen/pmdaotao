<?php

namespace app\modules\hocvien\models;

use app\modules\hocvien\models\base\DmNhanHoSoHoBase;
use yii\helpers\ArrayHelper;

class DmNhanHoSoHo extends DmNhanHoSoHoBase
{
    /**
     * get danh sách nhận hồ sơ
     */
    public function getListNhanHoSo($loaiDonVi = NULL)
    {
        $query = self::find()->select(['id', 'ten_don_vi'])->orderBy(['ten_don_vi' => SORT_ASC]);
        if ($loaiDonVi) {
            $query->andWhere(['loai_don_vi' => $loaiDonVi]);
        }
        return $query->all();
        return ArrayHelper::map($query, 'id', function ($model) {
            return '+ ' . $model->ten_don_vi;
        });
    }
}
