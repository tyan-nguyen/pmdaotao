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
        'template' => '{view} {viewHocVien} {update} {delete} ',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) {
        if ($action === 'viewHocVien') {
            return Url::to(['/hocvien/hv-thue/view', 'id' => $model->id_hoc_vien]);
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
            'viewHocVien' => function ($url, $model, $key) {
            return Html::a('<i class="fas fa-user"></i> Xem học viên', $url, [
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
        'value'=>function($model){
            return CustomFunc::fillNumber($model->ma_so_phieu);
        },
        'width' => '80px',
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
        'attribute'=>'id_hoc_vien',
        'value'=>function($model){
            return $model->hocVien->ho_ten;
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_hoc_vien',
        'label'=>'Hạng ĐT',
        'value'=>function($model){
        return $model->hocVien->hangDaoTao->ma_hang;
        },
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_hoc_phi',
    ], */
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'loai_phieu',
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'loai_nop',
        'value'=>function($model){
            return $model->loaiNop;
        },
        'pageSummary' => 'Tổng cộng',
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_tien_nop',
        'label'=>'TT.TM(A)',
        'value'=>function($model){
        return $model->hinh_thuc_thanh_toan=='TM'?$model->so_tien_nop:'';
        },
        'contentOptions' => [ 'style' => 'text-align:right' ],
        'format' => ['decimal', 0],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
        ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_tien_nop',
        'label'=>'TT.CK(B)',
        'value'=>function($model){
        return $model->hinh_thuc_thanh_toan=='CK'?$model->so_tien_nop:'';
        },
        'contentOptions' => [ 'style' => 'text-align:right' ],
        'format' => ['decimal', 0],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
        ],
            
    [
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
        ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_tien_nop',
        'label'=>'Tổng TT(A+B+C)',
        'value'=>function($model){
        return $model->so_tien_nop;
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
         'attribute'=>'nguoi_thu',
         'value'=>function($model){
         $user = User::findOne($model->nguoi_thu);
             return $user ? $user->username : 'Không xác định';
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

];   