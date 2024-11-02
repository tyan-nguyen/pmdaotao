<?php

namespace app\modules\thuexe\models;

use Yii;
use app\modules\thuexe\models\Xe;
use app\modules\thuexe\models\LoaiHinhThue;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "ptx_loai_xe".
 *
 * @property int $id
 * @property string $ten_loai_xe
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property int|null $thoi_gian_tao
 *
 * @property PtxLoaiHinhThue[] $ptxLoaiHinhThues
 * @property PtxXe[] $ptxXes
 */
class LoaiXe extends \app\models\PtxLoaiXe
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_loai_xe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_loai_xe'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao', 'thoi_gian_tao'], 'integer'],
            [['ten_loai_xe'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai_xe' => 'Tên Loại Xe',
            'ghi_chu' => 'Ghi Chú',
            'nguoi_tao' => 'Người Tạo ',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    /**
     * Gets query for [[PtxLoaiHinhThues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxLoaiHinhThues()
    {
        return $this->hasMany(LoaiHinhThue::class, ['id_loai_xe' => 'id']);
    }

    /**
     * Gets query for [[PtxXes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxXes()
    {
        return $this->hasMany(Xe::class, ['id_loai_xe' => 'id']);
    }
    public static function getList()
    {
        // Lấy danh sách nhân viên  và sắp xếp theo thứ tự bảng chữ cái
        $dsLoaiXe = LoaiXe::find()
            ->orderBy(['ten_loai_xe' => SORT_ASC])
            ->all();
    
        // Thêm dấu + vào trước tên nhân viên
        return ArrayHelper::map($dsLoaiXe, 'id', function($model) {
            return '+ ' . $model->ten_loai_xe; // Thêm dấu + trước tên nhân viên
        });
    }
    public function getLoaiXe()
    {
        return $this->hasOne(LoaiXe::class, ['id' => 'id_loai_xe']);
    }
    public function beforeSave($insert)
    {        
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s'); 
        }
        return parent::beforeSave($insert);
    }
}
