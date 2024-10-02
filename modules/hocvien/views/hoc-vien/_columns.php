<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\modules\hocvien\models\NopHocPhi;
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
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
        'attribute'=>'ho_ten',
    ],
   // [
       // 'class'=>'\kartik\grid\DataColumn',
      //  'attribute'=>'so_dien_thoai',
    //],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_cccd',
    ],
 
     [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'dia_chi',
     ],
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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_hang',
        'value' => function($model) {
            return $model->hangDaoTao ? $model->hangDaoTao->ten_hang : 'N/A';
        },
        'label' => 'Hạng đào tạo',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{payment} {view} {update} {delete} ',
        'dropdown' => false,
        'vAlign' => 'middle',
        'width' => '200px',
     'urlCreator' => function($action, $model, $key, $index) {
    if ($action === 'payment') {
        $nopHP = NopHocPhi::find()->where(['id_hoc_vien' => $model->id])->all();
        if (empty($nopHP)) { 
            return Url::to(['create2', 'id' => $key]); 
        } else {
            return Url::to(['mess', 'id' => $key]); 
        }
           }
            return Url::to([$action, 'id' => $key]); // URL mặc định cho các action khác
        },
          // Đặt buttons bên trong cấu hình của ActionColumn
          'buttons' => [
            'payment' => function($url, $model, $key) {
                return Html::a('<i class="fas fa-dollar-sign"></i>', $url, [
                    'title' => 'Đóng học phí',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-warning btn-sm',
                    'style' => 'width: 30px; text-align: center;',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip-warning',
                ]);
            }
        ],
        'viewOptions' => [
            'role' => 'modal-remote',
            'title' => 'Xem thông tin',
            'class' => 'btn ripple btn-primary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-primary'
        ],
        'updateOptions' => [
            'role' => 'modal-remote-2',
            'title' => 'Cập nhật dữ liệu',
            'class' => 'btn ripple btn-info btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-info'
        ],
        'deleteOptions' => [
            'role' => 'modal-remote',
            'title' => 'Xóa dữ liệu này',
            'data-confirm' => false,
            'data-method' => false, // Override yii data API
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Xác nhận xóa dữ liệu?',
            'data-confirm-message' => 'Bạn có chắc chắn thực hiện hành động này?',
            'class' => 'btn ripple btn-secondary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-secondary'
        ],
      
    ],
    

];   