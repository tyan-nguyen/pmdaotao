<?php
namespace app\modules\thuexe\models;

use yii\helpers\ArrayHelper;

class LichDungXe extends \app\modules\thuexe\models\base\LichDungXeBase{
    /**
     * lấy danh sách giờ của 01 ngày
     * @return string[]|number[]
     */
    public static function getListHoursOfDay(){
        $listHours = array();
        for($h=0;$h<=23;$h++){
            $hourStr = $h<10 ? ('0'.$h) : $h;
            $listHours[$hourStr] = $hourStr;
        }
        return $listHours;
    }
    /**
     * lấy danh sách phút của 01 giờ
     * @return string[]|number[]
     */
    public static function getListMinutesOfHour(){
        $listHours = array();
        for($i=0;$i<=59;$i++){
            $minuteStr = $i<10 ? ('0'.$i) : $i;
            $listHours[$minuteStr] = $minuteStr;
        }
        return $listHours;
    }
    /**
     * lấy danh sách phút 00,15,30,45 của 01 giờ
     * @return string[]|number[]
     */
    public static function getList15MinutesOfHour(){
        $listHours = array();
        $listHours['00'] = '00';
        $listHours['15'] = '15';
        $listHours['30'] = '30';
        $listHours['45'] = '45';
        return $listHours;
    }
    
    /**
     * get danh muc xe cam ung
     */
    public static function getDsXe(){
        $dsXe = Xe::find()->orderBy(['stt'=>SORT_ASC])->all();
        return ArrayHelper::map($dsXe, 'id', function($model) {
            return $model->tenXeLong;
        }, function($model) {
            return 'Hạng ' . $model->getLabelPhanLoaiXe();
        });
    }
}