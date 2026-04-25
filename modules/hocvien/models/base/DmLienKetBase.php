<?php

namespace app\modules\hocvien\models\base;

use app\models\HvDmLienKet;
use Yii;
use app\modules\hocvien\models\DangKyHv;

/**
 * This is the model class for table "hv_dm_lien_ket".
 *
 * @property int $id
 * @property string $loai_lien_ket
 * @property string $ten_lien_ket
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 */
class DmLienKetBase extends HvDmLienKet
{
    const LOAI_LIEN_KET_TC = 'TOCHUC';
    const LOAI_LIEN_KET_GV = 'GIAOVIEN';
    /**
     * Danh muc loai lien ket
     * @return string[]
     */
    public static function getDmLoaiLienKet()
    {
        return [
            self::LOAI_LIEN_KET_TC => 'Tổ chức',
            self::LOAI_LIEN_KET_GV => 'Cá nhân',
        ];
    }
    /**
     * danh muc loai lien ket label
     */
    public static function getDmLoaiLienKetLabel($loaiLienKet = NULL)
    {
        switch ($loaiLienKet) {
            case self::LOAI_LIEN_KET_TC:
                return 'Tổ chức';
            case self::LOAI_LIEN_KET_GV:
                return 'Cá nhân';
            default:
                return '';
        }
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['loai_lien_ket', 'ten_lien_ket'], 'required'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['nguoi_tao'], 'integer'],
            [['loai_lien_ket'], 'string', 'max' => 20],
            [['ten_lien_ket'], 'string', 'max' => 200],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai_lien_ket' => 'Loại liên kết',
            'ten_lien_ket' => 'Tên đơn vị liên kết',
            'ghi_chu' => 'Ghi chú',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->nguoi_tao = Yii::$app->user->getId();
        }
        return parent::beforeSave($insert);
    }
    //relationships with class DangKyHv
    public function getHvLienKets()
    {
        return $this->hasMany(DangKyHv::className(), ['id_lien_ket' => 'id']);
    }
}
