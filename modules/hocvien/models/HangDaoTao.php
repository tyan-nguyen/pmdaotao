<?php

namespace app\modules\hocvien\models;
use yii\helpers\ArrayHelper;
use Yii;
use app\modules\hocvien\models\KhoaHoc;
use app\modules\user\models\User;
/**
 * This is the model class for table "hv_hang_dao_tao".
 *
 * @property int $id
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
            [['nguoi_tao'], 'integer'],
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
            'ten_hang' => 'Ten Hang',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
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
        if(($user->noi_dang_ky == DangKyHv::NOIDANGKY_CS5 
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS9 
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS10
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS12
            ) && $this->id==9){//hạng A
            return HocPhi::findOne(1);//học phí cho hạng A (cho CN chợ lách)
        } else if(($user->noi_dang_ky == DangKyHv::NOIDANGKY_CS5 
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS9 
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS10
            || $user->noi_dang_ky == DangKyHv::NOIDANGKY_CS12
            ) && $this->id==10){//hạng A (có GPLX)
            return HocPhi::findOne(2);//học phí cho hạng A - có GPLX (cho CN chợ lách)
        } else {
            return $this->hasOne(HocPhi::class, ['id_hang' => 'id'])->orderBy(['id'=>SORT_DESC]);
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
        return ArrayHelper::map($dsHang, 'id', function($model) {
            return '+ ' . $model->ten_hang; // Thêm dấu + trước tên loại
        });
    }
}
