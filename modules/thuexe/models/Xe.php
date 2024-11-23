<?php

namespace app\modules\thuexe\models;

use Yii;
use app\modules\thuexe\models\LoaiXe;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "ptx_xe".
 *
 * @property int $id
 * @property int $id_loai_xe
 * @property string|null $hieu_xe
 * @property string|null $bien_so_xe
 * @property string|null $tinh_trang_xe
 * @property string|null $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property PtxLoaiXe $loaiXe
 * @property PtxPhieuThueXe[] $ptxPhieuThueXes
 */
class Xe extends \app\models\PtxXe 
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_loai_xe'], 'required'],
            [['id_loai_xe', 'nguoi_tao'], 'integer'],
            [['tinh_trang_xe'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['hieu_xe', 'bien_so_xe'], 'string', 'max' => 50],
            [['trang_thai'], 'string', 'max' => 25],
            [['id_loai_xe'], 'exist', 'skipOnError' => true, 'targetClass' =>LoaiXe::class, 'targetAttribute' => ['id_loai_xe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loai_xe' => 'Tên loại xe thuê',
            'hieu_xe' => 'Hiệu Xe',
            'bien_so_xe' => 'Biển Số Xe',
            'tinh_trang_xe' => 'Tình Trạng Xe',
            'trang_thai' => 'Trạng Thái',
            'nguoi_tao' => 'Người Tạo',
            'thoi_gian_tao' => 'Thời Gian Tạo',
        ];
    }

    /**
     * Gets query for [[LoaiXe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiXe()
    {
        return $this->hasOne(LoaiXe::class, ['id' => 'id_loai_xe']);
    }

    /**
     * Gets query for [[PtxPhieuThueXes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxPhieuThueXes()
    {
        return $this->hasMany(PhieuThueXe::class, ['id_xe' => 'id']);
    }
    public static function getList()
    {
        $dsXe = Xe::find()
            ->where(['trang_thai' => 'Khả dụng']) // Thêm điều kiện trạng thái
            ->orderBy(['hieu_xe' => SORT_ASC])
            ->all();
    
        return ArrayHelper::map($dsXe, 'id', function($model) {
            return '+ ' . $model->hieu_xe; 
        });
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
