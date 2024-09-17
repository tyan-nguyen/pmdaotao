<?php

namespace app\modules\giaovien\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\giaovien\models\Day;

/**
 * DaySearch represents the model behind the search form about `app\modules\giaovien\models\Day`.
 */
class DaySearch extends Day
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_nhan_vien', 'id_hang_xe', 'nguoi_tao'], 'integer'],
            [['ly_thuyet', 'thuc_hanh', 'thoi_gian_tao'], 'safe'],
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
        $query = Day::find();

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
            'id_nhan_vien' => $this->id_nhan_vien,
            'id_hang_xe' => $this->id_hang_xe,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'ly_thuyet', $this->ly_thuyet])
            ->andFilterWhere(['like', 'thuc_hanh', $this->thuc_hanh]);

        return $dataProvider;
    }
}
