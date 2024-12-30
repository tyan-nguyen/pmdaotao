<?php
use yii\helpers\Url;
use app\modules\khoahoc\models\NhomHoc;
use app\modules\lichhoc\models\PhongHoc;
use app\modules\giaovien\models\GiaoVien;
use app\modules\khoahoc\models\KhoaHoc;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
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
        'urlCreator' => function($action, $model, $key, $index) {
        return Url::to([$action,'id'=>$key]);
        },
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
        'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'id_khoa_hoc',
       'value' => function($model) {
            $kh = KhoaHoc::findOne($model->id_khoa_hoc);
            return $kh ? $kh->ten_khoa_hoc : 'Trống'; 
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_nhom',
        'value' => function($model) {
            $nhom = NhomHoc::findOne($model->id_nhom);
            return $nhom ? $nhom->ten_nhom : 'Chung'; 
        },
    ],
 
    [
        'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'id_phong_thi',
       'value' => function($model) {
            $phong = PhongHoc::findOne($model->id_phong_thi);
            return $phong ? $phong->ten_phong : '<span style="color: red;">Trống </span>'; 
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'id_giao_vien_gac',
       'value' => function($model) {
            $gv = GiaoVien::findOne($model->id_giao_vien_gac);
            return $gv ? $gv->ho_ten : '<span style="color: red;">Trống </span>'; 
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'thoi_gian_thi',
        'value' => function ($model) {
            return Yii::$app->formatter->asDatetime($model['thoi_gian_thi'], 'php:H:i | d-m-Y');
        },
    ],
    
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id_giao_vien_gac',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'thoi_gian_thi',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'trang_thai',
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