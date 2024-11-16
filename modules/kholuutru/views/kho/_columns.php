<?php
use yii\helpers\Url;
use yii\helpers\html;
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
        'attribute'=>'ten_kho',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'so_do_kho',
        'label' => 'Sơ đồ kho',
        'format' => 'html',
        'value' => function ($model) {
            $imageUrl = Yii::$app->urlManager->createUrl($model->so_do_kho);
            return Html::img($imageUrl, ['class' => 'zoomable-img img-thumbnail', 'style' => 'width:100px;height:100px;']);
        },
    ],
    
    
    
  //  [
    //    'class'=>'\kartik\grid\DataColumn',
     //   'attribute'=>'nguoi_tao',
    //],
   // [
    //    'class'=>'\kartik\grid\DataColumn',
    //    'attribute'=>'thoi_gian_tao',
   // ],
   

];   
?>

