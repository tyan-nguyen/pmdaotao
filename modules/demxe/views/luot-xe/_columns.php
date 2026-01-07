<?php
use yii\helpers\Url;
use app\modules\demxe\models\DemXe;
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
        'label'=>'T.T.',
        'value'=>function($model){
            return $model->trangThaiPhienIcon;
        },
        'format'=>'html',
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_xe',
        'label'=>'Loại xe',
        'value'=>function($model){
            return $model->id_xe != null ? '<span class="badge bg-primary">Xe nội bộ</span>' 
                : '<span class="badge bg-info">Xe khách</span>';
        },
        'format'=>'html',
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ma_xe',
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ma_xe',
        'label'=>'Biển số xe',
        'value'=>function($model){
            if($model->xe){
                if(User::hasPermission('qQuanLySuKienDemXe')){
                    return Html::a($model->xe->bien_so_xe,
                        '/thuexe/lich-xe/lich-xe-gv-so-sanh?idxe='.$model->id_xe.'&menu=dt3',[
                            'target'=>'_blank',
                            'data-pjax' => '0',
                            'class'=>'btn-in-grid',
                            'title'=>$model->trangThaiPhien
                            //'style'=>'font-weight:bold'
                        ]);
                } else {
                    return $model->xe->bien_so_xe;
                }
            } else {
                return '<span title="'.$model->trangThaiPhien.'">' . $model->bien_so_xe . '</span>';
            }
            return '<span title="'.$model->trangThaiPhien.'">' . 
                ($model->xe?$model->xe->bien_so_xe:$model->bien_so_xe)
                . '</span>';
        },
        'format'=>'raw',
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ma_cong',
        'value'=>function($model){
            return DemXe::getTram()[$model->ma_cong];
        },
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoi_gian_bd',
        'value'=>function($model){
            return CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_bd);
        },
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoi_gian_kt',
        'value'=>function($model){
            return CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_kt);
        },
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'so_gio',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_phut',
        'label'=>'Thời gian',
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nguoi_tao',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'thoi_gian_tao',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id_file',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ghi_chu',
    ],
];   