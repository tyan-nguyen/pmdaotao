<?php

namespace app\modules\daotao\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\daotao\models\TietHoc;

/**
 * TietHocSearch represents the model behind the search form about `app\modules\daotao\models\TietHoc`.
 */
class TietHocSearch extends TietHoc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_ke_hoach', 'id_hoc_vien', 'id_giao_vien', 'id_xe', 'id_mon_hoc', 'id_thoi_gian_hoc', 'id_nguoi_duyet', 'nguoi_tao'], 'integer'],
            [['so_gio'], 'number'],
            [['thoi_gian_bd', 'thoi_gian_kt', 'ghi_chu', 'trang_thai', 'trang_thai_duyet', 'ngay_duyet', 'thoi_gian_tao'], 'safe'],
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
    public function search($params, $cusomSearch=NULL)
    {
        $query = TietHoc::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		if($cusomSearch != NULL){
			$query->andFilterWhere ( [ 'OR' ,['like', 'ghi_chu', $cusomSearch],
            ['like', 'trang_thai', $cusomSearch],
            ['like', 'trang_thai_duyet', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'id_ke_hoach' => $this->id_ke_hoach,
            'id_hoc_vien' => $this->id_hoc_vien,
            'id_giao_vien' => $this->id_giao_vien,
            'id_xe' => $this->id_xe,
            'id_mon_hoc' => $this->id_mon_hoc,
            'id_thoi_gian_hoc' => $this->id_thoi_gian_hoc,
            'so_gio' => $this->so_gio,
            'thoi_gian_bd' => $this->thoi_gian_bd,
            'thoi_gian_kt' => $this->thoi_gian_kt,
            'ngay_duyet' => $this->ngay_duyet,
            'id_nguoi_duyet' => $this->id_nguoi_duyet,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai])
            ->andFilterWhere(['like', 'trang_thai_duyet', $this->trang_thai_duyet]);
		}
        return $dataProvider;
    }
}
