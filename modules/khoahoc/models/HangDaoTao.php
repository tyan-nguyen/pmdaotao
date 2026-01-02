<?php

namespace app\modules\khoahoc\models;
use Yii;
use app\modules\daotao\models\HangMonHoc;
use app\modules\hocvien\models\HocPhi;
/**
 * This is the model class for table "hv_hang_dao_tao".
 *
 * @property int $id
 * @property string $ma_hang
 * @property string $ten_hang
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string $check_phan_hang 
 * @property HvHocPhi[] $hvHocPhis
 * @property HvKhoaHoc[] $hvKhoaHocs
 */
class HangDaoTao extends \app\models\HvHangDaoTao
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_hang','check_phan_hang'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_hang'], 'string', 'max' => 255],
            [['check_phan_hang'],'string','max'=>15],
            [['ma_hang'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_hang' => 'Mã hạng',
            'ten_hang' => 'Tên Hạng',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'check_phan_hang'=>'Phân hạng',
        ];
    }
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Gets query for [[MonHoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListModule()
    {
        return $this->hasMany(HangMonHoc::class, ['id_hang' => 'id']);
    }
    
    /**
     * get hoc phi hien tai cua hang dao tao
     */
    public function getCurrentHocPhi(){
        return $this->hasOne(HocPhi::class, ['id_hang' => 'id'])->orderBy(['id'=>SORT_DESC]);
    }
}
