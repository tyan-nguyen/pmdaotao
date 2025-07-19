<?php
use yii\helpers\Url;
use app\custom\CustomFunc;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{view} {nhapHang} {xuatHang} {update} {delete}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) {
            if ($action === 'nhapHang') {
                return Url::to(['ton-kho/nhap-kho-le', 'id' => $key]);
            }
            if ($action === 'xuatHang') {
                return Url::to(['ton-kho/xuat-kho-le', 'id' => $key]);
            }
        	return Url::to([$action,'id'=>$key]);
        },
        'visibleButtons' => [
            'view' => function ($model, $key, $index) {
                return Yii::$app->params['showView'];
            },
        ],
        'buttons' => [
            'nhapHang' => function ($url, $model, $key) {
                return Html::a('<i class="fa fa-cart-arrow-down"></i> Nhập kho lẻ', $url, [
                    'title' => 'Nhập kho',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-warning dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip',
                ]);
            },
            'xuatHang' => function ($url, $model, $key) {
                return Html::a('<i class="fa fa-cart-arrow-down"></i> Xuất kho lẻ', $url, [
                    'title' => 'Xuất kho',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-warning dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip',
                ]);
            },
        ],
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','title'=>'Xem',
               'class'=>'btn ripple btn-primary btn-sm',
              'data-bs-placement'=>'top',
              'data-bs-toggle'=>'tooltip-primary'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Sửa', 
            'class'=>'btn ripple btn-info btn-sm',
            'data-bs-placement'=>'top',
            'data-bs-toggle'=>'tooltip-info'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Xóa', 
                      'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
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
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_loai_hang_hoa',
        'value'=>function($model){
            return $model->loaiHangHoa->ten_loai_hang_hoa;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ma_hang_hoa',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_hang_hoa',
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_san_xuat',
        'value'=>function($model){
            return CustomFunc::convertYMDToDMY($model->ngay_san_xuat);
        },
        'contentOptions' => ['style' => 'text-align:center'],
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_luong',
        'value'=>function($model){
            return $model->co_ton_kho ? number_format($model->so_luong) : '-';
        },
        'contentOptions' => ['style' => 'text-align:right'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'don_gia',
        'value'=>function($model){
            return number_format($model->don_gia);
        },
        'contentOptions' => ['style' => 'text-align:right'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'dvt',
        'value'=>function($model){
            return $model->donViTinh->ten_dvt;
        },
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'co_ton_kho',
        'format'=>'html',
        'value'=>function($model){
            return $model->co_ton_kho ? '<i class="text-primary ion-checkmark-round"></i>' : '';
        },
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'xuat_xu',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ghi_chu',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nguoi_tao',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'thoi_gian_tao',
    // ],
];   