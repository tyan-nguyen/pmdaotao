<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Thêm học viên';
// Register DataTables assets

$this->registerCssFile('https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css');
$this->registerJsFile('https://cdn.datatables.net/2.1.8/js/dataTables.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<?php if (!empty($hocVien)): ?>
    <h5 class="text-center mb-4" style="color:red;">Danh sách học viên đăng ký theo hạng xe</h5>

    <?php $form = ActiveForm::begin(); ?>

    <div class="table-responsive" style="max-width: 1000px; margin: 0 auto;">
        <!-- Bảng học viên -->
        <table id="hocVienTable" class="table table-hover table-striped" style="width: 100%;">
            <thead class="table-primary text-center">
                <tr>
                    <th style="width: 50px;">
                        <?= Html::checkBox('select_all', false, ['class' => 'select-all']) ?>
                    </th>
                    <th style="width: 200px;">Họ tên</th>
                    <th style="width: 100px;">Giới tính</th>
                    <th style="width: 300px;">Địa chỉ</th>
                    <th style="width: 150px;">Số điện thoại</th>
                    <th style="width: 150px;">Số CCCD</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hocVien as $h): ?>
                <tr class="text-center">
                    <td>
                        <?= Html::checkBox('hoc_vien_ids[]', false, ['value' => $h->id]) ?>
                    </td>
                    <td class="text-start"><span class="badge bg-success"><?= Html::encode($h->ho_ten) ?></span></td>
                    <td class="text-start">
                        <?= Html::encode($h->gioi_tinh == 1 ? 'Nam' : ($h->gioi_tinh == 0 ? 'Nữ' : 'Không xác định')) ?>
                    </td>
                    <td class="text-start"><?= Html::encode($h->dia_chi) ?></td>
                    <td class="text-start"><?= Html::encode($h->so_dien_thoai) ?></td>
                    <td class="text-start"><?= Html::encode($h->so_cccd) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-left mt-3">
             <?= Html::submitButton('<i class="fas fa-user-plus"></i> Thêm học viên', ['class' => 'btn btn-success btn-md']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

<?php else: ?>
    <div class="">
        <h5 style="color:red;">Không có học viên nào đăng ký theo hạng của khóa !</h5>
    </div>
<?php endif; ?>


<script>
$(document).ready(function() {
    $('#hocVienTable').DataTable({
        "paging": true,
        "searching": true,
        "info": true,
        "ordering": true,
        "lengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        "language": {
            "search": "Tìm kiếm:",
            "lengthMenu": "Hiển thị _MENU_ học viên",
            "info": "Hiển thị _START_ đến _END_ của _TOTAL_ học viên",
            "paginate": {
                "first": "Đầu",
                "last": "Cuối",
                "next": "Sau",
                "previous": "Trước"
            },
        }
    });
      // Chức năng "Chọn tất cả"
      $('.select-all').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('input[name="hoc_vien_ids[]"]').prop('checked', isChecked);
        });
});
</script>