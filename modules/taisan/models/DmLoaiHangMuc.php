<?php

namespace app\modules\taisan\models;

use app\models\CpDmLoaiHangMuc;
use app\modules\user\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cp_dm_loai_hang_muc".
 *
 * @property int $id
 * @property string $ten
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string $thoi_gian_tao
 */
class DmLoaiHangMuc extends CpDmLoaiHangMuc
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'nguoi_tao'], 'default', 'value' => null],
            [['ten'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
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
            'ten' => 'Tên loại hạng mục',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
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

    /**
     * get danh sách
     */
    public static function getList()
    {
        $query = self::find()->select(['id', 'ten'])->orderBy(['ten' => SORT_ASC]);
        return ArrayHelper::map($query->all(), 'id', function ($model) {
            return '+ ' . $model->ten;
        });
    }

    //ham lay nguoi tao
    public function getNguoiTao()
    {
        return $this->hasOne(User::class, ['id' => 'nguoi_tao']);
    }
}
