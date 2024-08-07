<?php
use yii\helpers\Url;
use app\modules\user\models\User;
use webvimark\modules\UserManagement\models\rbacDB\Role;
use app\modules\user\UserModule;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use webvimark\modules\UserManagement\components\GhostHtml;
use app\widgets\LinkToModalWidget;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'value'=>function(User $model){
            return GhostHtml::a(
                UserModule::t('back', '<i class="pe-7s-config"></i>'),
                //['/user/user-permission/set', 'id'=>$model->id],
                ['/user/user-permission/set', 'id'=>$model->id],
                ['class'=>'btn btn-sm btn-primary', 'data-pjax'=>1, 'role'=>'modal-remote', 'title'=>'Phân quyền tài khoản']);
        },
        'format'=>'raw',
        'visible'=>User::canRoute('/user/user-permission/set'),
        'options'=>[
            'width'=>'10px',
        ],
    ],
    [
        'value'=>function(User $model){
            return GhostHtml::a(
                UserModule::t('back', '<i class="pe-7s-lock"></i>'),
                ['change-password', 'id'=>$model->id],
                ['class'=>'btn btn-sm btn-default', 'data-pjax'=>1, 'role'=>'modal-remote', 'title'=>'Thay đổi mật khẩu']);
        },
        'format'=>'raw',
        'options'=>[
            'width'=>'10px',
        ],
    ],
    [
        'class'=>'webvimark\components\StatusColumn',
        'attribute'=>'superadmin',
        'visible'=>Yii::$app->user->isSuperadmin,
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'username',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'username',
        'label'=>'Nhân viên',
        //'value'=>'tenNhanVien',
        'format'=>'raw',
        'value'=>function($model){
            return LinkToModalWidget::widget([
                'label'=>$model->tenNhanVien,
                'link'=>$model->showLinkNhanVien
            ]);
        }
    ],
    [
        'attribute'=>'email',
        'format'=>'raw',
        'visible'=>User::hasPermission('viewUserEmail'),
    ],
    /* [
        'class'=>'webvimark\components\StatusColumn',
        'attribute'=>'email_confirmed',
        'visible'=>User::hasPermission('viewUserEmail'),
    ], */
   [
        'attribute'=>'gridRoleSearch',
        'filter'=>ArrayHelper::map(Role::getAvailableRoles(Yii::$app->user->isSuperAdmin),'name', 'description'),
        'value'=>function(User $model){
                return implode(', ', ArrayHelper::map($model->roles, 'name', 'description'));
            },
        'format'=>'raw',
        'visible'=>User::hasPermission('viewUserRoles'),
    ],
    [
        'attribute'=>'registration_ip',
        'value'=>function(User $model){
                return Html::a($model->registration_ip, "http://ipinfo.io/" . $model->registration_ip, ["target"=>"_blank"]);
            },
        'format'=>'raw',
        'visible'=>User::hasPermission('viewRegistrationIp'),
    ],
    [
        'class'=>'webvimark\components\StatusColumn',
        'attribute'=>'status',
        'optionsArray'=>[
            [User::STATUS_ACTIVE, UserModule::t('back', 'Active'), 'success'],
            [User::STATUS_INACTIVE, UserModule::t('back', 'Inactive'), 'warning'],
            [User::STATUS_BANNED, UserModule::t('back', 'Banned'), 'danger'],
        ],
    ],    
    
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '200px',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','title'=>'Xem thông tin',
            'class'=>'btn ripple btn-primary btn-sm',
            'data-bs-placement'=>'top',
            'data-bs-toggle'=>'tooltip-primary'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Cập nhật dữ liệu',
            'class'=>'btn ripple btn-info btn-sm',
            'data-bs-placement'=>'top',
            'data-bs-toggle'=>'tooltip-info'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Xóa dữ liệu này',
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-toggle'=>'tooltip',
            'data-confirm-title'=>'Xác nhận xóa dữ liệu?',
            'data-confirm-message'=>'Bạn có chắc chắn thực hiện hành động này?',
            'class'=>'btn ripple btn-secondary btn-sm',
            'data-bs-placement'=>'top',
            'data-bs-toggle'=>'tooltip-secondary'], 
    ],

];   