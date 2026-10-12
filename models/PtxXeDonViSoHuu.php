<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_xe_don_vi_so_huu".
 *
 * @property int $id
 * @property string $ten_don_vi
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property PtxXe[] $ptxXes
 */
class PtxXeDonViSoHuu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe_don_vi_so_huu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_don_vi'], 'required'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['nguoi_tao'], 'integer'],
            [['ten_don_vi'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_don_vi' => 'Tên Đơn Vị',
            'ghi_chu' => 'Ghi Chú',
            'thoi_gian_tao' => 'Thời Gian Tạo',
            'nguoi_tao' => 'Người Tạo',
        ];
    }

    /**
     * Gets query for [[PtxXes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxXes()
    {
        return $this->hasMany(PtxXe::class, ['id_don_vi_so_huu' => 'id']);
    }
}
