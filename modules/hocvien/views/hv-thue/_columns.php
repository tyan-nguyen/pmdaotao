<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\custom\CustomFunc;
return [
    /* [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ], */

        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        //'template' => '{payment} {view} {update} {delete} ',
        'template' => '{view} {setThue} {huySetThue}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) { 
            if ($action === 'payment') {
                return Url::to(['create2', 'id' => $key]);
            }
            if ($action === 'setThue') {
                return Url::to(['set-thue', 'id' => $key]);
            }
            if ($action === 'huySetThue') {
                return Url::to(['cancel-set-thue', 'id' => $key]);
            }
            return Url::to([$action, 'id' => $key]);
        },
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
    'buttons' => [
        'payment' => function ($url, $model, $key) {
            return Html::a('<i class="fas fa-dollar-sign"></i> Đóng học phí', $url, [
                'title' => 'Đóng học phí',
                'role' => 'modal-remote',
                'class' => 'btn ripple btn-warning dropdown-item', 
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
            ]);
        },
        'setThue' => function ($url, $model, $key) {
            return Html::a('<i class="ion-checkmark-round text-primary" data-bs-toggle="tooltip" aria-label="ion-checkmark-round" data-bs-original-title="ion-checkmark-round"></i> Đã xuất HĐ thuế', $url, [
                'title' => 'Đánh dấu xuất hóa đơn thuế',
                'role' => 'modal-remote',
                'class' => 'btn ripple btn-warning dropdown-item',
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
                'data-bs-dismiss' => 'modal'
            ]);
        },
        'huySetThue' => function ($url, $model, $key) {
            return Html::a('<i class="ion-close-round" data-bs-toggle="tooltip" aria-label="ion-close-round" data-bs-original-title="ion-close-round"></i> Hủy xuất HĐ thuế', $url, [
                'title' => 'Hủy đánh dấu xuất hóa đơn thuế',
                'role' => 'modal-remote',
                'class' => 'btn ripple btn-warning dropdown-item',
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
                'data-bs-dismiss' => 'modal'
            ]);
        },
    ],
    'visibleButtons' => [
        'setThue' => function ($model, $key, $index) {
            return !$model->co_ho_so_thue;
        },
        'huySetThue' => function ($model, $key, $index) {
            return $model->co_ho_so_thue;
        },
   ],
    

    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ho_ten',
        'width' => '200px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'dia_chi',
        'width' => '300px',
    ],
   // [
      //  'class'=>'\kartik\grid\DataColumn',
      //  'attribute'=>'so_dien_thoai',
   // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_cccd',
        'label'=>'CCCD (Mã KH)',
        'width' => '150px',
        'contentOptions' => [ 'style' => 'text-align:center' ],
    ],

 
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_hang',
        'width' => '200px',
        'value' => function($model) {
            return $model->hangDaoTao ? $model->hangDaoTao->ten_hang : 'N/A';
        },
        'label' => 'Hạng đào tạo',
        'pageSummary' => 'Tổng cộng (E=A-B-C+D)',
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label'=>'Học phí(A)',
        'width' => '120px',
        'value' => function($model) {
            return $model->tienHocPhi;
        },
        'contentOptions' => [ 'style' => 'text-align:right' ],
        'format' => ['decimal', 0],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
        ],
        //'pageSummary' => true,
        [
            'class' => '\kartik\grid\DataColumn',
            'label'=>'Đã T.T(TM)',
            'width' => '100px',
            'value' => function($model) {
            return $model->tienDaNopDuongTM;
            },
            'contentOptions' => [ 'style' => 'text-align:right' ],
            'format' => ['decimal', 0],
            'pageSummary' => true,
            'pageSummaryOptions' => ['class' => 'text-right text-end'],
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'label'=>'Đã T.T(CK)',
            'width' => '100px',
            'value' => function($model) {
            return $model->tienDaNopDuongCK;
            },
            'contentOptions' => [ 'style' => 'text-align:right' ],
            'format' => ['decimal', 0],
            'pageSummary' => true,
            'pageSummaryOptions' => ['class' => 'text-right text-end'],
       ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label'=>'Tổng T.T(B)',
        'width' => '120px',
        'value' => function($model) {
            return $model->tienDaNopDuong;
        },
        'contentOptions' => [ 'style' => 'text-align:right' ],
        'format' => ['decimal', 0],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
     ],
     [
         'class' => '\kartik\grid\DataColumn',
         'label'=>'Chiết khấu(C)',
         'width' => '100px',
         'value' => function($model) {
            return $model->tienChietKhau;
         },
         'contentOptions' => [ 'style' => 'text-align:right' ],
         'format' => ['decimal', 0],
         'pageSummary' => true,
         'pageSummaryOptions' => ['class' => 'text-right text-end'],
      ],
      [
          'class' => '\kartik\grid\DataColumn',
          'label'=>'Chi lại(D)',
          'width' => '100px',
          'value' => function($model) {
          return abs($model->tienDaNopAm);
          },
          'contentOptions' => [ 'style' => 'text-align:right;color:red' ],
          'format' => ['decimal', 0],
          'pageSummary' => true,
          'pageSummaryOptions' => ['class' => 'text-right text-end'],
       ],
      [
          'class' => '\kartik\grid\DataColumn',
          'label'=>'Còn lại(E)',
          'width' => '120px',
          'value' => function($model) {
            return $model->tienChuaThanhToan;
          },
          'contentOptions' => [ 'style' => 'text-align:right;font-weight:bold'],
          'format' => ['decimal', 0],
          'pageSummary' => true,
          'pageSummaryOptions' => ['class' => 'text-right text-end'],
     ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'trang_thai',
    // ],
     /* [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'nguoi_tao',
         'value'=>function($model){
             return $model->nguoiTao->username;
         },
         'width' => '100px',
     ], */
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'thoi_gian_tao',
         'value'=>function($model){
            return CustomFunc::convertYMDHISToDMY($model->thoi_gian_tao);
         },
         'width' => '100px',
         'contentOptions' => [ 'style' => 'text-align:center' ],
     ],
     
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'co_ho_so_thue',
         'label'=>'HS Thuế',
         'format'=>'html',
         'value'=>function($model){
            return $model->co_ho_so_thue==1?'<i class="ion-checkmark-round text-primary" data-bs-toggle="tooltip" aria-label="ion-checkmark-round" data-bs-original-title="ion-checkmark-round"></i>':'';
         },
         'width' => '50px',
         'contentOptions' => [ 'style' => 'text-align:center' ],
     ],
    
    
    
    /*
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'loai_dang_ky',
        'width' => '100px',
        'format' => 'raw',
        'value' => function ($model) {
        if (strtolower($model->loai_dang_ky) == 'nhập trực tiếp') {
            return '<span style="color: green;">Nhập trực tiếp</span>';
        } else {
            return '<span style="color: orange;">' . $model->loai_dang_ky . '</span>';
        }
        },
    ],
        
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'trang_thai_duyet',
        'width' => '100px',
        'format' => 'raw',
        'value' => function ($model) {
        if ($model->trang_thai_duyet == 'CHO_DUYET') {
            return '<span class="badge bg-primary">Chờ duyệt</span>';
        } elseif ($model->trang_thai_duyet == 'KHONG_DUYET') {
            return '<span class="badge bg-danger">Không duyệt</span>';
        } elseif ($model->trang_thai_duyet == 'DA_DUYET') {
            return '<span class="badge bg-danger">Đã duyệt</span>';
        }
        return '<span class="badge bg-secondary">Không xác định</span>';
        },
    ],
    */
  
    
 
];   