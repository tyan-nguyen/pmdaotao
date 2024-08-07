<?php
namespace app\modules\user\models;

use app\modules\dungchung\models\History;
use webvimark\modules\UserManagement\models\rbacDB\Role;

class UserBase extends \webvimark\modules\UserManagement\models\User{
    const MODEL_ID = 'taikhoan';
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
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function afterSave( $insert, $changedAttributes ){
        parent::afterSave($insert, $changedAttributes);
        History::addHistory($this::MODEL_ID, $changedAttributes, $this, $insert);
    }
    
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