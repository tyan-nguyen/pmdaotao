<?php

namespace app\modules\nhanvien\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\nhanvien\models\To;

/**
 * ToSearch represents the model behind the search form about `app\modules\nhanvien\models\To`.
 */
class ToSearch extends To
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_phong_ban'], 'integer'],
            [['ten_to'], 'safe'],
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
        $query = To::find();

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
            'id_phong_ban' => $this->id_phong_ban,
        ]);

        $query->andFilterWhere(['like', 'ten_to', $this->ten_to]);

        return $dataProvider;
    }
}
