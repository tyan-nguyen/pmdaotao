<?php

namespace app\modules\kholuutru\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "kho_kho".
 *
 * @property int $id
 * @property string $ten_kho
 * @property string|null $so_do_kho
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property Ke[] $khoKes
 * @property LuuKho[] $khoLuuKhos
 */
class Kho extends \app\models\KhoKho
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kho_kho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_kho'], 'required'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_kho', 'so_do_kho'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_kho' => 'Tên Kho',
            'so_do_kho' => 'Sơ đồ Kho',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    /**
     * Gets query for [[KhoKes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoKes()
    {
        return $this->hasMany(Ke::class, ['id_kho' => 'id']);
    }

    /**
     * Gets query for [[KhoLuuKhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoLuuKhos()
    {
        return $this->hasMany(LuuKho::class, ['id_kho' => 'id']);
    }
    public static function getList()
    {
        // Lấy danh sách nhân viên  và sắp xếp theo thứ tự bảng chữ cái
        $dsKho = Kho::find()
            ->orderBy(['ten_kho' => SORT_ASC])
            ->all();
        // Thêm dấu + vào trước tên nhân viên
        return ArrayHelper::map($dsKho, 'id', function($model) {
            return ' ' . $model->ten_kho; // Thêm dấu + trước tên nhân viên
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
