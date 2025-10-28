<?php
namespace app\modules\user\models;

//use app\modules\dungchung\models\History;
use Yii;
use webvimark\modules\UserManagement\models\rbacDB\Role;

class UserBase extends \webvimark\modules\UserManagement\models\User{
    const MODEL_ID = 'taikhoan';
    
    const USER_TYPE_NORMAL = 'BINHTHUONG';
    const USER_TYPE_NHANHOSO = 'NHANHOSO';
    const USER_TYPE_GIAOVIEN = 'GIAOVIEN';
    
    /**
     * Danh muc loai tai khoan
     * @return string[]
     */
    public static function getDmLoaiTaiKhoan()
    {
        return [
            self::USER_TYPE_NORMAL => 'Bình thường',
            self::USER_TYPE_NHANHOSO => 'Nhận hồ sơ',
            self::USER_TYPE_GIAOVIEN => 'Giáo viên',
        ];
    }
    /**
     * Danh muc loai taoi khoan label
     * @param int $val
     * @return string
     */
    public static function getLabelLoaiTaiKhoan($val=NULL)
    {
        switch ($val) {
            case self::USER_TYPE_NORMAL:
                $label = 'Bình thường';
                break;
            case self::USER_TYPE_NHANHOSO:
                $label = 'Nhận hồ sơ';
                break;
            case self::USER_TYPE_GIAOVIEN:
                $label = 'Giáo viên';
                break;
            default:
                $label = '';
        }
        return $label;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'unique'],
            ['username', 'trim'],
            
            [['status', 'email_confirmed'], 'integer'],
            
            ['email', 'email'],
            ['email', 'validateEmailConfirmedUnique'],
            
            ['bind_to_ip', 'validateBindToIp'],
            ['bind_to_ip', 'trim'],
            ['bind_to_ip', 'string', 'max' => 255],
            
            ['password', 'required', 'on'=>['newUser', 'changePassword']],
            ['password', 'string', 'max' => 255, 'on'=>['newUser', 'changePassword']],
            ['password', 'trim', 'on'=>['newUser', 'changePassword']],
            ['password', 'match', 'pattern' => Yii::$app->getModule('user-management')->passwordRegexp],
            
            ['repeat_password', 'required', 'on'=>['newUser', 'changePassword']],
            ['repeat_password', 'compare', 'compareAttribute'=>'password'],
            //user info
            ['ho_ten', 'string', 'max' => 255],
            ['biet_danh', 'string', 'max' => 50],
            [['noi_dang_ky', 'user_type'], 'string', 'max' => 20],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'username'           => 'Tên tài khoản',
            'superadmin'         => 'Là super admin',
            'confirmation_token' => 'Confirmation Token',
            'registration_ip'    => 'Registration IP',
            'bind_to_ip'         => 'Liên kết với địa chỉ IP',
            'status'             => 'Trạng thái',
            'gridRoleSearch'     => 'Roles',
            'created_at'         => 'Created',
            'updated_at'         => 'Updated',
            'password'           => 'Mật khẩu',
            'repeat_password'    => 'Nhắc lại mật khẩu',
            'email_confirmed'    => 'E-mail confirmed',
            'email'              => 'Tài khoản Email',
            //user info
            'ho_ten'            => 'Họ tên',
            'biet_danh'         => 'Tên ngắn (hiển thị)',
            'noi_dang_ky'       => 'Nơi đăng ký',
            'user_type'         => 'Loại tài khoản'
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    /* public function afterSave( $insert, $changedAttributes ){
        parent::afterSave($insert, $changedAttributes);
        History::addHistory($this::MODEL_ID, $changedAttributes, $this, $insert);
    } */
    
    /**
     * lay ten default role tao cung voi user
     * @return string
     */
    public function getUserRoleName(){
        return 'user_'. $this->id . '_';  // dang user_9_
    }
    
    /**
     * tao userRole neu chua ton tai (danh cho user duoc tao cu chua co userRoleName hoac luc tao bi loi)
     */
    public function createUserRoleName(){
        if(Role::find()->where(['name'=>$this->userRoleName])->one()==null){
            //create role for user
            $rol = new Role();
            $rol->type = 1;
            $rol->name = $this->userRoleName;// dang user_9_
            $rol->description = 'Quyền tùy chỉnh cho user '. $this->username;
            if($rol->save()){
                User::assignRole($this->id, $rol->name);
            }
        }
        return true;
    }
}

?>