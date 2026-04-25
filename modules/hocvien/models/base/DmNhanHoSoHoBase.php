<?php

namespace app\modules\hocvien\models\base;

use app\models\HvDmNhanHoSoHo;
use app\modules\hocvien\models\DangKyHv;
use Yii;

class DmNhanHoSoHoBase extends HvDmNhanHoSoHo
{
    const LOAI_LIEN_KET_TC = 'TOCHUC';
    const LOAI_LIEN_KET_GV = 'GIAOVIEN';
    /**
     * Danh muc loai lien ket
     * @return string[]
     */
    public static function getDmNhanHoSo()
    {
        return [
            self::LOAI_LIEN_KET_TC => 'Tổ chức',
            self::LOAI_LIEN_KET_GV => 'Cá nhân',
        ];
    }
    /**
     * danh muc loai lien ket label
     */
    public static function getDmNhanHoSoLabel($loaiLienKet = NULL)
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
            [['loai_don_vi', 'ten_don_vi'], 'required'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['nguoi_tao'], 'integer'],
            [['loai_don_vi'], 'string', 'max' => 20],
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
            'loai_don_vi' => 'Loại đơn vị',
            'ten_don_vi' => 'Tên đơn vị',
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
    public function getHvNhanHoSoHos()
    {
        return $this->hasMany(DangKyHv::className(), ['id_nhan_ho_so_ho' => 'id']);
    }
}
