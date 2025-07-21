<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\custom\CustomFunc;
use app\modules\user\models\User;
use app\modules\hocvien\models\DangKyHv;
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],

        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{payment} {view}  {update} {danhSachDoiSatHach} {danhSachDoiHang} {danhSachBaoLuu} {huyHoSo} {doiHangTrongNgay} {doiHangNgayCu}  {doiSatHach}  {baoLuu} {delete} ',
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
            if ($action === 'huyHoSo') {
                return Url::to(['huy-ho-so', 'id' => $key]);
            }
            if ($action === 'doiHangTrongNgay') {
                return Url::to(['doi-hang-instant', 'id' => $key]);
            }
            if ($action === 'doiHangNgayCu') {
                return Url::to(['doi-hang-with-history', 'id' => $key]);
            }
            if ($action === 'danhSachDoiHang') {
                return Url::to(['view-thay-doi-hang', 'id' => $key]);
            }
            if ($action === 'doiSatHach') {
                return Url::to(['doi-sat-hach/create', 'idhv' => $key]);
            }
            if ($action === 'danhSachDoiSatHach') {
                return Url::to(['doi-sat-hach/view', 'idhv' => $key]);
            }
            if ($action === 'baoLuu') {
                return Url::to(['bao-luu/create', 'idhv' => $key]);
            }
            if ($action === 'danhSachBaoLuu') {
                return Url::to(['bao-luu/view', 'idhv' => $key]);
            }
            return Url::to([$action, 'id' => $key]);
        },
        'visibleButtons' => [
            /*'payment' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                // only show 'payment' if user chung co so
                return ($model->noi_dang_ky == $user->noi_dang_ky || $user->superadmin);
            },*/
            'huyHoSo' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                // only show 'payment' if user chung co so
                return ($model->noi_dang_ky == $user->noi_dang_ky || $user->superadmin);
            },
            'doiHangTrongNgay' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                // only show 'doiHangTrongNgay' if user chung co so
                return ($model->noi_dang_ky == $user->noi_dang_ky || $user->superadmin);
            },
            'doiHangNgayCu' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                // only show 'doiHangNgayCu' if user chung co so
                return ($model->noi_dang_ky == $user->noi_dang_ky || $user->superadmin);
            },
            'danhSachDoiHang' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                // only show 'doiHangNgayCu' if user chung co so
                return ($model->thayDoiHangs != null);
            },
            'doiSatHach' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                // only show 'doiHangNgayCu' if user chung co so
                return ($model->noi_dang_ky == $user->noi_dang_ky || $user->superadmin);
            },
            'danhSachDoiSatHach' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                // only show 'doiHangNgayCu' if user chung co so
                return ($model->doiNgaySatHachs != null);
            },
            'baoLuu' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                // only show 'doiHangNgayCu' if user chung co so
                return ($model->noi_dang_ky == $user->noi_dang_ky || $user->superadmin);
            },
            'danhSachBaoLuu' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                // only show 'doiHangNgayCu' if user chung co so
                return ($model->baoLuus != null);
            },
            'update' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                // only show 'update' if use created
                //return ($model->nguoi_tao == $user->id || $user->superadmin);
                return ($model->noi_dang_ky == $user->noi_dang_ky || $user->superadmin);//chung co so sua duoc
            },
            'delete' => function ($model, $key, $index) {
                $user = User::getCurrentUser();
                // Only show delete button if user is admin
                return $user->superadmin;
            },
        ],
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
            'class' => 'btn ripple btn-danger btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-success',
            'style'=>'color:red'
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
        'huyHoSo' => function ($url, $model, $key) {
            return Html::a('<i class="fas fa-times"></i> Hủy hồ sơ', $url, [
                'title' => 'Hủy hồ sơ',
                'role' => 'modal-remote',
                'class' => 'btn ripple btn-warning dropdown-item',
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
                'style'=>'color:orange'
            ]);
        },
        'doiHangTrongNgay' => function ($url, $model, $key) {
            return Html::a('<i class="fas fa-exchange-alt"></i> Đổi hạng (trong ngày)', $url, [
                'title' => 'Đổi hạng trong ngày',
                'role' => 'modal-remote',
                'class' => 'btn ripple btn-warning dropdown-item',
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
                'style'=>'color:orange'
            ]);
        },
        'doiHangNgayCu' => function ($url, $model, $key) {
            return Html::a('<i class="fas fa-tools"></i> Đổi hạng (ngày cũ)', $url, [
                'title' => 'Đổi hạng ngày cũ',
                'role' => 'modal-remote',
                'class' => 'btn ripple btn-danger dropdown-item',
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
                'style'=>'color:red'
            ]);
        },
        'danhSachDoiHang' => function ($url, $model, $key) {
            return Html::a('<i class="fas fa-list-ol"></i> Lịch sử đổi hạng', $url, [
                'title' => 'Lịch sử đổi hạng',
                'role' => 'modal-remote-2',
                'class' => 'btn ripple btn-primary dropdown-item',
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip'
            ]);
        },
        'doiSatHach' => function ($url, $model, $key) {
            return Html::a('<i class="fas fa-tools"></i> Dời sát hạch', $url, [
                'title' => 'Dời ngày sát hạch',
                'role' => 'modal-remote',
                'class' => 'btn ripple btn-danger dropdown-item',
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
                'style'=>'color:red'
            ]);
        },
        'danhSachDoiSatHach' => function ($url, $model, $key) {
            return Html::a('<i class="fas fa-list-ol"></i> Lịch sử dời ngày sát hạch', $url, [
                'title' => 'Lịch sử dời ngày sát hạch',
                'role' => 'modal-remote-2',
                'class' => 'btn ripple btn-primary dropdown-item',
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip'
            ]);
        },
        'baoLuu' => function ($url, $model, $key) {
            return Html::a('<i class="fas fa-tools"></i> Bảo lưu', $url, [
                'title' => 'Bảo lưu',
                'role' => 'modal-remote',
                'class' => 'btn ripple btn-danger dropdown-item',
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
                'style'=>'color:red'
            ]);
        },
        'danhSachBaoLuu' => function ($url, $model, $key) {
            return Html::a('<i class="fas fa-list-ol"></i> Lịch sử bảo lưu', $url, [
                'title' => 'Lịch sử bảo lưu',
                'role' => 'modal-remote-2',
                'class' => 'btn ripple btn-primary dropdown-item',
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip'
            ]);
        },
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
            return DangKyHv::getLabelNoiDangKyBadge($model->noi_dang_ky);
        },
        'format'=>'raw',
        'width' => '50px',
        'contentOptions' => [ 'style' => 'text-align:center' ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ho_ten',
        'width' => '150px',
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'dia_chi',
        'width' => '150px',
    ], */
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
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'khoaHoc.ten_khoa_hoc',
        'label'=>'Khóa học',
        'width' => '100px',
        'contentOptions' => [ 'style' => 'text-align:center' ],
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
        'label'=>'Đã TT(B)',
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
         'label'=>'C.Khấu(C)',
         'width' => '120px',
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
          'label'=>'Chi(D)',
          'width' => '50px',
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
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'nguoi_tao',
         'value'=>function($model){
             return $model->nguoiTao->username;
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
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoi_gian_hoan_thanh_ho_so',
        'label'=>'Hoàn thành HS',
        'value'=>function($model){
            return CustomFunc::convertYMDHISToDMY($model->thoi_gian_hoan_thanh_ho_so);
        },
        'width' => '70px',
        'contentOptions' => [ 'style' => 'text-align:center'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ghi_chu',
        'label'=>'Ghi chú',
        'width' => '70px'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'da_nhan_ao',
        'label'=>'Áo',
        'format'=>'html',
        'value'=>function($model){
            return $model->da_nhan_ao==1?'<i class="ion-checkmark-round text-primary"></i>':'';
        },
        'width' => '30px',
        'contentOptions' => [ 'style' => 'text-align:center'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'size',
        'label'=>'Size',
        'format'=>'html',
        'width' => '30px',
        'contentOptions' => [ 'style' => 'text-align:center'],
     ],
     /* [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'ngay_nhan_ao',
         'label'=>'Ngày nhận',
         'value'=>function($model){
            return CustomFunc::convertYMDToDMY($model->ngay_nhan_ao);
         },
         'format'=>'html',
         'width' => '60px',
         'contentOptions' => [ 'style' => 'text-align:center'],
     ], */
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'header'=>'HT hồ sơ',
        'value'=>function($model){
        return $model->ngayHoanThanhHoSo;
        },
        'width' => '100px',
    ], */
    
    
    
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