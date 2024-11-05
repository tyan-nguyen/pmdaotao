<?php
use yii\helpers\Html;
use app\widgets\CardWidget;
/* @var $this yii\web\View */
/* @var $danhSachThongTin array */

$this->title = 'Thông Tin Nộp Phí Thuê Xe';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="nop-phi-thue-xe-view">
<?php CardWidget::begin(['title' => 'Thông tin thuê xe']) ?>
    <?php 
      if (!empty($danhSachThongTin)): 
        $firstRecord = $danhSachThongTin[0]; 
        
        // Hiển thị thông tin học viên hoặc người thuê
        if (isset($firstRecord['id_hoc_vien']) && $firstRecord['id_hoc_vien'] !== null): ?>
            <label style="color:blueviolet;"> Học viên: </label>
            <?= Html::encode($firstRecord['id_hoc_vien']) ?>
        <?php else: ?>
            <label style="color:blueviolet;"> Người thuê: </label>
            <?= Html::encode($firstRecord['ho_ten_nguoi_thue']) ?>
        <?php endif; ?>
    <?php else: ?>
        <label style="color:blueviolet;"> Người thuê: </label>
        <?= Html::encode($firstRecord['ho_ten_nguoi_thue']) ?>
    <?php endif; ?>

    <br>
    <label style="color:blueviolet;">Thông tin thuê chi tiết:</label>

    <?php 
       $foundTrangThai1 = false;

       foreach ($danhSachThongTin as $record) {
           if (isset($record['checkTrangThai']) && $record['checkTrangThai'] === 1) {
                echo Html::a('<i class="fas fa-eye icon-white"></i>', 
                     ['/thuexe/phieu-thue-xe/xem-tra-xe','id' =>$id ,  'modalType' => 'modal-remote-2'], 
                     ['class' => 'btn btn-sm btn-success', 'title' => 'Thông tin thuê chi tiết', 'role' => 'modal-remote-2']
                    );
                   $foundTrangThai1 = true;
            break;
          }
        }
           if (!$foundTrangThai1) {
                echo Html::a('<i class="fas fa-eye icon-white"></i>', 
                 ['/thuexe/phieu-thue-xe/view', 'id'=>$id,'modalType' => 'modal-remote-2'], 
                 ['class' => 'btn btn-sm btn-danger', 'title' => 'Thông tin thuê chi tiết', 'role' => 'modal-remote-2']
                );
           }
    ?>


<?php CardWidget::end() ?>

    <?php CardWidget::begin(['title'=>'Chi tiết'])?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Stt</th>
                <th>Nhân viên thu</th>
                <th>Ngày thu</th>
                <th>Số tiền thu</th>
                <th>Trạng thái </th>
                <th>Biên lai </th> 
            </tr>
        </thead>
        <tbody>
             <?php foreach ($danhSachThongTin as $iTt => $thongTin): ?>
                <tr>
                       <td><?= $iTt + 1 ?></td> 
                       <td><?= Html::encode($thongTin['nguoi_thu']) ?></td>
                       <td><?= Html::encode(Yii::$app->formatter->asDatetime($thongTin['ngay_nop'], 'php:d-m-Y')) ?></td>
                       <td><?= number_format($thongTin['so_tien_nop'] ,0,',', '.') . ' VNĐ' ?></td>
                       <td><?= Html::encode($thongTin['trang_thai'])?></td>
                       <td>
                           <?= Html::a('<i class="fas fa-eye icon-white"></i>', 
                            ['/thuexe/phieu-thue-xe/bien-lai', 'idNopHp'=> $idNopPhi,'modalType' => 'modal-remote-2'], 
                            ['class' => 'btn btn-sm btn-success', 'title' => 'Xem biên lai', 'role' => 'modal-remote-2']
                           ); ?>   
                       </td>
                </tr>
             <?php endforeach; ?>
        </tbody>
    </table>
    <?php Cardwidget::end()?>
</div>