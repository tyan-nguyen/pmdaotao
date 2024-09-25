<?php
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\modules\hocvien\models\HocVien;  // Import model HocVien
use yii\bootstrap5\Html;
use yii\widgets\Pjax;
// Lấy danh sách học viên dựa trên id_khoa_hoc của khóa học hiện tại
$dataProvider = new ActiveDataProvider([
    'query' => HocVien::find()->where(['id_khoa_hoc' => $model->id]), // $model là đối tượng KhoaHoc
    'pagination' => [
        'pageSize' => 5,  // Số lượng học viên hiển thị trên mỗi trang
    ],
]);

?>

<div class="hoc-vien-index">
<?php Pjax::begin([
        'id' => 'hoc-vien-grid',
        'enablePushState' => false,  // Tắt thay đổi URL khi phân trang
        'enableReplaceState' => false,  // Không thay đổi URL khi phân trang
    ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // Số thứ tự

          
            'ho_ten', 
            [
                'attribute' => 'ngay_sinh',
                'label' => 'Ngày sinh',
                'value' => function($model) {
                    return $model->getNgaySinh();
                },
            ],
            
            [
                'attribute' => 'gioi_tinh',
                'label' => 'Giới tính',
                'value' => function ($model) {
                    return $model->gioi_tinh == 1 ? 'Nam' : 'Nữ';
                },
            ],
            
        
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-eye icon-white"></i>', $url, ['class' => 'btn btn-sm btn-primary', 'title' => 'Xem']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-pencil-alt icon-white"></i>', $url, ['class' => 'btn btn-sm btn-warning', 'title' => 'Sửa']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-trash icon-white"></i>', $url, [
                            'class' => 'btn btn-sm btn-danger',
                            'title' => 'Xóa',
                            'data-confirm' => 'Bạn có chắc muốn xóa mục này không?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ]
            
            
        ],
    ]); ?>
     <?php Pjax::end(); ?> 
</div>
<style>
    .icon-white {
    color: white;
}
.pagination {
    display:flex;
    justify-content: center;
    padding:10px;
}

.pagination li a {
    color: #007bff; /* Màu văn bản cho các nút */
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.pagination li a:hover {
    background-color: #007bff; /* Màu nền khi di chuột */
    color: #fff; /* Màu văn bản khi di chuột */
}

.pagination .active a {
    background-color: #007bff; /* Màu nền cho nút đang được chọn */
    color: white;
    border-color: #007bff;
}

.pagination .disabled a {
    color: #aaa;
}
</style>