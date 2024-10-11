<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Thêm nhiều học viên - ' . $khoaHoc->ten_khoa_hoc;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<!-- Bảng học viên -->
<table id="hocVienTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th><?= Html::checkBox('select_all', false, ['class' => 'select-all']) ?></th>
            <th>Họ tên</th>
            <th>Địa chỉ</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($hocVien as $h): ?>
        <tr>
            <td><?= Html::checkBox('hoc_vien_ids[]', false, ['value' => $h->id]) ?></td>
            <td><?= Html::encode($h->ho_ten) ?></td>
            <td><?= Html::encode($h->dia_chi) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="form-group" style="text-align: left;">
    <?= Html::submitButton('<Thêm học viên', ['class' => 'btn btn-success']) ?>
</div>



<?php ActiveForm::end(); ?>

<!-- Thêm jQuery và DataTables CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>

<script>
    $(document).ready(function() {
        // Khởi tạo DataTables cho bảng
        $('#hocVienTable').DataTable({
            "paging": true,      // Cho phép phân trang
            "searching": true,   // Cho phép tìm kiếm
            "ordering": true,    // Cho phép sắp xếp
            "info": true         // Hiển thị thông tin phân trang
        });

        // Tích hợp tính năng "Chọn tất cả" với DataTables
        $('.select-all').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('input[name="hoc_vien_ids[]"]').prop('checked', isChecked);
        });
    });
</script>
