<?php
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Chi tiết nhóm: ' . $nhomHoc->ten_nhom;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách nhóm học', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $totalTrongNhom = count($hocVienTrongNhom); ?>
<?php $totalChuaNhom = count($hocVienChuaCoNhom); ?>


<div class="group-details">
    <!-- Tiêu đề danh sách học viên -->
    <h5 id="toggleTrongNhom" class="toggle-title active">DANH SÁCH HỌC VIÊN</h5>
    <div id="hocVienTrongNhomWrapper">
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
                <?php foreach ($hocVienTrongNhom as $index => $hocVien): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= Html::encode($hocVien->ho_ten) ?></td>
                        <td><?= Yii::$app->formatter->asDate($hocVien->ngay_sinh, 'php:d-m-Y') ?></td>
                        <td><?= Html::encode($hocVien->gioi_tinh =='1' ? 'Nam' : 'Nữ') ?></td>
                        <td><?= Html::encode($hocVien->diaChi) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <hr>

    <!-- Tiêu đề danh sách học viên chưa có nhóm -->
    <h5 id="toggleChuaNhom" class="toggle-title">DANH SÁCH HỌC VIÊN CHƯA SẮP NHÓM</h5>
    <div id="hocVienChuaNhomWrapper" style="display: none;">
        <form id="add-students-form" method="post" action="<?= Url::to(['add-students-to-group', 'id_nhom' => $nhomHoc->id]) ?>">
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
                </tbody>
            </table>
            <div style="text-align: right; margin-top: 20px;">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-user-plus"></i> Bổ sung học viên
                </button>
            </div>
        </form>
    </div>
</div>



<?php
$js = <<<JS
    $('#select-all').on('change', function() {
        $('input[name="selected_hoc_vien[]"]').prop('checked', this.checked);
    });
JS;
$this->registerJs($js);
?>
<script>
    $(document).ready(function() {
        $('#nhomHVTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json"
            }
        });
    });
    $(document).ready(function() {
        $('#noNhomHVTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json"
            }
        });
    });
</script>

<script>
$(document).on('submit', '#add-students-form', function(e) {
    e.preventDefault();
    const form = $(this);
    const url = form.attr('action');
    const data = form.serialize();

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function(response) {
            if (response.status === 'success') {
                $('.group-details').html(response.content);
                alert(response.message);
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Đã xảy ra lỗi khi gửi yêu cầu.');
        }
    });
});
</script>

<script>
    $.ajax({
    url: 'your-url',
    success: function(response) {
        $('#group-details').html(response); 
        $('#nhomHVTable, #noNhomHVTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json"
            }
        });
    }
});
</script>


<script>
$(document).ready(function () {
    $("#toggleTrongNhom").click(function () {
        $("#hocVienTrongNhomWrapper").slideDown();
        $("#hocVienChuaNhomWrapper").slideUp();
        $("#toggleTrongNhom").addClass("active");
        $("#toggleChuaNhom").removeClass("active");
    });

    $("#toggleChuaNhom").click(function () {
        $("#hocVienTrongNhomWrapper").slideUp();
        $("#hocVienChuaNhomWrapper").slideDown();
        $("#toggleTrongNhom").removeClass("active");
        $("#toggleChuaNhom").addClass("active");
    });
});
</script>


<style>
.toggle-title {
    color: blue;
    text-align: center;
    font-size: 18px;
    cursor: pointer;
    padding: 10px;
    background: #f0f0f0;
    border-radius: 5px;
    margin-bottom: 10px;
    transition: all 0.3s ease-in-out;
}

.toggle-title:hover {
    background: #dcdcdc;
}

.toggle-title.active {
    background: #0056b3;
    color: white;
}
</style>




