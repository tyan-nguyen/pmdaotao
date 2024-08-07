<?php

use yii\widgets\DetailView;
use app\modules\dungchung\models\History;
use app\modules\kholuutru\models\KhoLuuTru;
use app\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */
?>
<div class="panel panel-primary">
	<div class="tab-menu-heading tab-menu-heading-boxed">
		<div class="tabs-menu-boxed">
			<!-- Tabs -->
			<ul class="nav panel-tabs" role="tablist">
				<li><a href="#tab1" class="active" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
					Thông tin chung
				</a></li>
				<li><a href="#tab2" data-bs-toggle="tab" aria-selected="true" role="tab">
					Lịch sử thay đổi
				</a></li>
				<!-- <li><a href="#tab28" data-bs-toggle="tab" aria-selected="false" role="tab" class="" tabindex="-1">Tab 4</a></li> -->
			</ul>
		</div>
	</div>
 	
 	<div class="panel-body tabs-menu-body ps">
		<div class="tab-content">
			<div class="tab-pane  active show" id="tab1" role="tabpanel">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    'username',
                    'auth_key',
                   // 'password_hash',
                    'confirmation_token',
                    [
                        'attribute'=>'status',
                        'value'=>User::getStatusValue($model->status),
                    ],
                    //'superadmin',
                    //'created_at',
                   // 'updated_at',
                    'registration_ip',
                    'bind_to_ip',
                    'email:email',
                    //'email_confirmed:email',
                ],
            ]) ?>
            </div>
			
			<div class="tab-pane" id="tab2" role="tabpanel">
				<?= History::showHistory(KhoLuuTru::MODEL_ID, $model->id) ?>
			</div>
	</div>
	</div>

</div>