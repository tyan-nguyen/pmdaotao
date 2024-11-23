<?php

namespace app\modules\thuexe\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\thuexe\models\ConfigLoaiHinhThue;

/**
 * ConfigLoaiHinhThueSearch represents the model behind the search form of `app\modules\thuexe\models\ConfigLoaiHinhThue`.
 */
class ConfigLoaiHinhThueSearch extends ConfigLoaiHinhThue
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gio_bat_dau', 'gio_ket_thuc'], 'integer'],
            [[',ten_loai_hinh_thue', 'buoi'], 'safe'],
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
        $query = ConfigLoaiHinhThue::find();

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
            'gio_bat_dau' => $this->gio_bat_dau,
            'gio_ket_thuc' => $this->gio_ket_thuc,
        ]);

        $query->andFilterWhere(['like', ',ten_loai_hinh_thue', $this->,ten_loai_hinh_thue])
            ->andFilterWhere(['like', 'buoi', $this->buoi]);

        return $dataProvider;
    }
}
