<?php

namespace app\modules\kholuutru\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\kholuutru\models\Ngan;

/**
 * HopSearch represents the model behind the search form about `app\modules\kholuutru\models\Hop`.
 */
class NganSearch extends Ngan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nguoi_tao','id_ke'], 'integer'],
            [['ten_ngan', 'thoi_gian_tao'], 'safe'],
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
        $query = Ngan::find();

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
            'id_ke'=>$this->id_ke,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'ten_ngan', $this->ten_ngan]);

        return $dataProvider;
    }
}
