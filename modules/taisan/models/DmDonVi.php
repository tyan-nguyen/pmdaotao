<?php

namespace app\modules\taisan\models;

use app\models\CpDmDonVi;
use Yii;

/**
 * This is the model class for table "cp_dm_don_vi".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten
 * @property string $ten_sort
 * @property int|null $co_sua_chua
 * @property int|null $co_ban_hang
 * @property string|null $ghi_chu
 * @property int|null $stt
 * @property int|null $nguoi_tao
 * @property string $thoi_gian_tao
 */
class DmDonVi extends CpDmDonVi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'nguoi_tao'], 'default', 'value' => null],
            [['co_ban_hang'], 'default', 'value' => 0],
            [['ten'], 'required'],
            [['co_sua_chua', 'co_ban_hang', 'stt', 'nguoi_tao'], 'integer'],
            [['ghi_chu'], 'string'],
            [['code', 'ten_sort'], 'string', 'max' => 50],
            [['thoi_gian_tao'], 'safe'],
            [['ten'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'ten' => 'Tên',
            'ten_sort' => 'Tên ngắn',
            'co_sua_chua' => 'Sửa chữa',
            'co_ban_hang' => 'Bán hàng',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'stt' => 'Thứ tự',
        ];
    }

    //hàm beforeSave, set nguoi_tao
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }

    //lấy tên ngắn hiển thị trên danh sách
    public function getTenSort()
    {
        return $this->ten_sort ? $this->ten_sort : $this->ten;
    }

    //get list đơn vị để điền vào dropdown
    public static function getList($type = null)
    {
        if ($type == null)
            $donViList = self::find()->orderBy(['stt' => SORT_DESC])->all();
        else if ($type == 'ban_hang')
            $donViList = self::find()->where(['co_ban_hang' => 1])->orderBy(['stt' => SORT_DESC])->all();
        else if ($type == 'sua_chua')
            $donViList = self::find()->where(['co_sua_chua' => 1])->orderBy(['stt' => SORT_DESC])->all();
        else
            return [];
        return \yii\helpers\ArrayHelper::map($donViList, 'id', function ($model) {
            return '+ ' . $model->ten . ($model->code ? ' (' . $model->code . ')' : '');
        });
    }
}
