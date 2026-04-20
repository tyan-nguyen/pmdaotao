<?php

namespace app\modules\khoahoc\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\khoahoc\models\NhomHangDaoTao;

/**
 * NhomHangDaoTaoSearch represents the model behind the search form about `app\modules\khoahoc\models\NhomHangDaoTao`.
 */
class NhomHangDaoTaoSearch extends NhomHangDaoTao
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'stt', 'nguoi_tao'], 'integer'],
            [['ma_nhom_hang', 'ten_nhom_hang', 'thoi_gian_tao', 'ghi_chu'], 'safe'],
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
        $query = NhomHangDaoTao::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'ma_nhom_hang', $cusomSearch],
            ['like', 'ten_nhom_hang', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'stt' => $this->stt,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'ma_nhom_hang', $this->ma_nhom_hang])
            ->andFilterWhere(['like', 'ten_nhom_hang', $this->ten_nhom_hang])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
}
