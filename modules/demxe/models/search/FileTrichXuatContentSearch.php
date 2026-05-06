<?php

namespace app\modules\demxe\models\search;

use app\custom\CustomFunc;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\demxe\models\FileTrichXuatContent;

/**
 * FileTrichXuatContentSearch represents the model behind the search form about `app\modules\demxe\models\FileTrichXuatContent`.
 */
class FileTrichXuatContentSearch extends FileTrichXuatContent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_file', 'nguoi_tao'], 'integer'],
            [['camera', 'ma_xe', 'bien_so_xe', 'thoi_gian', 'thoi_gian_tao'], 'safe'],
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
        $query = FileTrichXuatContent::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
                ['like', 'camera', $cusomSearch],
                ['like', 'ma_xe', $cusomSearch],
                ['like', 'bien_so_xe', $cusomSearch]
            ]);
        } else {
            $query->andFilterWhere([
                'id' => $this->id,
                'id_file' => $this->id_file,

                'thoi_gian_tao' => $this->thoi_gian_tao,
                'nguoi_tao' => $this->nguoi_tao,
            ]);

            $query->andFilterWhere(['like', 'camera', $this->camera])
                ->andFilterWhere(['like', 'ma_xe', $this->ma_xe])
                ->andFilterWhere(['like', 'bien_so_xe', $this->bien_so_xe]);
            if ($this->thoi_gian != null) {
                $formatDate = CustomFunc::convertDMYToYMD($this->thoi_gian);
                $query->andFilterWhere(['>=', 'thoi_gian', $formatDate . ' 00:00:00'])
                    ->andFilterWhere(['<=', 'thoi_gian', $formatDate . ' 23:59:59']);
            }
        }
        return $dataProvider;
    }
}
