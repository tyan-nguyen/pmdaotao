<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\modules\hocvien\models\NopHocPhi;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\HocPhi;
use app\modules\hocvien\models\KhoaHoc;
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
        'template' => '{payment} {view} {update} {delete} ',
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
                // Lấy thông tin khóa học của học viên
                $khoaHoc = KhoaHoc::findOne($model->id_khoa_hoc);
        
                // Nếu không có thông tin khóa học, trả về URL mặc định
                if (!$khoaHoc) {
                    return Url::to(['mess2', 'id' => $key]); 
                }
        
                // Lấy học phí dựa trên id_hoc_phi của khóa học
                $hocPhiHang = HocPhi::findOne($khoaHoc->id_hoc_phi);
        
                // Nếu không có thông tin học phí, trả về URL mặc định
                if (!$hocPhiHang) {
                    return Url::to([$action, 'id' => $key]);
                }
        
                // Lấy thông tin các lần nộp học phí của học viên
                $nopHP = NopHocPhi::find()->where(['id_hoc_vien' => $model->id])->all();
        
                // Tính tổng số tiền đã nộp
                $tongTienDaNop = 0;
                foreach ($nopHP as $hcPhi) {
                    $tongTienDaNop += $hcPhi->so_tien_nop;
                }
            
                // Kiểm tra trạng thái học phí
                if ($tongTienDaNop >= $hocPhiHang->hoc_phi) {
                    // Học viên đã đóng đủ học phí
                    return Url::to(['mess', 'id' => $key]); // Chuyển đến actionMess để thông báo đã nộp đủ
                } else if($tongTienDaNop < $hocPhiHang->hoc_phi){
                    // Học viên chưa đóng hoặc đóng thiếu học phí
                    return Url::to(['create2', 'id' => $key]); // Tiếp tục cho nhập học phí
                }
            }
            return Url::to([$action, 'id' => $key]); // Trả về URL mặc định cho các hành động khác
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
                'class' => 'btn ripple btn-warning dropdown-item', // Thêm dropdown-item để đồng bộ
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
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
        'attribute'=>'ho_ten',
        'width' => '200px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'gioi_tinh',
        'width' => '150px',
        'value' => function ($model) {
            return $model->gioi_tinh == 1 ? 'Nam' : 'Nữ';
        },
        'filter' => [
            1 => 'Nam',
            0 => 'Nữ',
        ], 
        'headerOptions' => ['style' => 'text-align: center;'],
        'contentOptions' => ['style' => 'text-align: center;'],
    ],
    
   // [
       // 'class'=>'\kartik\grid\DataColumn',
      //  'attribute'=>'so_dien_thoai',
    //],
    //[
     //   'class'=>'\kartik\grid\DataColumn',
      //  'attribute'=>'so_cccd',
      //  'width' => '50px',
    //],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_khoa_hoc',
        'value' => function ($model) {
            $khoaHoc = KhoaHoc::findOne($model->id_khoa_hoc);
            return $khoaHoc 
                ? '<strong>' . $khoaHoc->ten_khoa_hoc . '</strong>' 
                : '<span class="badge bg-warning"> Chưa sắp khóa học </span>'; 
        },
        'format' => 'raw', 
    ],

     [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'trang_thai',
        'width' => '150px',
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
        'attribute' => 'check_hoc_phi',
        'label' => 'Học phí',
        'value' => function($model) {
            // Tìm học viên hiện tại
            $hocVien = HocVien::findOne($model->id);
            
            // Tìm thông tin khóa học của học viên
            $khoaHoc = $hocVien ? KhoaHoc::findOne($hocVien->id_khoa_hoc) : null;
    
            // Tìm học phí dựa trên id_hoc_phi của khóa học
            $hocPhiKhoaHoc = $khoaHoc ? HocPhi::findOne($khoaHoc->id_hoc_phi) : null;
    
            // Kiểm tra xem học phí có tồn tại không
            if ($hocPhiKhoaHoc) {
                // Tìm thông tin các lần nộp học phí của học viên
                $hocPhi = NopHocPhi::find()->where(['id_hoc_vien' => $hocVien->id])->all();
    
                // Tính tổng số tiền đã nộp
                $tongTienDaNop = 0;
                foreach ($hocPhi as $nopPhi) {
                    $tongTienDaNop += $nopPhi->so_tien_nop;
                }
    
                // Kiểm tra trạng thái nộp học phí
                if ($tongTienDaNop >= $hocPhiKhoaHoc->hoc_phi) {
                    $hocVien->check_hoc_phi = 'Nộp đủ';  // Cập nhật giá trị trường check_hoc_phi vào CSDL
                    $hocVien->save();  
                    return '<span class="badge bg-primary">Nộp đủ</span>';
                } elseif ($tongTienDaNop > 0) {
                    $hocVien->check_hoc_phi = 'Còn nợ học phí';  // Cập nhật giá trị trường check_hoc_phi vào CSDL
                    $hocVien->save();  
                    return '<span class="badge bg-warning">Còn nợ học phí</span>';
                } else {
                    $hocVien->check_hoc_phi = 'Chưa đóng học phí';  // Cập nhật giá trị trường check_hoc_phi vào CSDL
                    $hocVien->save();  
                    return '<span class="badge bg-danger">Chưa đóng học phí</span>';
                }
            } else {
                return '<span class="badge bg-success"> Vui lòng sắp khóa học </span>';
            }
        },
        'width' => '150px',
        'format' => 'raw', 
    ],
    
    

    

];   