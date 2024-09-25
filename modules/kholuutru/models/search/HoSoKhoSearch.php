<?php

namespace app\modules\kholuutru\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\kholuutru\models\LuuKho;

/**
 * HoSoKhoSearch represents the model behind the search form about `app\modules\kholuutru\models\LuuKho`.
 */
class HoSoKhoSearch extends LuuKho
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_file', 'id_kho', 'id_ke', 'id_ngan', 'id_hop', 'nguoi_tao', 'id_doi_tuong'], 'integer'],
            [['loai_file', 'thoi_gian_tao', 'doi_tuong'], 'safe'],
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
        $query = LuuKho::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'loai_file', $cusomSearch],
            ['like', 'doi_tuong', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'id_file' => $this->id_file,
            'id_kho' => $this->id_kho,
            'id_ke' => $this->id_ke,
            'id_ngan' => $this->id_ngan,
            'id_hop' => $this->id_hop,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
            'id_doi_tuong' => $this->id_doi_tuong,
        ]);

        $query->andFilterWhere(['like', 'loai_file', $this->loai_file])
            ->andFilterWhere(['like', 'doi_tuong', $this->doi_tuong]);
		}
        return $dataProvider;
    }
}
