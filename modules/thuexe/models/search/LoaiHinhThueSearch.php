<?php

namespace app\modules\thuexe\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\thuexe\models\LoaiHinhThue;

/**
 * LoaiHinhThueSearch represents the model behind the search form about `app\modules\thuexe\models\LoaiHinhThue`.
 */
class LoaiHinhThueSearch extends LoaiHinhThue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_loai_xe', 'nguoi_tao'], 'integer'],
            [['loai_hinh_thue', 'ngay_ap_dung', 'ngay_ket_thuc', 'thoi_gian_tao'], 'safe'],
            [['gia_thue'], 'number'],
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
        $query = LoaiHinhThue::find();

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
            'id_loai_xe' => $this->id_loai_xe,
            'gia_thue' => $this->gia_thue,
            'ngay_ap_dung' => $this->ngay_ap_dung,
            'ngay_ket_thuc' => $this->ngay_ket_thuc,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'loai_hinh_thue', $this->loai_hinh_thue]);

        return $dataProvider;
    }
}
