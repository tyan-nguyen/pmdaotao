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
use app\modules\user\models\User;
use app\modules\hocvien\models\base\HocVienBase;
use app\custom\CustomFunc;
use app\modules\danhmuc\models\DmTinh;
use app\modules\danhmuc\models\DmXa;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\vanban\models\search\VBDenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$user = User::getCurrentUser();
$listTitle = 'Thống kê lưu lượng';
$this->title = $listTitle;
$this->params['breadcrumbs'][] = $this->title;
//CrudAsset::register($this);
Yii::$app->params['showSearch'] = true;
Yii::$app->params['showExport'] = false;

//format total count of dataprovider
$totalFmt = number_format($dataProvider->getTotalCount(), 0, ',', '.');

if (!empty($searchModel->ngay_sinh_tu)) {
    $searchModel->ngay_sinh_tu = CustomFunc::convertYMDToDMY($searchModel->ngay_sinh_tu);
}
if (!empty($searchModel->ngay_sinh_den)) {
    $searchModel->ngay_sinh_den = CustomFunc::convertYMDToDMY($searchModel->ngay_sinh_den);
}

$pageSize = $dataProvider->pagination->pageSize ?? 20;

$exportDataProvider = clone $dataProvider;

$exportDataProvider->pagination = [
    'pageSize' => $pageSize,
    'page' => 0,
];

$exportXlsx = ExportMenu::widget([
    'dataProvider' => $exportDataProvider,
    // 'columns' => require(__DIR__ . '/_columns_export.php'),
    'columns' => require(__DIR__ . '/luu-luong/_columns.php'),
    'filename' => 'ds_hoc_vien_' . date('Y-m-d'),
    'showColumnSelector' => true,
    'columnSelectorOptions' => [
        'label' => 'Select',
        'class' => 'btn btn-outline-secondary',
        'encodeLabel' => false,
    ],
    'columnBatchToggleSettings' => [
        'label' => 'Dữ liệu cần xuất file',
    ],
    'contentBefore' => [
        [
            'value' => 'DANH SÁCH HỌC VIÊN',
            'options' => [
                'colspan' => 12, // sửa bằng số cột thực tế
                'style' => [
                    'font' => [
                        'bold' => true,
                        'size' => 20,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ],
            ],
        ],
        [
            'value' => 'Ngày xuất: ' . date('d/m/Y'),
            'options' => [
                'colspan' => 12, // sửa bằng số cột thực tế
                'style' => [
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    ],
                ],
            ],
        ],
    ],

    'exportConfig' => [
        ExportMenu::FORMAT_TEXT => false,
        //ExportMenu::FORMAT_TEXT_UTF8 => false,
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_CSV => false,
        //ExportMenu::FORMAT_PDF => false,
        ExportMenu::FORMAT_EXCEL => false,

        ExportMenu::FORMAT_EXCEL_X => [
            'label' => 'Xuất Excel (*.xlsx)',
            'icon' => 'fas fa-file-excel',
        ],

        ExportMenu::FORMAT_PDF => [
            'label' => 'Xuất PDF (*.pdf)',
            'icon' => 'fas fa-file-pdf',

            'pdfConfig' => [
                'mode' => 'UTF-8',
                'format' => 'A4-L',
                'orientation' => 'L',
                'destination' => 'D',

                'methods' => [
                    'SetTitle' => 'Danh sách học viên',

                    'SetHeader' => [
                        '<strong>DANH SÁCH HỌC VIÊN</strong>'
                            . '|'
                            . 'Ngày xuất: ' . date('d/m/Y')
                    ],

                    'SetFooter' => [
                        '|Trang {PAGENO}/{nbpg}|'
                    ],
                ],

                'options' => [
                    'title' => 'Danh sách học viên',
                    'subject' => 'Danh sách học viên đăng ký',
                    'author' => Yii::$app->name,
                    'keywords' => 'học viên, đăng ký, danh sách',
                ],
            ],

            'options' => [
                'title' => 'Xuất danh sách PDF',
            ],
        ], //end pdf
    ],

    'target' => ExportMenu::TARGET_BLANK,
    'showConfirmAlert' => false,

    'dropdownOptions' => [
        'label' => 'Export new',
        'class' => 'btn btn-success',
        'encodeLabel' => false,
    ],

    'onRenderSheet' => function ($sheet, $widget) {
        // Tên sheet XLSX
        $sheet->setTitle('Học viên');

        // Thiết lập trang PDF
        $sheet->getPageSetup()
            ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(PageSetup::PAPERSIZE_A4)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        $sheet->getStyle($sheet->calculateWorksheetDimension())
            ->getFont()
            ->setName('Times New Roman')
            ->setSize(13);

        // Căn lề khi xuất PDF
        $sheet->getPageMargins()
            ->setTop(0.5)
            ->setRight(0.3)
            ->setBottom(0.5)
            ->setLeft(0.3);

        // Lặp lại dòng tiêu đề cột trên mỗi trang PDF.
        // Nếu beforeContent chiếm dòng 1 và 2 thì header bảng thường ở dòng 3.
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(3, 3);
        $sheet->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()
            ->setBold(true)
            ->setSize(20);
        $sheet->getStyle('A2')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()
            ->setBold(true)
            ->setSize(20);
        //cột SĐT
        $sheet->getStyle('E:E')
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_TEXT);
        // cột CCCD
        $sheet->getStyle('F:F')
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_TEXT);

        $sheet->getStyle('J:J')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('K:k')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('L:L')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('M:M')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('N:N')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Footer PDF
        $sheet->getHeaderFooter()
            ->setOddFooter('&CTrang &P / &N');
    },

]);

?>
<style>
    #crud-datatable-togdata-page {
        border: 0px !important;
    }

    .dtoolbar .dropdown-toggle {
        border: 0px !important;
        color: black !important;
    }

    .dtoolbar .dropdown-toggle:hover,
    .dtoolbar .dropdown-toggle.show {
        border: 0px !important;
        background-color: white !important;
        color: red !important;
    }

    .dtoolbar .kv-checkbox-list.show {
        padding: 10px !important;
    }

    .thay-doi-hang td {
        color: blue !important;
    }

    .ho-so-da-huy td {
        color: blue !important;
        text-decoration: line-through;
    }

    .ho-so-bao-luu td {
        color: orange !important;
    }

    .doi-ngay-sat-hach td {
        color: green !important;
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
        <h5 class="mt-2"><i class="fe fe-search"></i> Thông tin</h5>
    </div>
    <div class="card-body">
        <div class="expanel expanel-default">
            <div class="expanel-body">
                <?php
                echo $this->render("luu-luong/_search", ["model" => $searchModel]);
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

        <?php if (
            !empty($searchModel->gioi_tinh) || !empty($searchModel->noi_dang_ky) || !empty($searchModel->id_hang) || !empty($searchModel->ngay_sinh_tu) || !empty($searchModel->ngay_sinh_den
                || !empty($searchModel->tuoi_tu) || !empty($searchModel->tuoi_den))
            || !empty($searchModel->id_khoa_hoc) || !empty($searchModel->id_xa)
            || !empty($searchModel->id_tinh) || !empty($searchModel->id_hangs)
            || !empty($searchModel->ngay_dang_ky_tu) || !empty($searchModel->ngay_dang_ky_den)
        ): ?>
            <div class="card custom-card">
                <div class="card-body">

                    <div>
                        <h3>Kết quả tìm kiếm</h3>
                        Các tiêu chí tìm kiếm:
                        <ul>
                            <?php if ($searchModel->gioi_tinh): ?>
                                <li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Giới tính:</strong> <?= $searchModel->gioi_tinh == 1 ? 'Nam' : 'Nữ' ?></li>
                            <?php endif; ?>
                            <?php if ($searchModel->noi_dang_ky): ?>
                                <li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Cơ sở đăng ký:</strong> <?= $searchModel->getLabelNoiDangKy() ?></li>
                            <?php endif; ?>
                            <?php if ($searchModel->id_hang): ?>
                                <li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Hạng đào tạo:</strong> <?= $searchModel->hangDaoTao->ten_hang ?></li>
                            <?php endif; ?>

                            <?php if ($searchModel->id_hangs) {
                                $tenHang = '';
                                foreach ($searchModel->id_hangs as $iHang => $idHang) {
                                    $hangdaotao = HangDaoTao::findOne($idHang);
                                    $tenHang .= $hangdaotao->ten_hang . ', ';
                                }
                            ?>
                                <li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Hạng đào tạo (chọn nhiều):</strong> <?= $tenHang ?></li>
                                <?php /*?><li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Hạng đào tạo:</strong> <?= $searchModel->hangDaoTao->ten_hang ?></li> <?php */ ?>
                            <?php } ?>

                            <?php if ($searchModel->id_khoa_hoc): ?>
                                <li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Khóa học:</strong> <?= $searchModel->khoaHoc->ten_khoa_hoc ?></li>
                            <?php endif; ?>
                            <?php if ($searchModel->ngay_sinh_tu): ?>
                                <li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Ngày sinh từ:</strong> <?= $searchModel->ngay_sinh_tu ?></li>
                            <?php endif; ?>
                            <?php if ($searchModel->ngay_sinh_den): ?>
                                <li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Ngày sinh đến:</strong> <?= $searchModel->ngay_sinh_den ?></li>
                            <?php endif; ?>
                            <?php if ($searchModel->tuoi_tu): ?>
                                <li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Tuổi từ:</strong> <?= $searchModel->tuoi_tu ?></li>
                            <?php endif; ?>
                            <?php if ($searchModel->tuoi_den): ?>
                                <li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Tuổi đến:</strong> <?= $searchModel->tuoi_den ?></li>
                            <?php endif; ?>
                            <?php if ($searchModel->id_xa): ?>
                                <li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Xã/Phường:</strong> <?= DmXa::getTenXa($searchModel->id_xa) ?></li>
                            <?php endif; ?>
                            <?php if ($searchModel->id_tinh): ?>
                                <li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Tỉnh/Thành:</strong> <?= DmTinh::getTenTinh($searchModel->id_tinh) ?></li>
                            <?php endif; ?>
                            <?php if ($searchModel->ngay_dang_ky_tu): ?>
                                <li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Ngày đăng ký từ:</strong> <?= $searchModel->ngay_dang_ky_tu ?></li>
                            <?php endif; ?>
                            <?php if ($searchModel->ngay_dang_ky_den): ?>
                                <li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Ngày đăng ký đến:</strong> <?= $searchModel->ngay_dang_ky_den ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <h4 style="margin-top:10px"><strong>Tổng cộng: </strong><?php echo $totalFmt ?> kết quả.</h4>
                </div>
            </div>
        <?php endif; ?>

        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pjax' => true,
            //'showPageSummary' => true,
            'columns' => require(__DIR__ . '/luu-luong/_columns.php'),
            'rowOptions' => function ($model, $key, $index, $grid) {
                if ($model->thayDoiHangs != null) {
                    return ['class' => 'thay-doi-hang'];
                }
                if ($model->huy_ho_so) {
                    return ['class' => 'ho-so-da-huy'];
                }
                if ($model->baoLuus) {
                    return ['class' => 'ho-so-bao-luu'];
                }
                if ($model->doiNgaySatHachs) {
                    return ['class' => 'doi-ngay-sat-hach'];
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
                        /* .
                    Html::a('<i class="fas fa fa-plus" aria-hiddi="true"></i> Thêm mới', ['create'],
                        ['role'=>'modal-remote','title'=> 'Thêm mới','class'=>'dropdown-item']) */
                        .
                        Html::a(
                            '<i class="fas fa fa-sync" aria-hidden="true"></i> Tải lại',
                            [''],
                            ['data-pjax' => 1, 'class' => 'dropdown-item', 'title' => 'Tải lại']
                        )
                        /* .
                    Html::a('<i class="fas fa fa-trash" aria-hidden="true"></i>&nbsp; Xóa danh sách',
                        ["bulkdelete"],
                        [
                            'class'=>'dropdown-item text-secondary',
                            'role'=>'modal-remote-bulk',
                            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                            'data-request-method'=>'post',
                            'data-confirm-title'=>'Xác nhận xóa?',
                            'data-confirm-message'=>'Bạn có chắc muốn xóa?'
                        ]) */
                        /*  .'<li><hr class="dropdown-divider"></li>'
                    . Html::a('<i class="fas fa-clipboard-list"></i> In DS theo ca', ['report-list'],
                        ['role'=>'modal-remote','title'=> 'In DS theo ca','class'=>'dropdown-item'])
                    .'<li><hr class="dropdown-divider"></li>'
                    . Html::a('<i class="fas fa-clipboard-list"></i> BB bàn giao hồ sơ', ['/hocvien/bao-cao/rp-bien-ban-ban-giao'],
                        ['role'=>'modal-remote','title'=> 'Biên bản bàn giao hồ sơ','class'=>'dropdown-item']) */
                        . '<li><hr class="dropdown-divider"></li>'
                        . '
						</div>
					</div>
                    ' .
                        '{toggleData}'
                        . '{export}'
                        . $exportXlsx
                ],
            ],
            'striped' => false,
            'condensed' => true,
            'responsive' => false,
            'panelHeadingTemplate' => '<div style="width:100%;"><div class="float-start mt-2 text-primary">{title}</div> <div class="float-end dtoolbar">{toolbar}</div></div>',
            'panelFooterTemplate' => '<div style="width:100%;"><div class="float-start">{summary}</div><div class="float-end">{pager}</div></div>',
            'summary' => 'Tổng: <strong>' . $totalFmt . '</strong> dòng dữ liệu',
            'panel' => [
                'headingOptions' => ['class' => 'card-header rounded-bottom-0 card-header text-dark'],
                'heading' => '<i class="typcn typcn-folder-open"></i> DANH SÁCH HỌC VIÊN',
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
    'size' => Modal::SIZE_EXTRA_LARGE
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