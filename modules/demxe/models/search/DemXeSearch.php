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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_xe', 'nguoi_tao', 'id_file'], 'integer'],
            [['ma_xe', 'ma_cong', 'thoi_gian_bd', 'thoi_gian_kt', 'so_phut', 'thoi_gian_tao', 'ghi_chu'], 'safe'],
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
            'thoi_gian_bd' => $this->thoi_gian_bd,
            'thoi_gian_kt' => $this->thoi_gian_kt,
            'so_gio' => $this->so_gio,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
            'id_file' => $this->id_file,
        ]);

        $query->andFilterWhere(['like', 'ma_xe', $this->ma_xe])
            ->andFilterWhere(['like', 'ma_cong', $this->ma_cong])
            ->andFilterWhere(['like', 'so_phut', $this->so_phut])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
}
