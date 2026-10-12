<?php

use yii\bootstrap5\Html;
use app\custom\CustomFunc;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\Xe */

$giayTos = $model->getGiayTosMoiNhat();
$infoGiayTo = $model->getTrangThaiGiayToXe(true);

?>

<?php if (!empty($infoGiayTo['missing'])): ?>
    <div class="alert alert-warning py-2 px-3 mb-3 d-flex align-items-center justify-content-between">
        <div>
            <i class="fa fa-exclamation-triangle text-warning me-2"></i>
            <span><strong>Chưa đủ giấy tờ bắt buộc:</strong> <?= Html::encode(implode(', ', array_map(function ($loai) {
                                                                    return $loai->ten_loai_giay_to;
                                                                }, $infoGiayTo['missing']))) ?></span>
        </div>

    </div>
<?php endif; ?>

<?php if (empty($giayTos)): ?>
    <div class="alert alert-info d-flex align-items-center justify-content-between" role="alert">
        <div>
            <i class="fa fa-info-circle me-2"></i> Xe này hiện chưa có thông tin giấy tờ nào được cập nhật.
        </div>

    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle mb-0">
            <thead class="table-light text-center">
                <tr>
                    <th style="width: 50px;">STT</th>
                    <th>Loại giấy tờ</th>
                    <th style="width: 130px;">Ngày bắt đầu</th>
                    <th style="width: 130px;">Ngày hết hạn</th>
                    <th style="width: 150px;">Tình trạng hạn</th>
                    <th style="width: 120px;">Hiệu lực</th>
                    <th>Ghi chú</th>
                    <th style="width: 150px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($giayTos as $index => $gt): ?>
                    <tr>
                        <td class="text-center"><?= $index + 1 ?></td>
                        <td class="font-weight-bold">
                            <?= $gt->loaiGiayTo ? Html::encode($gt->loaiGiayTo->ten_loai_giay_to) : '<span class="text-muted">Chưa rõ</span>' ?>
                            <?= ($gt->loaiGiayTo && $gt->loaiGiayTo->la_bat_buoc == \app\modules\thuexe\models\base\LoaiGiayToBase::BAT_BUOC_CO) ? '<span class="badge bg-danger ms-1" style="font-size: 11px;">Bắt buộc</span>' : '' ?>
                        </td>
                        <td class="text-center">
                            <?= $gt->ngay_bat_dau ? CustomFunc::convertYMDToDMY($gt->ngay_bat_dau) : '-' ?>
                        </td>
                        <td class="text-center">
                            <?= $gt->ngay_ket_thuc ? CustomFunc::convertYMDToDMY($gt->ngay_ket_thuc) : '-' ?>
                        </td>
                        <td class="text-center">
                            <?= $gt->getTrangThaiHanLabel() ?>
                        </td>
                        <td class="text-center">
                            <?= $gt->getIsActiveLabel() ?>
                        </td>
                        <td>
                            <?= $gt->ghi_chu ? Html::encode($gt->ghi_chu) : '<span class="text-muted">-</span>' ?>
                        </td>
                        <td class="text-center">
                            <?= Html::a(
                                '<i class="fa fa-eye"></i>',
                                ['/thuexe/xe-giay-to/view', 'id' => $gt->id, 'modalType' => 'modal-remote-2'],
                                ['role' => 'modal-remote-2', 'class' => 'btn btn-sm btn-outline-info me-1', 'title' => 'Xem chi tiết']
                            ) ?>
                            <?= Html::a(
                                '<i class="fa fa-edit"></i>',
                                ['/thuexe/xe-giay-to/update', 'id' => $gt->id, 'modalType' => 'modal-remote-2'],
                                ['role' => 'modal-remote-2', 'class' => 'btn btn-sm btn-outline-primary me-1', 'title' => 'Sửa']
                            ) ?>
                            <?= Html::a(
                                '<i class="fa fa-trash"></i>',
                                ['/thuexe/xe-giay-to/delete', 'id' => $gt->id, 'modalType' => 'modal-remote-2'],
                                [
                                    'role' => 'modal-remote-2',
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'title' => 'Xóa',
                                    'data-confirm' => false,
                                    'data-method' => false,
                                    'data-request-method' => 'post',
                                    'data-confirm-title' => 'Xác nhận xóa?',
                                    'data-confirm-message' => 'Bạn có chắc chắn muốn xóa giấy tờ này?'
                                ]
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-2 d-flex justify-content-between align-items-center small text-muted">
        <span><i class="fa fa-info-circle"></i> Bảng chỉ hiển thị giấy tờ mới nhất cho từng loại giấy tờ.</span>
        <?= Html::a('<i class="fa fa-history"></i> Xem toàn bộ lịch sử giấy tờ', ['/thuexe/xe-giay-to/index', 'XeGiayToSearch[id_xe]' => $model->id], ['target' => '_blank', 'data-pjax' => '0', 'class' => 'text-primary']) ?>
    </div>
<?php endif; ?>

<script>
    if ($('#giay-to-count-badge').length) {
        $('#giay-to-count-badge').text('<?= count($giayTos) ?>');
    }
    if ($('#giay-to-wrap-count').length) {
        $('#giay-to-wrap-count').text('<?= count($giayTos) ?>');
    }
    if ($('#giay-to-status-badge').length) {
        $('#giay-to-status-badge').html(<?= json_encode($model->getTrangThaiGiayToBadge()) ?>);
    }
</script>