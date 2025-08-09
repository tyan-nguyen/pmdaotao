<?php

namespace app\modules\hocvien\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\hocvien\models\NopHocPhi;
use app\custom\CustomFunc;
use yii\db\Expression;

/**
 * NopHocPhiSearch represents the model behind the search form about `app\modules\hocvien\models\NopHocPhi`.
 */
class NopHocPhiSearch extends NopHocPhi
{
    public $startdate;
    public $starttime;
    public $enddate;
    public $endtime;
    public $ma_so_hoc_vien;
    public $id_hang;
    public $noi_dang_ky;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_hoc_vien', 'id_hoc_phi', 'ma_so_phieu', 'so_lan_in_phieu', 'nguoi_thu', 'nguoi_tao'], 'integer'],
            [['loai_phieu', 'loai_nop', 'ngay_nop', 'hinh_thuc_thanh_toan', 'bien_lai', 'thoi_gian_tao', 'da_kiem_tra', 'ghi_chu', 'startdate', 'starttime', 'enddate', 'endtime', 'ma_so_hoc_vien', 'id_hang', 'noi_dang_ky'], 'safe'],
            [['so_tien_nop', 'chiet_khau', 'so_tien_con_lai'], 'number'],
            [['startdate', 'enddate'], 'checkDateFormat']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    public function checkDateFormat($attribute, $params)
    {
        if($this->startdate && $this->enddate && $this->starttime && $this->endtime){
            $start = CustomFunc::convertDMYToYMD($this->startdate) . ' ' . $this->starttime;
            $end = CustomFunc::convertDMYToYMD($this->enddate) . ' ' . $this->endtime;
            if($start >= $end){
                $this->addError($attribute, 'Vui lòng chọn thời gian bắt đầu nhỏ hơn thời gian kết thúc.');
            }
        }
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $cusomSearch=NULL)
    {
        $query = NopHocPhi::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		if($cusomSearch != NULL){
			$query->andFilterWhere ( [ 'OR' ,['like', 'loai_phieu', $cusomSearch],
            ['like', 'loai_nop', $cusomSearch],
            ['like', 'hinh_thuc_thanh_toan', $cusomSearch],
            ['like', 'bien_lai', $cusomSearch],
            ['like', 'da_kiem_tra', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'id_hoc_vien' => $this->id_hoc_vien,
            'id_hoc_phi' => $this->id_hoc_phi,
            'so_tien_nop' => $this->so_tien_nop,
            'chiet_khau' => $this->chiet_khau,
            'so_tien_con_lai' => $this->so_tien_con_lai,
            'ngay_nop' => $this->ngay_nop,
            'ma_so_phieu' => $this->ma_so_phieu,
            'so_lan_in_phieu' => $this->so_lan_in_phieu,
            'nguoi_thu' => $this->nguoi_thu,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'loai_phieu', $this->loai_phieu])
            ->andFilterWhere(['like', 'loai_nop', $this->loai_nop])
            ->andFilterWhere(['like', 'hinh_thuc_thanh_toan', $this->hinh_thuc_thanh_toan])
            ->andFilterWhere(['like', 'bien_lai', $this->bien_lai])
            ->andFilterWhere(['like', 'da_kiem_tra', $this->da_kiem_tra])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchPhieuThu($params, $cusomSearch=NULL)
    {
        $query = NopHocPhi::find()->alias('t');
        $query->select(['t.*', 'hv.so_cccd']);
        $query->joinWith(['hocVien as hv']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['ma_so_phieu' => SORT_DESC]],
        ]);
        
        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if($cusomSearch != NULL){
            $query->andFilterWhere ( [ 'OR' ,['like', 't.loai_phieu', $cusomSearch],
                ['like', 't.loai_nop', $cusomSearch],
                ['like', 't.hinh_thuc_thanh_toan', $cusomSearch],
                ['like', 't.bien_lai', $cusomSearch],
                ['like', 't.da_kiem_tra', $cusomSearch],
                ['like', 't.ghi_chu', $cusomSearch]] );            
        } else {
            $query->andFilterWhere([
                't.id' => $this->id,
                't.id_hoc_vien' => $this->id_hoc_vien,
                't.id_hoc_phi' => $this->id_hoc_phi,
                't.so_tien_nop' => $this->so_tien_nop,
                't.chiet_khau' => $this->chiet_khau,
                't.so_tien_con_lai' => $this->so_tien_con_lai,
                't.ngay_nop' => $this->ngay_nop,
                't.ma_so_phieu' => $this->ma_so_phieu,
                't.so_lan_in_phieu' => $this->so_lan_in_phieu,
                't.nguoi_thu' => $this->nguoi_thu,
                't.nguoi_tao' => $this->nguoi_tao,
                //'thoi_gian_tao' => $this->thoi_gian_tao,
                'hv.so_cccd' =>$this->ma_so_hoc_vien,
                'hv.id_hang' => $this->id_hang,
                'hv.noi_dang_ky' => $this->noi_dang_ky
            ]);
            
            $query->andFilterWhere(['like', 't.loai_phieu', 'PHIEUTHU']) //IMPORTANT!!!
            ->andFilterWhere(['like', 't.loai_nop', $this->loai_nop])
            ->andFilterWhere(['like', 't.hinh_thuc_thanh_toan', $this->hinh_thuc_thanh_toan])
            ->andFilterWhere(['like', 't.bien_lai', $this->bien_lai])
            ->andFilterWhere(['like', 't.da_kiem_tra', $this->da_kiem_tra])
            ->andFilterWhere(['like', 't.ghi_chu', $this->ghi_chu]);
            
            if($this->startdate && $this->enddate){
                if($this->starttime == null)
                    $this->starttime = '00:00:00';
                if($this->endtime == null)
                    $this->endtime = '23:59:59';
                $start = CustomFunc::convertDMYToYMD($this->startdate) . ' ' . $this->starttime;
                $end = CustomFunc::convertDMYToYMD($this->enddate) . ' ' . $this->endtime;
                $query->andFilterWhere(['>=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")])
                ->andFilterWhere(['<=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
            }
            if($this->thoi_gian_tao){
                $this->thoi_gian_tao = CustomFunc::convertDMYToYMD($this->thoi_gian_tao);
                $query->andWhere("DATE(t.thoi_gian_tao) = '".$this->thoi_gian_tao."'");
            }
        }
        return $dataProvider;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchPhieuChi($params, $cusomSearch=NULL)
    {
        $query = NopHocPhi::find()->alias('t');
        $query->select(['t.*', 'hv.so_cccd']);
        $query->joinWith(['hocVien as hv']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
        
        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if($cusomSearch != NULL){
            $query->andFilterWhere ( [ 'OR' ,['like', 't.loai_phieu', $cusomSearch],
                ['like', 't.loai_nop', $cusomSearch],
                ['like', 't.hinh_thuc_thanh_toan', $cusomSearch],
                ['like', 't.bien_lai', $cusomSearch],
                ['like', 't.da_kiem_tra', $cusomSearch],
                ['like', 't.ghi_chu', $cusomSearch]] );
        } else {
            $query->andFilterWhere([
                't.id' => $this->id,
                't.id_hoc_vien' => $this->id_hoc_vien,
                't.id_hoc_phi' => $this->id_hoc_phi,
                't.so_tien_nop' => $this->so_tien_nop,
                't.chiet_khau' => $this->chiet_khau,
                't.so_tien_con_lai' => $this->so_tien_con_lai,
                't.ngay_nop' => $this->ngay_nop,
                't.ma_so_phieu' => $this->ma_so_phieu,
                't.so_lan_in_phieu' => $this->so_lan_in_phieu,
                't.nguoi_thu' => $this->nguoi_thu,
                't.nguoi_tao' => $this->nguoi_tao,
                //'thoi_gian_tao' => $this->thoi_gian_tao,
                'hv.so_cccd' =>$this->ma_so_hoc_vien,
                'hv.id_hang' => $this->id_hang,
                'hv.noi_dang_ky' => $this->noi_dang_ky
            ]);
            
            $query->andFilterWhere(['like', 't.loai_phieu', 'PHIEUCHI']) //IMPORTANT!!!
            ->andFilterWhere(['like', 't.loai_nop', $this->loai_nop])
            ->andFilterWhere(['like', 't.hinh_thuc_thanh_toan', $this->hinh_thuc_thanh_toan])
            ->andFilterWhere(['like', 't.bien_lai', $this->bien_lai])
            ->andFilterWhere(['like', 't.da_kiem_tra', $this->da_kiem_tra])
            ->andFilterWhere(['like', 't.ghi_chu', $this->ghi_chu]);
            
            if($this->startdate && $this->enddate){
                $start = CustomFunc::convertDMYToYMD($this->startdate) . ' ' . $this->starttime;
                $end = CustomFunc::convertDMYToYMD($this->enddate) . ' ' . $this->endtime;
                $query->andFilterWhere(['>=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")])
                ->andFilterWhere(['<=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
            }
            
            if($this->thoi_gian_tao){
                $this->thoi_gian_tao = CustomFunc::convertDMYToYMD($this->thoi_gian_tao);
                $query->andWhere("DATE(t.thoi_gian_tao) = '".$this->thoi_gian_tao."'");
            }
            
        }
        return $dataProvider;
    }
}
