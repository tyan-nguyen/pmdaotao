<?php 
use app\modules\user\models\Dashboard;
use yii\bootstrap5\Modal;
use cangak\ajaxcrud\CrudAsset; 
use app\modules\user\models\User;

Yii::$app->params['showTopSearch'] = false;
Yii::$app->params['moduleID'] = 'Home';
Yii::$app->params['modelID'] = 'Dashboard';
CrudAsset::register($this);
$dash = new Dashboard();
?>

<?php Modal::begin([
   'options' => [
        'id'=>'ajaxCrudModal',
        'tabindex' => false // important for Select2 to work properly
   ],
   'dialogOptions'=>['class'=>'modal-xl'],
   'headerOptions'=>['class'=>'text-primary'],
   'titleOptions'=>['class'=>'text-primary'],
   'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal',
   'footer'=>'',// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<?php if (User::hasRole('nGiaoVien',false)):?>
<div class="row">
	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
		<div class="card custom-card service">
			<div class="card-body">
				<div class="item-box text-center">
					<div class=" text-center text-success mb-2"><i class="fa fa-users"></i>
					</div>
					<div class="item-box-wrap">
						<h5 class="mb-2">
							<a href="/daotao/ql-hoc-vien?menu=hv2">Danh sách học viên</a>
						</h5>
						<p class="text-muted mb-0">Danh sách học viên phụ trách</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
		<div class="card custom-card service">
			<div class="card-body">
				<div class="item-box text-center">
					<div class=" text-center mb-2 text-primary"><i class="fa fa-graduation-cap"></i>
					</div>
					<div class="item-box-wrap">						
						<h5 class="mb-2">
							<a href="/daotao/ke-hoach-giao-vien?menu=hv1">Kế hoạch giảng dạy</a>
						</h5>				
						<p class="text-muted mb-0">Sắp xếp lịch học thực hành</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
		<div class="card custom-card service">
			<div class="card-body">
				<div class="item-box text-center">
					<div class=" text-center mb-2 text-primary"><i class="fa fa-graduation-cap"></i>
					</div>
					<div class="item-box-wrap">						
						<h5 class="mb-2">
							<a href="/user/auth/change-own-password">Đổi mật khẩu</a>
						</h5>				
						<p class="text-muted mb-0">Thay đổi mật khẩu</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<?php elseif(User::hasRole('nToThueXe',false)): ?>
<div class="row">
	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
		<div class="card custom-card service">
			<div class="card-body">
				<div class="item-box text-center">
					<div class=" text-center text-success mb-2"><i class="fa fa-users"></i>
					</div>
					<div class="item-box-wrap">
						<h5 class="mb-2">
							<a href="/thuexe/lich-thue/xe-schedule?menu=ttx1&id=4">Lịch theo xe</a>
						</h5>
						<p class="text-muted mb-0">Xem lịch thuê theo từng xe cụ thể</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
		<div class="card custom-card service">
			<div class="card-body">
				<div class="item-box text-center">
					<div class=" text-center mb-2 text-primary"><i class="fa fa-graduation-cap"></i>
					</div>
					<div class="item-box-wrap">						
						<h5 class="mb-2">
							<a href="/thuexe/lich-thue/index-public?menu=ttx4">Danh sách hôm nay</a>
						</h5>				
						<p class="text-muted mb-0">Xem danh sách thuê xe hôm nay</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
		<div class="card custom-card service">
			<div class="card-body">
				<div class="item-box text-center">
					<div class=" text-center mb-2 text-primary"><i class="fa fa-graduation-cap"></i>
					</div>
					<div class="item-box-wrap">						
						<h5 class="mb-2">
							<a href="/thuexe/lich-thue/loai-xe-schedule-by-columns?menu=ttx3&id=2">Lịch (theo cột)</a>
						</h5>				
						<p class="text-muted mb-0">Xem lịch thuê tổng hợp theo hạng xe</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
		<div class="card custom-card service">
			<div class="card-body">
				<div class="item-box text-center">
					<div class=" text-center mb-2 text-primary"><i class="fa fa-graduation-cap"></i>
					</div>
					<div class="item-box-wrap">						
						<h5 class="mb-2">
							<a href="/user/auth/change-own-password">Đổi mật khẩu</a>
						</h5>				
						<p class="text-muted mb-0">Thay đổi mật khẩu</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<?php elseif(User::hasRole('nThue',false)): ?>
<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
		<div class="card custom-card service">
			<div class="card-body">
				<div class="item-box text-center">
					<div class=" text-center mb-2 text-primary"><i class="fa fa-graduation-cap"></i>
					</div>
					<div class="item-box-wrap">						
						<h5 class="mb-2">
							<a href="/user/auth/change-own-password">Đổi mật khẩu</a>
						</h5>				
						<p class="text-muted mb-0">Thay đổi mật khẩu</p>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php elseif (User::hasRole('nDaoTao',false)):?>
<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
    	<div class="card custom-card service">
    		<div class="card-body">
    			<div class="item-box text-center">
    				<div class=" text-center text-danger mb-2"><i class="fa fa-users"></i>
    				</div>
    				<div class="item-box-wrap">
    					<h5 class="mb-2">
    						<a href="/hocvien/hv-ho-so?menu=hv4">Quản lý học viên</a>
    					</h5>
    					<p class="text-muted mb-0">Quản lý thông tin học viên, 
    						học phí</p>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
    	<div class="card custom-card service">
    		<div class="card-body">
    			<div class="item-box text-center">
    				<div class=" text-center mb-2 text-primary"><i class="fa fa-graduation-cap"></i>
    				</div>
    				<div class="item-box-wrap">						
    					<h5 class="mb-2">
    						<a href="/daotao/ke-hoach?menu=hv5">Kế hoạch giảng dạy</a>
    					</h5>				
    					<p class="text-muted mb-0">Sắp xếp lịch học thực hành GV-HV</p>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    	
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
    	<div class="card custom-card service">
    		<div class="card-body">
    			<div class="item-box text-center">
    				<div class=" text-center mb-2 text-primary"><i class="fa fa-graduation-cap"></i>
    				</div>
    				<div class="item-box-wrap">						
    					<h5 class="mb-2">
    						<a href="/user/auth/change-own-password">Đổi mật khẩu</a>
    					</h5>				
    					<p class="text-muted mb-0">Thay đổi mật khẩu</p>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>	
<?php elseif (User::hasRole('nXem',false)):?>
<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
    	<div class="card custom-card service">
    		<div class="card-body">
    			<div class="item-box text-center">
    				<div class=" text-center text-danger mb-2"><i class="fa fa-users"></i>
    				</div>
    				<div class="item-box-wrap">
    					<h5 class="mb-2">
    						<a href="/hocvien/hv-ho-so?menu=thongke4">Quản lý học viên</a>
    					</h5>
    					<p class="text-muted mb-0">Quản lý thông tin học viên, khóa học, hạng đào tạo</p>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
    	<div class="card custom-card service">
    		<div class="card-body">
    			<div class="item-box text-center">
    				<div class=" text-center mb-2 text-primary"><i class="fa fa-graduation-cap"></i>
    				</div>
    				<div class="item-box-wrap">						
    					<h5 class="mb-2">
    						<a href="/hocvien/thong-ke/thong-ke-ho-so-moi?menu=thongke1">Thống kê học viên đăng ký mới</a>
    					</h5>				
    					<p class="text-muted mb-0">Xem thống kê số lượng học viên đăng ký theo ngày</p>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    	
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
    	<div class="card custom-card service">
    		<div class="card-body">
    			<div class="item-box text-center">
    				<div class=" text-center mb-2 text-primary"><i class="fa fa-graduation-cap"></i>
    				</div>
    				<div class="item-box-wrap">						
    					<h5 class="mb-2">
    						<a href="/user/auth/change-own-password">Đổi mật khẩu</a>
    					</h5>				
    					<p class="text-muted mb-0">Thay đổi mật khẩu</p>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>	
<?php else:?>
<div class="row">

	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
		<div class="card custom-card service">
			<div class="card-body">
				<div class="item-box text-center">
					<div class=" text-center mb-2 text-info"><i class="fa fa-graduation-cap"></i>
					</div>
					<div class="item-box-wrap">						
						<h5 class="mb-2">
							<a href="/hocvien/thong-ke/tong-hop?menu=hv8">Thống kê - Công nợ</a>
						</h5>				
						<p class="text-muted mb-0">Thống kê học viên, công nợ</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
		<div class="card custom-card service">
			<div class="card-body">
				<div class="item-box text-center">
					<div class=" text-center text-danger mb-2"><i class="fa fa-users"></i>
					</div>
					<div class="item-box-wrap">
						<h5 class="mb-2">
							<a href="/hocvien/dang-ky-hv?menu=hv1">Quản lý học viên đăng ký</a>
						</h5>
						<p class="text-muted mb-0">Quản lý thông tin học viên, 
							học phí</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
		<div class="card custom-card service">
			<div class="card-body">
				<div class="item-box text-center">
					<div class=" text-center text-success mb-2"><i class="fa fa-users"></i>
					</div>
					<div class="item-box-wrap">
						<h5 class="mb-2">
							<a href="/hocvien/hoc-phi/phieu-thu?menu=hv6">Quản lý phiếu thu</a>
						</h5>
						<p class="text-muted mb-0">Quản lý phiếu thu tiền học phí</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
		<div class="card custom-card service">
			<div class="card-body">
				<div class="item-box text-center">
					<div class=" text-center mb-2 text-primary"><i class="fa fa-graduation-cap"></i>
					</div>
					<div class="item-box-wrap">						
						<h5 class="mb-2">
							<a href="/daotao/ke-hoach?menu=dt5">Kế hoạch giảng dạy</a>
						</h5>				
						<p class="text-muted mb-0">Sắp xếp lịch học thực hành GV-HV</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<?php endif;?>

<div class="row">
	<div class="col-sm-12">
        <div class="card custom-card">
        	<div class="card-body" style="width: 100%; height:450px">
        		<img src="/libs/images/anhtruonglai.jpg" alt="img" style="width: 100%; height: 100%; object-fit: cover;">
        	</div>
        </div>
    </div>
</div>

