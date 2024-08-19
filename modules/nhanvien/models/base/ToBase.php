<?php

namespace app\modules\nhanvien\models\base;

use Yii;
use app\modules\nhanvien\models\PhongBan;
use app\modules\nhanvien\models\NhanVien;
/**
 * This is the model class for table "nv_to".
 *
 * @property int $id
 * @property int|null $id_phong_ban
 * @property string $ten_to
 * @property string $thoi_gian_tao
 * @property int $nguoi_tao
 *
 * @property NvNhanVien[] $nvNhanViens
 * @property NvPhongBan $phongBan
 */
class ToBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nv_to';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_phong_ban', 'nguoi_tao'], 'integer'],
            [['ten_to', 'thoi_gian_tao', 'nguoi_tao'], 'required'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_to'], 'string', 'max' => 255],
            [['id_phong_ban'], 'exist', 'skipOnError' => true, 'targetClass' => PhongBan::class, 'targetAttribute' => ['id_phong_ban' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_phong_ban' => 'Id Phong Ban',
            'ten_to' => 'Ten To',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

    /**
     * Gets query for [[NvNhanViens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNvNhanViens()
    {
        return $this->hasMany(NhanVien::class, ['id_to' => 'id']);
    }

    /**
     * Gets query for [[PhongBan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhongBan()
    {
        return $this->hasOne(PhongBan::class, ['id' => 'id_phong_ban']);
    }
}
