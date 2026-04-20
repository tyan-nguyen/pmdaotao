<?php

namespace app\modules\hocvien\models;

use yii\helpers\ArrayHelper;
use Yii;
use app\modules\hocvien\models\KhoaHoc;
use app\modules\khoahoc\models\NhomHangDaoTao;
use app\modules\user\models\User;

/**
 * This is the model class for table "hv_hang_dao_tao".
 *
 * @property int $id
 * @property int|null $id_nhom_hang
 * @property string $ten_hang
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HvHocPhi[] $hvHocPhis
 * @property HvKhoaHoc[] $hvKhoaHocs
 */
class HangDaoTao extends \app\models\HvHangDaoTao
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_hang_dao_tao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_hang'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao', 'id_nhom_hang'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_hang'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_nhom_hang' => 'Nhóm Hạng',
            'ten_hang' => 'Tên hạng',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }
    public function getNhomHang()
    {
        return $this->hasOne(NhomHangDaoTao::class, ['id' => 'id_nhom_hang']);
    }

    /**
     * Gets query for [[HvHocPhis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvHocPhis()
    {
        return $this->hasMany(HocPhi::class, ['id_hang' => 'id']);
    }
    public function getHocPhi()
    {
        //neu user la chi nhanh cho lach va hang dao tao hang a, a1 se lay theo hoc phi cung
        // con lai thi lay hoc phi moi nhat
        $user = User::getCurrentUser();
        if (($user->noi_dang_ky == DangKyHv::NOIDANGKY_CS5
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS9
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS10
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS12
        ) && $this->id == 7) { //hạng A1
            return HocPhi::findOne(3); //học phí cho hạng A1(cho CN chợ lách)
        } else if (($user->noi_dang_ky == DangKyHv::NOIDANGKY_CS5
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS9
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS10
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS12
        ) && $this->id == 8) { //hạng A1
            return HocPhi::findOne(4); //học phí cho hạng A1 - CGPLX (cho CN chợ lách)
        } else if (($user->noi_dang_ky == DangKyHv::NOIDANGKY_CS5
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS9
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS10
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS12
        ) && $this->id == 9) { //hạng A
            return HocPhi::findOne(1); //học phí cho hạng A (cho CN chợ lách)
        } else if (($user->noi_dang_ky == DangKyHv::NOIDANGKY_CS5
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS9
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS10
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS12
        ) && $this->id == 10) { //hạng A (có GPLX)
            return HocPhi::findOne(2); //học phí cho hạng A - có GPLX (cho CN chợ lách)
        } else {
            return $this->hasOne(HocPhi::class, ['id_hang' => 'id'])->orderBy(['id' => SORT_DESC]);
        }
    }

    /**
     * Gets query for [[HvKhoaHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvKhoaHocs()
    {
        return $this->hasMany(KhoaHoc::class, ['id_hang' => 'id']);
    }
    public static function getList()
    {
        // Sắp xếp danh sách theo thứ tự bảng chữ cái dựa trên 'ten_loai'
        //$dsHang = HangDaoTao::find()->orderBy(['ten_hang' => SORT_ASC])->all();
        $dsHang = HangDaoTao::find()->orderBy(['id' => SORT_ASC])->all();

        // Thêm dấu + vào trước mỗi tên loại văn bản
        return ArrayHelper::map($dsHang, 'id', function ($model) {
            return '+ ' . $model->ten_hang; // Thêm dấu + trước tên loại
        });
    }
}
