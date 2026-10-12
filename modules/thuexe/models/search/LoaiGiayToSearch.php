<?php

namespace app\modules\thuexe\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\thuexe\models\LoaiGiayTo;

/**
 * LoaiGiayToSearch represents the model behind the search form about `app\modules\thuexe\models\LoaiGiayTo`.
 */
class LoaiGiayToSearch extends LoaiGiayTo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'check_het_han', 'la_bat_buoc', 'so_ngay_bao_truoc', 'nguoi_tao'], 'integer'],
            [['ten_loai_giay_to', 'ghi_chu', 'thoi_gian_tao'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LoaiGiayTo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'check_het_han' => $this->check_het_han,
            'la_bat_buoc' => $this->la_bat_buoc,
            'so_ngay_bao_truoc' => $this->so_ngay_bao_truoc,
            'nguoi_tao' => $this->nguoi_tao,
        ]);

        $query->andFilterWhere(['like', 'ten_loai_giay_to', $this->ten_loai_giay_to])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);

        return $dataProvider;
    }
}
