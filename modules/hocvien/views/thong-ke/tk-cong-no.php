<?php 
    use app\widgets\CardWidget;
    use app\modules\user\models\User;
    use app\modules\hocvien\models\DangKyHv;
?>

<?php CardWidget::begin(['title'=>'Tất cả công nợ (Tính đến ' .date('d/m/Y H:i:s') . ')' ]) ?>

<div class="table-responsive border p-0 pt-3">
    <table class="table table-bordered mg-b-0">
        <thead>
            <tr>
                <th width="50px" align="center">STT</th>
                <th>Nhân viên TNHS</th>
                <th>Cơ sở đăng ký</th>
                <th>Công nợ</th>
            </tr>
        </thead>
        <tbody>
        
        <?php 
            $userCongNo = User::find()
                ->where('noi_dang_ky IS NOT NULL')
                ->andFilterWhere(['user_type'=>User::USER_TYPE_NHANHOSO])
                ->orderBy(['noi_dang_ky'=>SORT_ASC])->all();
            $userCongNoCount = User::find()
                ->where('noi_dang_ky IS NOT NULL')
                ->andFilterWhere(['user_type'=>User::USER_TYPE_NHANHOSO])->count();
            $cs = null;
            $sumCS = 0;
            foreach ($userCongNo as $iUsr=>$usr){
                if($iUsr == 0){
                    $cs = $usr->noi_dang_ky;
                }
                
                if($usr->noi_dang_ky != $cs){
        ?>
            <tr>
            	
                <td colspan="3" align="right"><strong>TỔNG CỘNG</strong></td>
                <td align="right"><strong><?= number_format($sumCS) ?></strong></td>
            </tr>
            <?php 
                }
                
                if($usr->noi_dang_ky != $cs){
                    $sumCS = 0;//
                    $cs = $usr->noi_dang_ky;//important
                }
                $sumCS += User::getNoConLaiCuaNhanVien($usr->id,NULL);
             ?>

            <tr>
                <th scope="row"><?= $iUsr+1 ?></th>
                <td><?= $usr->hoTen ?></td>
                <td><?= $usr->noi_dang_ky . ' - ' .DangKyHv::getLabelNoiDangKyOther($usr->noi_dang_ky) ?></td>
                <td align="right"><?= number_format(User::getNoConLaiCuaNhanVien2($usr->id,NULL)) ?></td>
            </tr>
            
            <?php 
            if($userCongNoCount == ($iUsr+1)){
            ?>
            <tr>
                <td colspan="3"  align="right"><strong>TỔNG CỘNG</strong></td>
                <td align="right"><strong><?= number_format($sumCS) ?></strong></td>
            </tr>
            <?php 
                }
            ?>
				
            
        <?php } ?>
        
        <tr>
                <td colspan="3" align="right"><strong>TỔNG CỘNG CÔNG NỢ</strong></td>
                <td align="right"><strong><?= number_format(User::getNoConLaiCuaTatCaHocVien(NULL)) ?></strong></td>
            </tr>
        
        </tbody>
    </table>
</div>

<?php CardWidget::end()?>