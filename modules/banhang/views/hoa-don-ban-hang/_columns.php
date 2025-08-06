<?php
use yii\helpers\Url;
use app\custom\CustomFunc;
use app\modules\user\models\User;
use yii\helpers\Html;
use app\modules\banhang\models\HoaDon;

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
        'attribute'=>'trang_thai',
        'label'=>'TR.THÁI',
        'format'=>'html',
        'value'=>function($model){
            return $model->getDmTrangThaiLabelWithBadge($model->trang_thai);
        },
        'contentOptions' => ['style' => 'text-align:center;width:80px;'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_vao_so',
        'label'=>'Số hóa đơn',
        'value'=>function($model){
            return $model->soHoaDon;
        },
        'contentOptions' => ['style' => 'text-align:center;font-weight:bold'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'loai_khach_hang',
        'label'=>'Loại KH',
        'value'=>function($model){
            return HoaDon::getDmLoaiKhachHangLabel($model->loai_khach_hang);
        },
        'headerOptions' => ['style' => 'width:100px;'],
        'contentOptions' => ['style' => 'width:100px;'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_khach_hang',
        'value'=>function($model){
            return $model->khachHang->ho_ten;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Số CCCD',
        'value'=>function($model){
            return $model->khachHang?$model->khachHang->so_cccd:'';
        },
        'contentOptions' => ['style' => 'text-align:center;'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Số ĐT',
        'value'=>function($model){
            return $model->khachHang?$model->khachHang->so_dien_thoai:'';
        },
        'contentOptions' => ['style' => 'text-align:center;'],
     ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_don_hang',
    ], */
    
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nam',
    ], */
    
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_dat_hang',
        'value'=>function($model){
            return CustomFunc::convertYMDToDMY($model->ngay_dat_hang);
        },
        'contentOptions' => ['style' => 'text-align:center'],
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_xuat',
        'value'=>function($model){
            return CustomFunc::convertYMDToDMY($model->ngay_xuat);
        },
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hinh_thuc_thanh_toan',
        'label'=>'HTTT',
        'contentOptions' => ['style' => 'text-align:center'],
        'pageSummary' => 'Tổng cộng',
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Số tiền',
        'value'=>function($model){
          return $model->tongTien;  
        },
        'contentOptions' => ['style' => 'text-align:right;font-weight:bold'],
        'format' => ['decimal', 0],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'so_lan_in',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'da_giao_hang',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ngay_giao_hang',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'chi_phi_van_chuyen',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ghi_chu',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nguoi_tao',
        'value'=>function($model){
            return User::getHoTenByID($model->nguoi_tao);
        }
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'thoi_gian_tao',
    // ],
];   