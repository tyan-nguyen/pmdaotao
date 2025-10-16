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

if(!empty($searchModel->ngay_sinh_tu)){
    $searchModel->ngay_sinh_tu = CustomFunc::convertYMDToDMY($searchModel->ngay_sinh_tu);
}
if(!empty($searchModel->ngay_sinh_den)){
    $searchModel->ngay_sinh_den = CustomFunc::convertYMDToDMY($searchModel->ngay_sinh_den);
}

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
    'id'=>'myGrid',
    'timeout' => 10000,
    'formSelector' => '.myFilterForm'
]); ?>

<div class="van-ban-den-index">
    <div id="ajaxCrudDatatable">
    
    	<?php if (!empty($searchModel->gioi_tinh) || !empty($searchModel->noi_dang_ky) || !empty($searchModel->id_hang) || !empty($searchModel->ngay_sinh_tu) || !empty($searchModel->ngay_sinh_den
    	    || !empty($searchModel->tuoi_tu) || !empty($searchModel->tuoi_den) )
            	    || !empty($searchModel->id_khoa_hoc) ): ?>
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
                            </ul>
                        </div>             
    				
                	<h4 style="margin-top:10px"><strong>Tổng cộng: </strong><?php echo $totalFmt ?> kết quả.</h4>
                </div>
            </div>  
        <?php endif; ?>
    
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pjax'=>true,
            //'showPageSummary' => true,
            'columns' => require(__DIR__.'/luu-luong/_columns.php'),
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
                    /* .
                    Html::a('<i class="fas fa fa-plus" aria-hiddi="true"></i> Thêm mới', ['create'],
                        ['role'=>'modal-remote','title'=> 'Thêm mới','class'=>'dropdown-item']) */
                    .
                    Html::a('<i class="fas fa fa-sync" aria-hidden="true"></i> Tải lại', [''],
                        ['data-pjax'=>1, 'class'=>'dropdown-item', 'title'=>'Tải lại'])
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
            'responsive' => false,
            'panelHeadingTemplate'=>'<div style="width:100%;"><div class="float-start mt-2 text-primary">{title}</div> <div class="float-end">{toolbar}</div></div>',
            'panelFooterTemplate'=>'<div style="width:100%;"><div class="float-start">{summary}</div><div class="float-end">{pager}</div></div>',
            'summary'=>'Tổng: <strong>' . $totalFmt . '</strong> dòng dữ liệu',
            'panel' => [
                'headingOptions'=>['class'=>'card-header rounded-bottom-0 card-header text-dark'],
                'heading' => '<i class="typcn typcn-folder-open"></i> DANH SÁCH HỌC VIÊN',
                'before' => false,
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