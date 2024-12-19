<?php

namespace app\modules\giaovien\models;

use Yii;
use app\modules\hocvien\models\HangDaoTao;
/**
 * This is the model class for table "nv_day".
 *
 * @property int $id
 * @property int $id_nhan_vien
 * @property int $id_hang_xe
 * @property int $ly_thuyet
 * @property int $thuc_hanh
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HangXe $hangXe
 * @property NhanVien $nhanVien
 */
class Day extends \app\models\NvDay
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nv_day';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nhan_vien', 'id_hang_xe', 'ly_thuyet', 'thuc_hanh'], 'required'],
            [['id_nhan_vien', 'id_hang_xe', 'ly_thuyet', 'thuc_hanh', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
          
            [['id_hang_xe'], 'exist', 'skipOnError' => true, 'targetClass' => HangDaoTao::class, 'targetAttribute' => ['id_hang_xe' => 'id']],
            [['id_nhan_vien'], 'exist', 'skipOnError' => true, 'targetClass' => GiaoVien::class, 'targetAttribute' => ['id_nhan_vien' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_nhan_vien' => 'Nhân viên',
            'id_hang_xe' => 'Hạng xe',
            'ly_thuyet' => 'Lý thuyết',
            'thuc_hanh' => 'Thực hành',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            
        ];
    }

    /**
     * Gets query for [[HangXe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHangXe()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang_xe']);
    }

    /**
     * Gets query for [[NhanVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhanVien()
    {
        return $this->hasOne(GiaoVien::class, ['id' => 'id_nhan_vien']);
    }
    public function beforeSave($insert) { 
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
}
