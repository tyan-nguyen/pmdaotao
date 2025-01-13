<?php

namespace app\modules\lichhoc\models;

use Yii;

/**
 * This is the model class for table "lh_ket_qua_thi".
 *
 * @property int $id
 * @property int $id_hoc_vien
 * @property int $id_lich_thi
 * @property int $id_phan_thi
 * @property int $diem_so
 * @property string $ket_qua
 * @property int $trang_thai
 * @property int $nguoi_tao
 * @property string $thoi_gian_tao
 * @property int|null $lan_thi 
 */
class KetQuaThi extends \app\models\LhKetQuaThi
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lh_ket_qua_thi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hoc_vien', 'id_lich_thi'], 'required'],
            [['id_hoc_vien', 'id_lich_thi', 'id_phan_thi', 'diem_so', 'trang_thai', 'nguoi_tao','lan_thi'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ket_qua'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hoc_vien' => 'Học Viên',
            'id_lich_thi' => 'Lịch Thi',
            'id_phan_thi' => 'Phần Thi',
            'diem_so' => 'Điểm Số',
            'ket_qua' => 'Kết Quả Thi',
            'trang_thai' => 'Trạng Thái',
            'nguoi_tao' => 'Nguười Tạo',
            'thoi_gian_tao' => 'Thời Gian Tạo',
            'lan_thi'=>'Lần Thi',
        ];
    }
    public function beforeSave($insert)
    {  
        if($this->isNewRecord)
            {
                $this->nguoi_tao = Yii::$app->user->identity->id;
                $this->thoi_gian_tao = date('Y-m-d H:i:s');
            }
        return parent:: beforeSave($insert);
    }
    public function getPhanThi()
    {
        return $this->hasOne(PhanThi::class, ['id' => 'id_phan_thi']);
    }
}
