<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_xe_loai_giay_to".
 *
 * @property int $id
 * @property string $ten_loai_giay_to
 * @property int $check_het_han
 * @property string|null $ghi_chu
 * @property int|null $so_ngay_bao_truoc
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property PtxXeGiayTo[] $ptxXeGiayTos
 */
class PtxXeLoaiGiayTo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe_loai_giay_to';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_loai_giay_to'], 'required'],
            [['check_het_han', 'so_ngay_bao_truoc', 'nguoi_tao'], 'integer'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_loai_giay_to'], 'string', 'max' => 200],
            [['check_het_han'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai_giay_to' => 'Tên Loại Giấy Tờ',
            'check_het_han' => 'Kiểm Tra Hết Hạn',
            'so_ngay_bao_truoc' => 'Số Ngày Báo Trước',
            'ghi_chu' => 'Ghi Chú',
            'thoi_gian_tao' => 'Thời Gian Tạo',
            'nguoi_tao' => 'Người Tạo',
        ];
    }

    /**
     * Gets query for [[PtxXeGiayTos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxXeGiayTos()
    {
        return $this->hasMany(PtxXeGiayTo::class, ['id_loai_giay_to' => 'id']);
    }
}
