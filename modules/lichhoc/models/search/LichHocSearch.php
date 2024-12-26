<?php

namespace app\modules\lichhoc\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lichhoc\models\LichHoc;

/**
 * LichHocSearch represents the model behind the search form about `app\modules\lichhoc\models\LichHoc`.
 */
class LichHocSearch extends LichHoc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_khoa_hoc', 'id_nhom', 'id_phong', 'id_giao_vien', 'tiet_bat_dau', 'tiet_ket_thuc', 'nguoi_tao'], 'integer'],
            [['hoc_phan', 'ngay', 'thu', 'thoi_gian_tao'], 'safe'],
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
        $query = LichHoc::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if (!empty($this->ngay)) {
            $ngay = \DateTime::createFromFormat('d/m/Y', $this->ngay);
            if ($ngay) {
                $this->ngay = $ngay->format('Y-m-d');
            } else {
                $this->ngay = null; 
            }
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_khoa_hoc' => $this->id_khoa_hoc,
            'id_nhom' => $this->id_nhom,
            'id_phong' => $this->id_phong,
            'id_giao_vien' => $this->id_giao_vien,
            'ngay' => $this->ngay,
            'tiet_bat_dau' => $this->tiet_bat_dau,
            'tiet_ket_thuc' => $this->tiet_ket_thuc,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'hoc_phan', $this->hoc_phan]);

        return $dataProvider;
    }
}
