<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Thêm học viên';
// Register DataTables assets

$this->registerCssFile('https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css');
$this->registerJsFile('https://cdn.datatables.net/2.1.8/js/dataTables.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<?php if (!empty($hocVien)): ?>
    <h5 class="text-center mb-4" style="color:red;">DANH SÁCH HỌC VIÊN ĐĂNG KÝ THEO HẠNG XE</h5>
<?php
    $form = ActiveForm::begin([
    'id' => 'add-hoc-vien-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'options' => [
        'data-pjax' => true,
    ],
]);
?>

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
                    <td class="text-start"><span class="badge bg-primary"><?= Html::encode($h->ho_ten) ?></span></td>
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
        <div class="form-group">
             <?= Html::submitButton('Thêm học viên', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

<?php else: ?>
        <div class="alert alert-warning">
            Không tìm thấy Học viên.
        </div>
<?php endif; ?>


<script>
      $(document).ready(function() {
        $('#hocVienTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json"
            }
        });
    });
</script>

<script>
 $(document).on('beforeSubmit', '#add-hoc-vien-form', function (e) {
    e.preventDefault(); 
    let $form = $(this);

    if ($form.find('.has-error').length) {
        return false; 
    }

    $.ajax({
        type: $form.attr('method'),
        url: $form.attr('action'),
        data: $form.serialize(),
        success: function (response) {
            if (response.success) {
                $('#hoc-vien-list-container').html(response.content);
                alert('Thêm học viên thành công!');
            } else {
                alert(response.message || 'Có lỗi xảy ra khi thêm học viên.');
            }
        },
        error: function () {
            alert('Không thể gửi yêu cầu. Vui lòng thử lại.');
        }
    });

    return false; 
});

</script>