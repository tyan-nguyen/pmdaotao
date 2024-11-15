<?php

namespace app\modules\thuexe\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\thuexe\models\LoaiHinhThueChiTiet;

/**
 * LoaiHinhThueChiTietSearch represents the model behind the search form about `app\modules\thuexe\models\LoaiHinhThueChiTiet`.
 */
class LoaiHinhThueChiTietSearch extends LoaiHinhThueChiTiet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nguoi_tao'], 'integer'],
            [['ten_loai_hinh_thue', 'don_vi_tinh', 'buoi', 'gio_bat_dau', 'gio_ket_thuc', 'ghi_chu', 'thoi_gian_tao'], 'safe'],
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
        $query = LoaiHinhThueChiTiet::find();

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
            'gio_bat_dau' => $this->gio_bat_dau,
            'gio_ket_thuc' => $this->gio_ket_thuc,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'ten_loai_hinh_thue', $this->ten_loai_hinh_thue])
            ->andFilterWhere(['like', 'don_vi_tinh', $this->don_vi_tinh])
            ->andFilterWhere(['like', 'buoi', $this->buoi])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);

        return $dataProvider;
    }
}
