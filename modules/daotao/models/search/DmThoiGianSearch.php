<?php

namespace app\modules\daotao\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\daotao\models\DmThoiGian;

/**
 * DmThoiGianSearch represents the model behind the search form about `app\modules\daotao\models\DmThoiGian`.
 */
class DmThoiGianSearch extends DmThoiGian
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'stt', 'nguoi_tao', 'active'], 'integer'],
            [['ten_thoi_gian', 'thoi_gian_bd', 'thoi_gian_kt', 'ghi_chu', 'thoi_gian_tao'], 'safe'],
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
        $query = DmThoiGian::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'ten_thoi_gian', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'stt' => $this->stt,
            'thoi_gian_bd' => $this->thoi_gian_bd,
            'thoi_gian_kt' => $this->thoi_gian_kt,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        	'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'ten_thoi_gian', $this->ten_thoi_gian])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
}
