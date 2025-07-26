<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;


$congNos = $model->congNoKhachHang; 
?>

<div class="cong-no-khach-hang" id="congNoContent">
<div class="mb-3">
    <?= Html::a('<i class="fa fa-plus"></i> Thêm công nợ', 
        ['/khachhang/cong-no-khach-hang/create', 'idKH' => $model->id], 
        [
            'class' => 'btn fw-bold btn-warning',
            'style' => 'color: white;',
            'role' => 'modal-remote-2', 
            'title' => 'Thêm công nợ'
        ]
    ) ?>
</div>


<table class="table table-bordered table-hover table-striped">
    <thead class="table-light">
        <tr>
            <th style="width: 40px;">#</th>
            <th style="width: 100px;">Loại công nợ</th>
            <th style="width: 100px;">Số tiền</th>
            <th style="width: 100px;">Ghi chú</th>
            <th style="width: 100px;">Ngày phát sinh</th>
            <th style="width: 100px;">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($congNos)): ?>
            <?php foreach ($congNos as $index => $item): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= ucfirst($item->loai_cong_no) ?></td>
                    <td style="text-align: right;"><?= number_format($item->so_tien, 0, ',', '.') ?></td>
                    <td><?= StringHelper::truncateWords($item->ghi_chu, 15) ?></td>
                    <td><?= date('d/m/Y', strtotime($item->ngay_phat_sinh)) ?></td>
                    <td>
                        <?= Html::a('<i class="fa fa-edit"></i> Sửa', 
                           ['/khachhang/cong-no-khach-hang/update', 'id' => $item->id, 'idKH'=>$model->id], 
                               [
                                  'class' => 'btn fw-bold btn-warning',
                                  'style' => 'color: white;',
                                  'role' => 'modal-remote-2', 
                                  'title' => 'Sửa'
                               ]
                         ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center text-muted">Không có dữ liệu công nợ.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>

