<?php 
use app\widgets\CardWidget;
?>

<?php CardWidget::begin(['title'=>'Học viên đăng ký mới' ]) ?>

<?php 
    // Lấy danh sách 7 ngày gần nhất, tính cả hôm nay
    $dates = [];
    for ($i = 0; $i < 7; $i++) {
        $dates[] = date('Y-m-d', strtotime("-$i days"));
    }
    // Duyệt qua danh sách 7 ngày
    foreach ($dates as $date) {
        echo "Ngày: $date\n";
    }
?>

<?php CardWidget::end()?>