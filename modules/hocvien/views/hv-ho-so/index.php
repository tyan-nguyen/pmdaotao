<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
//use cangak\ajaxcrud\CrudAsset; 
use cangak\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;
use app\widgets\FilterFormWidget;
use app\modules\hocvien\models\HangDaoTao;
use app\modules\hocvien\models\HocVien;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\vanban\models\search\VBDenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hồ sơ học viên';
$this->params['breadcrumbs'][] = $this->title;
//CrudAsset::register($this);
Yii::$app->params['showSearch'] = true;
Yii::$app->params['showExport'] = true;
?>

<style>
    #crud-datatable-togdata-page {
        border: 0px !important;
    }

    .ho-so-da-huy td {
        color: blue !important;
        text-decoration: line-through;
    }

    /* 1. Thiết lập chiều cao cố định cho cả 2 trạng thái */
    .double-scroll-wrapper::-webkit-scrollbar,
    .kv-grid-container::-webkit-scrollbar {
        height: 14px;
        /* Đây là chiều cao tối đa khi nở ra */
    }

    /* 2. Phần nền (Track) - nên để trong suốt hoặc màu rất nhẹ */
    .double-scroll-wrapper::-webkit-scrollbar-track,
    .kv-grid-container::-webkit-scrollbar-track {
        background: transparent;
    }

    /* 3. Cục kéo (Thumb) - Đây là nơi xử lý hiệu ứng mượt */
    .double-scroll-wrapper::-webkit-scrollbar-thumb,
    .kv-grid-container::-webkit-scrollbar-thumb {
        background-color: #eae9f1;
        border-radius: 20px;
        /* MẸO: Dùng border dày cùng màu với nền trang (ví dụ màu trắng #ffffff) 
       để ép cục kéo trông nhỏ lại khi ở trạng thái nghỉ */
        border: 4px solid #ffffff;
        transition: all 0.4s ease-in-out;
        /* Tạo độ trễ mượt mà */
    }

    /* 4. Khi Hover vào vùng chứa (Container) */
    .double-scroll-wrapper:hover::-webkit-scrollbar-thumb,
    .kv-grid-container:hover::-webkit-scrollbar-thumb {
        background-color: #b3b1b1;
        /* Đậm hơn một chút cho rõ */
        /* Khi hover, giảm độ dày border để cục kéo "nở" ra */
        border: 1px solid #ffffff;
    }

    /** eae9f1 b3b1b1 */

    /* Container của Kartik */
    .kv-grid-container {
        overflow-x: auto;
    }

    /* Cột 2: NĐK */
    .kv-sticky-column-4 {
        position: sticky !important;
        left: 0;
        /* Chỉnh lại cho khít với độ rộng cột 1 */
        /*background-color: white !important;*/
        box-shadow: inset -1px 0 0 #dee2e6;
    }

    /* Cột 2: NĐK */
    .kv-sticky-column-5 {
        position: sticky !important;
        left: 50px;
        /* Chỉnh lại cho khít với độ rộng cột 1 */

        /* background-color: white !important;*/
        box-shadow: inset -1px 0 0 #dee2e6;
    }

    /* XỬ LÝ GIAO ĐIỂM: Để Header không bị chữ ở dưới trượt qua khi scroll cả 2 hướng */

    thead th.kv-sticky-column-4,
    thead th.kv-sticky-column-5 {
        background-color: #f5f5f5 !important;
    }

    /* Ngăn chữ lọt qua viền khi cuộn */
    .kv-sticky-column-4,
    .kv-sticky-column-5 {
        background-clip: padding-box;
    }

    /* Đảm bảo menu luôn nằm trên cùng */
    .dropdown-menu {
        z-index: 9999 !important;
    }
</style>

<div class="card border-default" id="divFilterExtend">
    <div class="card-header rounded-bottom-0 card-header text-dark" id="simple">
        <h5 class="mt-2"><i class="fe fe-search"></i> Tìm kiếm</h5>
    </div>
    <div class="card-body">
        <div class="expanel expanel-default">
            <div class="expanel-body">
                <?php
                echo $this->render("_search", ["model" => $searchModel]);
                ?>
            </div>
        </div>
    </div>
</div>

<?php Pjax::begin([
    'id' => 'myGrid',
    'timeout' => 10000,
    'formSelector' => '.myFilterForm'
]); ?>

<div class="van-ban-den-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'containerOptions' => [
                'style' => 'min-height:500px;',
                'class' => 'kv-grid-container'
            ],
            //'filterModel' => $searchModel,
            'pjax' => true,
            //'showPageSummary' => true,
            'columns' => require(__DIR__ . '/_columns.php'),
            'rowOptions' => function ($model, $key, $index, $grid) {
                if ($model->huy_ho_so) {
                    return ['class' => 'ho-so-da-huy'];
                }
            },
            'toolbar' => [
                [
                    'content' =>
                    '
                    <div class="dropdown">
						<button aria-expanded="false" aria-haspopup="true" class="btn dropdown-toggle" data-bs-toggle="dropdown" type="button"><i class="fa fa-navicon"></i></button>
						<div class="dropdown-menu tx-13" style="">
							<h6 class="dropdown-header tx-uppercase tx-11 tx-bold bg-info tx-spacing-1">
								Chọn chức năng</h6>'

                        /*  .Html::a('<i class="fas fa fa-plus" aria-hiddi="true"></i> Thêm mới', ['create'],
                        ['role'=>'modal-remote','title'=> 'Thêm mới','class'=>'dropdown-item']) */
                        .
                        Html::a(
                            '<i class="fas fa fa-sync" aria-hidden="true"></i> Tải lại',
                            [''],
                            ['data-pjax' => 1, 'class' => 'dropdown-item', 'title' => 'Tải lại']
                        )
                        /*.
                    Html::a('<i class="fas fa fa-trash" aria-hidden="true"></i>&nbsp; Xóa danh sách',
                        ["bulkdelete"],
                        [
                            'class'=>'dropdown-item text-secondary',
                            'role'=>'modal-remote-bulk',
                            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                            'data-request-method'=>'post',
                            'data-confirm-title'=>'Xác nhận xóa?',
                            'data-confirm-message'=>'Bạn có chắc muốn xóa?'
                        ])
                    .'<li><hr class="dropdown-divider"></li>'
                    . Html::a('<i class="fas fa-clipboard-list"></i> In DS theo ca', ['report-list'],
                        ['role'=>'modal-remote','title'=> 'In DS theo ca','class'=>'dropdown-item'])
                    .'<li><hr class="dropdown-divider"></li>'
                    . Html::a('<i class="fas fa-clipboard-list"></i> Báo cáo DS HV', ['/hocvien/bao-cao/rp-danh-sach-dang-ky'],
                        ['role'=>'modal-remote','title'=> 'Báo cáo danh sách học viên','class'=>'dropdown-item'])
                    */

                        /*  . Html::a('<i class="fas fa-clipboard-list"></i> In Báo cáo theo ca', ['report-sum'],
                        ['role'=>'modal-remote','title'=> 'In Báo cáo tổng','class'=>'dropdown-item']) */
                        . '
						</div>
					</div>
                    ' .
                        '{toggleData}'
                        . '{export}'
                ],
            ],
            'striped' => false,
            'condensed' => true,
            'responsive' => true,
            'panelHeadingTemplate' => '<div style="width:100%;"><div class="float-start mt-2 text-primary">{title}</div> <div class="float-end">{toolbar}</div></div>',
            'panelFooterTemplate' => '<div style="width:100%;"><div class="float-start">{summary}</div><div class="float-end">{pager}</div></div>',
            'summary' => 'Tổng: {totalCount} dòng dữ liệu',
            'panel' => [
                'headingOptions' => ['class' => 'card-header rounded-bottom-0 card-header text-dark'],
                'heading' => '<i class="typcn typcn-folder-open"></i> DANH SÁCH HỌC VIÊN ĐÃ HOÀN THÀNH HỒ SƠ',
                'before' => false,
            ],
            'export' => [
                'fontAwesome' => true,
                'showConfirmAlert' => false,
                'target' => GridView::TARGET_BLANK, // xuất ra tab mới
                'filename' => 'ds_hoc_vien' . date('Y-m-d'), // tên file export mặc định
                'options' => [
                    'class' => 'btn'
                ]
            ],
            'exportConfig' => [
                GridView::EXCEL => [
                    'label' => 'Xuất Excel',
                    'filename' => 'ds_hoc_vien_' . date('Y-m-d'),
                    'options' => ['title' => 'Danh sách học viên'],
                    'config' => [
                        'worksheet' => 'Học viên',
                        'cssFile' => '', // nếu cần
                    ],
                ],
                GridView::PDF => [
                    'label' => 'Xuất PDF',
                    'filename' => 'ds_hoc_vien_' . date('Y-m-d'),
                    'options' => ['title' => 'Danh sách học viên'],
                    'config' => [
                        'methods' => [
                            'SetHeader' => ['DANH SÁCH HỌC VIÊN|DANH SÁCH|Xuất ngày: ' . date("d/m/Y")],
                            'SetFooter' => ['|Trang {PAGENO}|'],
                        ],
                        'options' => [
                            'title' => 'Danh sách học viên',
                            'subject' => 'Xuất file PDF',
                            'keywords' => 'export, pdf,',
                        ],
                    ],
                ],
            ],

        ]) ?>
    </div>

</div>

<?php Pjax::end(); ?>

<?php Modal::begin([
    'options' => [
        'id' => 'ajaxCrudModal',
        'tabindex' => false // important for Select2 to work properly
    ],
    //'dialogOptions'=>['class'=>'modal-lg'],
    'closeButton' => ['label' => '<span aria-hidden=\'true\'>×</span>'],
    'id' => 'ajaxCrudModal',
    'footer' => '', // always need it for jquery plugin
    'size' => Modal::SIZE_EXTRA_LARGE
]) ?>

<?php Modal::end(); ?>

<?php Modal::begin([
    'options' => [
        'id' => 'ajaxCrudModal2',
        'tabindex' => false // important for Select2 to work properly
    ],
    // 'dialogOptions'=>['class'=>'modal-lg'],
    'closeButton' => ['label' => '<span aria-hidden=\'true\'>×</span>'],
    'id' => 'ajaxCrudModal2',
    'footer' => '', // always need it for jquery plugin
    'size' => Modal::SIZE_LARGE
]) ?>

<?php Modal::end(); ?>

<?php
/* $searchContent = $this->render("_search", ["model" => $searchModel]);
    echo FilterFormWidget::widget(["content"=>$searchContent, "description"=>"Nhập thông tin tìm kiếm."])  */
?>

<?php
$js = <<<JS
    function addDoubleScroll() {
        var container = $('.kv-grid-container'); 
        // Xóa scrollbar cũ nếu đã tồn tại (để tránh lặp khi Pjax reload)
        $('.double-scroll-wrapper').remove();
        
        // Tạo một div giả lập có chiều rộng bằng với table bên trong
        var tableWidth = container.find('table').outerWidth();
        var topScroll = $('<div class="double-scroll-wrapper" style="overflow-x:auto; overflow-y:hidden; height:20px; width:100%;">' +
                          '<div style="width:' + tableWidth + 'px; height:20px;"></div></div>');
        
        // Chèn vào phía trên container của Grid
        container.before(topScroll);
        
        // Đồng bộ hóa 2 thanh cuộn
        topScroll.scroll(function(){
            container.scrollLeft(topScroll.scrollLeft());
        });
        container.scroll(function(){
            topScroll.scrollLeft(container.scrollLeft());
        });
    }

    // Chạy khi load trang
    addDoubleScroll();
    
    // Nếu bạn có dùng Pjax, hãy chạy lại sau khi Pjax hoàn tất
    $(document).on('pjax:complete', function() {
        addDoubleScroll();
    });
JS;
$this->registerJs($js);
?>