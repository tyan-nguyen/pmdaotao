<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\modules\hocvien\models\NopHocPhi;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\HocPhi;
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
        'width' => '150px',
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
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'dia_chi',
        'width' => '200px',
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
        'width' => '200px',
        'value' => function($model) {
            return $model->hangDaoTao ? $model->hangDaoTao->ten_hang : 'N/A';
        },
        'label' => 'Hạng đào tạo',
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'check_hoc_phi',
        'label' => 'Trạng thái học phí',
        'value' => function($model) {
            // Tìm học viên hiện tại
            $hocVien = HocVien::findOne($model->id);
            // Tìm học phí của hạng đào tạo
            $hocPhiHang = HocPhi::findOne(['id_hang' => $hocVien->id_hang]);
    
            // Kiểm tra xem học phí có tồn tại không
            if ($hocPhiHang) {
                // Tìm thông tin các lần nộp học phí của học viên
                $hocPhi = NopHocPhi::find()->where(['id_hoc_vien' => $hocVien->id])->all();
    
                // Tính tổng số tiền đã nộp
                $tongTienDaNop = 0;
                foreach ($hocPhi as $hcPhi) {
                    $tongTienDaNop += $hcPhi->so_tien_nop;
                }
    
         // Kiểm tra trạng thái nộp học phí
         if ($tongTienDaNop >= $hocPhiHang->hoc_phi) {
            $hocVien->check_hoc_phi = 'Nộp đủ';  // Cập nhật giá trị trường check_hoc_phi vào CSDL
            $hocVien->save();  
            return '<span class="badge bg-primary">Nộp đủ</span>';
        } elseif ($tongTienDaNop > 0) {
            $hocVien->check_hoc_phi = 'Còn nợ học phí';  // Cập nhật giá trị t rường check_hoc_phi vào CSDL
            $hocVien->save();  
            return '<span class="badge bg-warning">Còn nợ học phí</span>';
        } else {
            $hocVien->check_hoc_phi = 'Chưa đóng học phí';  // Cập nhật giá trị trường check_hoc_phi vào CSDL
            $hocVien->save();  
            return '<span class="badge bg-danger">Chưa đóng học phí</span>';
        }
    } else {
        return 'Không có học phí';
    }
},
        'width' => '150px',
        'format' => 'raw', 
    ],
    
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{payment} {view} {update} {delete} ',
        'dropdown' => false,
        'vAlign' => 'middle',
        'width' => '200px',
   'urlCreator' => function($action, $model, $key, $index) {
    if ($action === 'payment') {
        // Lấy thông tin học phí của học viên
        $hocPhiHang = HocPhi::findOne(['id_hang' => $model->id_hang]);
        
        // Lấy thông tin các lần nộp học phí của học viên
        $nopHP = NopHocPhi::find()->where(['id_hoc_vien' => $model->id])->all();
        
        // Tính tổng số tiền đã nộp
        $tongTienDaNop = 0;
        foreach ($nopHP as $hcPhi) {
            $tongTienDaNop += $hcPhi->so_tien_nop;
        }

        // Kiểm tra trạng thái học phí
        if ($hocPhiHang && $tongTienDaNop >= $hocPhiHang->hoc_phi) {
            // Nếu học viên đã đóng đủ học phí
            return Url::to(['mess', 'id' => $key]); //Ngừng cho nhập học phí và chuyển đến actionMess để thông báo đã nộp đủ
        } else {
            // Nếu học viên chưa đóng hoặc đóng thiếu học phí
            return Url::to(['create2', 'id' => $key]);  // Tiếp tục cho nhập học phí
        }
    }
    return Url::to([$action, 'id' => $key]);
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
            'role' => 'modal-remote',
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