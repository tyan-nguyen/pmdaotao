<?php

namespace app\modules\daotao\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\daotao\models\MonHoc;

/**
 * MonHocSearch represents the model behind the search form about `app\modules\daotao\models\MonHoc`.
 */
class MonHocSearch extends MonHoc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nguoi_tao'], 'integer'],
            [['ma_mon', 'ten_mon', 'ten_mon_sub', 'ghi_chu', 'thoi_gian_tao'], 'safe'],
            [['so_gio_qd', 'so_gio_tt'], 'number'],
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
        $query = MonHoc::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'ma_mon', $cusomSearch],
            ['like', 'ten_mon', $cusomSearch],
            ['like', 'ten_mon_sub', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'so_gio_qd' => $this->so_gio_qd,
            'so_gio_tt' => $this->so_gio_tt,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'ma_mon', $this->ma_mon])
            ->andFilterWhere(['like', 'ten_mon', $this->ten_mon])
            ->andFilterWhere(['like', 'ten_mon_sub', $this->ten_mon_sub])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
}
