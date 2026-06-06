<?php
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\vanban\models\search\VBDenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Xe';
$this->params['breadcrumbs'][] = $this->title;
//CrudAsset::register($this);
Yii::$app->params['showSearch'] = true;
Yii::$app->params['showExport'] = true;
?>

<style>
#crud-datatable-togdata-page{
    border:0px!important;
}
</style>

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

<div class="card border-default" id="divFilterExtend">
	<div class="card-header rounded-bottom-0 card-header text-dark" id="simple">
		<h5 class="mt-2"><i class="fe fe-search"></i> Tìm kiếm</h5>
	</div>
	<div class="card-body text-center">
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
    'id'=>'myGrid',
    'timeout' => 10000,
    'formSelector' => '.myFilterForm'
]); ?>

<div class="xe-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'containerOptions' => [
                'style' => 'min-height:500px;',
                'class' => 'kv-grid-container'
            ],
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    '
                    <div class="dropdown">
						<button aria-expanded="false" aria-haspopup="true" class="btn dropdown-toggle" data-bs-toggle="dropdown" type="button"><i class="fa fa-navicon"></i></button>
						<div class="dropdown-menu tx-13" style="">
							<h6 class="dropdown-header tx-uppercase tx-11 tx-bold bg-info tx-spacing-1">
								Chọn chức năng</h6>'
                    .
                    Html::a('<i class="fas fa fa-plus" aria-hiddi="true"></i> Thêm mới', ['create'],
                        ['role'=>'modal-remote','title'=> 'Thêm mới','class'=>'dropdown-item'])
                    .
                    Html::a('<i class="fas fa fa-sync" aria-hidden="true"></i> Tải lại', [''],
                        ['data-pjax'=>1, 'class'=>'dropdown-item', 'title'=>'Tải lại'])
                    .
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
                    .
                    '
						</div>
					</div>
                    '.
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => false,
            'condensed' => true,
            'responsive' => true,
            'perfectScrollbar' => true,
            'panelHeadingTemplate'=>'<div style="width:100%;"><div class="float-start mt-2 text-primary">{title}</div> <div class="float-end">{toolbar}</div></div>',
            'panelFooterTemplate'=>'<div style="width:100%;"><div class="float-start">{summary}</div><div class="float-end">{pager}</div></div>',
            'summary'=>'Tổng: {totalCount} dòng dữ liệu',
            'panel' => [
                'headingOptions'=>['class'=>'card-header rounded-bottom-0 card-header text-dark'],
                'heading' => '<i class="typcn typcn-folder-open"></i> DANH SÁCH XE',
                'before'=>false,
            ],
            'export'=>[
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
                    'filename' => 'ds_xe_' . date('Y-m-d'),
                    'options' => ['title' => 'Danh sách xe'],
                    'config' => [
                        'worksheet' => 'DS Xe',
                        'cssFile' => '', // nếu cần
                    ],
                ],
                GridView::PDF => [
                    'label' => 'Xuất PDF',
                    'filename' => 'ds_hoc_vien_' . date('Y-m-d'),
                    'options' => ['title' => 'Danh sách xe'],
                    'config' => [
                        'methods' => [
                            'SetHeader' => ['DANH SÁCH XE|DANH SÁCH|Xuất ngày: ' . date("d/m/Y")],
                            'SetFooter' => ['|Trang {PAGENO}|'],
                        ],
                        'options' => [
                            'title' => 'Danh sách xe',
                            'subject' => 'Xuất file PDF',
                            'keywords' => 'export, pdf,',
                        ],
                    ],
                ],
            ],
        ])?>
    </div>
    
</div>

<?php Pjax::end(); ?>

<?php Modal::begin([
   'options' => [
        'id'=>'ajaxCrudModal',
        'tabindex' => false // important for Select2 to work properly
   ],
   //'dialogOptions'=>['class'=>'modal-lg'],
   'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal',
    'footer'=>'',// always need it for jquery plugin
    'size'=>Modal::SIZE_EXTRA_LARGE
])?>

<?php Modal::end(); ?>

<?php Modal::begin([
   'options' => [
        'id'=>'ajaxCrudModal2',
        'tabindex' => false // important for Select2 to work properly
   ],
  // 'dialogOptions'=>['class'=>'modal-lg'],
   'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal2',
    'footer'=>'',// always need it for jquery plugin
    'size'=>Modal::SIZE_LARGE
])?>

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


<script>
//su dung trong form xoa hinh anh
$(document).on('click', '.btn-delete-image', function () {
    const imageId = $(this).data('id'); 
    const parentDiv = $(this).closest('.col-md-4'); 

    if (confirm('Bạn có chắc chắn muốn xóa hình này không?')) {
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['delete-single-image']) ?>', 
            type: 'POST',
            data: {id: imageId}, 
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    parentDiv.fadeOut(300, function () { 
                        $(this).remove();
                    });
                } else {
                    alert(response.message);
                }
            },
        });
    }
});

$(document).on('click', '.btn-make-primary', function () {
    const imageId = $(this).data('id'); 
    const parentDiv = $(this).closest('.col-md-4'); 

    if (confirm('Bạn có chắc chắn muốn đặt hình này làm hình đại diện cho xe?')) {
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['make-img-primary']) ?>', 
            type: 'POST',
            data: {id: imageId}, 
            success: function (response) {
                alert(response.message);
            },
        });
    }
});

</script>