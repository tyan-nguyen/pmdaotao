<?php

namespace app\modules\kholuutru\models;

use Yii;
use app\modules\kholuutru\models\Ngan;
use app\modules\kholuutru\models\LuuKho;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "kho_hop".
 *
 * @property int $id
 * @property int $id_ngan
 * @property string $ten_hop
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property LuuKho[] $khoLuuKhos
 * @property Ngan $ngan
 */
class Hop extends \app\models\KhoHop
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kho_hop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ngan', 'ten_hop'], 'required'],
            [['id_ngan', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_hop'], 'string', 'max' => 255],
            [['id_ngan'], 'exist', 'skipOnError' => true, 'targetClass' => Ngan::class, 'targetAttribute' => ['id_ngan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ngan' => 'Ngăn',
            'ten_hop' => 'Tên Hộp',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    /**
     * Gets query for [[KhoLuuKhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoLuuKhos()
    {
        return $this->hasMany(LuuKho::class, ['id_hop' => 'id']);
    }

    /**
     * Gets query for [[Ngan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNgan()
    {
        return $this->hasOne(Ngan::class, ['id' => 'id_ngan']);
    }
    
    public static function getList()
    {
        // Lấy danh sách hộp và sắp xếp theo thứ tự bảng chữ cái
        $dsKho = Hop::find()
        ->orderBy(['ten_hop' => SORT_ASC])
        ->all();
        // Thêm dấu + vào trước tên nhân viên
        return ArrayHelper::map($dsKho, 'id', function($model) {
            return ' ' . $model->ten_hop; // Thêm dấu + trước tên hộp
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
