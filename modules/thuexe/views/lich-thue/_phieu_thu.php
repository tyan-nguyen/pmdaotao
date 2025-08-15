<?php 
use app\widgets\CardWidget;
use app\modules\thuexe\models\PhieuThu;
use app\custom\CustomFunc;
use app\modules\user\models\User;
use yii\helpers\Html;
?>

<?php CardWidget::begin(['title'=>'Chi tiết thu tiền']) ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Số phiếu</th>
                <th>HTTT</th>
                <th>Số tiền</th>
                <th>Chiết khấu</th>
                <th>Còn lại</th>
                <th>Ngày nộp</th>
                <th>Người thu</th>
                <th>Ghi chú</th>
                <th><i class="fas fa-print"></i></th>
                <th></th>
                <!-- <th>Biên lai</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            $index = 1;
            foreach ($model->phieuThus as $pThu): ?>
                <tr <?= ($pThu->loai_phieu==PhieuThu::PHIEUCHILABEL)?'class="tr-red"':'' ?> >
                    <td><?= $index ?></td>
                    <td><?= CustomFunc::fillNumber($pThu->ma_so_phieu) ?></td>
                    <td><?= $pThu->hinh_thuc_thanh_toan ?></td>
                    
                    <td><?= number_format($pThu->so_tien, 0, ',', '.') ?></td>
                    <td><?= number_format($pThu->chiet_khau, 0, ',', '.') ?></td>
                    <td><?= number_format($pThu->so_tien_con_lai, 0, ',', '.') ?></td>
                    <td><?= CustomFunc::convertYMDHISToDMYHI($pThu->thoi_gian_tao) ?></td>
                    
                    <td>
                        <?php
                        // Tìm thông tin người thu từ bảng user
                        $user = User::findOne($pThu->nguoi_tao);
                        echo $user ? Html::encode($user->username) : 'Không xác định';
                        ?>
                    </td>
                    
                    <td><?= $pThu->ghi_chu ?></td>
                    
                    <td><span id="soLanIn<?= $pThu->id ?>"><?= $pThu->so_lan_in_phieu ?></span></td>
                    <td>
                    	<div class="btn-group">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            In
                          </button>
                          <ul class="dropdown-menu">
                            <li><?= Html::button('<i class="fa fa-print"> </i> Xem trước (bản nháp)', ['class' => 'btn btn-default', 'style'=>'width:100%', 'onclick' => 'InPhieuThu('.$pThu->id.',1)']) ?></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><?= Html::button('<i class="fa fa-print"> </i> In Phiếu (Ký tên đóng dấu)', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'InPhieuThu('.$pThu->id.',0)']) ?></li>
                          </ul>
                        </div>
                    </td>
                </tr>
            <?php
            $index++;
            endforeach; ?>
        </tbody>
    </table>
<?php CardWidget::end() ?>