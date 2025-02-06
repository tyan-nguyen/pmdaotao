<?php
use yii\helpers\Html;

$this->title = 'Danh sách phần thi của hạng';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="ptContent" class="phan-thi-index">
    <?php if (empty($phanThi)): ?>
        <div class="alert alert-warning">
            Hạng đào tạo chưa được cài đặt phần thi.
        </div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên phần thi</th>
                    <th>Thứ tự thi</th>
                    <th>Điểm đạt tối thiểu</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($phanThi as $index => $pt): ?>
                    <tr>
                        <td>
                            <?= $index + 1 ?>
                            <?php if ($index === count($phanThi) - 1): ?>
                               
                            <?php endif; ?>
                        </td>
                        <td><?= $pt->ten_phan_thi ?></td>
                        <th><?= $pt->thu_tu_thi ?></th>
                        <td><?= $pt->diem_dat_toi_thieu ?></td>
                        <td><?= $pt->trang_thai ?></td>
                        <td>
                            <?= Html::a('<i class="fa fa-pencil"></i>', 
                                        ['/khoahoc/hang-dao-tao/update-list-phan-thi', 'id' => $pt->id],
                                        [
                                            'class' => 'btn ripple btn-success btn-sm',
                                            'title' => 'Cập nhật',
                                            'style' => 'color: white;',
                                            'role' => 'modal-remote-2',
                                        ]
                            ) ?>
                            <?= Html::a('<i class="fa fa-trash"></i>',
                                 ['/khoahoc/hangdaotao/delete-phan-thi','id'=> $pt->id],
                                 [
                                      'class'=>'btn ripple btn-warning btn-sm',
                                      'title'=>'Xóa phần thi',
                                      'style'=>'color:while;',
                                      'role'=>'modal-remote-2',
                                 ]
                            )?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>