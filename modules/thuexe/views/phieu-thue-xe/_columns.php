<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\modules\hocvien\models\HocVien;
use app\modules\thuexe\models\Xe;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
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
        'attribute' => 'id_hoc_vien', 
        'value' => function($model) {
            $hocVien = HocVien::findOne($model->id_hoc_vien);
            return $hocVien ? $hocVien->ho_ten : '<span style="color: red;">Trống </span>'; 
        },
        'format' => 'raw', 
    ],
    
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ho_ten_nguoi_thue',
        'value' => function($model) {
            return empty($model->ho_ten_nguoi_thue) ? '<span style="color: red;">Trống </span>' : $model->ho_ten_nguoi_thue;
           
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
   
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => ' {return} {payment} {sent} {approve}  {view} {update}  ',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '300px',
    
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
                 return Url::to(['nop-phi-thue-xe', 'id' => $key]);     
             }

            return Url::to([$action, 'id' => $key]);
       },
        'buttons' => [
          
            'sent' => function($url, $model, $key) {
                return Html::a('<i class="fa fa-mail-forward"></i>', $url, [
                    'title' => 'Gửi phiếu',
                    'role' => 'modal-remote-2',
                    'class' => 'btn ripple btn-warning btn-sm',
                    'style' => 'width: 30px; text-align: center;',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip-warning',
                ]);
                
            },
            'approve' => function($url, $model, $key) {
                return Html::a('<i class="fa fa-check"></i>', $url, [
                    'title' => 'Kiểm duyệt phiếu',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-success btn-sm',
                    'style' => 'width: 30px; text-align: center;',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip-success',
                ]);
            },
            'return' => function($url, $model, $key) {
                    return Html::a('<i class="fa fa-undo"></i>', $url, [
                        'title' => 'Thông tin trả xe',
                        'role' => 'modal-remote',
                        'class' => 'btn ripple btn-secondary btn-sm',
                        'style' => 'width: 30px; text-align: center;',
                        'data-bs-placement' => 'top',
                        'data-bs-toggle' => 'tooltip-secondary',
                    ]);
                
            },
            'payment' => function($url, $model, $key) {
                return Html::a('<i class="fa fa-dollar"></i>', $url, [
                    'title' => 'Phí thuê',
                    'role' => 'modal-remote-2',
                    'class' => 'btn ripple btn-danger btn-sm',
                    'style' => 'width: 30px; text-align: center;',
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

];   