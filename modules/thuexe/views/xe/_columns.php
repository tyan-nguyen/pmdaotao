<?php
use yii\helpers\Url;
use app\modules\thuexe\models\LoaiXe;
use yii\bootstrap5\Html;
use app\modules\thuexe\models\Xe;
use app\custom\CustomFunc;
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{capNhapGiaoVien} {image} {view} {update} {delete}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
   
        'urlCreator' => function($action, $model, $key, $index) { 
            if ($action === 'capNhapGiaoVien') {
                return Url::to(['phan-cong-giao-vien', 'id' => $key]);
            }
            if ($action === 'image') {
                         return Url::to(['add-image', 'id' => $key]);
            }
                        return Url::to([$action,'id'=>$key]);
        },        
        'buttons' => [
            'capNhapGiaoVien' => function ($url, $model, $key) {
                return Html::a('<i class="fa-solid fa-list-check"></i> Phân công giáo viên', $url, [
                    'title' => 'Phân công giáo viên giảng dạy',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-warning dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip',
                ]);
            },
            'image' => function($url, $model, $key) {
                return Html::a('<i class="fa fa-image"></i> Thêm hình ảnh', $url, [
                    'title' => 'Thêm hình ảnh',
                    'role' => 'modal-remote-2',
                    'class' => 'btn ripple btn-success dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip-success',
                ]);
                
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
       'attribute'=>'id_loai_xe',
       'value' => function($model) {
            $loaiXe = LoaiXe::findOne($model->id_loai_xe);
            return $loaiXe ? $loaiXe->ten_loai_xe : '<span style="color: red;">Trống </span>'; 
       },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'phan_loai',
        'value' => function($model) {
            return $model->getLabelPhanLoaiXe();
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hieu_xe',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'bien_so_xe',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'mau_sac',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_dang_kiem',
        'value'=>function($model){
            return CustomFunc::convertYMDToDMY($model->ngay_dang_kiem);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_hop_dong',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_giao_vien',
        'label' => 'Người phụ trách',
        'value'=>function($model){
            return $model->giaoVien?$model->giaoVien->ho_ten:'';
        },
        //'width' => '150px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tinh_trang_xe',
        'value'=>function($model){
            return Xe::getLabelTinhTrangXeBadge($model->tinh_trang_xe);
        },
        'format'=>'raw',
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hieu_xe',
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ghi_chu',
    ],
    /* [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'trang_thai',
        'value' => function ($model) {
            return $model->trang_thai === 'Khả dụng' ? 'Khả dụng' : 'Không khả dụng';
        },
        'contentOptions' => function ($model) {
            return [
                'class' => $model->trang_thai === 'Khả dụng' ? 'text-success' : 'text-danger',
                'style' => 'font-weight: bold;', 
            ];
        },
    ], */
    
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nguoi_tao',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'thoi_gian_tao',
    // ],

];   