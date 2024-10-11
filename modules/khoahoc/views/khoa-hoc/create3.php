<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Thêm học viên';

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


	
<!-- Thêm jQuery và DataTables CDN -->

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
<script>
    // Khởi tạo DataTables cho bảng học viên
    $(document).ready(function() {
        $('#hocVienTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "pageLength": 5,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json"
            }
        });

        // Chức năng "Chọn tất cả"
        $('.select-all').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('input[name="hoc_vien_ids[]"]').prop('checked', isChecked);
        });
    });
</script>
