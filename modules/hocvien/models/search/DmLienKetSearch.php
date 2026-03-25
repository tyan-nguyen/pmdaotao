<?php

namespace app\modules\hocvien\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\hocvien\models\DmLienKet;

/**
 * DmLienKetSearch represents the model behind the search form about `app\modules\hocvien\models\DmLienKet`.
 */
class DmLienKetSearch extends DmLienKet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nguoi_tao'], 'integer'],
            [['loai_lien_ket', 'ten_lien_ket', 'ghi_chu', 'thoi_gian_tao'], 'safe'],
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
        $query = DmLienKet::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'loai_lien_ket', $cusomSearch],
            ['like', 'ten_lien_ket', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'thoi_gian_tao' => $this->thoi_gian_tao,
            'nguoi_tao' => $this->nguoi_tao,
        ]);

        $query->andFilterWhere(['like', 'loai_lien_ket', $this->loai_lien_ket])
            ->andFilterWhere(['like', 'ten_lien_ket', $this->ten_lien_ket])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
}
