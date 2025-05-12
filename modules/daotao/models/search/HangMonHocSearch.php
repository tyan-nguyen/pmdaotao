<?php

namespace app\modules\daotao\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\daotao\models\HangMonHoc;

/**
 * HangMonHocSearch represents the model behind the search form about `app\modules\daotao\models\HangMonHoc`.
 */
class HangMonHocSearch extends HangMonHoc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_hang', 'id_mon', 'nguoi_tao'], 'integer'],
            [['dang_hieu_luc', 'thoi_gian_tao'], 'safe'],
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
        $query = HangMonHoc::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'dang_hieu_luc', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'id_hang' => $this->id_hang,
            'id_mon' => $this->id_mon,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'dang_hieu_luc', $this->dang_hieu_luc]);
		}
        return $dataProvider;
    }
}
