<?php

use yii\bootstrap5\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\modules\thuexe\models\LichThue;
use kartik\select2\Select2;
use yii\web\JsExpression;
use app\custom\CustomFunc;
use app\modules\thuexe\models\LichThi;
use app\modules\daotao\models\TietHoc;

$this->title = 'Lịch dạy của xe ' . $model->bien_so_xe;
Yii::$app->params['showSearch'] = false;
Yii::$app->params['showView'] = true;

//$contactLog = ContactLogPolicy::getContactLogByStaff();
$contactLog = TietHoc::find()->orderBy(['thoi_gian_bd' => SORT_ASC])// SORT_ASC quan trọng để tính gộp
    ->andWhere(['id_xe'=>$model->id])->all();
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
    
    if ($current === null) {
        // bắt nhóm đầu tiên
        $current = [
            'start' => $start,
            'end' => $end,
            'giao_vien' => $gv,
            'hoc_vien' => $hv,
            'id_hoc_vien' => $idHv,
            'trang_thai' => $trangThai,
            'color' => $color,
            'bien_so_xe'=>$bienSoXe
        ];
    } else {
        // Điều kiện gộp:
        // 1. Liền kề về thời gian
        // 2. Cùng học viên
        // 3. Cùng trạng thái
        if (
            $start == $current['end'] &&
            $idHv == $current['id_hoc_vien'] &&
            $trangThai == $current['trang_thai']
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
        . '<br>Trạng thái: ' . TietHoc::getDmTrangThai()[$m['trang_thai']],
        'start' => $m['start'],
        'end' => $m['end'],
        'backgroundColor' => $m['color'],
    ];
}

//add background cho lich thi
/***** thêm khoảng thời gian sau để phòng load hết chậm load trang ***/
/* $lichThi = LichThi::find()->all();
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
} */

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
</style>

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
                'data' => LichThue::getDsXeCamUng(),
                'value' => $model->id,
                'pluginEvents' => [
                    "select2:select" => new JsExpression('function(e) {
                        var data = e.params.data;
                        if(data && data.id) {
                            var url = "/thuexe/lich-thue/xe-schedule?menu=dc8&id=" + data.id;
                            window.location.href = url; // chuyển hướng sang trang chi tiết
                        }
                    }')
                ]
            ]);
            ?>
        </div>
        <div class="col-md-8">
        	<span style="background-color:#45aaf2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Đã lên lịch 
        	&nbsp;&nbsp;<span style="background-color:#fca13a">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Đang thuê (chưa HĐ)
        	&nbsp;&nbsp;<span style="background-color:#54b75c">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Đang thuê (có HĐ)
        	&nbsp;&nbsp;<span style="background-color:#ff0000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 30 phút nữa tới
        	&nbsp;&nbsp;<span style="background-color:#02587b">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Đã hoàn thành
        	<br/>
        	Màu nền: <span style="background-color:#ddd">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Hôm nay 
        	&nbsp;&nbsp; &nbsp;<span style="background-color:yellow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Ngày thi 
        </div>
    </div>

    <div id="calendar2" class="calendar"></div>
</div>

<link rel="stylesheet" href="/js/tippy6.3.7/tippy.css" />
<script src="/js/tippy6.3.7/popper.min.js"></script>
<script src="/js/tippy6.3.7/tippy-bundle.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar2');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay, refreshBtn'
            },
            customButtons: {
                refreshBtn: {
                    text: 'Làm mới',
                    click: function() {
                        window.location.reload();
                    }
                }
            },
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            editable: true,
            selectable: true,
            selectMirror: true,
            initialView: 'timeGridWeek',
            allDaySlot: false,
            locale: 'vi',
            timeZone: 'local',
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            droppable: false,
            editable: false,
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

                calendar.unselect()*/
            },
            eventDidMount: function(info) {
                if (info.event.extendedProps.role) {
                    info.el.setAttribute('role', info.event.extendedProps.role);
                }
                if(info.event.title){
                    tippy(info.el, {
                      content: info.timeText + '<br>' + info.event.title + '<br>' 
                      	+ '<br> Ghi chú: <br>' + info.event.extendedProps.description,
                      placement: 'top',
                      theme: 'light-border',
                      allowHTML: true,
                    });
                }
            },
            events: <?= json_encode($eventData); ?>,
            eventContent: function(arg) {
                // Thời gian FullCalendar render sẵn
                let time = arg.timeText;            
                // Title có HTML bạn truyền từ PHP
                let title = arg.event.title;            
                return {
                    html: '<div class="fc-event-custom">' +
                            '<div class="fc-time">' + time + '</div>' +
                            '<div class="fc-title">' + title + '</div>' +
                          '</div>'
                };
            }
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