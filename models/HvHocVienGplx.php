<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_hoc_vien_gplx".
 *
 * @property int $id
 * @property int $id_hoc_vien
 * @property string|null $so_gplx
 * @property string|null $hang_gplx
 * @property string|null $ngay_tt_gplx
 * @property string|null $ngay_cap_gplx
 * @property string|null $ngay_hh_gplx
 * @property string|null $don_vi_cap_gplx
 * @property int|null $stt
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property HvHocVien $hocVien
 */
class HvHocVienGplx extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_hoc_vien_gplx';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hoc_vien'], 'required'],
            [['id_hoc_vien', 'stt', 'nguoi_tao'], 'integer'],
            [['ngay_tt_gplx', 'ngay_cap_gplx', 'ngay_hh_gplx', 'thoi_gian_tao'], 'safe'],
            [['so_gplx'], 'string', 'max' => 20],
            [['hang_gplx', 'don_vi_cap_gplx'], 'string', 'max' => 10],
            [['id_hoc_vien'], 'exist', 'skipOnError' => true, 'targetClass' => HvHocVien::class, 'targetAttribute' => ['id_hoc_vien' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hoc_vien' => 'Học viên',
            'so_gplx' => 'Số GPLX',
            'hang_gplx' => 'Hạng GPLX',
            'ngay_tt_gplx' => 'Ngày TT GPLX',
            'ngay_cap_gplx' => 'Ngày cấp GPLX',
            'ngay_hh_gplx' => 'Ngày hết hạn GPLX',
            'don_vi_cap_gplx' => 'Đơn vị cấp GPLX',
            'stt' => 'STT',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
        ];
    }

    /**
     * Gets query for [[HocVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocVien()
    {
        return $this->hasOne(HvHocVien::class, ['id' => 'id_hoc_vien']);
    }
}
