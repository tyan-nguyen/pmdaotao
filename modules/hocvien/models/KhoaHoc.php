<?php

namespace app\modules\hocvien\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "hv_khoa_hoc".
 *
 * @property int $id
 * @property int $id_hang
 * @property string $ten_khoa_hoc
 * @property string $ngay_bat_dau
 * @property string $ngay_ket_thuc
 * @property string|null $ghi_chu
 * @property string $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HvHangDaoTao $hang
 * @property HvHocVien[] $hvHocViens
 * @property HvTaiLieuKhoaHoc[] $hvTaiLieuKhoaHocs
 */
class KhoaHoc extends \app\models\HvKhoaHoc
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_khoa_hoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hang', 'ten_khoa_hoc', 'ngay_bat_dau', 'ngay_ket_thuc', 'trang_thai'], 'required'],
            [['id_hang', 'nguoi_tao'], 'integer'],
            [['ngay_bat_dau', 'ngay_ket_thuc', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['ten_khoa_hoc', 'trang_thai'], 'string', 'max' => 255],
            [['id_hang'], 'exist', 'skipOnError' => true, 'targetClass' => HangDaoTao::class, 'targetAttribute' => ['id_hang' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hang' => 'Id Hang',
            'ten_khoa_hoc' => 'Ten Khoa Hoc',
            'ngay_bat_dau' => 'Ngay Bat Dau',
            'ngay_ket_thuc' => 'Ngay Ket Thuc',
            'ghi_chu' => 'Ghi Chu',
            'trang_thai' => 'Trang Thai',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[Hang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHang()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang']);
    }

    /**
     * Gets query for [[HvHocViens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvHocViens()
    {
        return $this->hasMany(HocVien::class, ['id_khoa_hoc' => 'id']);
    }

    /**
     * Gets query for [[HvTaiLieuKhoaHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    
    public static function getList()
    {
        // Sắp xếp danh sách theo thứ tự bảng chữ cái dựa trên 'ten_loai'
        $dsKhoaHoc = KhoaHoc::find()->orderBy(['ten_khoa_hoc' => SORT_ASC])->all();
    
        // Thêm dấu + vào trước mỗi tên loại văn bản
        return ArrayHelper::map($dsKhoaHoc, 'id', function($model) {
            return '+ ' . $model->ten_khoa_hoc; // Thêm dấu + trước tên loại
        });
    }
}
