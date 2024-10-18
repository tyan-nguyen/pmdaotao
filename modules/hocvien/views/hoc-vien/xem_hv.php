<?php
use yii\bootstrap5\Html;

if ($isEmpty) {
    echo "<p>Không tìm thấy Học viên</p>";
} else {
?>

<table class="table" id="hocVienTable">
    <thead>
        <tr>
            <th>STT</th>
            <th>Họ tên</th>
            <th>Số CCCD</th>
            <th>Giới tính</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($datas as $iHv => $hv): ?>
        <tr>
            <td><?= $iHv + 1 ?></td>
            <td><?= $hv->ho_ten ?></td>
            <td><?= $hv->so_cccd ?></td>
            <td><?= $hv->gioi_tinh == 1 ? 'Nam' : 'Nữ' ?></td>
            <td>
                <?= Html::a('<i class="fas fa-eye icon-white"></i>', 
                    ['/hocvien/hoc-vien/view', 'id' => $hv->id, 'modalType' => 'modal-remote-2'], 
                    ['class' => 'btn btn-sm btn-primary', 'title' => 'Xem', 'role' => 'modal-remote-2']
                ); ?>
                
                <?= Html::a('<i class="fa fa-remove"></i>', 
                    ['/hocvien/hoc-vien/delete-from-khoa-hoc', 'id' => $hv->id], 
                    ['class' => 'btn ripple btn-info btn-sm delete-hv-btn', 'title' => 'Xóa học viên', 'style' => 'color: white;', 'data-id' => $hv->id]
                ); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php } ?>


<script>
$(document).on('click', '.delete-hv-btn', function(e) {
    e.preventDefault(); // Ngăn hành động mặc định (chuyển trang)

    var url = $(this).attr('/hocvien/hoc-vien/delete-from-khoa-hoc'); // URL của hành động xóa

    $.ajax({
        url: url,
        type: 'POST',
        success: function(response) {
            if (response.forceReload) {
                // Reload lại nội dung bảng học viên
                $(response.forceReload).html(response.reloadContent);
            }
            if (response.tcontent) {
                alert(response.tcontent);  // Hiển thị thông báo
            }
        },
        error: function() {
            alert('Lỗi khi xóa học viên.');
        }
    });
});
</script>


<style>
    .icon-white {
    color: white;
}
.pagination {
    display:flex;
    justify-content: center;
    padding:10px;
}

.pagination li a {
    color: #007bff; /* Màu văn bản cho các nút */
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.pagination li a:hover {
    background-color: #007bff; /* Màu nền khi di chuột */
    color: #fff; /* Màu văn bản khi di chuột */
}

.pagination .active a {
    background-color: #007bff; /* Màu nền cho nút đang được chọn */
    color: white;
    border-color: #007bff;
}

.pagination .disabled a {
    color: #aaa;
}
</style>