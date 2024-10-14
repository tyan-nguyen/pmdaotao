<?php
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\modules\hocvien\models\HocVien;  // Import model HocVien
use yii\bootstrap5\Html;
use yii\widgets\Pjax;


?>
<table class="table">
    <tr>
    	<th>STT</th>
    	<th>Họ tên</th>
    	<th>Số CCCD</th>
    	<th></th>
    </tr>
<?php 
    $datas = HocVien::find()->where(['id_khoa_hoc' => $model->id])->all();
    foreach ($datas as $iHv=>$hv){
?>
    <tr>
        <td><?= $iHv+1 ?></td>
        <td><?= $hv->ho_ten ?></td>
        <td><?= $hv->so_cccd ?></td>
        <td>
        	<?= Html::a('<i class="fas fa-eye icon-white"></i>', 
        	    ['/hocvien/hoc-vien/view', 'id'=>$hv->id, 'modalType'=>'modal-remote-2'], 
                [
                    'class' => 'btn btn-sm btn-primary', 
                    'title' => 'Xem',
                    'role'=>'modal-remote-2'
                ]); ?>
                
            <?= Html::a('<i class="fas fa-pencil-alt icon-white"></i>', 
                ['/hocvien/hoc-vien/update-from-khoa-hoc', 'id'=>$hv->id, 'modalType'=>'modal-remote-2', 'idKhoaHoc'=>$model->id], 
                    [
                        'class' => 'btn btn-sm btn-warning', 
                        'title' => 'Sửa',
                        'role'=>'modal-remote-2'
                    ]); ?>
            <?= Html::a( '<i class="fa fa-remove"> </i>',
                                ['/khoahoc/khoahoc/update2', 
                                'id' => $hv->id
                                ],
                                [
                                    'class' => 'btn ripple btn-info btn-sm',
                                    'title' => 'Xóa học viên ',
                                    'style' => 'color: white;',
                                    'role'=>'modal-remote-2',
                                ]
                            ) ?>
        </td>
    </tr>
<?php } ?>
</table>

<div class="hoc-vien-index">

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