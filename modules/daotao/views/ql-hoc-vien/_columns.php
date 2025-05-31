<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\modules\hocvien\models\NopHocPhi;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\HocPhi;
use app\modules\hocvien\models\KhoaHoc;
use app\custom\CustomFunc;
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
   [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{view}',
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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_khoa_hoc',
        'value' => function ($model) {
        $khoaHoc = KhoaHoc::findOne($model->id_khoa_hoc);
        return $khoaHoc
        ? '<strong>' . $khoaHoc->ten_khoa_hoc . '</strong>'
            : '<span class="badge bg-warning"> Chưa sắp khóa học </span>';
        },
        'format' => 'raw',
        'width' => '200px',
    ],
   
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ho_ten',
        'width' => '200px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_sinh',
        'value'=>function($model){
            return CustomFunc::convertYMDToDMY($model->ngay_sinh);  
        },
        'width' => '100px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'gioi_tinh',
        'width' => '150px',
        'value' => function ($model) {
            return $model->gioi_tinh == 1 ? 'Nam' : 'Nữ';
        },
        'filter' => [
            1 => 'Nam',
            0 => 'Nữ',
        ], 
        'headerOptions' => ['style' => 'text-align: center;'],
        'contentOptions' => ['style' => 'text-align: center;'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_cccd',
        'label'=>'CCCD (Mã KH)',
        'width' => '150px',
        'contentOptions' => [ 'style' => 'text-align:center' ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_dien_thoai',
        'width' => '100px',
        'contentOptions' => [ 'style' => 'text-align:center' ],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_hang',
        'width' => '250px',
        'value' => function($model) {
            return $model->hangDaoTao ? $model->hangDaoTao->ten_hang : 'N/A';
        },
        'label' => 'Hạng đào tạo',
        ],
    
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_giao_vien',
        'value'=>function($model){
            return $model->giaoVien?$model->giaoVien->ho_ten:'';
        },
        'width' => '150px',
    ],

     /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'trang_thai',
        'width' => '150px',
     ], */

    
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nguoi_tao',
        'value'=>function($model){
        return $model->nguoiTao->username;
        },
        'width' => '100px',
    ], */
];   