<?php
use yii\helpers\Html;
use app\widgets\CardWidget;
/* @var $this yii\web\View */
/* @var $danhSachThongTin array */

$this->title = 'Thông Tin Nộp Phí Thuê Xe';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="nop-phi-thue-xe-view">
    <?php if (empty($nopPhiRecords)): ?>
        <p style = "color:chartreuse;"> Người thuê chưa đóng phí thuê !</p>
    <?php else: ?>
        <?php CardWidget::begin(['title' => 'Thông tin thuê xe']) ?>
        
        <?php if (!empty($danhSachThongTin)): ?>
            <?php $firstRecord = $danhSachThongTin[0]; ?>
            <label style="color:blueviolet;"> 
                <?= isset($firstRecord['id_hoc_vien']) && $firstRecord['id_hoc_vien'] !== null ? 'Học viên:' : 'Người thuê:' ?> 
            </label>
            <?= Html::encode($firstRecord['id_hoc_vien'] ?? $firstRecord['ho_ten_nguoi_thue']) ?>
        <?php else: ?>
            <label style="color:blueviolet;">Người thuê:</label>
            <?= Html::encode($firstRecord['ho_ten_nguoi_thue'] ?? 'N/A') ?>
        <?php endif; ?>

        <br>
        <label style="color:blueviolet;">Thông tin thuê chi tiết:</label>

        <?php 
            $foundTrangThai1 = false;

            foreach ($danhSachThongTin as $record) {
                if (isset($record['checkTrangThai']) && $record['checkTrangThai'] === 1) {
                    echo Html::a(
                        '<i class="fas fa-eye icon-white"></i>',
                        ['/thuexe/phieu-thue-xe/xem-tra-xe', 'id' => $id, 'modalType' => 'modal-remote-2'],
                        ['class' => 'btn btn-sm btn-success', 'title' => 'Thông tin thuê chi tiết', 'role' => 'modal-remote-2']
                    );
                    $foundTrangThai1 = true;
                    break;
                }
            }

            if (!$foundTrangThai1) {
                echo Html::a(
                    '<i class="fas fa-eye icon-white"></i>',
                    ['/thuexe/phieu-thue-xe/view', 'id' => $id, 'modalType' => 'modal-remote-2'],
                    ['class' => 'btn btn-sm btn-danger', 'title' => 'Thông tin thuê chi tiết', 'role' => 'modal-remote-2']
                );
            }
        ?>

        <br>
        <label style="color:blueviolet;">Trạng thái:</label> 
        <span>
            <?php
                if ($checkPhiThue == 1 ) {
                    echo "Chưa nộp đủ";
                } elseif ($checkPhiThue == 0) {
                    echo "Nộp đủ";
                } else {
                    echo "Chưa đóng học phí";
                }
            ?>
        </span>

        <br>
        <hr>
        <table style="border-collapse: collapse; width: 60%;">
    <tr>
        <td style="border: 1px solid #8A2BE2; padding: 8px;">
            <label style="color:blueviolet;">Phí thuê:</label>
        </td>
        <td style="border: 1px solid #8A2BE2; padding: 8px;">
              <span class="text-align:center;" style="color:blue;"><?= number_format($phiThue ,0,',', '.') . ' VNĐ' ?></span>
        </td>
        <td style="border: 1px solid #8A2BE2; padding: 8px;">
            <label style="color:brown;">Phí phát sinh:</label>
        </td>
        <td style="border: 1px solid #8A2BE2; padding: 8px;">
             <span class="text-align:center;" style="color:red;"><?= number_format($phiPhatSinh ,0,',', '.') . ' VNĐ' ?></span>
        </td>
    </tr>
    <tr>
        <td style="border: 1px solid #8A2BE2; padding: 8px;">
            <label style="color:blueviolet;">Phí thuê đã thu:</label>
        </td>
        <td style="border: 1px solid #8A2BE2; padding: 8px;"><?= number_format($phithueThu ,0,',', '.') . ' VNĐ' ?></td>
     
        <td style="border: 1px solid #8A2BE2; padding: 8px;">
            <label style="color:brown;">Phí phát sinh đã thu:</label>
        </td>
        <td style="border: 1px solid #8A2BE2; padding: 8px;"><?= number_format($phithuePSthu ,0,',', '.') . ' VNĐ' ?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #8A2BE2; padding: 8px;">
            <label style="color:blueviolet;">Còn nợ:</label>
        </td>
        <td style="border: 1px solid #8A2BE2; padding: 8px;"> <span class="text-align:center;" style="color:greenyellow;"><?= number_format($chiphiThueConNo ,0,',', '.') . ' VNĐ' ?></span></td>
      
        <td style="border: 1px solid #8A2BE2; padding: 8px;">
             <label style="color:brown;">Còn nợ:</label>
        </td>
        <td style="border: 1px solid #8A2BE2; padding: 8px;"> <span class="text-align:center;" style="color:greenyellow;"><?= number_format($chiphiThuePSConNo ,0,',', '.') . ' VNĐ' ?></span></td>
    </tr>
</table>

        <?php CardWidget::end() ?>

        <?php CardWidget::begin(['title' => 'Chi tiết']) ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Lần thu</th>
                    <th>Nhân viên thu</th>
                    <th>Ngày thu</th>
                    <th>Số tiền thu</th>
                    <th>Trạng thái</th>
                    <th>Biên lai</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($danhSachThongTin as $iTt => $thongTin): ?>
                    <tr>
                        <td><?= $iTt + 1 ?></td>
                        <td><?= Html::encode($thongTin['nguoi_thu']) ?></td>
                        <td><?= Html::encode(Yii::$app->formatter->asDatetime($thongTin['ngay_nop'], 'php:d-m-Y')) ?></td>
                        <td><?= number_format($thongTin['so_tien_nop'], 0, ',', '.') . ' VNĐ' ?></td>
                        <td><?= Html::encode($thongTin['trang_thai']) ?></td>
                        <td>
                            <?= Html::a(
                                '<i class="fas fa-eye icon-white"></i>',
                                ['/thuexe/phieu-thue-xe/bien-lai', 'idNopHp' => $thongTin['idNopPhi'], 'modalType' => 'modal-remote-2'],
                                ['class' => 'btn btn-sm btn-success', 'title' => 'Xem biên lai', 'role' => 'modal-remote-2']
                            ); ?>   
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php CardWidget::end() ?>
    <?php endif; ?>
</div>
