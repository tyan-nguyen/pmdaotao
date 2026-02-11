<?php

namespace app\modules\thuexe\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\thuexe\models\LichDungXe;
use app\custom\CustomFunc;

/**
 * LichDungXeSearch represents the model behind the search form about `app\modules\thuexe\models\LichDungXe`.
 */
class LichDungXeSearch extends LichDungXe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_xe', 'id_nguoi_phu_trach', 'id_tai_xe', 'nguoi_tao'], 'integer'],
            [['noi_dung', 'thoi_gian_bat_dau', 'thoi_gian_ket_thuc', 'trang_thai', 
                'ghi_chu', 'thoi_gian_tao', 'ngay_bat_dau'], 'safe'],
            [['so_gio'], 'number'],
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
        $query = LichDungXe::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'noi_dung', $cusomSearch],
            ['like', 'trang_thai', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
		    if($this->ngay_bat_dau){
		        $this->ngay_bat_dau = CustomFunc::convertDMYToYMD($this->ngay_bat_dau);
		        $query->where("DATE(thoi_gian_bat_dau) = '" . $this->ngay_bat_dau."'");
		    }
		    
        	$query->andFilterWhere([
            'id' => $this->id,
            'id_xe' => $this->id_xe,
            'id_nguoi_phu_trach' => $this->id_nguoi_phu_trach,
            'id_tai_xe' => $this->id_tai_xe,
            'thoi_gian_bat_dau' => $this->thoi_gian_bat_dau,
            'thoi_gian_ket_thuc' => $this->thoi_gian_ket_thuc,
            'so_gio' => $this->so_gio,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'noi_dung', $this->noi_dung])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
}
