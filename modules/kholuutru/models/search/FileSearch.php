<?php

namespace app\modules\kholuutru\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\kholuutru\models\File;

/**
 * FileSearch represents the model behind the search form about `app\modules\kholuutru\models\File`.
 */
class FileSearch extends File
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_loai_ho_so', 'nguoi_tao', 'id_doi_tuong'], 'integer'],
            [['file_name', 'file_type', 'file_size', 'file_display_name', 'thoi_gian_tao', 'doi_tuong'], 'safe'],
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
        $query = File::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'file_name', $cusomSearch],
            ['like', 'file_type', $cusomSearch],
            ['like', 'file_size', $cusomSearch],
            ['like', 'file_display_name', $cusomSearch],
            ['like', 'doi_tuong', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'id_loai_ho_so' => $this->id_loai_ho_so,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
            'id_doi_tuong' => $this->id_doi_tuong,
        ]);

        $query->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'file_type', $this->file_type])
            ->andFilterWhere(['like', 'file_size', $this->file_size])
            ->andFilterWhere(['like', 'file_display_name', $this->file_display_name])
            ->andFilterWhere(['like', 'doi_tuong', $this->doi_tuong]);
		}
        return $dataProvider;
    }
}
