<?php

use app\widgets\CardWidget;
?>

<?php
CardWidget::begin([
    'title' => 'Lịch sử mua hàng',
]);
?>

<table class="table table-bordered table-responsive" style="width:100%">
    <thead>
        <tr>
            <th>STT</th>
            <th>Loại thu</th>
            <th>Ngày đóng</th>
            <th>Số tiền</th>
            <th style="text-align: center;">Hình thức</th>
            <th>Người thu</th>
            <th>Ghi chú</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($model->muaHangs != null) {
            $stt = 0;
            foreach ($model->muaHangs as $muaHang) {
                $stt++;
        ?>
                <tr>
                    <td><?= $stt ?></td>
                    <td><?= $muaHang['type'] ?></td>
                    <td><?= $muaHang['thoi_gian'] ?></td>
                    <td><?= number_format($muaHang['so_tien']) ?></td>
                    <td style="text-align: center;"><?= $muaHang['hinh_thuc'] ?></td>
                    <td><?= $muaHang['nguoi_thu'] ?></td>
                    <td><?= $muaHang['ghi_chu'] ?></td>
                </tr>
            <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="7" class="text-center">Chưa có dữ liệu</td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<?php
CardWidget::end();
?>