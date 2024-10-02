<?php

namespace app\modules\hocvien\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\hocvien\models\DangKyHv;

/**
 * DangKyHvSearch represents the model behind the search form about `app\modules\hocvien\models\DangKyHv`.
 */
class DangKyHvSearch extends DangKyHv
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_khoa_hoc', 'nguoi_tao', 'id_hang','gioi_tinh'], 'integer'],
            [['ho_ten', 'so_dien_thoai', 'so_cccd', 'trang_thai', 'thoi_gian_tao', 'ngay_sinh'], 'safe'],
        ];
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
        $query = DangKyHv::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_khoa_hoc' => $this->id_khoa_hoc,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
            'gioi_tinh'=>$this->gioi_tinh,
        ]);

        $query->andFilterWhere(['like', 'ho_ten', $this->ho_ten])
           
            ->andFilterWhere(['like', 'so_dien_thoai', $this->so_dien_thoai])
            ->andFilterWhere(['like', 'so_cccd', $this->so_cccd])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai])
            ->andFilterWhere(['like', 'id_hang', $this->id_hang])
            ->andFilterWhere(['like', 'ngay_sinh', $this->ngay_sinh]);

        return $dataProvider;
    }
}
