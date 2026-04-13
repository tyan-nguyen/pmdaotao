<?php

use app\custom\CustomFunc;
use app\modules\hocvien\models\DangKyHv;
use app\modules\user\models\User;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => '',
        'template' => '{view} {update} {delete}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton' => [
            'label' => '<i class="fe fe-settings floating"></i>',
            'class' => 'btn dropdown-toggle p-0'
        ],
        'vAlign' => 'middle',
        'width' => '20px',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'visibleButtons' => [
            'view' => function ($model, $key, $index) {
                return Yii::$app->params['showView'];
            },
            'update' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                return $user->canRoute('hocvien/dm-lien-ket/update');
            },
            'delete' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                return $user->canRoute('hocvien/dm-lien-ket/delete');
            },
        ],
        'viewOptions' => [
            'role' => 'modal-remote',
            'title' => 'View',
            'title' => 'Xem',
            'class' => 'btn ripple btn-primary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-primary'
        ],
        'updateOptions' => [
            'role' => 'modal-remote',
            'title' => 'Sửa',
            'class' => 'btn ripple btn-info btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-info'
        ],
        'deleteOptions' => [
            'role' => 'modal-remote',
            'title' => 'Xóa',
            'data-confirm' => false,
            'data-method' => false, // for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Xác nhận xóa dữ liệu?',
            'data-confirm-message' => 'Bạn có chắc chắn thực hiện hành động này?',
            'class' => 'btn ripple btn-secondary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-secondary'
        ],

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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'loai_don_vi',
        'value' => function ($model) {
            return $model->getDmNhanHoSoLabel($model->loai_don_vi);
        },
        'width' => '150px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ten_don_vi',
        'width' => '300px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Số lượng HV',
        'value' => function ($model) {
            return DangKyHv::find()->where(['id_nhan_ho_so_ho' => $model->id])->count();
        },
        'width' => '100px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ghi_chu',
        'format' => 'ntext',
        'width' => '150px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'thoi_gian_tao',
        'value' => function ($model) {
            return CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_tao);
        },
        'width' => '150px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nguoi_tao',
        'value' => function ($model) {
            return User::findOne($model->nguoi_tao)->username;
        },
        'width' => '150px',
    ],
];
