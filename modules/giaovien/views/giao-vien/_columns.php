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
    ],
    
   
    [
        'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'so_cccd',
   ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'gioi_tinh',
         'value'=> function ($model)
         {
            return $model->gioi_tinh == 1 ? 'Nam' : 'Nữ' ;
         },
        'filter'=> [1 => 'Nam', 0 => 'Nữ'],
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
        'width' => '200px',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','title'=>'Xem thông tin',
            'class'=>'btn ripple btn-primary btn-sm',
            'data-bs-placement'=>'top',
            'data-bs-toggle'=>'tooltip-primary'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Cập nhật dữ liệu', 
            'class'=>'btn ripple btn-info btn-sm',
            'data-bs-placement'=>'top',
            'data-bs-toggle'=>'tooltip-info'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Xóa dữ liệu này', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Xác nhận xóa dữ liệu?',
                          'data-confirm-message'=>'Bạn có chắc chắn thực hiện hành động này?',
                           'class'=>'btn ripple btn-secondary btn-sm',
                           'data-bs-placement'=>'top',
                           'data-bs-toggle'=>'tooltip-secondary'], 
    ],

];   
?>

