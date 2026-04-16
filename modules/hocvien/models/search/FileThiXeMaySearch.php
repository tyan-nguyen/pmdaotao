<?php

namespace app\modules\hocvien\models\search;

use app\custom\CustomFunc;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\hocvien\models\FileThiXeMay;

/**
 * FileThiXeMaySearch represents the model behind the search form about `app\modules\hocvien\models\FileThiXeMay`.
 */
class FileThiXeMaySearch extends FileThiXeMay
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nguoi_tao'], 'integer'],
            [['ngay_thi', 'ten_khoa_thi', 'filename', 'url', 'thoi_gian_tao', 'ghi_chu'], 'safe'],
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
    public function search($params, $cusomSearch = NULL)
    {
        $query = FileThiXeMay::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($cusomSearch != NULL) {
            $query->andFilterWhere([
                'OR',
                ['like', 'filename', $cusomSearch],
                ['like', 'ten_khoa_thi', $cusomSearch],
                ['like', 'url', $cusomSearch],
                ['like', 'ghi_chu', $cusomSearch]
            ]);
        } else {

            if ($this->ngay_thi) {
                $this->ngay_thi = CustomFunc::convertDMYToYMD($this->ngay_thi);
            }
            $query->andFilterWhere([
                'id' => $this->id,
                'ngay_thi' => $this->ngay_thi,
                'nguoi_tao' => $this->nguoi_tao,
                'thoi_gian_tao' => $this->thoi_gian_tao,
            ]);

            $query->andFilterWhere(['like', 'filename', $this->filename])
                ->andFilterWhere(['like', 'ten_khoa_thi', $this->ten_khoa_thi])
                ->andFilterWhere(['like', 'url', $this->url])
                ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
        }
        return $dataProvider;
    }
}
