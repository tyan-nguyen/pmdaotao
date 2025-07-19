<div class="card custom-card">
    <div class="card-header custom-card-header rounded-bottom-0">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="add-detail-tab" data-bs-toggle="tab" href="#add-detail" role="tab" aria-controls="add-detail" aria-selected="false"style="color: blue;"><i class="fa fa-address-card"></i> Thông tin hàng hóa </a>
            </li>
            <?php if($model->co_ton_kho){ ?>
          	<li class="nav-item" role="presentation">
                <a class="nav-link" id="add-detail-tab" data-bs-toggle="tab" href="#tabTonKho" role="tab" aria-controls="tabTonKho" aria-selected="false"style="color: blue;"><i class="fa fa-cart-arrow-down"></i> Tồn kho </a>
            </li>
            <?php } ?>
        </ul>
    </div>
   <div class="card-body">
      <div class="skill-tags">
      
        <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="add-detail" role="tabpanel" aria-labelledby="add-detail-tab">
                    <!-- hàng hóa -->
                    <?= $this->render('view_hang_hoa', ['model' => $model]) ?>
              </div>
              <?php if($model->co_ton_kho){ ?>
               <div class="tab-pane fade show" id="tabTonKho" role="tabpanel" aria-labelledby="tabTonKho-tab">
                    <!-- tồn kho -->
                    <?= $this->render('view_ton_kho', [
                        'model' => $model->getLichSuTonKho()->orderBy(['id'=>SORT_DESC])->all()
                    ]) ?>
              </div>
              <?php } ?>
        </div>
        
      </div>
   </div>
</div>
