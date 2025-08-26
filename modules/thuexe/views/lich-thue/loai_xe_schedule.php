<?php

use yii\bootstrap5\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\modules\thuexe\models\LichThue;
use kartik\select2\Select2;
use yii\web\JsExpression;
use app\custom\CustomFunc;

$this->title = 'Lịch thuê xe của các xe thuộc hạng ' . $model->ten_loai_xe;
Yii::$app->params['showSearch'] = false;
Yii::$app->params['showView'] = true;

//$contactLog = ContactLogPolicy::getContactLogByStaff();
$contactLog = LichThue::find()->alias('t')
    ->joinWith(['xe as x'])
    ->orderBy(['thoi_gian_tao' => SORT_DESC])
    ->andWhere(['x.id_loai_xe'=>$model->id])
    ->all();

//$colorList = ContactLogForm::getStatusColorHexList();
$colorList = LichThue::getTrangThaiColor();
$eventData = [];
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
    
    $eventData[] = [
        'title' => 'Xe số ' . $item->xe->ma_so . ' - ' . $item->xe->bien_so_xe,
        'description' => 'GV: '. ($item->giaoVien ? $item->giaoVien->ho_ten : '') . ' - HV: '
        . ($item->khachHang ? $item->khachHang->ho_ten : '') . ' thuê từ ' . CustomFunc::convertYMDHISToDMYHI($startTime) 
                . ' đến ' . CustomFunc::convertYMDHISToDMYHI($endTime),
        'start' => $startTime,
        'end' => $endTime,
        'url' => Url::to(['/thuexe/lich-thue/update', 'id' => $item->id, 'force_close' => 'true']),
        'extendedProps' => [
            'role' => 'modal-remote',
        ],
        'backgroundColor' => $backgroundColor,
        // 'textColor' => 'black'
    ];
}
?>
<style>
    .fc-timegrid-event {
        background-color: #ffc107;
    }

    .fc-refreshBtn-button {
        color: #fff !important;
        background-color: #5a92a9 !important;
        border-color: #5a92a9 !important;
    }
</style>

<link rel="stylesheet" href="/js/tippy6.3.7/tippy.css" />
<script src="/js/tippy6.3.7/popper.min.js"></script>
<script src="/js/tippy6.3.7/tippy-bundle.umd.min.js"></script>

<div class="card border-default p-4">
    <div class="row mb-3">
        <div class="col-md-3">
            <?=
            Select2::widget([
                'name' => 'search-xe',
                'options' => [
                    'id' => 'xe-select',
                    'placeholder' => 'Chọn xe...'
                ],
                'data' => LichThue::getDsLoaiXeCamUng(),
                'value' => $model->id,
                'pluginEvents' => [
                    "select2:select" => new JsExpression('function(e) {
                        var data = e.params.data;
                        if(data && data.id) {
                            var url = "/thuexe/lich-thue/loai-xe-schedule?menu=dc9&id=" + data.id;
                            window.location.href = url; // chuyển hướng sang trang chi tiết
                        }
                    }')
                ]
            ]);
            ?>
        </div>
        <div class="col-md-9">
        	<span style="background-color:#45aaf2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Đã lên lịch 
        	&nbsp;&nbsp;<span style="background-color:#fca13a">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Đang thuê (chưa HĐ)
        	&nbsp;&nbsp;<span style="background-color:#54b75c">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Đang thuê (có HĐ)
        	&nbsp;&nbsp;<span style="background-color:#ff0000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 30 phút nữa tới
        	&nbsp;&nbsp;<span style="background-color:#02587b">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Đã hoàn thành 
        </div>
    </div>

    <div id="calendar2" class="calendar"></div>
</div>

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

                calendar.unselect()
                */
            },
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
                    });
                }
            },
            events: <?= json_encode($eventData); ?>,
            /* eventMouseEnter: function(info) {
                 
            } */
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