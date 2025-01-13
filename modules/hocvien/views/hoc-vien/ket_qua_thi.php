<?php
use app\modules\lichhoc\models\LichThi;
use app\modules\lichhoc\models\KetQuaThi;
use app\modules\lichhoc\models\PhanThi;
use yii\helpers\Html;

$idHV = $model->id; 
$idKH = $model->id_khoa_hoc;
$lichThi = LichThi::find()->where(['id_khoa_hoc' => $idKH])->one();
$phanThis = PhanThi :: find()->where(['id_hang'=>$model->id_hang])->all();
$ketquaThi = KetQuaThi::find()->where(['id_hoc_vien' => $idHV])->all();
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
            <th style="border: 4px solid skyblue;">ĐIỂM SỐ</th>
            <th style="border: 4px solid skyblue;">KẾT QUẢ</th>
            <tfoot>
                 <tr id="statusRow">
                     <td colspan="3" style="text-align: center; font-weight: bold;">Kết quả:</td>
                     <?= Html::a('<i class="fa fa-cog"> </i>', 
                       ['/hocvien/hoc-vien/insert-ket-qua-thi','idHV'=>$idHV],
                             [
                                'class' => 'btn ripple btn-success btn-sm',
                                'title' => 'Cài đặt Kết quả thi',
                                'style' => 'color: white;',
                                'role' => 'modal-remote-2',
                             ]
                     ) ?>
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
                    <?= $ketqua ? Html::encode($ketqua->diem_so) : '<span style="color:red;">X</span>' ?>
                </td>
                <td style="border: 4px solid skyblue; font-weight: bold; color: <?= $ketqua && $ketqua->ket_qua == 'ĐẠT' ? 'green' : 'red' ?>;">
                    <?= $ketqua ? Html::encode($ketqua->ket_qua) : '<span style="color:red;">X</span>' ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<?php endif; ?>
