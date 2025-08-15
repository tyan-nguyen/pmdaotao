<?php

namespace app\modules\thuexe\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\thuexe\models\PhieuThu;
use app\custom\CustomFunc;
use yii\db\Expression;

/**
 * PhieuThuSearch represents the model behind the search form about `app\modules\thuexe\models\PhieuThu`.
 */
class PhieuThuSearch extends PhieuThu
{
    public $startdate;
    public $starttime;
    public $enddate;
    public $endtime;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_lich_thue', 'ma_so_phieu', 'so_lan_in_phieu', 'nguoi_tao'], 'integer'],
            [['loai_phieu', 'hinh_thuc_thanh_toan', 'thoi_gian_tao', 'ghi_chu', 'startdate', 'starttime', 'enddate', 'endtime',], 'safe'],
            [['so_tien', 'chiet_khau', 'so_tien_con_lai'], 'number'],
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
        $query = PhieuThu::find();

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
            ['like', 'hinh_thuc_thanh_toan', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'id_lich_thue' => $this->id_lich_thue,
            'so_tien' => $this->so_tien,
            'chiet_khau' => $this->chiet_khau,
            'so_tien_con_lai' => $this->so_tien_con_lai,
            'ma_so_phieu' => $this->ma_so_phieu,
            'so_lan_in_phieu' => $this->so_lan_in_phieu,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'loai_phieu', $this->loai_phieu])
            ->andFilterWhere(['like', 'hinh_thuc_thanh_toan', $this->hinh_thuc_thanh_toan])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
    
    
    public function searchPhieuThu($params, $cusomSearch=NULL)
    {
        $query = PhieuThu::find();
        
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
            $query->andFilterWhere ( [ 'OR' ,['like', 'loai_phieu', $cusomSearch],
                ['like', 'hinh_thuc_thanh_toan', $cusomSearch],
                ['like', 'ghi_chu', $cusomSearch]] );
            
        } else {
            $query->andFilterWhere([
                'id' => $this->id,
                'id_lich_thue' => $this->id_lich_thue,
                'so_tien' => $this->so_tien,
                'chiet_khau' => $this->chiet_khau,
                'so_tien_con_lai' => $this->so_tien_con_lai,
                'ma_so_phieu' => $this->ma_so_phieu,
                'so_lan_in_phieu' => $this->so_lan_in_phieu,
                'nguoi_tao' => $this->nguoi_tao,
                //'thoi_gian_tao' => $this->thoi_gian_tao,
                
            ]);
            
            $query->andFilterWhere(['like', 'loai_phieu', 'PHIEUTHU']) //IMPORTANT!!!
            ->andFilterWhere(['like', 'hinh_thuc_thanh_toan', $this->hinh_thuc_thanh_toan])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
            
            if($this->startdate && $this->enddate){
                if($this->starttime == null)
                    $this->starttime = '00:00:00';
                    if($this->endtime == null)
                        $this->endtime = '23:59:59';
                        $start = CustomFunc::convertDMYToYMD($this->startdate) . ' ' . $this->starttime;
                        $end = CustomFunc::convertDMYToYMD($this->enddate) . ' ' . $this->endtime;
                        $query->andFilterWhere(['>=', 'thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")])
                        ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
            }
            if($this->thoi_gian_tao){
                $this->thoi_gian_tao = CustomFunc::convertDMYToYMD($this->thoi_gian_tao);
                $query->andWhere("DATE(thoi_gian_tao) = '".$this->thoi_gian_tao."'");
            }
        }
        return $dataProvider;
    }
    
    public function searchPhieuChi($params, $cusomSearch=NULL)
    {
        $query = PhieuThu::find();
        
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
            $query->andFilterWhere ( [ 'OR' ,['like', 'loai_phieu', $cusomSearch],
                ['like', 'hinh_thuc_thanh_toan', $cusomSearch],
                ['like', 'ghi_chu', $cusomSearch]] );
            
        } else {
            $query->andFilterWhere([
                'id' => $this->id,
                'id_lich_thue' => $this->id_lich_thue,
                'so_tien' => $this->so_tien,
                'chiet_khau' => $this->chiet_khau,
                'so_tien_con_lai' => $this->so_tien_con_lai,
                'ma_so_phieu' => $this->ma_so_phieu,
                'so_lan_in_phieu' => $this->so_lan_in_phieu,
                'nguoi_tao' => $this->nguoi_tao,
                //'thoi_gian_tao' => $this->thoi_gian_tao,
                
            ]);
            
            $query->andFilterWhere(['like', 'loai_phieu', 'PHIEUCHI']) //IMPORTANT!!!
            ->andFilterWhere(['like', 'hinh_thuc_thanh_toan', $this->hinh_thuc_thanh_toan])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
            
            if($this->startdate && $this->enddate){
                if($this->starttime == null)
                    $this->starttime = '00:00:00';
                    if($this->endtime == null)
                        $this->endtime = '23:59:59';
                        $start = CustomFunc::convertDMYToYMD($this->startdate) . ' ' . $this->starttime;
                        $end = CustomFunc::convertDMYToYMD($this->enddate) . ' ' . $this->endtime;
                        $query->andFilterWhere(['>=', 'thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")])
                        ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
            }
            if($this->thoi_gian_tao){
                $this->thoi_gian_tao = CustomFunc::convertDMYToYMD($this->thoi_gian_tao);
                $query->andWhere("DATE(thoi_gian_tao) = '".$this->thoi_gian_tao."'");
            }
        }
        return $dataProvider;
    }
}
