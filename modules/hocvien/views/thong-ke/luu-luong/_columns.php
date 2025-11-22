<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\custom\CustomFunc;
use app\modules\user\models\User;
use app\modules\hocvien\models\DangKyHv;
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
        'template' => '{bienTapDiaChi}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) {
            if ($action === 'bienTapDiaChi') {
                return Url::to(['dang-ky-hv/bien-tap-dia-chi', 'idhv' => $key]);
            }
            return Url::to([$action, 'id' => $key]);
        },
        'visibleButtons' => [
            'bienTapDiaChi' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                return ($model->noi_dang_ky == $user->noi_dang_ky || $user->superadmin || $user->username == 'bientapdulieu');//chung co so sua duoc
            },
        ],
        'buttons' => [
            'bienTapDiaChi' => function ($url, $model, $key) {
                return Html::a('<i class="fa fa-pencil"></i> Cập nhật địa chỉ', $url, [
                    'title' => 'Biên tập lại địa chỉ theo đơn vị hành chính',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-primary dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip'
                ]);
            }
            
        ],                
    ],
    
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'noi_dang_ky',
        'label'=>'NĐK',
        'value'=>function($model){
            return DangKyHv::getLabelNoiDangKyBadge($model->noi_dang_ky) 
                /*. '<span class="badge bg-success">' . DangKyHv::getLabelNoiDangKyOther($model->noi_dang_ky) . '</span>'*/;
            },
        'format'=>'raw',
        'width' => '50px',
        'contentOptions' => [ 'style' => 'text-align:center' ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ho_ten',
        'width' => '120px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_sinh',
        'value'=>function($model){
            return $model->getNgaySinh();
        },
        'width' => '40px',
        'contentOptions' => [ 'style' => 'text-align:center' ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Địa chỉ cũ',
        'attribute'=>'dia_chi',
        'width' => '200px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Địa chỉ(BT lại)',
        'value'=>function($model){
            return $model->diaChiText;  
        },
        'width' => '200px',
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_cccd',
        'label'=>'CCCD (Mã KH)',
        'width' => '150px',
        'contentOptions' => [ 'style' => 'text-align:center' ],
    ], */

 
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_hang',
        'width' => '100px',
        'value' => function($model) {
        return '<span title="'. ($model->hangDaoTao ? $model->hangDaoTao->ten_hang : 'N/A') .'">' . ($model->hangDaoTao ? $model->hangDaoTao->ma_hang : 'N/A') . '</span>';
        },
        'format'=>'html',
        'label' => 'H.Đào tạo',        
        /* 'pageSummary' => 'Tổng cộng (E=A-B-C+D)',
        'pageSummaryOptions' => ['class' => 'text-right text-end'], */
        //'contentOptions' => [ 'style' => 'text-align:center' ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_khoa_hoc',
        'label'=>'Khóa học',
        'value' => function($model) {
            return $model->khoaHoc ? $model->khoaHoc->ten_khoa_hoc : '';
        },
        'width' => '100px',
        'contentOptions' => [ 'style' => 'text-align:center' ],
    ],
    
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'trang_thai',
    // ],
     [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoi_gian_tao',
        'label'=>'Ngày đăng ký',
        'value'=>function($model){
            return CustomFunc::convertYMDHISToDMY($model->thoi_gian_tao);
        },
        'width' => '70px',
        'contentOptions' => [ 'style' => 'text-align:center'],
     ],
     [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoi_gian_hoan_thanh_ho_so',
        'label'=>'H.Thành HS',
        'value'=>function($model){
        return CustomFunc::convertYMDHISToDMY($model->thoi_gian_hoan_thanh_ho_so);
        },
        'width' => '70px',
        'contentOptions' => [ 'style' => 'text-align:center'],
     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'nguoi_tao',
         'value'=>function($model){
             return $model->nguoiTao->shortName;
         },
         'width' => '80px',
         'contentOptions' => [ 'style' => 'text-align:center'],
     ],
     /*[
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'thoi_gian_tao',
         'label'=>'Ngày đăng ký',
         'value'=>function($model){
            return CustomFunc::convertYMDHISToDMY($model->thoi_gian_tao);
         },
         'width' => '70px',
         'contentOptions' => [ 'style' => 'text-align:center'],
    ],*/
   
    
];   