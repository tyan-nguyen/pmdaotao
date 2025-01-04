<?php

namespace app\modules\lichhoc\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lichhoc\models\PhanThi;

/**
 * PhanThiSearch represents the model behind the search form about `app\modules\lichhoc\models\PhanThi`.
 */
class PhanThiSearch extends PhanThi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'diem_dat_toi_thieu', 'nguoi_tao','id_hang','thu_tu_thi'], 'integer'],
            [['ten_phan_thi', 'trang_thai', 'thoi_gian_tao'], 'safe'],
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
        $query = PhanThi::find();

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
            'diem_dat_toi_thieu' => $this->diem_dat_toi_thieu,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'ten_phan_thi', $this->ten_phan_thi])
            ->andFilterWhere(['like', 'id_hang', $this->id_hang])
            ->andFilterWhere(['like','thu_tu_thi',$this->thu_tu_thi])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai]);

        return $dataProvider;
    }
}
