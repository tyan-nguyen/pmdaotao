<?php
use yii\helpers\Html;
use app\modules\hocvien\models\HocVien;
use app\modules\lichhoc\models\PhanThi;
use app\modules\lichhoc\models\KetQuaThi;

$idKH = $modelKH->id;
$dshocVien = HocVien::find()->where(['id_khoa_hoc' => $idKH])->all();

$dataRows = [];
foreach ($dshocVien as $index => $hocVien) {
    $idHV = $hocVien->id;
    $idHang = $hocVien->id_hang;

    $soLuongPhanThi = PhanThi::find()->where(['id_hang' => $idHang])->count();

    $dsKetQuaThi = KetQuaThi::find()->where(['id_hoc_vien' => $idHV])->all();

    if (empty($dsKetQuaThi)) {
        $trangThai = '<span class="badge bg-secondary"> Học viên chưa thi </span>';
    } else {

        $soLuongKetQuaDat = array_reduce($dsKetQuaThi, function ($carry, $item) {
            return $carry + ($item->ket_qua === 'ĐẠT' ? 1 : 0);
        }, 0);

        $trangThai = $soLuongKetQuaDat >= $soLuongPhanThi
            ? '<span class="badge bg-success"> Hoàn thành </span>'
            : '<span class="badge bg-warning"> Chưa hoàn thành </span>';
    }

    $dataRows[] = [
        'stt' => $index + 1,
        'ho_ten' => $hocVien->ho_ten,
        'trang_thai' => $trangThai,
        'chi_tiet' => Html::a('<i class="fa fa-window-maximize"></i>', 
            ['/khoahoc/khoa-hoc/add-nhom'], 
            [
                'class' => 'btn ripple btn-warning btn-sm',
                'title' => 'Chi tiết',
                'style' => 'color: white;',
                'role' => 'modal-remote-2',
            ]
        ),
    ];
}
?>

<table id="hocVienKQTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>STT</th>
            <th>Học viên</th>
            <th>Kết quả</th>
            <th>Chi tiết</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataRows as $row): ?>
            <tr>
                <td><?= $row['stt'] ?></td>
                <td><?= Html::encode($row['ho_ten']) ?></td>
                <td><?= $row['trang_thai'] ?></td>
                <td><?= $row['chi_tiet'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#hocVienTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json"
            }
        });
    });
    $(document).ready(function() {
        $('#hocVienKQTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json"
            }
        });
    });
</script>

