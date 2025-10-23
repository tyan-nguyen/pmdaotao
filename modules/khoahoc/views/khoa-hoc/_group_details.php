<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
?>

<div class="group-details">
    <h5 style="color:blue; text-align:center;">DANH SÁCH HỌC VIÊN</h5>
    <table class="table table-bordered table-striped" id="nhomHVTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên học viên</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Địa chỉ</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($hocVienTrongNhom)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Chưa có học viên nào trong nhóm.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($hocVienTrongNhom as $index => $hocVien): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= Html::encode($hocVien->ho_ten) ?></td>
                        <td><?= Yii::$app->formatter->asDate($hocVien->ngay_sinh, 'php:d-m-Y') ?></td>
                        <td><?= Html::encode($hocVien->gioi_tinh === '1' ? 'Nam' : 'Nữ') ?></td>
                        <td><?= Html::encode($hocVien->diaChi) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <div style="text-align: right; margin-top: 20px;">
       <button style="background-color:rgb(55, 11, 211); color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
         <span><i class="fa fa-group"></i> :<?= $totalTrongNhom ?> HV</span>
       </button>
    </div>
    <hr style="text-align:center;">

    <h5 style="color:red; text-align:center;">DANH SÁCH HỌC VIÊN CHƯA SẮP NHÓM</h5>
    <form id="add-students-form" method="post" action="<?= Url::to(['add-students-to-group', 'id_nhom' => $nhomHoc]) ?>">
        <table class="table table-bordered table-striped" id="noNhomHVTable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>#</th>
                    <th>Tên học viên</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Địa chỉ</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($hocVienChuaCoNhom)): ?>
                    <tr>
                        
                    </tr>
                <?php else: ?>
                    <?php foreach ($hocVienChuaCoNhom as $index => $hocVien): ?>
                        <tr>
                            <td><input type="checkbox" name="selected_hoc_vien[]" value="<?= $hocVien->id ?>"></td>
                            <td><?= $index + 1 ?></td>
                            <td><?= Html::encode($hocVien->ho_ten) ?></td>
                            <td><?= Yii::$app->formatter->asDate($hocVien->ngay_sinh, 'php:d-m-Y') ?></td>
                            <td><?= Html::encode($hocVien->gioi_tinh === '1' ? 'Nam' : 'Nữ') ?></td>
                            <td><?= Html::encode($hocVien->diaChi) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div style="text-align: right; margin-top: 20px;">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-user-plus"></i> Bổ sung học viên
            </button>
        </div>
    </form>
</div>




