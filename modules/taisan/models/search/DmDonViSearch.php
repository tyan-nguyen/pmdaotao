<?php

namespace app\modules\taisan\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\taisan\models\DmDonVi;

/**
 * DmDonViSearch represents the model behind the search form about `app\modules\taisan\models\DmDonVi`.
 */
class DmDonViSearch extends DmDonVi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'stt', 'nguoi_tao'], 'integer'],
            [['code', 'ten', 'co_sua_chua', 'co_ban_hang', 'ghi_chu', 'thoi_gian_tao'], 'safe'],
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
        $query = DmDonVi::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'code', $cusomSearch],
            ['like', 'ten', $cusomSearch],
            ['like', 'co_sua_chua', $cusomSearch],
            ['like', 'co_ban_hang', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'stt' => $this->stt,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'ten', $this->ten])
            ->andFilterWhere(['like', 'co_sua_chua', $this->co_sua_chua])
            ->andFilterWhere(['like', 'co_ban_hang', $this->co_ban_hang])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
}
