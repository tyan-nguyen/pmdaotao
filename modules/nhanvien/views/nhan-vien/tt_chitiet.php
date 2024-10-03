<div class="row">
    <div class="col-xl-12 col-md-12">
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 "style="color: red;">Thông tin công việc: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                    <p><strong>Phòng:</strong> <?= $model->phongBan ? $model->phongBan->ten_phong_ban : 'Chưa có phòng ban' ?></p>
                                    <p><strong>Tổ:</strong> <?= $model->to ? $model->to->ten_to : 'Chưa có tổ'?></p>
                                        <p><strong>Chức vụ:</strong> <?= $model->chuc_vu?></p>
										<p><strong>Vị trí công việc:</strong> <?= $model->vi_tri_cong_viec?></p>
                                        <p><strong>Trạng thái:</strong> <?= $model->trang_thai ?></p>
                                      
								    </div>
						    </div>
	</div>
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 " style="color:red;">Thông tin chuyên môn: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                        <p><strong>Trình độ:</strong> <?= $model->trinh_do ?></p>
                                        <p><strong>Kinh nghiệm làm việc:</strong> <br> <?= $model->kinh_nghiem_lam_viec ?></p> 
								    </div>
						    </div>
	</div>
</div>
