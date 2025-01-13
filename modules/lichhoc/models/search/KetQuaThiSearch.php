<?php

namespace app\modules\lichhoc\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lichhoc\models\KetQuaThi;

/**
 * KetQuaThiSearch represents the model behind the search form of `app\modules\lichhoc\models\KetQuaThi`.
 */
class KetQuaThiSearch extends KetQuaThi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_hoc_vien', 'id_lich_thi', 'id_phan_thi', 'diem_so', 'trang_thai', 'nguoi_tao','lan_thi'], 'integer'],
            [['ket_qua', 'thoi_gian_tao'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = KetQuaThi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_hoc_vien' => $this->id_hoc_vien,
            'id_lich_thi' => $this->id_lich_thi,
            'id_phan_thi' => $this->id_phan_thi,
            'diem_so' => $this->diem_so,
            'lan_thi'=>$this->lan_thi,
            'trang_thai' => $this->trang_thai,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'ket_qua', $this->ket_qua]);

        return $dataProvider;
    }
}
