<?php

namespace app\modules\danhmuc\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dm_tinh".
 *
 * @property int $id
 * @property int|null $ma_tinh
 * @property string $loai
 * @property string $ten_tinh
 * @property string $ten_tinh_full
 * @property string|null $ghi_chu
 * @property int $stt
 *
 * @property DmXa[] $dmXas
 */
class DmTinh extends \app\models\DmTinh
{
    //lấy danh sách fill dropdown
    public static function getList()
    {
        $ds = DmTinh::find()->orderBy(['stt' => SORT_ASC])->all();
        return ArrayHelper::map($ds, 'id', function($model) {
            return '+ ' . $model->ten_tinh_full;
        });
    }
}
