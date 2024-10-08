<?php

namespace app\modules\kholuutru\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "kho_ngan".
 *
 * @property int $id
 * @property int $id_ke
 * @property string $ten_ngan
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property Ke $ke
 * @property Hop[] $khoHops
 * @property LuuKho[] $khoLuuKhos
 */
class Ngan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kho_ngan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ke', 'ten_ngan'], 'required'],
            [['id_ke', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_ngan'], 'string', 'max' => 255],
            [['id_ke'], 'exist', 'skipOnError' => true, 'targetClass' => Ke::class, 'targetAttribute' => ['id_ke' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ke' => 'Kệ',
            'ten_ngan' => 'Tên Ngăn',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    /**
     * Gets query for [[Ke]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKe()
    {
        return $this->hasOne(Ke::class, ['id' => 'id_ke']);
    }

    /**
     * Gets query for [[KhoHops]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoHops()
    {
        return $this->hasMany(Hop::class, ['id_ngan' => 'id']);
    }

    /**
     * Gets query for [[KhoLuuKhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoLuuKhos()
    {
        return $this->hasMany(LuuKho::class, ['id_ngan' => 'id']);
    }
    public static function getList()
    {
        // Lấy danh sách nhân viên  và sắp xếp theo thứ tự bảng chữ cái
        $dsKe = Ngan::find()
            ->orderBy(['ten_ngan' => SORT_ASC])
            ->all();
        // Thêm dấu + vào trước tên nhân viên
        return ArrayHelper::map($dsKe, 'id', function($model) {
            return '+ ' . $model->ten_ngan; // Thêm dấu + trước tên nhân viên
        });
    }
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
    
}
