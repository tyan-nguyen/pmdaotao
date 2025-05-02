<?php
use yii\helpers\Url;
use app\custom\CustomFunc;
use app\modules\user\models\User;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{view} {update} {delete} ',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'viewOptions' => [
            'role' => 'modal-remote',
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
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hinh_thuc_thanh_toan',
        'label'=>'HTTT',
        'contentOptions' => [ 'style' => 'text-align:center' ],
        'pageSummary' => 'Tổng cộng',
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_tien_nop',
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
        'attribute'=>'chiet_khau',
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
        'attribute'=>'so_tien_con_lai',
        'value'=>function($model){
        return $model->so_tien_con_lai;
        },
        'contentOptions' => [ 'style' => 'text-align:right' ],
        'format' => ['decimal', 0],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
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
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'thoi_gian_tao',
         'value'=>function($model){
            return CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_tao);
         }
     ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'da_kiem_tra',
    // ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'ghi_chu',
     ],

];   