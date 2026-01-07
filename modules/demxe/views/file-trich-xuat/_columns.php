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
        'template' => '{readFile} {importFile} {view} {update} {delete}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) {
            if ($action === 'readFile') {
                return Url::to(['read-file', 'id' => $key]);
            }
            if ($action === 'importFile') {
                return Url::to(['import-file', 'id' => $key]);
            }
        	return Url::to([$action,'id'=>$key]);
        },
        'buttons' => [
            'readFile' => function ($url, $model, $key) {
                return Html::a('<i class="fe fe-file"></i> Đọc file', $url, [
                    'title' => 'Đọc file',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-warning dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip',
                ]);
            },
            'importFile' => function ($url, $model, $key) {
                return Html::a('<i class="fe fe-download"></i> Import file', $url, [
                    'title' => 'Import file',
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
            'readFile' => function ($model, $key, $index) {
                return !$model->daDocFile();
            },
            'importFile' => function ($model, $key, $index) {
                return !$model->daImportFile() && $model->daDocFile();
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
        'attribute'=>'thoi_gian_tu',
        'value'=>function($model){
            return CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_tu);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoi_gian_den',
        'value'=>function($model){
            return CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_den);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'filename',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'url',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nguoi_tao',
        'value'=>function($model){
            return User::getHoTenByID($model->nguoi_tao);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoi_gian_tao',
        'value'=>function($model){
            return CustomFunc::convertYMDHISToDMY($model->thoi_gian_tao);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ghi_chu',
    ],
];   