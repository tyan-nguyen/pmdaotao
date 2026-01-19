<?php

namespace app\modules\demxe\models;
use Yii;
use app\models\PtxXeDemXe;
use app\modules\thuexe\models\Xe;
use yii\helpers\Html;
use app\custom\CustomFunc;
use app\modules\daotao\models\TietHoc;

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
    public static function getTramIcon()
    {
        return [
            self::CONG1 => '<span class="badge bg-primary">Trạm Căn tin',
            self::CONG2 => '<span class="badge bg-info">Trạm Sân CB</span>',
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
   /*  public static function getDmTrangThaiPhien(){
        return [
            'CHICOVO'=>'Có vô không có ra',
            'CHICORA'=>'Có ra chưa có vô',
            'COVOCORA'=>'Có ra có vô',
        ];
    } */
    public static function getDmTrangThaiPhien(){
        return [
            'HasInNotOut'=>'Có vô không có ra',
            'HasOutNotIn'=>'Có ra chưa có vô',
            'HasInOut'=>'Có ra có vô',
        ];
    }
    /**
     * get trạng thái phiên xe
     */
    public function getTrangThaiPhien(){
        $status = '';
        if($this->hasInNotOut){
            $status = 'Có vô không có ra';
        } else if($this->hasOutNotIn){
            $status = 'Có ra chưa có vô';
        }else if($this->hasInOut){
            $status = 'Có ra có vô';
        }
        return $status;
    }
    /**
     * get trạng thái phiên xe status
     */
    public function getTrangThaiPhienIcon(){
        $status = '';
        if($this->hasInNotOut){
            $status = '<i class="ion-alert c-icon-danger" title="'.$this->trangThaiPhien.'"></i>';
        } else if($this->hasOutNotIn){
            $status = '<i class="ion-alert-circled c-icon-warning" title="'.$this->trangThaiPhien.'"></i>';
        }else if($this->hasInOut){
            $status = '<i class="ion-checkmark c-icon-normal"></i>';
        }
        return $status;
    }
    /**
     * check trạng thái của phiên
     * return true/false
     */
    
    /**
     * check có vô ko có ra
     */
    public function getHasInNotOut(){
        if($this->thoi_gian_bd == null && $this->thoi_gian_kt!=null)
            return true;
        else 
            return false;
    }
    /**
     * check có ra không có vô
     */
    public function getHasOutNotIn(){
        if($this->thoi_gian_bd != null && $this->thoi_gian_kt==null)
            return true;
        else
            return false;
    }
    /**
     * check có ra không có vô
     */
    public function getHasInOut(){
        if($this->thoi_gian_bd != null && $this->thoi_gian_kt!=null)
            return true;
        else
            return false;
    }
    /**
     * get loiạ xe theo id_xe
     */
    public function getLoaiXe(){
        if($this->id_xe){
            return '<span class="badge bg-primary">'.$this->xe->labelPhanLoaiXe.'</span>';
            
        } else {
            return '<span class="badge bg-info">Xe khách</span>';
        }
    }
    
    /**
     * sự kiện theo yêu cầu
     */
    /**
     * get trạng thái sự kiện xe
     */
    public static function getDmSuKien(){
        return [
            'OneNightStand'=>'Qua đêm',
            'NonRegister'=>'Đi không đăng ký kế hoạch',
        ];
    }
    
    public function getSuKien(){
        $text = '';
        if($this->xeQuaDem)
            $text = 'Qua đêm';
        else if($this->diKhongKeHoach)
            $text = 'Đi không đăng ký kế hoạch';
        return $text;
    }
    
    public function getSuKienIcon(){
        $html = '';
        if($this->xeQuaDem)
            $html .= Html::img('/libs/images/icons/error.gif', ['width'=>'20', 'title'=>'XE QUA ĐÊM']);
        if($this->diKhongKeHoach)
            $html .= Html::img('/libs/images/icons/location.gif', ['width'=>'22', 'title'=>'ĐI KHÔNG KẾ HOẠCH']);
        return $html!=''?$html:'-';
    }
    /**
     * sự kiện xe qua đêm
     */
    public function getXeQuaDem(){
        //xe có về ko có đi
        //if($this->hasInNotOut){
            
       // }
        //xe đi chua ve
        //else if($this->hasOutNotIn){
        if($this->hasOutNotIn){
            $di = strtotime($this->thoi_gian_bd);
            $ve = strtotime(date('Y-m-d H:i:s'));
            
            $hasOvernight = false;
            
            $startDate = date('Y-m-d', $di);
            $endDate   = date('Y-m-d', $ve);
            
            $current = strtotime($startDate);
            
            while ($current <= strtotime($endDate)) {
                
                $nightStart = strtotime(date('Y-m-d', $current) . ' 00:00:00');
                $nightEnd   = strtotime(date('Y-m-d', $current) . ' 05:00:00');
                
                // check giao nhau
                if ($di < $nightEnd && $ve > $nightStart) {
                    $hasOvernight = true;
                    break;
                }
                
                // sang ngày tiếp theo
                $current = strtotime('+1 day', $current);
            }
            return $hasOvernight;
        }
        //xe co di co ve
        else if($this->hasInOut){
            $di = strtotime($this->thoi_gian_bd);
            $ve = strtotime($this->thoi_gian_kt);
            
            $hasOvernight = false;
            
            $startDate = date('Y-m-d', $di);
            $endDate   = date('Y-m-d', $ve);
            
            $current = strtotime($startDate);
            
            while ($current <= strtotime($endDate)) {
                
                $nightStart = strtotime(date('Y-m-d', $current) . ' 00:00:00');
                $nightEnd   = strtotime(date('Y-m-d', $current) . ' 05:00:00');
                
                // check giao nhau
                if ($di < $nightEnd && $ve > $nightStart) {
                    $hasOvernight = true;
                    break;
                }
                
                // sang ngày tiếp theo
                $current = strtotime('+1 day', $current);
            }
            return $hasOvernight;
        } else{
            return false;
        }
        
    }
    /**
     * sự kiện xe đi không có kế hoạch
     * check ngày đi (phiên >30 phút hoặc tính từ lúc đi tới hiện tại là >30 phút) 
     * sau đó so với ngày kế hoạch có không, nếu có thì true, ngược lại thì false
     */
    public function getDiKhongKeHoach(){
        if(!$this->id_xe){//xe la
            return false;
        } else {
            $thoiGianHienTai = date('Y-m-d H:i:s');
            $ngayDi = null;
            //lấy ngày đi của phiên >30 phút, thời gian về - đi > 30 phút hoặc hiện tại - đi > 30 phút
            $phutDi = 0;
            if($this->thoi_gian_bd != null && $this->thoi_gian_kt != null){
                $phutDi = CustomFunc::getMinutes($this->thoi_gian_bd, $this->thoi_gian_kt);
                $ngayDi = CustomFunc::convertYMDHISToYMD($this->thoi_gian_bd);
            } else if($this->thoi_gian_bd != null && $this->thoi_gian_kt == null){
                $phutDi = CustomFunc::getMinutes($this->thoi_gian_bd, $thoiGianHienTai);
                $ngayDi = CustomFunc::convertYMDHISToYMD($this->thoi_gian_bd);
            } else if($this->thoi_gian_bd == null && $this->thoi_gian_kt != null){
                $dt = new \DateTime($this->thoi_gian_kt);
                $phutDi = CustomFunc::getMinutes($dt->format('Y-m-d 00:00:00'), $this->thoi_gian_kt);
                $ngayDi = CustomFunc::convertYMDHISToYMD($this->thoi_gian_kt);
            } 
            //so với ngày kế hoạch
            if($phutDi >= 30){//30 phút
                $start = $ngayDi . ' 00:00:00';
                $end   = $ngayDi . ' 23:59:59';
                $exists = TietHoc::find()
                ->andWhere(['<=', 'thoi_gian_bd', $end])
                ->andWhere(['>=', 'thoi_gian_bd', $start])
                ->andWhere(['id_xe'=>$this->id_xe])
                ->exists();
                if(!$exists)
                    return true;
                else 
                    return false;
            } else {
                return false;
            }
        }
    }
}