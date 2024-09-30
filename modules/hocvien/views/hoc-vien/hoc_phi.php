<?php
use yii\helpers\Html;
use app\modules\nhanvien\models\NhanVien;
use app\modules\hocvien\models\NopHocPhi;
use app\modules\hocvien\models\HocVien;
/* @var $this yii\web\View */
/* @var $model app\modules\giaovien\models\GiaoVien */
?>

<?php
// Tìm học phí của học viên hiện tại
$hocPhi = NopHocPhi::find()->where(['id_hoc_vien' => $model->id])->all();
// Lấy thông tin học viên
$hocVien = HocVien::findOne($model->id);
$tenHang = $hocVien && $hocVien->hang ? $hocVien->hang->ten_hang : null;
?>

<div id="hpContent" class="hoc-phi-view">
    <?php if (empty($hocPhi)): ?>
        <!-- Học viên chưa đóng học phí -->
        <p style="color:red">Học viên chưa đóng học phí !.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hạng xe</th>
                    <th>Số tiền nộp</th>
                    <th>Người thu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hocPhi as $hcPhi): ?>
                    <tr>
                        <td><?= $tenHang ?></td>
                        <td><?= number_format($hcPhi->so_tien_nop, 0, ',', '.') . ' VNĐ' ?></td>
                        <td>
                            <?php
                            // Tìm thông tin người thu từ bảng user
                            $user = NhanVien::findOne($hcPhi->nguoi_thu);
                            echo $user ? Html::encode($user->ho_ten) : 'Không xác định';
                            ?>
                        </td>
                        <td>
                           
                       </td>
                    </tr>

                    
                <?php endforeach; ?>
            </tbody>
        </table>
       
        <p class="text-align:center;" style="color:red"> Biên lai </p>
     
        <!-- Hiển thị ảnh nếu đường dẫn bắt đầu bằng 'bien_lai' -->
        <td>
             <img src="<?= Yii::getAlias('@web') . '/' . Html::encode($hcPhi->bien_lai) ?>" alt="Biên lai" style="width: 500px; height: auto;">
       </td>
    <?php endif; ?>
</div>

<script>
function funcUploadDay($data){
    $('#dayContent').html($data);
}
</script>
