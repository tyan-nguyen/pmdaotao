<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\modules\hocvien\models\HocVien;
use app\modules\thuexe\models\Xe;
use app\modules\thuexe\models\NopPhiThueXe;
use app\modules\thuexe\models\PhieuThueXe;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{return} {payment} {sent} {approve}  {view} {update} ',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) { 
            if ($action === 'sent') {
                 if ($model->id_nguoi_gui === null) {
                  return Url::to(['sent', 'id' => $key]); 
                     } else {
                         return Url::to(['mess', 'id' => $key]);
                       }
              }
            if ($action === 'approve') {
                if ($model->id_nguoi_duyet === null) {
                 return Url::to(['approve', 'id' => $key]); 
                    } else {
                        return Url::to(['mess-kdp', 'id' => $key]); 
                      }
             }
             if ($action === 'return') {
                if (($model->id_nhan_vien_ky_tra === null) && ($model->trang_thai ==='Đã duyệt')  ){
                 return Url::to(['tra-xe', 'id' => $key]); 
                    } else if(($model->id_nhan_vien_ky_tra === null) && ($model->trang_thai !='Đã duyệt') ){
                        return Url::to(['mess-sc', 'id' => $key]); 
                      }else
                      {
                        return Url::to(['mess-duyet-sc', 'id' => $key]); 
                      }
             }
             if ($action === 'payment') {
                // Tìm tất cả các bản ghi trong bảng NopPhiThueXe có `id_phieu_thue_xe` bằng với `$key`
                $nopPhiRecords = NopPhiThueXe::findAll(['id_phieu_thue_xe' => $key]);
                 // Lấy bản ghi PhieuThueXe hiện tại dựa trên `$key`
                $phieuThueXe = PhieuThueXe::findOne($key);
                // Trường hợp không tìm thấy bản ghi nào
               if (empty($nopPhiRecords)&& ($phieuThueXe ->trang_thai === 'Đã duyệt')) {
                   return Url::to(['nop-phi-thue-xe', 'id' => $key]);
                }
                if($phieuThueXe-> trang_thai === 'Đả trả')
                      if ($phieuThueXe->trang_thai != 'Đã duyệt')
                {
                    return Url::to(['thong-bao-chua-duyet', 'id' => $key]);
                }
                if(($phieuThueXe->trang_thai === 'Không duyệt') || ($phieuThueXe->trang_thai === 'Đã nhập') || ($phieuThueXe->trang_thai === 'Không gửi') )
                {
                    return Url::to(['thong-bao-chua-duyet', 'id' => $key]); 
                }
                // Nếu tìm thấy bản ghi trong bảng NopPhiThueXe
                $tongtien = 0;
                // Tính tổng số tiền đã nộp trước
                foreach ($nopPhiRecords as $record) {
                       $tongtien += $record->so_tien_nop;
                }
                $tongtienPhatSinh = 0;
                // tính tổng tiền phí phát sinh đã nộp 
               
                foreach ($nopPhiRecords as $record)
                {
                  if ($record->trang_thai === "Phí phát sinh") 
                    {
                         $tongtienPhatSinh += $record->so_tien_nop;
                    }
                }
                
                foreach ($nopPhiRecords as $record) {
                    // Trường hợp 1: `trang_thai` là "Phí thuê xe" và `chi_phi_thue_phat_sinh` của `phieuThueXe` là null
                  
                    if ($record->trang_thai === "Phí thuê xe" && $phieuThueXe->chi_phi_thue_phat_sinh === null) {
                        if($tongtien < $phieuThueXe->chi_phi_thue_du_kien)
                        {
                            return Url::to(['nop-phi-thue-xe', 'id' => $key]);
                        }
                        else 
                        {
                            return Url::to(['xem-thong-tin-phi-thue', 'id' => $key]);
                        }
                    }
                    
                    // Trường hợp 2: `trang_thai` là "Phí thuê xe" và `chi_phi_thue_phat_sinh` của `phieuThueXe` là 0
                    if ($record->trang_thai === "Phí thuê xe" && $phieuThueXe->chi_phi_thue_phat_sinh == 0) {
                        if($tongtien < $phieuThueXe->chi_phi_thue_du_kien)
                        {
                            return Url::to(['nop-phi-thue-xe', 'id' => $key]);
                        }
                        else 
                        {
                            return Url::to(['xem-thong-tin-phi-thue', 'id' => $key]);
                        }
                    }
            
                    // Trường hợp 3: `trang_thai` là "Phí phát sinh"
                    if ($record->trang_thai === "Phí phát sinh") {
                        if($tongtienPhatSinh < $phieuThueXe->chi_phi_thue_phat_sinh)
                        {
                            return Url::to(['nop-phi-thue-xe', 'id' => $key]);
                        }
                        else 
                        {
                            return Url::to(['xem-thong-tin-phi-thue', 'id' => $key]);
                        }
                    }
                    
                }
                // Mặc định trả về URL của `nop-phi-thue-xe` nếu không thỏa mãn các điều kiện trên
                return Url::to(['nop-phi-thue-xe', 'id' => $key]);//Xem lại chỗ này 
            }
            return Url::to([$action, 'id' => $key]);
       },
        'buttons' => [
          
            'sent' => function($url, $model, $key) {
                return Html::a('<i class="fa fa-share"></i> Gửi phiếu', $url, [
                    'title' => 'Gửi phiếu',
                    'role' => 'modal-remote-2',
                    'class' => 'btn ripple btn-info dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip-warning',
                ]);
                
            },
            'approve' => function($url, $model, $key) {
                return Html::a('<i class="fa fa-check"></i> Kiểm duyệt phiếu', $url, [
                    'title' => 'Kiểm duyệt phiếu',
                    'role' => 'modal-remote',
    
                    'class' => 'btn ripple btn-info dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip-success',
                ]);
            },
            'return' => function($url, $model, $key) {
                    return Html::a('<i class="fa fa-undo"></i> Thông tin trả xe', $url, [
                        'title' => 'Thông tin trả xe',
                        'role' => 'modal-remote',
                        'class' => 'btn ripple btn-info dropdown-item',
                        'data-bs-placement' => 'top',
                        'data-bs-toggle' => 'tooltip-secondary',
                    ]);
                
            },
            'payment' => function($url, $model, $key) {
                return Html::a('<i class="fa fa-strikethrough"></i> Phí thuê', $url, [
                    'title' => 'Phí thuê',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-info dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip-danger',
                ]);
            
        },
        
        ],

        'viewOptions'=>['role'=>'modal-remote','title'=>'View','title'=>'Xem phiếu',
             'class'=>'btn ripple btn-primary btn-sm',
             'data-bs-placement'=>'top',
             'data-bs-toggle'=>'tooltip-primary'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Cập nhật phiếu', 
             'class'=>'btn ripple btn-info btn-sm',
             'data-bs-placement'=>'top',
             'data-bs-toggle'=>'tooltip-info'],   
        
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'trang_thai',
        'label' => 'Trạng thái',
        'value' => function ($model) {
            switch ($model->trang_thai) {
                case 'Đã nhập':
                    return '<span class="badge" style="background-color: pink; color: white;">Đã nhập</span>';
                case 'Đã gửi':
                    return '<span class="badge" style="background-color: green; color: white;">Đã gửi</span>';
                case 'Đã duyệt':
                    return '<span class="badge" style="background-color: skyblue; color: white;">Đã duyệt</span>';
                case 'Không duyệt':
                    return '<span class="badge" style="background-color: red; color: white;">Không duyệt</span>';
                case 'Đã trả':
                    return '<span class="badge" style="background-color: yellow; color: white;">Đã trả</span>';
                default:
                    return '<span class="badge bg-secondary">Không xác định</span>';
            }
        },
        'format' => 'raw', // Định dạng raw để hiển thị HTML
        'width' => '150px', // Đặt chiều rộng cho cột
    ],
    
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
   // [
       // 'class'=>'\kartik\grid\DataColumn',
       // 'attribute'=>'ngay_thue_xe',
       // 'width' => '150px',
        //'value'=>function($model){
         //   return $model->ngayThueXe;
       // }
    //],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'NGƯỜI THUÊ',
        'value' => function($model) {
            if (!empty($model->id_hoc_vien)) {
                $hocVien = HocVien::findOne($model->id_hoc_vien);
                return $hocVien ? $hocVien->ho_ten : '<span style="color: red;">Trống</span>'; 
            }
            return !empty($model->ho_ten_nguoi_thue) ? $model->ho_ten_nguoi_thue : '<span style="color: red;">Trống</span>';
        },
        'format' => 'raw',
    ],  
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'ĐỐI TƯỢNG',
        'value' => function($model) {
            if (empty($model->id_hoc_vien)) {
                return '<span style="color: blue;">Khác</span>';
            } else {
                return '<span style="color: green;">Học viên</span>';
            }
        },
        'format' => 'raw', 
    ],
    
    
    
    [
        'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'id_xe',
       'value' => function($model) {
            $xe = Xe::findOne($model->id_xe);
            return $xe ? $xe->hieu_xe : '<span style="color: red;">Trống </span>'; 
        },
    ],
  
    //[
      //   'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'thoi_gian_bat_dau_thue',
     //],
   


];   