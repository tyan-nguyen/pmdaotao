<?php
namespace app\modules\user\models;

use webvimark\modules\UserManagement\models\forms\ChangeOwnPasswordForm;

class ChangeUserPasswordForm extends ChangeOwnPasswordForm{
    public function attributeLabels()
    {
        return [
            'current_password' => 'Mật khẩu hiện tại',
            'password'         => 'Mật khẩu mới',
            'repeat_password'  => 'Nhắc lại mật khẩu mới',
        ];
    }
}