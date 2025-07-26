<?php

namespace app\modules\banhang\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\banhang\models\KhachHang;

/**
 * KhachHangSearch represents the model behind the search form about `app\modules\khachhang\models\KhachHang`.
 */
class KhachHangSearch extends KhachHang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_loai_khach_hang', 'nguoi_tao'], 'integer'],
            [['ho_ten', 'so_dien_thoai', 'dia_chi', 'thoi_gian_tao'], 'safe'],
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
        $query = KhachHang::find();

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
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
            'id_loai_khach_hang' => $this->id_loai_khach_hang
        ]);

        $query->andFilterWhere(['like', 'ho_ten', $this->ho_ten])
            ->andFilterWhere(['like', 'so_dien_thoai', $this->so_dien_thoai])
            ->andFilterWhere(['like', 'dia_chi', $this->dia_chi]);

        return $dataProvider;
    }
}
