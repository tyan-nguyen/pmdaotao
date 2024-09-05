<?php

namespace app\modules\kholuutru\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\kholuutru\models\LoaiFile;

/**
 * LoaiFileSearch represents the model behind the search form about `app\modules\kholuutru\models\LoaiFile`.
 */
class LoaiFileSearch extends LoaiFile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nguoi_tao'], 'integer'],
            [['loai', 'ho_so_bat_buoc', 'ghi_chu', 'thoi_gian_tao', 'doi_tuong'], 'safe'],
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
        $query = LoaiFile::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'loai', $cusomSearch],
            ['like', 'ho_so_bat_buoc', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch],
            ['like', 'doi_tuong', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'loai', $this->loai])
            ->andFilterWhere(['like', 'ho_so_bat_buoc', $this->ho_so_bat_buoc])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu])
            ->andFilterWhere(['like', 'doi_tuong', $this->doi_tuong]);
		}
        return $dataProvider;
    }
}
