<?php

namespace app\modules\kholuutru\models\base;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\kholuutru\models\Hop;

/**
 * HopSearch represents the model behind the search form about `app\modules\kholuutru\models\Hop`.
 */
class HopSearch extends Hop
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_ngan', 'nguoi_tao'], 'integer'],
            [['ten_hop', 'thoi_gian_tao'], 'safe'],
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
    public function search($params)
    {
        $query = Hop::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_ngan' => $this->id_ngan,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'ten_hop', $this->ten_hop]);

        return $dataProvider;
    }
}
