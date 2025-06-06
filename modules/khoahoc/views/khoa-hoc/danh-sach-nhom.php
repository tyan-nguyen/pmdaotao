<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\hocvien\models\HocVien;

/** @var yii\web\View $this */
/** @var array $nhomHoc */
/** @var int $idKhoaHoc */

$this->title = 'Danh sách Nhóm';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="nhom-hoc-danh-sach" id="dsNhomContent">
    <?php if (!empty($nhomHoc)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên nhóm</th>
                    <th>Số lượng học viên tối đa</th>
                    <th>Số lượng học viên</th>
                    <th>Hành động</th>
                </tr>
            </thead> 
            <tbody>
                <?php foreach ($nhomHoc as $index => $nhom): ?>
                    <tr id="row-<?= $nhom->id ?>">
                        <td><?= $index + 1 ?></td>
                        <td><?= Html::encode($nhom->ten_nhom) ?></td>
                        <td style="color:red;"><?= Html::encode($nhom->so_luong_hoc_vien)?></td>
                        <td style ="color:blue;"><?= HocVien::find()->where(['id_nhom' => $nhom->id])->count() ?></td>
                        <td>
                            <?= Html::a('<i class="fa fa-pencil"> </i>', 
                                ['/khoahoc/khoa-hoc/update-nhom-hoc', 'id' => $nhom->id],
                                [
                                    'class' => 'btn ripple btn-success btn-sm',
                                    'title' => 'Cập nhật',
                                    'style' => 'color: white;',
                                    'role' => 'modal-remote-2',
                                ]
                            ) ?>
                            <?= Html::button('<i class="fa fa-trash"></i>', [
                                'class' => 'btn btn-danger btn-sm',
                                'title'=>'Xóa',
                                'onclick' => "deleteRecord({$nhom->id})",
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">
            Không có nhóm nào thuộc khóa học này.
        </div>
    <?php endif; ?>
</div>

<?php
$deleteUrl = Url::to(['khoa-hoc/delete-nhom']); 
$js = <<<JS
function deleteRecord(id) {
    if (confirm('Bạn có chắc chắn muốn xóa nhóm này không?')) {
        $.ajax({
            url: '$deleteUrl',
            type: 'POST',
            data: {id: id},
            success: function (response) {
                if (response.success) {
                    $('#row-' + id).remove();
                    alert('Xóa thành công!');
                } else {
                    alert('Xóa thất bại: ' + response.message);
                }
            },
            error: function () {
                alert('Đã xảy ra lỗi khi xóa nhóm.');
            }
        });
    }
}
JS;
$this->registerJs($js);
?>

<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

