<?php

namespace app\modules\lichhoc\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lichhoc\models\LichThi;

/**
 * LichThiSearch represents the model behind the search form about `app\modules\lichhoc\models\LichThi`.
 */
class LichThiSearch extends LichThi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_khoa_hoc', 'id_nhom', 'id_phong_thi', 'id_giao_vien_gac', 'nguoi_tao'], 'integer'],
            [['thoi_gian_thi', 'trang_thai', 'thoi_gian_tao'], 'safe'],
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
        $query = LichThi::find();

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
            'id_khoa_hoc' => $this->id_khoa_hoc,
            'id_nhom' => $this->id_nhom,
            'id_phong_thi' => $this->id_phong_thi,
            'id_giao_vien_gac' => $this->id_giao_vien_gac,
            'thoi_gian_thi' => $this->thoi_gian_thi,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai]);

        return $dataProvider;
    }
}
