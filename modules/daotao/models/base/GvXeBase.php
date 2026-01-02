<?php

namespace app\modules\daotao\models\base;

use Yii;
use app\models\GdGvXe;
use app\modules\giaovien\models\GiaoVien;
use app\modules\thuexe\models\Xe;
use app\modules\daotao\models\GvXeHistory;

/**
 * This is the model class for table "gd_gv_xe".
 *
 * @property int $id
 * @property int $id_giao_vien
 * @property int $id_xe
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property NvNhanVien $giaoVien
 * @property PtxXe $xe
 */
class GvXeBase extends GdGvXe
{
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_giao_vien', 'id_xe'], 'required'],
            [['id_giao_vien', 'id_xe', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['id_giao_vien'], 'exist', 'skipOnError' => true, 'targetClass' => GiaoVien::class, 'targetAttribute' => ['id_giao_vien' => 'id']],
            [['id_xe'], 'exist', 'skipOnError' => true, 'targetClass' => Xe::class, 'targetAttribute' => ['id_xe' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_giao_vien' => 'Giáo viên',
            'id_xe' => 'Xe',
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
    /**
     * after delete
     */
    public function afterDelete()
    {
        parent::afterDelete(); // luôn gọi trước
        
        $history = new GvXeHistory();
        $history->id_giao_vien = $this->id_giao_vien;
        $history->id_xe = $this->id_xe;
        $history->time_start = $this->thoi_gian_tao;
        $history->time_end = date('Y-m-d H:i:s');
        //$history->note = '';
        
        // Không throw exception để tránh rollback delete chính
        if (!$history->save(false)) {
            Yii::error($history->errors, __METHOD__);
        }
    }
    
    /**
     * Gets query for [[GiaoVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGiaoVien()
    {
        return $this->hasOne(GiaoVien::class, ['id' => 'id_giao_vien']);
    }
    
    /**
     * Gets query for [[Xe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getXe()
    {
        return $this->hasOne(Xe::class, ['id' => 'id_xe']);
    }
    
}
