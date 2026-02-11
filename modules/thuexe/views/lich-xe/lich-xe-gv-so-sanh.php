<?php
use yii\bootstrap5\Modal;
use app\modules\thuexe\models\LichThue;
use app\custom\CustomFunc;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;
use app\modules\thuexe\models\Xe;
use app\modules\thuexe\models\LichThi;
use app\modules\user\models\User;
use app\modules\daotao\models\TietHoc;
use app\modules\demxe\models\DemXe;
use app\modules\thuexe\models\LichDungXe;

$this->title = 'So sánh lịch sử dụng xe ' . $model->bien_so_xe;

//$listXe = Xe::find()->where(['id_loai_xe'=>$model->id, 'phan_loai'=>'SATHACH'])->orderBy(['stt'=>SORT_ASC])->all();
$listXeData = [];
/* foreach ($listXe as $iXe => $itemXe){
    $listXeData[] = [
        'id' => 'col'.$itemXe->ma_so,
        'title' => 'Xe ' . $itemXe->ma_so,
        'order' => $iXe+1
    ];
} */
$listXeData[] = [
    'id' => 'collich',
    'title' => 'Lịch',
    'order' => 1
];
$listXeData[] = [
    'id' => 'colthue',
    'title' => 'Thuê',
    'order' => 2
];
$listXeData[] = [
    'id' => 'colcong1',
    'title' => 'Cổng 1',
    'order' => 3
];
$listXeData[] = [
    'id' => 'colcong2',
    'title' => 'Cổng 2',
    'order' => 4
];

//$contactLog = ContactLogPolicy::getContactLogByStaff();
//lấy từ 30 ngày gần nhất ->tương lai
$fromDate = date('Y-m-d 00:00:00', strtotime('-30 days'));
$contactLog = TietHoc::find()// SORT_ASC quan trọng để tính gộp
->andWhere(['id_xe'=>$model->id])->andWhere(['>=', 'thoi_gian_bd', $fromDate])->orderBy(['thoi_gian_bd' => SORT_ASC])->all();
//$colorList = ContactLogForm::getStatusColorHexList();
$colorList = TietHoc::getDmTrangThaiColor();
$eventData = [];

$merged = [];
$current = null;

foreach ($contactLog as $item) {
    $start = $item->thoi_gian_bd;
    $end   = $item->thoi_gian_kt;
    
    $gv = $item->giaoVien ? $item->giaoVien->ho_ten : '';
    $hv = $item->hocVien ? $item->hocVien->ho_ten : '';
    $idHv = $item->id_hoc_vien;
    $trangThai = $item->trang_thai;
    $color = $colorList[$trangThai] ?? '#000';
    $bienSoXe = $item->xe->bien_so_xe;
    $monHoc = $item->monHoc->ten_mon;
    
    if ($current === null) {
        // bắt nhóm đầu tiên
        $current = [
            'start' => $start,
            'end' => $end,
            'giao_vien' => $gv,
            'hoc_vien' => $hv,
            'id_hoc_vien' => $idHv,
            'trang_thai' => $trangThai,
            'mon_hoc' => $monHoc,
            'color' => $color,
            'bien_so_xe'=>$bienSoXe
        ];
    } else {
        // Điều kiện gộp:
        // 1. Liền kề về thời gian
        // 2. Cùng học viên
        // 3. Cùng trạng thái
        // 4. Cùng môn học
        if (
            $start == $current['end'] &&
            $idHv == $current['id_hoc_vien'] &&
            $trangThai == $current['trang_thai'] &&
            $monHoc = $current['mon_hoc']
            ) {
                // gộp: tăng giờ kết thúc
                $current['end'] = $end;
            } else {
                // đóng nhóm cũ, mở nhóm mới
                $merged[] = $current;
                
                $current = [
                    'start' => $start,
                    'end' => $end,
                    'giao_vien' => $gv,
                    'hoc_vien' => $hv,
                    'id_hoc_vien' => $idHv,
                    'trang_thai' => $trangThai,
                    'mon_hoc' => $monHoc,
                    'color' => $color,
                    'bien_so_xe' => $bienSoXe
                ];
            }
    }
}

// đẩy nhóm cuối
if ($current !== null) {
    $merged[] = $current;
}

$eventData = [];

foreach ($merged as $m) {
    $eventData[] = [
        'title' => 'GV: ' . $m['giao_vien'] . '<br>HV: ' . $m['hoc_vien'],
        'description' => 'Xe:'. $m['bien_so_xe'] .'<br>GV: ' . $m['giao_vien'] . ' - HV: ' . $m['hoc_vien']
        . ' dạy từ ' . CustomFunc::convertYMDHISToDMYHI($m['start'])
        . ' đến ' . CustomFunc::convertYMDHISToDMYHI($m['end'])
        . '<br>Môn học: ' . $m['mon_hoc']
        . '<br>Trạng thái: ' . TietHoc::getDmTrangThai()[$m['trang_thai']],
        'start' => $m['start'],
        'end' => $m['end'],
        'backgroundColor' => $m['color'],
        'resourceId' => 'collich'
    ];
}
//lịch dùng xe add to list lịch (sét màu đen)
$lichDungXes = LichDungXe::find()->where([
    'id_xe'=> $model->id
])->andWhere(['>=', 'thoi_gian_bat_dau', $fromDate])->all();
foreach ($lichDungXes as $item){
    $eventData[] = [
        'title' => 'Phụ trách: ' . $item->nguoiPhuTrach->ho_ten,
        'description' => 'Xe:'. $item->xe->bien_so_xe .'<br>'
        . 'Từ ' . CustomFunc::convertYMDHISToDMYHI($item->thoi_gian_bat_dau)
        . ' đến ' . CustomFunc::convertYMDHISToDMYHI($item->thoi_gian_ket_thuc)
        . '<br>Nội dung: ' . $item->noi_dung
        . '<br>Trạng thái: ' . LichDungXe::getDmTrangThai()[$item->trang_thai],
        'start' => $item->thoi_gian_bat_dau,
        'end' => $item->thoi_gian_ket_thuc,
        'backgroundColor' => '#212121',
        'resourceId' => 'collich'
    ];
}


//$contactLog = ContactLogPolicy::getContactLogByStaff();
$contactLog = LichThue::find()
//->joinWith(['xe as x'])
->andWhere(['id_xe'=>$model->id])
->andWhere(['>=', 'thoi_gian_bat_dau', $fromDate])
->orderBy(['thoi_gian_tao' => SORT_DESC])
//->andWhere(['x.id_loai_xe'=>$model->id])
->all();

//$colorList = ContactLogForm::getStatusColorHexList();
$colorList = LichThue::getTrangThaiColor();
//$eventData = [];
foreach ($contactLog as $item) {
    $startTime = $item->thoi_gian_bat_dau;
    $endTime = $item->thoi_gian_ket_thuc;
    //$backgroundColor = '#ffc107';
    // $backgroundColor = '#ddd';
    
    if ($item->trang_thai !== null) {
        $backgroundColor = $colorList[$item->trang_thai];
    }
    
    if(LichThue::checkLichDangHieuLucChuaXuatHoaDon($item->id)){
        $backgroundColor = '#fca13a';
    } else if(LichThue::checkLichDangHieuLucDaXuatHoaDon($item->id)){
        $backgroundColor = '#54b75c';
    }else if(LichThue::checkLichSapToi($item->id)){
        $backgroundColor = '#ff0000';
    }
    
    //$calendarTitle = $item->so_gio >= 2 ? ('Xe ' . $item->xe->ma_so . ' - ' . $item->xe->bien_so_xe) : ('Xe ' . $item->xe->ma_so);
    $calendarTitle = 'Xe ' . $item->xe->ma_so;
    //$calendarDescription = $item->so_gio >=2 ? '' : ('Biển số ' .$item->xe->bien_so_xe . ' - ');
    $calendarDescription = 'Biển số ' .$item->xe->bien_so_xe . ' - ';
    $calendarDescription .= 'GV: '. ($item->giaoVien ? $item->giaoVien->ho_ten : '') . ' - HV: '
        . ($item->khachHang ? $item->khachHang->ho_ten : '') . ' thuê từ ' . CustomFunc::convertYMDHISToDMYHI($startTime) . ' đến ' . CustomFunc::convertYMDHISToDMYHI($endTime);
        $eventData[] = [
            'title' => $calendarTitle,
            'description' => $calendarDescription,
            'start' => $startTime,
            'end' => $endTime,
            'url' => Url::to([(User::hasRole('nToThueXe', false)?'/thuexe/lich-thue/view-public':'/thuexe/lich-thue/update'), 'id' => $item->id, 'force_close' => 'true']),
            'extendedProps' => [
                'role' => 'modal-remote',
            ],
            'backgroundColor' => $backgroundColor,
            'resourceId' => 'colthue'
            // 'textColor' => 'black'
        ];
}


$contactLog = DemXe::find()->where(['id_xe'=>$model->id, 'ma_cong'=>DemXe::CONG1])
    ->andWhere(['>=', 'thoi_gian_bd', $fromDate])->all();

$colorList = DemXe::getDmTrangThaiColor();
//$eventData = [];
foreach ($contactLog as $item) {
    $startTime = $item->thoi_gian_bd;
    $endTime = $item->thoi_gian_kt;
    //$backgroundColor = '#ffc107';
    // $backgroundColor = '#ddd';
    
    if ($item->getDmTrangThai() !== null) {
        $backgroundColor = $colorList[$item->getDmTrangThai()];
    }
    
    /* if(LichThue::checkLichDangHieuLucChuaXuatHoaDon($item->id)){
     $backgroundColor = '#fca13a';
     } else if(LichThue::checkLichDangHieuLucDaXuatHoaDon($item->id)){
     $backgroundColor = '#54b75c';
     }else if(LichThue::checkLichSapToi($item->id)){
     $backgroundColor = '#ff0000';
     } */
    
    $eventData[] = [
        'title' => 'Xe số ' . $item->xe->ma_so . ' - ' . $item->xe->bien_so_xe,
        'description' => 'Xe chạy từ ' . CustomFunc::convertYMDHISToDMYHI($startTime)
        . ' đến ' . CustomFunc::convertYMDHISToDMYHI($endTime) .', thời gian chạy: ' . $item->so_phut,
        'start' => $startTime,
        'end' => $endTime,
        'url' => Url::to(['/demxe/luot-xe/update', 'id' => $item->id, 'force_close' => 'true']),
        'extendedProps' => [
            'role' => 'modal-remote',
        ],
        'backgroundColor' => $backgroundColor,
        // 'textColor' => 'black',
        'resourceId' => 'colcong1'
    ];
}


$contactLog = DemXe::find()->where(['id_xe'=>$model->id, 'ma_cong'=>DemXe::CONG2])
    ->andWhere(['>=', 'thoi_gian_bd', $fromDate])->all();

$colorList = DemXe::getDmTrangThaiColor();
//$eventData = [];
foreach ($contactLog as $item) {
    $startTime = $item->thoi_gian_bd;
    $endTime = $item->thoi_gian_kt;
    //$backgroundColor = '#ffc107';
    // $backgroundColor = '#ddd';
    
    if ($item->getDmTrangThai() !== null) {
        $backgroundColor = $colorList[$item->getDmTrangThai()];
    }
    
    /* if(LichThue::checkLichDangHieuLucChuaXuatHoaDon($item->id)){
     $backgroundColor = '#fca13a';
     } else if(LichThue::checkLichDangHieuLucDaXuatHoaDon($item->id)){
     $backgroundColor = '#54b75c';
     }else if(LichThue::checkLichSapToi($item->id)){
     $backgroundColor = '#ff0000';
     } */
    
    $eventData[] = [
        'title' => 'Xe số ' . $item->xe->ma_so . ' - ' . $item->xe->bien_so_xe,
        'description' => 'Xe chạy từ ' . CustomFunc::convertYMDHISToDMYHI($startTime)
        . ' đến ' . CustomFunc::convertYMDHISToDMYHI($endTime) .', thời gian chạy: ' . $item->so_phut,
        'start' => $startTime,
        'end' => $endTime,
        'url' => Url::to(['/demxe/luot-xe/update', 'id' => $item->id, 'force_close' => 'true']),
        'extendedProps' => [
            'role' => 'modal-remote',
        ],
        'backgroundColor' => $backgroundColor,
        // 'textColor' => 'black'
        'resourceId' => 'colcong2'
    ];
}

//add background cho lich thi
/***** thêm khoảng thời gian sau để phòng load hết chậm load trang ***/
$lichThi = LichThi::find()->all();
if($lichThi){
    foreach ($lichThi as $iLichThi=>$lich){
        $eventData[] = [
            'groupId' => 'highlight',
            'start' => $lich->thoi_gian_bd,
            'end' => $lich->thoi_gian_kt,
            'display' => 'background',
            'backgroundColor' => 'yellow'
        ];
    }
}
?>

<style>
    .fc-day-today {
        background-color: #ddd !important;
    }
    .fc-timegrid-event {
        background-color: #ffc107;
    }
    .fc-refreshBtn-button {
        color: #fff !important;
        background-color: #5a92a9 !important;
        border-color: #5a92a9 !important;
    }    
    .fc-col-header thead th{
        padding: 15px 0px;
    }

    td[data-resource-id="<?= $listXeData[0]['id']?$listXeData[0]['id']:'' ?>"], th[data-resource-id="<?= $listXeData[0]['id']?$listXeData[0]['id']:'' ?>"] {
      border-left: 3px solid orange; /* Ví dụ: thêm viền */
    }
    
    th[data-resource-id^="col"] {
      border-top: 3px solid orange; /* Ví dụ: thêm viền */
    }
    th[data-resource-id^="col"] {
      border-bottom: 3px solid orange; /* Ví dụ: thêm viền */
    }
    
    
    <?php 
    //xuất css tô đậm cho cột 2,4,6 trong tuần
    /* $soCotTrongNgay = count($listXeData);
    
    $firstColColor = $soCotTrongNgay+2;
    for($i=0;$i<$soCotTrongNgay;$i++){
        echo '.fc-timegrid-col:nth-child('.$firstColColor.') { background-color: #fef2f2; }';
        if($i<$soCotTrongNgay){
            $firstColColor++;
        }
    }
    $firstColColor += $soCotTrongNgay;
    for($i=0;$i<$soCotTrongNgay;$i++){
        echo '.fc-timegrid-col:nth-child('.$firstColColor.') { background-color: #fef2f2; }';
        if($i<$soCotTrongNgay){
            $firstColColor++;
        }
    }
    $firstColColor += $soCotTrongNgay;
    for($i=0;$i<$soCotTrongNgay;$i++){
        echo '.fc-timegrid-col:nth-child('.$firstColColor.') { background-color: #fef2f2; }';
        if($i<$soCotTrongNgay){
            $firstColColor++;
        }
    } */
    ?>
    <?php /* ?>
    .fc-timegrid-col:nth-child(7) { background-color: #fef2f2; } 
    .fc-timegrid-col:nth-child(8) { background-color: #fef2f2; } 
    .fc-timegrid-col:nth-child(9) { background-color: #fef2f2; } 
    .fc-timegrid-col:nth-child(10) { background-color: #fef2f2; }
    .fc-timegrid-col:nth-child(11) { background-color: #fef2f2; }
    .fc-timegrid-col:nth-child(12) { background-color: #fef2f2; } 
    .fc-timegrid-col:nth-child(13) { background-color: #fef2f2; } 
    
    .fc-timegrid-col:nth-child(19) { background-color: #fef2f2; } 
    .fc-timegrid-col:nth-child(20) { background-color: #fef2f2; }
    .fc-timegrid-col:nth-child(21) { background-color: #fef2f2; }
    .fc-timegrid-col:nth-child(22) { background-color: #fef2f2; } 
    .fc-timegrid-col:nth-child(23) { background-color: #fef2f2; }
    .fc-timegrid-col:nth-child(24) { background-color: #fef2f2; } 
    .fc-timegrid-col:nth-child(25) { background-color: #fef2f2; } 
    
    .fc-timegrid-col:nth-child(31) { background-color: #fef2f2; } 
    .fc-timegrid-col:nth-child(32) { background-color: #fef2f2; } 
    .fc-timegrid-col:nth-child(33) { background-color: #fef2f2; }
    .fc-timegrid-col:nth-child(34) { background-color: #fef2f2; } 
    .fc-timegrid-col:nth-child(35) { background-color: #fef2f2; } 
    .fc-timegrid-col:nth-child(36) { background-color: #fef2f2; } 
    .fc-timegrid-col:nth-child(37) { background-color: #fef2f2; } 
    <?php */ ?>
   
</style>

<link rel="stylesheet" href="/js/tippy6.3.7/tippy.css" />
<script src="/js/tippy6.3.7/popper.min.js"></script>
<script src="/js/tippy6.3.7/tippy-bundle.umd.min.js"></script>

<div class="card border-default p-4">
    <div class="row mb-3">
        <div class="col-md-4">
           <?=
            Select2::widget([
                'name' => 'search-xe',
                'options' => [
                    'id' => 'xe-select',
                    'placeholder' => 'Chọn xe...'
                ],
                'data' => Xe::getListAll(),
                'value' => $model->id,
                'pluginEvents' => [
                    "select2:select" => new JsExpression('function(e) {
                        var data = e.params.data;
                        if(data && data.id) {
                            var url = "/thuexe/lich-xe/lich-xe-gv-so-sanh?menu=dt3&idxe=" + data.id;
                            window.location.href = url; // chuyển hướng sang trang chi tiết
                        }
                    }')
                ]
            ]);
            ?>
        </div>
        <div class="col-md-8">
        	Sự kiện: &nbsp;&nbsp;<span style="background-color:#45aaf2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Đã lên lịch 
        	&nbsp;&nbsp;<span style="background-color:#fca13a">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Đang thuê (chưa HĐ)
        	&nbsp;&nbsp;<span style="background-color:#54b75c">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Đang thuê (có HĐ)
        	&nbsp;&nbsp;<span style="background-color:#ff0000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 30 phút nữa tới
        	&nbsp;&nbsp;<span style="background-color:#02587b">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Đã hoàn thành 
        	<br/>
        	Màu nền: <span style="background-color:#ddd">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Hôm nay 
        	&nbsp;&nbsp; &nbsp;<span style="background-color:yellow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Ngày thi
        </div>
    </div>

    <div id="calendar"></div>
</div>



 
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            //right: 'dayGridMonth,timeGridWeek,timeGridDay, refreshBtn'
            right: 'refreshBtn'
        },
        customButtons: {
            refreshBtn: {
                text: 'Làm mới',
                click: function() {
                    window.location.reload();
                }
            }
        },
        //navLinks: true,// can click day/week names to navigate views
        businessHours: true, // display business hours
        locale: 'vi',
        timeZone: 'local',
        initialView: 'resourceTimeGridWeek',
        allDaySlot: false,
        slotLabelFormat: {
          hour: '2-digit',
          minute: '2-digit',
          meridiem: false, // Tắt hiển thị AM/PM
          hour12: false // Đảm bảo hiển thị định dạng 24 giờ
        },
        //slotMinTime: "08:00:00",
        //slotMaxTime: "22:00:00",
        datesAboveResources: true,
        resourceOrder: 'order',
        resources: <?= json_encode($listXeData); ?>/* [
          { id: 'col1', title: 'Xe 1', order: 1 },
          { id: 'col2', title: 'Xe 2', order: 2 },
          { id: 'col3', title: 'Xe 3', order: 3 },
          { id: 'col4', title: 'Xe 4', order: 4 },
          { id: 'col5', title: 'Xe 5', order: 5 },
          { id: 'col6', title: 'Xe 6', order: 6 }
        ] */,
        editable: true,
        selectable: true,
        selectMirror: true,
        droppable: false,// true để kéo thả sự kiện sang giờ khác
        dayMaxEvents: true, // allow "more" link when too many events
        select: function(arg) {
            const params = new URLSearchParams({
                start_str: arg.startStr,
                end_str: arg.endStr,
                force_close: true
            });

            /*const url = '<?= Url::to(['/thuexe/lich-thue/create?type=hocvien']) ?>' + '&' + params.toString();

            if (modal) {
                modal.open({
                    href: url
                });
            }

            calendar.unselect()
            */
        },
        /* slotLaneDidMount: function(arg) {
          // Lấy ngày, giờ từ cell
          const cellDate = arg.date;  
          const dateStr = cellDate.toISOString().split('T')[0]; // YYYY-MM-DD
          const hour = cellDate.getHours();
        
          // Ví dụ: highlight ngày 2025-08-25 từ 12h đến 14h
          if (dateStr === "2025-08-25" && hour >= 6 && hour < 8) {
            arg.el.style.backgroundColor = "#ff0000"; // màu nền
          }
        }, */
     	eventDidMount: function(info) {
            if (info.event.extendedProps.role) {
                info.el.setAttribute('role', info.event.extendedProps.role);
            }
            //info.el.setAttribute('title', info.event.extendedProps.description);
            if(info.event.title){
                tippy(info.el, {
                  content: info.event.title + ' (' + info.event.extendedProps.description + ')',
                  placement: 'top',
                  theme: 'light-border',
                  allowHTML: true,
                });
            }                
            
        },
        events:  <?= json_encode($eventData); ?>,
        eventContent: function(arg) {
          return {
            html: `<div style="
              background:${arg.event.backgroundColor};
              color:#fff;
              border-radius:4px;
              padding:2px;
              width:100%;
              height:100%;
              display:flex;
              align-items:center;
              justify-content:center;
            ">${arg.event.title}</div>`
          };
    	},
    	
	});
	calendar.render();
});
</script>   

<?php Modal::begin([
    'options' => [
        'id' => 'ajaxCrudModal',
        'tabindex' => false // important for Select2 to work properly
    ],
    'dialogOptions' => ['class' => 'modal-lg modal-xxl'],
    'closeButton' => ['label' => '<span aria-hidden=\'true\'>×</span>'],
    'id' => 'ajaxCrudModal',
    'footer' => '', // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>

<?php Modal::begin([
    'options' => [
        'id' => 'ajaxCrudModal2',
        'tabindex' => false // important for Select2 to work properly
    ],
    'dialogOptions' => ['class' => 'modal-lg modal-xxl'],
    'closeButton' => ['label' => '<span aria-hidden=\'true\'>×</span>'],
    'id' => 'ajaxCrudModal2',
    'footer' => '', // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>