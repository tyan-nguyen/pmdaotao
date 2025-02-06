<?php
use app\modules\lichhoc\models\KetQuaThi;
use yii\helpers\Html;
use app\widgets\FileDisplayWidget;
use app\modules\lichhoc\models\LichThi;

$idHV = $model->id; 
$idKH = $model->id_khoa_hoc;
$lichThi = LichThi::find()->where(['id_khoa_hoc' => $idKH])->one();
$currentDateTime = new DateTime();
$ketquaThiIndexed = [];
foreach ($ketquaThi as $ketqua) {
    $ketquaThiIndexed[$ketqua->id_phan_thi] = $ketqua;
}

if (!empty($lichThi)) {
    $examDateTime = new DateTime($lichThi->thoi_gian_thi); 
    $isExamPassed = $currentDateTime > $examDateTime;
}
?>

<?php
$isAllPassed = true; 

foreach ($phanThis as $phanThi) {
    $ketqua = isset($ketquaThiIndexed[$phanThi->id]) ? $ketquaThiIndexed[$phanThi->id] : null;

    if (!$ketqua || $ketqua->ket_qua != 'ĐẠT') {
        $isAllPassed = false; 
        break;
    }
}

$overallResult = $isAllPassed ? 'Đủ điều kiện cấp giấy phép' : 'Chưa đủ điều kiện cấp giấy phép';
?>

<?php if (empty($idKH)): ?>
    <p style="text-align:center; color:red;" class="alert alert-primary" role="alert">Học viên chưa được sắp khóa học.</p>
<?php elseif (empty($lichThi)): ?>
    <p style="text-align:center; color:red;" class="alert alert-primary" role="alert">Khóa học chưa có lịch thi.</p>
<?php elseif (!empty($lichThi) && empty($ketquaThi)): ?>
    <p style="text-align:center; color:red;" class="alert alert-primary" role="alert">Khóa học chưa có kết quả thi.</p>
    
    <?php if (isset($isExamPassed) && $isExamPassed): ?>
        <?= Html::a('<i class="fa fa-cog"> </i>', 
            ['/hocvien/hoc-vien/insert-ket-qua-thi','idHV'=>$idHV],
            [
                'class' => 'btn ripple btn-success btn-sm',
                'title' => 'Cài đặt Kết quả thi',
                'style' => 'color: white;',
                'role' => 'modal-remote-2',
            ]
        ) ?>
    <?php endif; ?>
<?php else: ?>
    <table class="table table-bordered text-center" style="border: 4px solid skyblue;">
    <thead>
        <tr style="border: 4px solid skyblue;">
            <th style="border: 4px solid skyblue;">PHẦN THI</th>
            <th style="border: 4px solid skyblue;">LẦN THI </th>
            <th style="border: 4px solid skyblue;">ĐIỂM SỐ</th>
            <th style="border: 4px solid skyblue;">KẾT QUẢ</th>
            <tfoot>
                <tr id="statusRow">
                    <td colspan="4" style="text-align: center; font-weight: bold; color: <?= $isAllPassed ? 'green' : 'red' ?>;">
                            <?= $overallResult ?>
                    </td>
                   
                </tr>
            </tfoot>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($phanThis as $phanThi): ?>
            <?php
        
            $ketqua = isset($ketquaThiIndexed[$phanThi->id]) ? $ketquaThiIndexed[$phanThi->id] : null;
            ?>
            <tr>
                <td style="border: 4px solid skyblue;"><?= Html::encode($phanThi->ten_phan_thi) ?></td>
                <td style="border: 4px solid skyblue; font-weight: bold; color: blue;">
                    <?= $ketqua ? Html::encode($ketqua->lan_thi) : '<span style="color:red;">X</span>' ?>
                </td>
                <td style="border: 4px solid skyblue; font-weight: bold; color: blue;">
                    <?= $ketqua ? Html::encode($ketqua->diem_so) : '<span style="color:red;">X</span>' ?>
                </td>
                <td style="border: 4px solid skyblue; font-weight: bold; color: <?= $ketqua && $ketqua->ket_qua == 'ĐẠT' ? 'green' : ($ketqua && $ketqua->ket_qua == 'RỚT' ? 'red' : 'gray') ?>;">
                     <?= $ketqua ? Html::encode($ketqua->ket_qua) : '<span style="color:red;">X</span>' ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php if ($isAllPassed): ?>
    <div class="tab-pane fade show active p-1" id="tabFile" role="tabpanel" aria-labelledby="list-tab">
        <?= FileDisplayWidget::widget([
            'type' => 'LOAIHOSO',
            'doiTuong' => KetQuaThi::MODEL_ID,
            'idDoiTuong' => $model->id,
        ]) ?>
    </div>
<?php endif; ?>