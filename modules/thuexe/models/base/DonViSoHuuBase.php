<?php

namespace app\modules\thuexe\models\base;

use Yii;
use app\models\PtxXeDonViSoHuu;
use app\modules\thuexe\models\Xe;
use yii\helpers\ArrayHelper;

/**
 * Class DonViSoHuuBase
 * @package app\modules\thuexe\models\base
 */
class DonViSoHuuBase extends PtxXeDonViSoHuu
{
    /**
     * Danh sách đơn vị sở hữu dạng key-value cho dropdown
     * @return array
     */
    public static function getList()
    {
        return ArrayHelper::map(self::find()->orderBy(['ten_don_vi' => SORT_ASC])->all(), 'id', 'ten_don_vi');
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            if ($this->nguoi_tao == null) {
                $this->nguoi_tao = Yii::$app->user->id ?? null;
            }
            if ($this->thoi_gian_tao == null) {
                $this->thoi_gian_tao = date('Y-m-d H:i:s');
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[Xes]].
     * @return \yii\db\ActiveQuery
     */
    public function getXes()
    {
        return $this->hasMany(Xe::class, ['id_don_vi_so_huu' => 'id']);
    }
}
