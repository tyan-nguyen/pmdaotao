<?php
use yii\helpers\Url;
use app\custom\CustomFunc;
use app\modules\daotao\models\KeHoach;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{view} {update} {delete}',
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
        'visibleButtons' => [
            'view' => function ($model, $key, $index) {
                return Yii::$app->params['showView'];
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
        'attribute'=>'id_giao_vien',
        'value'=>function($model){
            return $model->giaoVien?$model->giaoVien->ho_ten:'';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_thuc_hien',
        'value'=>function($model){
            return CustomFunc::convertYMDToDMY($model->ngay_thuc_hien);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'trang_thai_duyet',
        'value'=>function($model){
            return KeHoach::getLabelTinhTrangXeBadge($model->trang_thai_duyet);
        },
        'format' => 'raw'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_nguoi_duyet',
        'value'=>function($model){
        return $model->nguoiDuyet?($model->nguoiDuyet->ho_ten?$model->nguoiDuyet->ho_ten:$model->nguoiDuyet->username):'';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoi_gian_duyet',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'noi_dung_duyet',
        'width' => '250px',
    ],
    
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'thoi_gian_tao',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nguoi_tao',
    // ],
];   