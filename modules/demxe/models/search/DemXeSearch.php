<?php

namespace app\modules\demxe\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\demxe\models\DemXe;

/**
 * DemXeSearch represents the model behind the search form about `app\modules\demxe\models\DemXe`.
 */
class DemXeSearch extends DemXe
{
    public $loaiXe;
    public $bd_tu;
    public $bd_den;
    public $kt_tu;
    public $kt_den;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_xe', 'nguoi_tao', 'id_file'], 'integer'],
            [['ma_xe', 'ma_cong', 'thoi_gian_bd', 'thoi_gian_kt', 'so_phut', 
                'thoi_gian_tao', 'ghi_chu', 'loaiXe', 'bd_tu', 'bd_den', 'kt_tu', 'kt_den'], 'safe'],
            [['so_gio'], 'number']
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $cusomSearch=NULL)
    {
        $query = DemXe::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'id' => SORT_DESC
            ]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		if($cusomSearch != NULL){
			$query->andFilterWhere ( [ 'OR' ,['like', 'ma_xe', $cusomSearch],
            ['like', 'ma_cong', $cusomSearch],
            ['like', 'so_phut', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
                'id' => $this->id,
                'id_xe' => $this->id_xe,
                //'thoi_gian_bd' => $this->thoi_gian_bd,
                //'thoi_gian_kt' => $this->thoi_gian_kt,
                'so_gio' => $this->so_gio,
                'nguoi_tao' => $this->nguoi_tao,
                'thoi_gian_tao' => $this->thoi_gian_tao,
                'id_file' => $this->id_file,
            ]);
    
            $query->andFilterWhere(['like', 'ma_xe', $this->ma_xe])
                ->andFilterWhere(['like', 'ma_cong', $this->ma_cong])
                ->andFilterWhere(['like', 'so_phut', $this->so_phut])
                ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
            
                if($this->loaiXe){
                    if($this->loaiXe == 'xeNha')
                        $query->andWhere('id_xe IS NOT NULL');
                    else
                        $query->andWhere('id_xe IS NULL');
                }
                
            if(!empty($this->thoi_gian_bd) || !empty($this->thoi_gian_kt)){
                
                if (!empty($this->thoi_gian_bd)) {
                    if(strlen($this->thoi_gian_bd)<=10){
                        $start = date('Y-m-d 00:00:00', strtotime($this->thoi_gian_bd));
                        $end   = date('Y-m-d 23:59:59', strtotime($this->thoi_gian_bd));                        
                        $query->andWhere(['between', 'thoi_gian_bd', $start, $end]);
                    }else{
                        $query->andFilterWhere([
                            'thoi_gian_bd'=> date('Y-m-d H:i:s', strtotime($this->thoi_gian_bd))
                        ]);
                    }
                }
                
                if (!empty($this->thoi_gian_kt)) {
                    if(strlen($this->thoi_gian_kt)<=10){
                        $start = date('Y-m-d 00:00:00', strtotime($this->thoi_gian_kt));
                        $end   = date('Y-m-d 23:59:59', strtotime($this->thoi_gian_kt));
                        $query->andWhere(['between', 'thoi_gian_kt', $start, $end]);
                    }else{
                        $query->andFilterWhere([
                            'thoi_gian_bd' => date('Y-m-d H:i:s', strtotime($this->thoi_gian_kt))
                        ]);
                    }
                }
                
            } else {
        
                if (!empty($this->bd_tu)) {
                    if(strlen($this->bd_tu)<=10){
                        $query->andWhere([
                            '>=',
                            'thoi_gian_bd',
                            date('Y-m-d 00:00:00', strtotime($this->bd_tu))
                        ]);
                    }else{
                        $query->andWhere([
                            '>=',
                            'thoi_gian_bd',
                            date('Y-m-d H:i:s', strtotime($this->bd_tu))
                        ]);
                    }
                }
                
                if (!empty($this->bd_den)) {
                    if(strlen($this->bd_den)<=10){
                        $query->andWhere([
                            '<=',
                            'thoi_gian_bd',
                            date('Y-m-d 23:59:59', strtotime($this->bd_den))
                        ]);
                    }else{
                        $query->andWhere([
                            '<=',
                            'thoi_gian_bd',
                            date('Y-m-d H:i:s', strtotime($this->bd_den))
                        ]);
                    }
                }
                
                if (!empty($this->kt_tu)) {
                    if(strlen($this->kt_tu)<=10){
                        $query->andWhere([
                            '>=',
                            'thoi_gian_kt',
                            date('Y-m-d 00:00:00', strtotime($this->kt_tu))
                        ]);
                    }else{
                        $query->andWhere([
                            '>=',
                            'thoi_gian_kt',
                            date('Y-m-d H:i:s', strtotime($this->kt_tu))
                        ]);
                    }
                }
                
                if (!empty($this->kt_den)) {
                    if(strlen($this->kt_den)<=10){
                        $query->andWhere([
                            '<=',
                            'thoi_gian_kt',
                            date('Y-m-d 23:59:59', strtotime($this->kt_den))
                        ]);
                    } else{
                        $query->andWhere([
                            '<=',
                            'thoi_gian_kt',
                            date('Y-m-d H:i:s', strtotime($this->kt_den))
                        ]);
                    }
                }
                
            }
                
		}
        return $dataProvider;
    }
}
