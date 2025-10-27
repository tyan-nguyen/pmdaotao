<?php
use yii\helpers\Url;
use app\custom\CustomFunc;
use app\modules\thuexe\models\LichThue;
use yii\helpers\Html;
use app\modules\user\models\User;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{chiTiet} {delete}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) {
            if ($action === 'chiTiet') {
                return Url::to(['update', 'id' => $key]);
            }
        	return Url::to([$action,'id'=>$key]);
        },
        'buttons' => [
            'chiTiet' => function ($url, $model, $key) {
            return Html::a('<i class="fa fa-folder-open"></i> Chi tiết', $url, [
                'title' => 'Xem chi tiết',
                'role' => 'modal-remote',
                'class' => 'btn ripple btn-warning dropdown-item',
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
            ]);
            },
        ],
        'visibleButtons' => [
            'view' => function ($model, $key, $index) {
                return Yii::$app->params['showView'];
            },
            'delete' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                // Only show delete button if user is admin
                return $user->superadmin;
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
        'attribute'=>'id_xe',
        'value'=>function($model){
            return $model->xe?$model->xe->tenXeShort:'';
        }
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'loai_giao_vien',
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_giao_vien',
        'value'=>function($model){
            return $model->giaoVien?$model->giaoVien->ho_ten:'';
        },
        'label'=>'Người hướng dẫn',
        'contentOptions' => function ($model) {
            return ['class' => 'trang-thai-' . strtolower($model->loai_giao_vien)];
        }
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'loai_khach_hang',
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_khach_hang',
        'value'=>function($model){
            return $model->khachHang?$model->khachHang->ho_ten:'';
        },
        'contentOptions' => function ($model) {
            return ['class' => 'trang-thai-' . strtolower($model->loai_khach_hang)];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'SĐT',
        'value'=>function($model){
            return $model->khachHang?$model->khachHang->so_dien_thoai:'';
        },
        'contentOptions' => function ($model) {
            return ['class' => 'trang-thai-' . strtolower($model->loai_khach_hang)];
        }
    ],    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoi_gian_bat_dau',
        'label'=>'Thời gian BĐ',
        'value'=>function($model){
            return CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_bat_dau);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoi_gian_ket_thuc',
        'label'=>'Thời gian KT',
        'value'=>function($model){
            return CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_ket_thuc);
        }
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'don_gia',
        'contentOptions' => ['style' => 'text-align:right'],
        'value'=>function($model){
            return number_format($model->don_gia);
        },
        'width'=>'70',
        'pageSummary' => 'Tổng cộng',
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_gio',
        'width'=>'70',
        'contentOptions' => ['style' => 'text-align:right'],
        'format' => ['decimal', 1],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Thành tiền',
        'width'=>'70',
        'value'=>function($model){
            return $model->tongTien;
        },
        'contentOptions' => ['style' => 'text-align:right'],
        'format' => ['decimal', 0],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Đã TT',
        'width'=>'70',
        'value'=>function($model){
            return $model->tienDaThanhToan;
        },
        //'contentOptions' => ['style' => 'text-align:right'],
        'format' => ['decimal', 0],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
        'contentOptions' => function ($model) {
            $cls = '';
            if($model->tienDaThanhToan > $model->tongTien){
                $cls = 'tien-thua';
            }else if($model->tienDaThanhToan == $model->tongTien){
                $cls = 'tien-du';
            }
            return ['class' => $cls, 'style' => 'text-align:right'];
        }
        ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'trang_thai',
        'value'=>function($model){
            return LichThue::getDmTrangThaiLabelWithBadge($model->trang_thai);
        },
        'format'=>'html',
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nguoi_tao',
        'value'=>function($model){
        return $model->nguoiTao?$model->nguoiTao->username:'';
        },
        'width' => '80px',
        'contentOptions' => [ 'style' => 'text-align:center'],
    ],
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