<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\modules\hocvien\models\DangKyHv;

class FixController extends Controller
{
    public $freeAccessActions = ['fix-ngay-ht-hs'];
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }
    
    /**
     * fixed ngày hoàn thành hồ sơ
     * dành cho dữ liệu cũ chưa có cột hoàn thành hồ sơ
     */
    public function actionFixNgayHtHs(){
        $hocViens = DangKyHv::find()->all();
        $sl = 0;
        foreach ($hocViens as $iHv=>$hocVien){
            if($hocVien->thoi_gian_hoan_thanh_ho_so == NULL){
                foreach ($hocVien->hvNopHocPhis as $inhp=>$nhp){
                    if($nhp->so_tien_con_lai <= $hocVien->hocPhi->hoc_phi/2){
                        $hocVien->thoi_gian_hoan_thanh_ho_so = $nhp->thoi_gian_tao;
                        $hocVien->updateAttributes(['thoi_gian_hoan_thanh_ho_so']);
                        $sl++;
                        break;
                    }
                }
            }
        }
        echo 'Cập nhật ' .$sl .' dòng';
    }
    
}