<?php

namespace app\modules\demxe\models;
use Yii;
use app\models\PtxXeDemXe;
use app\modules\thuexe\models\Xe;

class DemXe extends PtxXeDemXe
{    
    const CONG1 = 'CONG1';
    const CONG1_START = 'CONG1_START';
    const CONG1_END = 'CONG1_END';
    const CONG2 = 'CONG2';
    const CONG2_START = 'CONG2_START';
    const CONG2_END = 'CONG2_END';
    /**
     * Danh muc cong
     * @return string[]
     */
    public static function getTram()
    {
        return [
            self::CONG1 => 'Trạm Căn tin',
            self::CONG2 => 'Trạm Sân CB',
        ];
    }
    /**
     * Danh muc tram thuoc cong nao
     * @return string[]
     */
    public static function getCongThuocTram($val = NULL)
    {
        $label = '';
        switch ($val) {
            case self::CONG1_START:
                $label = self::CONG1;
                break;
            case self::CONG1_END:
                $label = self::CONG1;
                break;
            case self::CONG2_START:
                $label = self::CONG2;
                break;
            case self::CONG2_END:
                $label = self::CONG2;
                break;
            default:
                $label = '';
        }
        return $label;
    }
    public static function getDmCong()
    {
        return [
            self::CONG1_START => 'Cổng 1 Đi',
            self::CONG1_END => 'Cổng 1 Về',
            self::CONG2_START => 'Cổng 2 Vào',
            self::CONG2_END => 'Cổng 2 Ra',
        ];
    }
    /**
     * Danh muc cong->sử dụng khi import dữ liệu
     * @return string[]
     */
    public static function getDmCongFromCamera()
    {
        return [
            self::CONG1_START => 'Cổng 1 Ra',
            self::CONG1_START => 'Cổng 1 Ra 2',
            self::CONG1_END => 'Cổng 1 Vào',
            self::CONG2_START => 'Cổng 2 Vào',
            self::CONG2_END => 'Cổng 2 Ra',
        ];
    }
    
    public static function getDmCongStartXeNha()
    {
        return [
            self::CONG1_START,
            self::CONG2_START,
        ];
    }
    public static function getDmCongEndXeNha()
    {
        return [
            self::CONG1_END,
            self::CONG2_END,
        ];
    }
    public static function getDmCongStartXeLa()
    {
        return [
            self::CONG1_START,
            self::CONG2_END,
        ];
    }
    public static function getDmCongEndXeLa()
    {
        return [
            self::CONG1_END,
            self::CONG2_START,
        ];
    }
    /**
     * Danh muc cong label
     * @param int $val
     * @return string
     */
    public function getLabelCong($val = NULL)
    {
        switch ($val) {
            case self::CONG1_START:
                $label = "Cổng 1 Đi";
                break;
            case self::CONG1_END:
                $label = "Cổng 1 Về";
                break;
            case self::CONG2_START:
                $label = "Cổng 2 Vào";
                break;
            case self::CONG2_END:
                $label = "Cổng 2 Ra";
                break;
            default:
                $label = '';
        }
        return $label;
    }
    /**
     * Danh muc trang thai
     * @return string[]
     */
    public function getDmTrangThai()
    {
        if($this->thoi_gian_bd != null && $this->thoi_gian_kt != null){
            return 'OK';
        } else if($this->thoi_gian_bd != null && $this->thoi_gian_kt == null){
            return 'DICHUAVE';
        } else if($this->thoi_gian_bd == null && $this->thoi_gian_kt != null){
            return 'VEKHONGCODI';
        } else {
            return null;
        }
    }
    /**
     * Danh muc trang thai
     * @return string[]
     */
    public static function getDmTrangThaiColor()
    {
        return [
            '' => '#ddd',
            'OK' => 'var(--success)',
            'DICHUAVE' => 'var(--warning)',
            'VEKHONGCODI' => 'var(--danger)',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_xe', 'thoi_gian_bd', 'thoi_gian_kt', 'so_gio', 'nguoi_tao', 'thoi_gian_tao', 'id_file', 'ghi_chu'], 'default', 'value' => null],
            [['id_xe', 'nguoi_tao', 'id_file'], 'integer'],
            [['ma_xe', 'ma_cong'], 'required'],
            [['thoi_gian_bd', 'thoi_gian_kt', 'thoi_gian_tao'], 'safe'],
            [['so_gio'], 'number'],
            [['ghi_chu'], 'string'],
            [['ma_xe', 'so_phut', 'bien_so_xe'], 'string', 'max' => 50],
            [['ma_cong'], 'string', 'max' => 20],
            [['id_file'], 'exist', 'skipOnError' => true, 'targetClass' => FileTrichXuat::class, 'targetAttribute' => ['id_file' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_xe' => 'Xe',
            'ma_xe' => 'Mã Xe',
            'bien_so_xe' => 'Biển số xe',
            'ma_cong' => 'Cổng',
            'thoi_gian_bd' => 'Thời gian đi',
            'thoi_gian_kt' => 'Thời gian về',
            'so_gio' => 'Số giờ',
            'so_phut' => 'Số phút',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'id_file' => 'File',
            'ghi_chu' => 'Ghi chú',
        ];
    }
    
    /**
     * beforesave
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::beforeSave()
     */
    public function beforeSave($insert) {
        
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(FileTrichXuat::class, ['id' => 'id_file']);
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
    /** DANH SÁCH TRẠNG THÁI PHIÊN */
    /**
     * get trạng thái phiên xe
     */
    public static function getDmTrangThaiPhien(){
        return [
            'CHICOVO'=>'Có vô không có ra',
            'CHICORA'=>'Có ra chưa có vô',
            'COVOCORA'=>'Có ra có vô',
        ];
    }
    /**
     * get trạng thái phiên xe
     */
    public function getTrangThaiPhien(){
        $status = '';
        if($this->thoi_gian_bd == null && $this->thoi_gian_kt!=null){
            $status = 'Có vô không có ra';
        } else if($this->thoi_gian_bd != null && $this->thoi_gian_kt==null){
            $status = 'Có ra chưa có vô';
        }else if($this->thoi_gian_bd != null && $this->thoi_gian_kt!=null){
            $status = 'Có ra có vô';
        }
        return $status;
    }
    /**
     * get trạng thái phiên xe status
     */
    public function getTrangThaiPhienIcon(){
        $status = '';
        if($this->thoi_gian_bd == null && $this->thoi_gian_kt!=null){
            $status = '<i class="ion-alert c-icon-danger"></i>';
        } else if($this->thoi_gian_bd != null && $this->thoi_gian_kt==null){
            $status = '<i class="ion-alert-circled c-icon-warning"></i>';
        }else if($this->thoi_gian_bd != null && $this->thoi_gian_kt!=null){
            $status = '<i class="ion-checkmark c-icon-normal"></i>';
        }
        return $status;
    }
    
}