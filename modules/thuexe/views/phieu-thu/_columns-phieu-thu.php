<?php
use yii\helpers\Url;
use app\custom\CustomFunc;
use app\modules\user\models\User;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{view} {viewLichThue} {update} {delete} ',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) {
            if ($action === 'viewLichThue') {
                return Url::to(['/thuexe/lich-thue/update', 'id' => $model->id_lich_thue]);
            }
            return Url::to([$action, 'id' => $key]);
        },
        'visibleButtons' => [
            'update' => function ($model, $key, $index) {
                return /*($model->so_lan_in_phieu==0 && Yii::$app->user->id == User::findOne($model->nguoi_tao)->id) ||*/ User::getCurrentUser()->superadmin;
            },
            'delete' => function ($model, $key, $index) {
                return User::getCurrentUser()->superadmin;
            },
        ],
        'buttons' => [
            'viewLichThue' => function ($url, $model, $key) {
                return Html::a('<i class="fas fa-user"></i> Xem lịch thuê', $url, [
                    'title' => 'Xem học viên',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-warning dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip',
                ]);
            },
            'view' => function ($url, $model, $key) {
                return Html::a('<i class="fas fa-eye"></i> Xem phiếu', $url, [
                    'title' => 'Xem phiếu',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-warning dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip',
                ]);
            },
        ],
        /* 'viewOptions' => [
            'role' => 'modal-remote',
            'title' => 'Xem phiếu',
            'class' => 'btn ripple btn-primary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-primary'
        ], */
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
            'class' => 'btn ripple btn-success btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-success'
        ],
            
    ],
            
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ma_so_phieu',
        'label'=>'Mã số',
        'value'=>function($model){
            return CustomFunc::fillNumber($model->ma_so_phieu);
        },
        'width' => '50px',
        'contentOptions' => [ 'style' => 'text-align:center' ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoi_gian_tao',
        'label'=>'Ngày TT',
        'value'=>function($model){
            //return CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_tao);
            return CustomFunc::convertYMDHISToDMY($model->thoi_gian_tao);
        },
        'width' => '80px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_lich_thue',
        'label'=>'Khách hàng',
        'value'=>function($model){
            return $model->lichThue->khachHang?$model->lichThue->khachHang->ho_ten:'';
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_lich_thue',
        'label'=>'Giáo viên',
        'value'=>function($model){
            return $model->lichThue->giaoVien?$model->lichThue->giaoVien->ho_ten:'';
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_lich_thue',
        'label'=>'Xe',
        'value'=>function($model){
            return $model->lichThue->xe?$model->lichThue->xe->tenXeShort:'';
        },
        'pageSummary' => 'Tổng cộng',
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_lich_thue',
        'label'=>'Hạng',
        'value'=>function($model){
            return $model->lichThue->xe->loaiXe?$model->lichThue->xe->loaiXe->ten_loai_xe:'';
        },
        'pageSummary' => 'Tổng cộng',
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
        ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hinh_thuc_thanh_toan',
        'label'=>'HTTT',
        'contentOptions' => [ 'style' => 'text-align:center' ],
        'pageSummary' => 'Tổng cộng',
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_tien',
        'label'=>'TT.TM(A)',
        'value'=>function($model){
            return $model->hinh_thuc_thanh_toan=='TM'?$model->so_tien:'';
        },
        'contentOptions' => [ 'style' => 'text-align:right' ],
        'format' => ['decimal', 0],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_tien',
        'label'=>'TT.CK(B)',
        'value'=>function($model){
            return $model->hinh_thuc_thanh_toan=='CK'?$model->so_tien:'';
        },
        'contentOptions' => [ 'style' => 'text-align:right' ],
        'format' => ['decimal', 0],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ],
    
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'chiet_khau',
        'label'=>'Chiết khấu(C)',
        'value'=>function($model){
            return $model->chiet_khau;
        },
        'contentOptions' => [ 'style' => 'text-align:right' ],
        'format' => ['decimal', 0],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_tien',
        'label'=>'Tổng TT(A+B)',
        'value'=>function($model){
        return $model->so_tien;
        },
        'contentOptions' => [ 'style' => 'text-align:right' ],
        'format' => ['decimal', 0],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
        ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_tien_con_lai',
        'label'=>'Còn lại(D)',
        'value'=>function($model){
            return $model->so_tien_con_lai;
        },
        'contentOptions' => [ 'style' => 'text-align:right' ],
        'format' => ['decimal', 0],
        //'pageSummary' => true,
        //'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ],
    /*  [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'ngay_nop',
    ],
     */
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'so_lan_in_phieu',
    // ],
     
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'nguoi_tao',
         'value'=>function($model){
             return $model->nguoiTao->shortName;
         },
         'contentOptions' => [ 'style' => 'text-align:center' ],
     ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'bien_lai',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nguoi_tao',
    // ],
     /* [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'thoi_gian_tao',
         'value'=>function($model){
            return CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_tao);
         }
     ], */
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'da_kiem_tra',
    // ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'ghi_chu',
     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'label'=>'Ghi chú (lịch)',
         'value'=>'lichThue.ghi_chu'
     ],

];   