<?php

namespace app\modules\hocvien\models\search;


use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\HangDaoTao;
/**
 * HocVienSearch represents the model behind the search form about `app\models\HvHocVien`.
 */
class HocVienSearch extends HocVien
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_khoa_hoc', 'nguoi_tao'], 'integer'],
            [['ho_ten', 'so_dien_thoai', 'so_cccd', 'trang_thai', 'thoi_gian_tao','ngay_sinh'], 'safe'],
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
        $query = HocVienSearch::find();

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
            'id_khoa_hoc' => $this->id_khoa_hoc,
             'ngay_sinh'=>$this->ngay_sinh,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'ho_ten', $this->ho_ten])
            ->andFilterWhere(['like', 'so_dien_thoai', $this->so_dien_thoai])
            ->andFilterWhere(['like', 'so_cccd', $this->so_cccd])
      
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai]);

        return $dataProvider;
    }
  

}
