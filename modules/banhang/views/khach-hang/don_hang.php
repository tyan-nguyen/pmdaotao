<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;



$congNos = $model->donHang; 
?>

<div class="cong-no-khach-hang" id="congNoContent">
<div class="mb-3">
    <?= Html::a('<i class="fa fa-plus"></i> Thêm đơn hàng', 
        ['/khachhang/don-hang-khach-hang/create', 'idKH' => $model->id], 
        [
            'class' => 'btn fw-bold btn-warning',
            'style' => 'color: white;',
            'role' => 'modal-remote-2', 
            'title' => 'Thêm đơn hàng'
        ]
    ) ?>
</div>


<table class="table table-bordered table-hover table-striped">
    <thead class="table-light">
        <tr>
            <th style="width: 40px;">#</th>
            <th style="width: 100px;">Số đơn hàng</th>
            <th style="width: 100px;">Ngày đặt hàng</th>
            <th style="width: 100px;">Tổng tiền</th>
            <th style="width: 100px;">Đã giao hàng</th>
            <th style="width: 100px;">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($congNos)): ?>
            <?php foreach ($congNos as $index => $item): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= ucfirst($item->so_don_hang) ?></td>
                    <td><?= date('d/m/Y', strtotime($item->ngay_dat_hang)) ?></td>
                    <td style="text-align: right;"><?php // number_format($item->tong_tien, 0, ',', '.') ?></td>
                    <td><?= ucfirst($item->da_giao_hang) ?></td>
                   
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

