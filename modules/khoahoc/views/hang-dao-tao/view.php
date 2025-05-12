<?php

use yii\widgets\DetailView;
use app\modules\user\models\User;
use app\custom\CustomFunc;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\khoahoc\models\HangDaoTao */
?>
<div class="hang-dao-tao-view">
 
<div class="row">
    <div class="col-xl-3 col-md-12">
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
                        <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin hạng đào tạo:</h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                        <p><strong>Tên hạng:</strong> <?= $model->ten_hang?></p>
                                        <p><strong>Ghi chú:</strong> <?= $model->ghi_chu?></p>
                                        <p><strong>Người tạo:</strong> <?= User::findOne($model->nguoi_tao)?User::findOne($model->nguoi_tao)->getHoTen():'' ?></p>
                                        <p><strong>Ngày tạo:</strong> <?= CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_tao)?></p>
								    </div>
						    </div>
	</div>

    </div>
    <div class="col-xl-9 col-md-12">
    <div class="card custom-card">
        <div class="card-header custom-card-header rounded-bottom-0">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="add-document-tab" data-bs-toggle="tab" href="#add-document" role="tab" aria-controls="add-student" aria-selected="true" style="color: blue;">
                        <i class="fa fa-file-image-o"></i> Thông tin module học
                    </a>
                </li>     
            </ul>
        </div>
        <div class="card-body">
            <div class="skill-tags">
                <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="add-document" role="tabpanel" aria-labelledby="add-document-tab">
                 <?= Html::a( '<i class="fa fa-plus"> </i> ',
                        ['/daotao/hang-mon-hoc/create-from-hang', 
                         'idHang' => $model->id
                        ],
                        [
                            'class'=>'btn btn-primary',
                            'title' => 'Thêm module',
                            'style' => 'color: white;',
                            'role'=>'modal-remote-2'
                        ]
                    ) ?>
                		<div id="monHocContent">
                			<?= $this->render('../../../daotao/views/hang-mon-hoc/_viewFromHang', ['model'=>$model->listModule]) ?>                			
                		</div>
    
				</div>

                </div>
            </div>
        </div>
    </div>
</div>

</div>

</div>


