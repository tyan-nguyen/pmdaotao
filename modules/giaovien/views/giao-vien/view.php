<?



/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\NhanVien */
?>
<div class="nhan-vien-view">
    <div class="row">
    <div class="col-xl-3 col-md-12">
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 "style="color: red;">Thông tin cá nhân: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                        <p><strong>Họ Tên:</strong> <?= $model->ho_ten ?></p>
                                        <p><strong>Giới tính:</strong> <?= $model->gioi_tinh == 1 ? 'Nam' : 'Nữ' ?></p>
                                        <p><strong>Số CCCD:</strong> <?= $model->so_cccd ?></p>
                                        <p><strong>Địa Chỉ:</strong> <?= $model->dia_chi ?></p>
                                        <p><strong>Điện Thoại:</strong> <?= $model->dien_thoai ?></p>
                                        <p><strong>Email:</strong> <?= $model->email ?></p>
                                        <p><strong>Mã số thuế:</strong> <?= $model->ma_so_thue ?></p>
                                        <p><strong>Tài khoản:</strong> <?= $model->taiKhoan->username ?></p>
								    </div>
						    </div>
	</div>
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 "style="color: red;">Thông tin công việc: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                    <p><strong>Phòng:</strong> <?= $model->phongBan->ten_phong_ban ?></p>
                                    <p><strong>Tổ:</strong> <?= $model->to->ten_to ?></p>
                                        <p><strong>Chức vụ:</strong> <?= $model->chuc_vu?></p>
                                        <p><strong>Trạng thái:</strong> <?= $model->trang_thai ?></p>
								    </div>
						    </div>
	</div>
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 "style="color:red;">Thông tin chuyên môn: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                        <p><strong>Trình độ:</strong> <?= $model->trinh_do ?></p>
                                        <p><strong>Kinh nghiệm làm việc:</strong> <?= $model->kinh_nghiem_lam_viec ?></p>
                                        
                                      
								    </div>
						    </div>
	</div>
</div>


        <div class="col-xl-9 col-md-12">
        
        <div class="card custom-card">
            <div class="card-header custom-card-header rounded-bottom-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="list-tab" data-bs-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true"style="color: blue;"><i class="fa fa-legal"></i>  Phân công giảng dạy</a>
                    </li>
                  
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="add-timetable-tab" data-bs-toggle="tab" href="#add-timetable" role="tab" aria-controls="add-student" aria-selected="false"style="color: blue;"><i class="fa fa-calendar"></i> Lịch dạy</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="add-document-tab" data-bs-toggle="tab" href="#add-document" role="tab" aria-controls="add-student" aria-selected="false"style="color: blue;"><i class="fa fa-file"></i> Hồ sơ</a>
                    </li>
                </ul>
			</div>
                   <div class="card-body">
                      <div class="skill-tags">
                        <div class="tab-content" id="myTabContent">
                        <!-- Nội dung Danh sách lớp -->
                            <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                        <!-- Nội dung hiển thị khi click vào "Phân công giảng dạy" -->
                               
                                <?= $this->render('phan_cong_day', ['model' => $model]) ?> 
                            </div>
                             <!-- Nội dung Lịch học -->
                             <div class="tab-pane fade" id="add-timetable" role="tabpanel" aria-labelledby="add-timetable-tab">
                        <!-- Nội dung hiển thị khi click vào "Thêm học viên" -->
                                <h3>Lịch học</h3>
                                <p>Hiển thị lịch dạy tại đây.</p>
                              
                            </div>
                              <!-- Nội dung Tài liệu khóa học -->
                              <div class="tab-pane fade" id="add-document" role="tabpanel" aria-labelledby="add-document-tab">
                        <!-- Nội dung hiển thị khi click vào "Thêm học viên" -->
                              
                        <?= $this->render('ho_so_gv',['model'=>$model])?>
                              
                            </div>
                        </div>
                      </div>
                  </div>
        </div>
    </div>

        </div>
    </div>

   

<style>
.info-box {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 15px;
    background-color: #f9f9f9;
    margin-bottom: 15px;
}
.info-box p {
    margin: 0;
    padding: 5px 0;
}
.info-box strong {
    display: inline-block;
    width: 150px; /* Hoặc chiều rộng phù hợp với yêu cầu */
}
</style>
<script>
function reloadDay() {
    // Logic đơn giản để kiểm tra hoạt động của hàm
    console.log('Hàm reloadDay() đã được gọi.');
    alert('Hàm reloadDay() đã hoạt động.');
}
</script>