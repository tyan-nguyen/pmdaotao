<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset;
use cangak\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\taisan\models\search\TaiSanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tài sản';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->params['showSearch'] = true;
Yii::$app->params['showView'] = true;
//CrudAsset::register($this);

?>
<style>
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
</style>

<?php if (Yii::$app->params['showSearch']): ?><div class="card border-default" id="divFilterExtend">
        <div class="card-header rounded-bottom-0 card-header text-dark" id="simple">
            <h5 class="mt-2"><i class="fe fe-search"></i> Tìm kiếm</h5>
        </div>
        <div class="card-body">
            <div class="expanel expanel-default">
                <div class="expanel-body">
                    <?php
                    echo $this->render("_search", ["model" => $searchModel]);
                    ?> </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php Pjax::begin([
    'id' => 'myGrid',
    'timeout' => 10000,
    'formSelector' => '.myFilterForm'
]); ?>

<div class="tai-san-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'containerOptions' => [
                'style' => 'min-height:300px;',
                'class' => 'kv-grid-container'
            ],
            'pjax' => true,
            'columns' => require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                [
                    'content' =>
                    '
                    <div class="dropdown">
						<button aria-expanded="false" aria-haspopup="true" class="btn dropdown-toggle" data-bs-toggle="dropdown" type="button"><i class="fa fa-navicon"></i></button>
						<div class="dropdown-menu tx-13" style="">
							<h6 class="dropdown-header tx-uppercase tx-11 tx-bold bg-info tx-spacing-1">
								Chọn chức năng</h6>'
                        .
                        Html::a(
                            '<i class="fas fa fa-plus" aria-hiddi="true"></i> Thêm mới',
                            ['create'],
                            ['role' => 'modal-remote', 'title' => 'Thêm mới', 'class' => 'dropdown-item']
                        )
                        .
                        Html::a(
                            '<i class="fas fa fa-sync" aria-hidden="true"></i> Tải lại',
                            [''],
                            ['data-pjax' => 1, 'class' => 'dropdown-item', 'title' => 'Tải lại']
                        )
                        .
                        Html::a(
                            '<i class="fas fa fa-trash" aria-hidden="true"></i>&nbsp; Xóa đã chọn',
                            ["bulkdelete"],
                            [
                                'class' => 'dropdown-item text-secondary',
                                'role' => 'modal-remote-bulk',
                                'data-confirm' => false,
                                'data-method' => false, // for overide yii data api
                                'data-request-method' => 'post',
                                'data-confirm-title' => 'Xác nhận xóa?',
                                'data-confirm-message' => 'Bạn có chắc muốn xóa?'
                            ]
                        )
                        .
                        '
						</div>
					</div>
                    ' .
                        '{export}'
                ],
            ],
            'striped' => false,
            'condensed' => true,
            'responsive' => true,
            'perfectScrollbar' => true,
            'panelHeadingTemplate' => '<div style="width:100%;"><div class="float-start mt-2 text-primary">{title}</div> <div class="float-end">{toolbar}</div></div>',
            'panelFooterTemplate' => '<div style="width:100%;"><div class="float-start">{summary}</div><div class="float-end">{pager}</div></div>',
            'summary' => 'Tổng: {totalCount} dòng dữ liệu',
            'panel' => [
                'headingOptions' => ['class' => 'card-header rounded-bottom-0 card-header text-dark'],
                'heading' => '<i class="typcn typcn-folder-open"></i> DANH SÁCH TÀI SẢN',
                'before' => false,
            ],
            'export' => [
                'options' => [
                    'class' => 'btn'
                ]
            ]
        ]) ?>
    </div>
</div>

<?php Pjax::end(); ?>

<?php Modal::begin([
    'options' => [
        'id' => 'ajaxCrudModal',
        'tabindex' => false // important for Select2 to work properly
    ],
    'dialogOptions' => ['class' => 'modal-xl modal-xxl'],
    'closeButton' => ['label' => '<span aria-hidden=\'true\'>×</span>'],
    'id' => 'ajaxCrudModal',
    'footer' => '', // always need it for jquery plugin
]) ?>

<?php Modal::end(); ?>

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