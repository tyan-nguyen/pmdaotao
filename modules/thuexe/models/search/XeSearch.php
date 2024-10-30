<?php

namespace app\modules\thuexe\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\thuexe\models\Xe;

/**
 * XeSearch represents the model behind the search form about `app\modules\thuexe\models\Xe`.
 */
class XeSearch extends Xe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_loai_xe', 'nguoi_tao'], 'integer'],
            [['hieu_xe', 'bien_so_xe', 'tinh_trang_xe', 'trang_thai', 'thoi_gian_tao'], 'safe'],
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
        $query = Xe::find();

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
            'id_loai_xe' => $this->id_loai_xe,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'hieu_xe', $this->hieu_xe])
            ->andFilterWhere(['like', 'bien_so_xe', $this->bien_so_xe])
            ->andFilterWhere(['like', 'tinh_trang_xe', $this->tinh_trang_xe])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai]);

        return $dataProvider;
    }
}
