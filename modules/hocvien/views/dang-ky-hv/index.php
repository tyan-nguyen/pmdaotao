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
use app\modules\hocvien\models\DangKyHv;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\vanban\models\search\VBDenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$user = User::getCurrentUser();
$listTitle = 'Đăng ký học (tại tất cả cơ sở)';
if(!$user->superadmin && $user->noi_dang_ky){
    $listTitle = 'Đăng ký học tại ' . HocVienBase::getLabelNoiDangKyOther($user->noi_dang_ky);
}
$this->title = $listTitle;
$this->params['breadcrumbs'][] = $this->title;
//CrudAsset::register($this);
Yii::$app->params['showTopSearch'] = false;
Yii::$app->params['showSearch'] = true;
Yii::$app->params['showExport'] = false;

//format total count of dataprovider
$totalFmt = number_format($dataProvider->getTotalCount(), 0, ',', '.');
?>
<style>
#crud-datatable-togdata-page{
    border:0px!important;
}
.thay-doi-hang td{
    color:blue !important;
}
.ho-so-da-huy td{
    color:blue !important;
    text-decoration: line-through;
}
.ho-so-bao-luu td{
    color:orange !important;
}
.doi-ngay-sat-hach td{
    color:green !important;
}

/* Tùy chỉnh thanh cuộn giả lập phía trên */
.double-scroll-wrapper::-webkit-scrollbar {
    height: 13px; /* Độ rộng (chiều cao) của thanh cuộn ngang */
}

/* Tùy chỉnh thanh cuộn gốc của GridView */
.kv-grid-container::-webkit-scrollbar {
    height: 13px; 
}

/* Màu nền của thanh cuộn */
.double-scroll-wrapper::-webkit-scrollbar-track,
.kv-grid-container::-webkit-scrollbar-track {
    background: #eae9f1; 
    border-radius: 10px;
}

/* Màu của cục kéo (thumb) */
.double-scroll-wrapper::-webkit-scrollbar-thumb,
.kv-grid-container::-webkit-scrollbar-thumb {
    background: #eae9f1; 
    border-radius: 10px;
    border: 2px solid #f1f1f1; /* Tạo khoảng trắng bao quanh để trông thanh thoát hơn */
}

/* Hiệu ứng khi di chuột vào cục kéo */
.double-scroll-wrapper::-webkit-scrollbar-thumb:hover,
.kv-grid-container::-webkit-scrollbar-thumb:hover {
    background: #b3b1b1; 
}

</style>
<div class="card border-default" id="divFilterExtend" <?= Yii::$app->request->get('DangKyHvSearch') ? 'style="display:block;"' : 'style="display:none;"' ?>>
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

<?php 
   $slVoucher = DangKyHv::find()->where(['label'=>'VOUCHERT11'])->count();
?>

<?php Pjax::begin([
    'id'=>'myGrid',
    'timeout' => 10000,
    'formSelector' => '.myFilterForm'
]); ?>

<div class="van-ban-den-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'containerOptions' => [
                'style' => 'min-height:500px;'
            ],
            //'filterModel' => $searchModel,
            'pjax'=>true,
            'showPageSummary' => true,
            'columns' => require(__DIR__.'/_columns.php'),
            'rowOptions' => function ($model, $key, $index, $grid) {
                if($model->thayDoiHangs != null){
                    return ['class' => 'thay-doi-hang'];
                }
                if($model->huy_ho_so){
                    return ['class' => 'ho-so-da-huy'];
                }
                if($model->baoLuus){
                    return ['class' => 'ho-so-bao-luu'];
                }
                if($model->doiNgaySatHachs){
                    return ['class' => 'doi-ngay-sat-hach'];
                }
            },
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
                    .'<li><hr class="dropdown-divider"></li>'
                    . Html::a('<i class="fas fa-clipboard-list"></i> In DS theo ca', ['report-list'],
                        ['role'=>'modal-remote','title'=> 'In DS theo ca','class'=>'dropdown-item'])
                    /* .'<li><hr class="dropdown-divider"></li>'
                    . Html::a('<i class="fas fa-clipboard-list"></i> Báo cáo DS HV', ['/hocvien/bao-cao/rp-danh-sach-dang-ky'],
                        ['role'=>'modal-remote','title'=> 'Báo cáo danh sách học viên','class'=>'dropdown-item']) */
                    .'<li><hr class="dropdown-divider"></li>'
                    . Html::a('<i class="fas fa-clipboard-list"></i> BB bàn giao hồ sơ', ['/hocvien/bao-cao/rp-bien-ban-ban-giao'],
                        ['role'=>'modal-remote','title'=> 'Biên bản bàn giao hồ sơ','class'=>'dropdown-item'])
                    .'<li><hr class="dropdown-divider"></li>'
                    .'
						</div>
					</div>
                    '.
                    '{toggleData}'
                    .'{export}'
                ],
            ],          
            'striped' => false,
            'condensed' => true,
            'responsive' => true,
            'perfectScrollbar' => true,
            'panelHeadingTemplate'=>'<div style="width:100%;"><div class="float-start mt-2 text-primary">{title}</div> <div class="float-end">{toolbar}</div></div>',
            'panelFooterTemplate'=>'<div style="width:100%;"><div class="float-start">{summary}</div><div class="float-end">{pager}</div></div>',
            'summary'=>'Tổng: <strong>' . $totalFmt . '</strong> dòng dữ liệu',
            'panel' => [
                'headingOptions'=>['class'=>'card-header rounded-bottom-0 card-header text-dark'],
                /*'heading' => '<i class="typcn typcn-folder-open"></i> DANH SÁCH HỌC VIÊN ĐĂNG KÝ (VOUCHER 3TR: <strong>' . $slVoucher . '/150</strong>)',*/
                'heading' => '<i class="typcn typcn-folder-open"></i> DANH SÁCH HỌC VIÊN ĐĂNG KÝ',
                'before'=>false,
            ],
            'export'=>[
                'fontAwesome' => true,
                'showConfirmAlert' => false,
                'target' => GridView::TARGET_BLANK, // xuất ra tab mới
                'filename' => 'ds_hoc_vien' . date('Y-m-d'), // tên file export mặc định
                'options' => [
                    'class' => 'btn'
                ],
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
    'size'=>Modal::SIZE_EXTRA_LARGE
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