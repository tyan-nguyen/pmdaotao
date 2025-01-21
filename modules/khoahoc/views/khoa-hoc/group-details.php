<?php
use yii\helpers\Html;

$this->title = 'Chi tiết nhóm: ' . $nhomHoc->ten_nhom;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách nhóm học', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="group-details">
    <h4>Danh sách Học viên</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên học viên</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Địa chỉ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($hocVienTrongNhom)): ?>
                <tr>
                    <td colspan="6" class="text-center">Không có học viên trong nhóm.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($hocVienTrongNhom as $index => $hocVien): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= Html::encode($hocVien->ho_ten) ?></td>
                        <td><?= Yii::$app->formatter->asDate($hocVien->ngay_sinh, 'php:d-m-Y') ?></td>
                        <td><?= Html::encode($hocVien->gioi_tinh === '1' ? 'Nam' : 'Nữ') ?></td>
                        <td><?= Html::encode($hocVien->dia_chi) ?></td>
                        <td>
                            <?= Html::a('<i class="fa fa-eye"></i>', ['hoc-vien/view', 'id' => $hocVien->id], ['title' => 'Xem chi tiết', 'class' => 'btn btn-primary btn-sm']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Bảng 2: Học viên chưa có nhóm -->
    <h4>Học viên chưa có nhóm</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên học viên</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Địa chỉ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($hocVienChuaCoNhom)): ?>
                <tr>
                    <td colspan="6" class="text-center">Không có học viên chưa có nhóm.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($hocVienChuaCoNhom as $index => $hocVien): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= Html::encode($hocVien->ho_ten) ?></td>
                        <td><?= Yii::$app->formatter->asDate($hocVien->ngay_sinh, 'php:d-m-Y') ?></td>
                        <td><?= Html::encode($hocVien->gioi_tinh === '1' ? 'Nam' : 'Nữ') ?></td>
                        <td><?= Html::encode($hocVien->dia_chi) ?></td>
                        <td>
                            <?= Html::a('<i class="fa fa-eye"></i>', ['hoc-vien/view', 'id' => $hocVien->id], ['title' => 'Xem chi tiết', 'class' => 'btn btn-primary btn-sm']) ?>
                            <?= Html::a('<i class="fa fa-plus"></i>', ['hoc-vien/assign', 'id' => $hocVien->id, 'id_nhom' => $nhomHoc->id], [
                                'title' => 'Thêm vào nhóm',
                                'class' => 'btn btn-success btn-sm',
                                'data-method' => 'post',
                                'data-confirm' => 'Bạn có chắc muốn thêm học viên này vào nhóm?',
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</div>
