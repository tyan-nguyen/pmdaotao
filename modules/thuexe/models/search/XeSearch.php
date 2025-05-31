<?php

namespace app\modules\thuexe\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\thuexe\models\Xe;

/**
 * DangKyHvSearch represents the model behind the search form about `app\modules\hocvien\models\DangKyHv`.
 */
class XeSearch extends Xe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_loai_xe', 'nguoi_tao', 'id_giao_vien'], 'integer'],
            [['hieu_xe', 'bien_so_xe', 'tinh_trang_xe', 'trang_thai', 'thoi_gian_tao', 'ghi_chu', 'phan_loai'], 'safe'],
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
        $query = Xe::find();

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
            'id_loai_xe' => $this->id_loai_xe,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
            'id_giao_vien' => $this->id_giao_vien,
            'tinh_trang_xe' => $this->tinh_trang_xe,
            'phan_loai' => $this->phan_loai
        ]);

        $query->andFilterWhere(['like', 'hieu_xe', $this->hieu_xe])
        ->andFilterWhere(['like', 'bien_so_xe', $this->bien_so_xe])
        ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu])
        ->andFilterWhere(['like', 'trang_thai', $this->trang_thai]);

        return $dataProvider;
    }
}
