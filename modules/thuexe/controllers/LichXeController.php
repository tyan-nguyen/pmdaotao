<?php

namespace app\modules\thuexe\controllers;

use app\custom\CustomFunc;
use app\modules\daotao\models\KeHoach;
use app\modules\daotao\models\TietHoc;
use app\modules\demxe\models\DemXe;
use app\modules\thuexe\models\LichDungXe;
use app\modules\thuexe\models\LichThue;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\thuexe\models\Xe;
use app\modules\thuexe\models\LoaiXe;
use app\modules\user\models\User;
use yii\helpers\Url;

/**
 * LichThueController implements the CRUD actions for LichThue model.
 */
class LichXeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'ghost-access' => [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * get lịch của xe: lich giao vien (da hoan thanh/da len lich/da qua thoi gian)
     */
    public function actionLichXeGv($idxe)
    {
        $model = Xe::findOne($idxe);
        return $this->render('lich-xe-gv', [
            'model' => $model
        ]);
    }

    /**
     * get thoi gian su dung xe thuc te//ket noi phan mem dem xe <duong truong>
     */
    public function actionXeLive($idxe)
    {
        $model = Xe::findOne($idxe);
        return $this->render('xe-live', [
            'model' => $model
        ]);
    }

    /**
     * get thoi gian su dung xe thuc te//ket noi phan mem dem xe <trong san>
     */
    public function actionXeLiveTrongSan($idxe)
    {
        $model = Xe::findOne($idxe);
        return $this->render('xe-live-trong-san', [
            'model' => $model
        ]);
    }

    /**
     * get lịch của xe: lich giao vien (da hoan thanh/da len lich/da qua thoi gian) so sanh voi thuc te
     */
    public function actionLichXeGvSoSanhEventsData($idxe)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Xe::findOne($idxe);
        //$contactLog = ContactLogPolicy::getContactLogByStaff();
        //lấy từ 30 ngày gần nhất ->tương lai
        $fromDate = date('Y-m-d 00:00:00', strtotime('-30 days'));
        // SORT_ASC quan trọng để tính gộp
        $contactLog = TietHoc::find()->alias('t')
            ->joinWith(['keHoach k'])
            ->andWhere(['t.id_xe' => $model->id])
            ->andWhere(['>=', 't.thoi_gian_bd', $fromDate])
            //->andWhere(['IN', 'k.trang_thai_duyet', KeHoach::getDmTrangThaiForLichSuDungXe()])
            ->andWhere(['k.trang_thai_duyet' => KeHoach::getDmTrangThaiForLichSuDungXe()])
            ->orderBy(['t.thoi_gian_bd' => SORT_ASC])->all();
        //$colorList = ContactLogForm::getStatusColorHexList();
        $colorList = TietHoc::getDmTrangThaiColor();
        $eventData = [];

        $merged = [];
        $current = null;

        foreach ($contactLog as $item) {
            $start = $item->thoi_gian_bd;
            $end   = $item->thoi_gian_kt;

            $gv = $item->giaoVien ? $item->giaoVien->ho_ten : '';
            $hv = $item->hocVien ? $item->hocVien->ho_ten : '';
            $idHv = $item->id_hoc_vien;
            $trangThai = $item->trang_thai;
            $color = $colorList[$trangThai] ?? '#000';
            $bienSoXe = $item->xe->bien_so_xe;
            $monHoc = $item->monHoc->ten_mon;

            if ($current === null) {
                // bắt nhóm đầu tiên
                $current = [
                    'start' => $start,
                    'end' => $end,
                    'giao_vien' => $gv,
                    'hoc_vien' => $hv,
                    'id_hoc_vien' => $idHv,
                    'trang_thai' => $trangThai,
                    'mon_hoc' => $monHoc,
                    'color' => $color,
                    'bien_so_xe' => $bienSoXe
                ];
            } else {
                // Điều kiện gộp:
                // 1. Liền kề về thời gian
                // 2. Cùng học viên
                // 3. Cùng trạng thái
                // 4. Cùng môn học
                if (
                    $start == $current['end'] &&
                    $idHv == $current['id_hoc_vien'] &&
                    $trangThai == $current['trang_thai'] &&
                    $monHoc = $current['mon_hoc']
                ) {
                    // gộp: tăng giờ kết thúc
                    $current['end'] = $end;
                } else {
                    // đóng nhóm cũ, mở nhóm mới
                    $merged[] = $current;

                    $current = [
                        'start' => $start,
                        'end' => $end,
                        'giao_vien' => $gv,
                        'hoc_vien' => $hv,
                        'id_hoc_vien' => $idHv,
                        'trang_thai' => $trangThai,
                        'mon_hoc' => $monHoc,
                        'color' => $color,
                        'bien_so_xe' => $bienSoXe
                    ];
                }
            }
        }

        // đẩy nhóm cuối
        if ($current !== null) {
            $merged[] = $current;
        }

        $eventData = [];

        foreach ($merged as $m) {
            $eventData[] = [
                'title' => 'GV: ' . $m['giao_vien'] . '<br>HV: ' . $m['hoc_vien'],
                'description' => 'Xe:' . $m['bien_so_xe'] . '<br>GV: ' . $m['giao_vien'] . ' - HV: ' . $m['hoc_vien']
                    . ' dạy từ ' . CustomFunc::convertYMDHISToDMYHI($m['start'])
                    . ' đến ' . CustomFunc::convertYMDHISToDMYHI($m['end'])
                    . '<br>Môn học: ' . $m['mon_hoc']
                    . '<br>Trạng thái: ' . TietHoc::getDmTrangThai()[$m['trang_thai']],
                'start' => $m['start'],
                'end' => $m['end'],
                'backgroundColor' => $m['color'],
                'resourceId' => 'collich'
            ];
        }
        //lịch dùng xe add to list lịch (sét màu đen)
        $lichDungXes = LichDungXe::find()->where([
            'id_xe' => $model->id,
            'trang_thai' => LichDungXe::TT_ACTIVE
        ])->andWhere(['>=', 'thoi_gian_bat_dau', $fromDate])->all();
        foreach ($lichDungXes as $item) {
            $eventData[] = [
                'title' => 'Phụ trách: ' . $item->nguoiPhuTrach->ho_ten,
                'description' => 'Xe:' . $item->xe->bien_so_xe . '<br>'
                    . 'Từ ' . CustomFunc::convertYMDHISToDMYHI($item->thoi_gian_bat_dau)
                    . ' đến ' . CustomFunc::convertYMDHISToDMYHI($item->thoi_gian_ket_thuc)
                    . '<br>Nội dung: ' . $item->noi_dung
                    . '<br>Trạng thái: ' . LichDungXe::getDmTrangThai()[$item->trang_thai],
                'start' => $item->thoi_gian_bat_dau,
                'end' => $item->thoi_gian_ket_thuc,
                'backgroundColor' => '#212121',
                'resourceId' => 'collich'
            ];
        }


        //$contactLog = ContactLogPolicy::getContactLogByStaff();
        $contactLog = LichThue::find()
            //->joinWith(['xe as x'])
            ->andWhere(['id_xe' => $model->id])
            ->andWhere(['>=', 'thoi_gian_bat_dau', $fromDate])
            ->orderBy(['thoi_gian_tao' => SORT_DESC])
            //->andWhere(['x.id_loai_xe'=>$model->id])
            ->all();

        //$colorList = ContactLogForm::getStatusColorHexList();
        $colorList = LichThue::getTrangThaiColor();
        //$eventData = [];
        foreach ($contactLog as $item) {
            $startTime = $item->thoi_gian_bat_dau;
            $endTime = $item->thoi_gian_ket_thuc;
            //$backgroundColor = '#ffc107';
            // $backgroundColor = '#ddd';

            if ($item->trang_thai !== null) {
                $backgroundColor = $colorList[$item->trang_thai];
            }

            if (LichThue::checkLichDangHieuLucChuaXuatHoaDon($item->id)) {
                $backgroundColor = '#fca13a';
            } else if (LichThue::checkLichDangHieuLucDaXuatHoaDon($item->id)) {
                $backgroundColor = '#54b75c';
            } else if (LichThue::checkLichSapToi($item->id)) {
                $backgroundColor = '#ff0000';
            }

            //$calendarTitle = $item->so_gio >= 2 ? ('Xe ' . $item->xe->ma_so . ' - ' . $item->xe->bien_so_xe) : ('Xe ' . $item->xe->ma_so);
            $calendarTitle = 'Xe ' . $item->xe->ma_so;
            //$calendarDescription = $item->so_gio >=2 ? '' : ('Biển số ' .$item->xe->bien_so_xe . ' - ');
            $calendarDescription = 'Biển số ' . $item->xe->bien_so_xe . ' - ';
            $calendarDescription .= 'GV: ' . ($item->giaoVien ? $item->giaoVien->ho_ten : '') . ' - HV: '
                . ($item->khachHang ? $item->khachHang->ho_ten : '') . ' thuê từ ' . CustomFunc::convertYMDHISToDMYHI($startTime) . ' đến ' . CustomFunc::convertYMDHISToDMYHI($endTime);
            $eventData[] = [
                'title' => $calendarTitle,
                'description' => $calendarDescription,
                'start' => $startTime,
                'end' => $endTime,
                'url' => Url::to([(User::hasRole('nToThueXe', false) ? '/thuexe/lich-thue/view-public' : '/thuexe/lich-thue/update'), 'id' => $item->id, 'force_close' => 'true']),
                'extendedProps' => [
                    'role' => 'modal-remote',
                ],
                'backgroundColor' => $backgroundColor,
                'resourceId' => 'colthue'
                // 'textColor' => 'black'
            ];
        }


        $contactLog = DemXe::find()->where(['id_xe' => $model->id, 'ma_cong' => DemXe::CONG1])
            ->andWhere(['>=', 'thoi_gian_bd', $fromDate])->all();

        $colorList = DemXe::getDmTrangThaiColor();
        //$eventData = [];
        foreach ($contactLog as $item) {
            $startTime = $item->thoi_gian_bd;
            $endTime = $item->thoi_gian_kt;
            //$backgroundColor = '#ffc107';
            // $backgroundColor = '#ddd';

            if ($item->getDmTrangThai() !== null) {
                $backgroundColor = $colorList[$item->getDmTrangThai()];
            }

            /* if(LichThue::checkLichDangHieuLucChuaXuatHoaDon($item->id)){
     $backgroundColor = '#fca13a';
     } else if(LichThue::checkLichDangHieuLucDaXuatHoaDon($item->id)){
     $backgroundColor = '#54b75c';
     }else if(LichThue::checkLichSapToi($item->id)){
     $backgroundColor = '#ff0000';
     } */

            $eventData[] = [
                'title' => 'Xe số ' . $item->xe->ma_so . ' - ' . $item->xe->bien_so_xe,
                'description' => 'Xe chạy từ ' . CustomFunc::convertYMDHISToDMYHI($startTime)
                    . ' đến ' . CustomFunc::convertYMDHISToDMYHI($endTime) . ', thời gian chạy: ' . $item->so_phut,
                'start' => $startTime,
                'end' => $endTime ? $endTime : date('Y-m-d H:i:s'),
                'url' => Url::to(['/demxe/luot-xe/view', 'id' => $item->id, 'force_close' => 'true']),
                'extendedProps' => [
                    'role' => 'modal-remote',
                ],
                'backgroundColor' => $backgroundColor,
                // 'textColor' => 'black',
                'resourceId' => 'colcong1'
            ];
        }


        $contactLog = DemXe::find()->where(['id_xe' => $model->id, 'ma_cong' => DemXe::CONG2])
            ->andWhere(['>=', 'thoi_gian_bd', '2026-05-05 00:00:00']) //!!!!!!!!!!! tam de do roi cho du lieu cu, sau khi xu ly xong co thể bỏ hoặc ko
            ->andWhere(['>=', 'thoi_gian_bd', $fromDate])->all();

        $colorList = DemXe::getDmTrangThaiColor();
        //$eventData = [];
        foreach ($contactLog as $item) {
            $startTime = $item->thoi_gian_bd;
            $endTime = $item->thoi_gian_kt;
            //$backgroundColor = '#ffc107';
            // $backgroundColor = '#ddd';

            if ($item->getDmTrangThai() !== null) {
                $backgroundColor = $colorList[$item->getDmTrangThai()];
            }

            /* if(LichThue::checkLichDangHieuLucChuaXuatHoaDon($item->id)){
     $backgroundColor = '#fca13a';
     } else if(LichThue::checkLichDangHieuLucDaXuatHoaDon($item->id)){
     $backgroundColor = '#54b75c';
     }else if(LichThue::checkLichSapToi($item->id)){
     $backgroundColor = '#ff0000';
     } */

            $eventData[] = [
                'title' => 'Xe số ' . $item->xe->ma_so . ' - ' . $item->xe->bien_so_xe,
                'description' => 'Xe chạy từ ' . CustomFunc::convertYMDHISToDMYHI($startTime)
                    . ' đến ' . CustomFunc::convertYMDHISToDMYHI($endTime) . ', thời gian chạy: ' . $item->so_phut,
                'start' => $startTime,
                'end' => $endTime,
                //'end' => $endTime ? $endTime : date('Y-m-d H:i:s'),
                'url' => Url::to(['/demxe/luot-xe/view', 'id' => $item->id, 'force_close' => 'true']),
                'extendedProps' => [
                    'role' => 'modal-remote',
                ],
                'backgroundColor' => $backgroundColor,
                // 'textColor' => 'black'
                'resourceId' => 'colcong2'
            ];
        }

        return $eventData;
    }

    /**
     * get lịch của xe: lich giao vien (da hoan thanh/da len lich/da qua thoi gian) so sanh voi thuc te
     */
    public function actionLichXeGvSoSanh($idxe)
    {
        $this->layout = '/mainFullTrial';
        $model = Xe::findOne($idxe);
        return $this->render('lich-xe-gv-so-sanh', [
            'model' => $model
        ]);
    }

    /**
     * get lịch của xe: lich thue xe (da len lich/da qua thoi gian)
     */
   /*  public function actionLichXeThue($idxe){
        
    } */
    /**
     * get lịch của xe: lich thue xe (da len lich/da qua thoi gian)
     */
    /* public function actionLichXeAll($idxe){
        
    } */
}
