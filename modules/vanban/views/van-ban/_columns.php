<?php
use yii\helpers\Url;
use app\modules\vanban\models\VanBanDen;
use app\modules\vanban\models\VanBanDi;

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
        'attribute'=>'so_loai_van_ban',
        'width'=> '100px',
        'format'=>'html',
        'value'=>function($model){
            if($model->so_loai_van_ban == VanBanDen::MODEL_ID){
                return '<span class="badge bg-primary">' . $model->getLoaiSoVBLabel() . '</span>';
            } else {
                return '<span class="badge bg-success">' . $model->getLoaiSoVBLabel() . '</span>';
            }
        },
        'contentOptions'=>['style'=>'text-align:center;']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nam',
        'width'=> '200px',
        'contentOptions'=>['style'=>'text-align:center;']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_vao_so',
        'width'=> '100px',
        'contentOptions'=>['style'=>'text-align:center;']
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_loai_van_ban',
        'value' => function ($model) {
            return $model->loaiVanBan->ten_loai; 
        },
        'width'=> '200px',
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_vb',
        'width'=> '200px',
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_ky',
        'value'=>function($model){
            return $model->ngayKy;
        },
        'width'=> '200px',
    ],
   // [
     //   'class'=>'\kartik\grid\DataColumn',
       // 'attribute'=>'trich_yeu',
    //],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nguoi_ky',
        'width'=> '200px',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'vbden_ngay_den',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'so_vao_so',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'vbden_nguoi_nhan',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'vbden_ngay_chuyen',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'vbdi_noi_nhan',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'vbdi_so_luong_ban',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'vbdi_ngay_chuyen',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ghi_chu',
    // ],
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
        // 'attribute'=>'so_loai_van_ban',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '100px',
        'template' => '{view}',
        'urlCreator' => function($action, $model, $key, $index) { 
            if($model->so_loai_van_ban == VanBanDen::MODEL_ID){
                return Url::to(['vb-den/view','id'=>$key]);
            } else if($model->so_loai_van_ban == VanBanDi::MODEL_ID){
                return Url::to(['vb-di/view','id'=>$key]);
            }
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','title'=>'Xem thông tin',
            'class'=>'btn ripple btn-primary btn-sm',
            'data-bs-placement'=>'top',
            'data-bs-toggle'=>'tooltip-primary']
    ],

];   