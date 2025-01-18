<?php

namespace app\modules\nhanvien\models;

use Yii;

/**
 * This is the model class for table "nv_to".
 *
 * @property int $id
 * @property int|null $id_phong_ban
 * @property string $ten_to
 *
 * @property NvNhanVien[] $nvNhanViens
 * @property NvPhongBan $phongBan
   * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 */
class To extends \app\models\NvTo
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
            [['id_phong_ban'], 'integer'],
            [['ten_to'], 'required'],
            [['ten_to'], 'string', 'max' => 255],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
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
            'id_phong_ban' => 'Phòng Ban',
            'ten_to' => 'Tên Tổ',
            'nguoi_tao' => 'Người Tạo',
            'thoi_gian_tao' => 'Thời Gian Tạo',
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
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
}
