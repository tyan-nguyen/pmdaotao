<?php

namespace app\modules\daotao\models\base;

use Yii;
use app\models\GdGvXeHistory;
use app\modules\giaovien\models\GiaoVien;
use app\modules\thuexe\models\Xe;

class GvXeHistoryBase extends GdGvXeHistory
{  
    /**
     * beforsave
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->user_created = Yii::$app->user->identity->id;
            $this->date_created = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['note'], 'default', 'value' => null],
            [['id_giao_vien', 'id_xe', 'time_start', 'time_end', 'date_created', 'user_created'], 'required'],
            [['id_giao_vien', 'id_xe', 'user_created'], 'integer'],
            [['time_start', 'time_end', 'date_created'], 'safe'],
            [['note'], 'string'],
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
            'time_start' => 'Bắt đầu',
            'time_end' => 'Kết thúc',
            'date_created' => 'Ngày lưu',
            'user_created' => 'Người lưu',
            'note' => 'Ghi chú',
        ];
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
