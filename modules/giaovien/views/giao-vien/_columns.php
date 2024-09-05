<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->registerCssFile('https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js', ['depends' => [\yii\web\YiiAsset::class]]);
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
   // [
   //     'class' => 'kartik\grid\SerialColumn',
    //    'width' => '30px',
   // ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
   
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ho_ten',
        'format' => 'raw',
        'value' => function($model) {
            return Html::a(
                Html::encode($model->ho_ten),
                '#',
                [
                    'class' => 'btn btn-link',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#options-modal-' . $model->id,
                ]
            );
        },
    ],
    
   
    [
        'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'so_cccd',
   ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'gioi_tinh',
    ],
    //[
     //  'class'=>'\kartik\grid\DataColumn',
      // 'attribute'=>'dia_chi',
  // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'dien_thoai',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tai_khoan',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'email',
    // ],
     [
        'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'trinh_do',
     ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'chuyen_nganh',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'vi_tri_cong_viec',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'kinh_nghiem_lam_viec',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ma_so_thue',
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
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Xem','data-toggle'=>'tooltip', 'class' => 'btn btn-info btn-sm'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Cập nhật', 'data-toggle'=>'tooltip','class' => 'btn btn-warning btn-sm'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Xóa',  'class' => 'btn btn-danger btn-sm',
                          'data-confirm'=>false, 'data-method'=>false,
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Xác nhận',
                          'data-confirm-message'=>'Bạn chắc chắn muốn xóa mục này?'], 
    ],

];   
?>

