<?php
use yii\helpers\Url;
use app\modules\khoahoc\models\HangDaoTao;
use app\modules\giaovien\models\Day;
$this->registerCssFile('https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js', ['depends' => [\yii\web\YiiAsset::class]]);
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{view} {update} {delete}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) {
        return Url::to([$action,'id'=>$key]);
        },
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
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ho_ten',
        'width' => '200px',
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'gioi_tinh',
        'width' => '50px',
         'value'=> function ($model)
         {
            return $model->gioi_tinh == 1 ? 'Nam' : 'Nữ' ;
         },
        'filter'=> [1 => 'Nam', 0 => 'Nữ'],
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_phong_ban',
        'width' => '200px',
        'value' => function ($model) {
            return $model->phongBan 
                ? '<b>' . $model->phongBan->ten_phong_ban . '</b>' 
                : '<span class="badge bg-warning"> Trống </span>';
        },
        'format' => 'raw', 
    ],
    
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_giao_vien',
        'label' => 'Hạng dạy',
        'width' => '150px',
        'value' => function ($model) {
            $hangs = Day::find()
                ->where(['id_nhan_vien' => $model->id])  
                ->all();
    
            if ($hangs) {
                $hangNames = [];
                foreach ($hangs as $hang) {
                    $hangName = HangDaoTao::findOne($hang->id_hang_xe)->ten_hang;
                    if ($hangName) {
                        $hangNames[] = $hangName;
                    }
                }
                return '<strong>' . implode(',<br/> ', $hangNames) . '</strong>'; 
            } else {
                return '<span class="badge bg-warning">Chưa phân công</span>';  
            }
        },
        'format' => 'raw', 
        'width' => '200px', 
    ],
    
    
     [
        'attribute' => 'trang_thai',
        'format' => 'html',
        'width' => '100px',
        'value' => function ($model) {
            if ($model->trang_thai === 'Đang làm việc') {
                return '<span class="badge bg-success">Đang làm việc</span>';
            } elseif ($model->trang_thai === 'Đã nghỉ việc') {
                return '<span class="badge bg-danger">Đã nghỉ việc</span>';
            } elseif ($model->trang_thai === 'Tạm nghỉ') {
                return '<span class="badge bg-primary">Tạm nghỉ</span>';
            }
            return '<span class="badge bg-secondary">Không xác định</span>';
        },
    ],
];   
?>

