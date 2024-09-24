<?php

namespace app\modules\khoahoc\models\search;


use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\khoahoc\models\KhoaHoc;
/**
 * HVKhoaHocSearch represents the model behind the search form about `app\models\HvKhoaHoc`.
 */
class KhoaHocSearch extends KhoaHoc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_hang', 'nguoi_tao'], 'integer'],
            [['ten_khoa_hoc', 'ngay_bat_dau', 'ngay_ket_thuc', 'ghi_chu', 'trang_thai', 'thoi_gian_tao'], 'safe'],
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
        $query = KhoaHoc::find();

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
            
            'id_hang' => $this->id_hang,
            'ngay_bat_dau' => $this->ngay_bat_dau,
            'ngay_ket_thuc' => $this->ngay_ket_thuc,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'ten_khoa_hoc', $this->ten_khoa_hoc])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai]);

        return $dataProvider;
    }
}
