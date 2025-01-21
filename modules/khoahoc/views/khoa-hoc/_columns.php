<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{adduser} {addusers} {addGroup} {view} {update} {delete} ',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) { 
            if ($action === 'adduser') {
                return Url::to(['insert-hoc-vien', 'id' => $key]);
            }
            if ($action === 'addusers') {
                return Url::to(['insert-many-hoc-vien', 'id' => $key]);
            }
            if ($action === 'addGroup') {
                return Url::to(['add-group', 'id' => $key]);
            }

            return Url::to([$action, 'id' => $key]);
        },
               
                 'buttons' => [
                    'adduser' => function($url, $model, $key) {
                        return Html::a('<i class="fa fa-user-plus"></i> Thêm học viên', $url, [
                            'title' => 'Thêm Học viên',
                            'role' => 'modal-remote',
                            'class' => 'btn ripple btn-danger dropdown-item',
                            'data-bs-placement' => 'top',
                            'data-bs-toggle' => 'tooltip-warning',
                        ]);
                    },
                    'addusers' => function($url, $model, $key) {
                        return Html::a('<i class="icon-people"></i> Thêm nhiều', $url, [
                            'title' => 'Thêm nhiều Học viên',
                            'role' => 'modal-remote',
                            'class' => 'btn ripple btn-success dropdown-item',
                            'data-bs-placement' => 'top',
                            'data-bs-toggle' => 'tooltip-success',
                        ]);
                    },
                    'addGroup' => function($url, $model, $key) {
                        return Html::a('<i class="fa fa-plus-circle"></i> Quản lí nhóm', $url, [
                            'title' => 'Quản lí nhóm',
                            'role' => 'modal-remote',
                            'class' => 'btn ripple btn-success dropdown-item',
                            'data-bs-placement' => 'top',
                            'data-bs-toggle' => 'tooltip-warning',
                        ]);
                    }
                ],
              
            'viewOptions'=>['role'=>'modal-remote','title'=>'View','title'=>'Xem thông tin',
                'class'=>'btn ripple btn-primary btn-sm',
                'data-bs-placement'=>'top',
                'data-bs-toggle'=>'tooltip-primary'],
            'updateOptions'=>['role'=>'modal-remote','title'=>'Cập nhật dữ liệu', 
                'class'=>'btn ripple btn-info btn-sm',
                'data-bs-placement'=>'top',
                'data-bs-toggle'=>'tooltip-info'],
            'deleteOptions'=>['role'=>'modal-remote','title'=>'Xóa dữ liệu này', 
                              'data-confirm'=>false, 'data-method'=>false,
                              'data-request-method'=>'post',
                              'data-toggle'=>'tooltip',
                              'data-confirm-title'=>'Xác nhận xóa dữ liệu?',
                              'data-confirm-message'=>'Bạn có chắc chắn thực hiện hành động này?',
                               'class'=>'btn ripple btn-secondary btn-sm',
                               'data-bs-placement'=>'top',
                               'data-bs-toggle'=>'tooltip-secondary'], 
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
   
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_khoa_hoc',
        'width' => '200px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_hang',
        'width' => '100px',
        'value' => function($model) {
            return $model->hang ? $model->hang->ten_hang : 'N/A';
        },
        'label' => 'Hạng đào tạo',
    ],


    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_bat_dau',
        'width' => '100px',
        'value'=>function($model){
            return $model->ngayBatDau;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_ket_thuc',
        'width' => '100px',
        'value'=>function($model){
            return $model->ngayKetThuc;
        }
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'trang_thai',
        'width' => '150px',
        'format' => 'raw', 
        'value' => function($model) {
            if ($model->trang_thai === 'CHUA_HOAN_THANH') {
                return '<span class="badge bg-danger"> Chưa hoàn thành </span>';
            } elseif ($model->trang_thai === 'DA_HOAN_THANH') {
                return '<span class="badge bg-success"> Hoàn thành </span>';
            }
            return '<span class="badge bg-secondary"> Không xác định </span>'; 
        },
    ],
];   