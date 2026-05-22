<?php

namespace app\modules\taisan\models;

use app\models\CpDmHangMuc;
use app\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "cp_dm_hang_muc".
 *
 * @property int $id
 * @property int $id_loai_hang_muc
 * @property string $ten
 * @property float $don_gia
 * @property string $dvt
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property CpPhieuChiTiet[] $cpPhieuChiTiets
 */
class DmHangMuc extends CpDmHangMuc
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'nguoi_tao'], 'default', 'value' => null],
            [['ten', 'id_loai_hang_muc', 'dvt'], 'required'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['nguoi_tao', 'id_loai_hang_muc'], 'integer'],
            [['don_gia'], 'number'],
            [['ten'], 'string', 'max' => 200],
            [['dvt'], 'string', 'max' => 20],
            [['ten'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loai_hang_muc' => 'Loại hạng mục',
            'ten' => 'Tên',
            'don_gia' => 'Đơn giá',
            'dvt' => 'Đơn vị tính',
            'ghi_chu' => 'Ghi Chú',
            'thoi_gian_tao' => 'Thời Gian Tạo',
            'nguoi_tao' => 'Người Tạo',
        ];
    }

    //hàm beforeSave, set nguoi_tao
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            if ($this->don_gia == null) {
                $this->don_gia = 0;
            }
        }
        return parent::beforeSave($insert);
    }

    //ham get loai hang muc
    public function getLoaiHangMuc()
    {
        return $this->hasOne(DmLoaiHangMuc::class, ['id' => 'id_loai_hang_muc']);
    }

    /**
     * Gets query for [[CpPhieuChiTiets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCpPhieuChiTiets()
    {
        return $this->hasMany(PhieuChiTiet::class, ['id_hang_muc' => 'id']);
    }

    //ham lay nguoi tao
    public function getNguoiTao()
    {
        return $this->hasOne(User::class, ['id' => 'nguoi_tao']);
    }
}
