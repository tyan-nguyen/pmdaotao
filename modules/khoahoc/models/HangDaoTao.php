<?php

namespace app\modules\khoahoc\models;
use Yii;
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
            'ten_hang' => 'Tên Hạng',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
}
