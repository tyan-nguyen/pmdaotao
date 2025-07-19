<?php

namespace app\modules\banhang\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\banhang\models\HangHoa;

/**
 * HangHoaSearch represents the model behind the search form about `app\modules\hanghoa\models\HangHoa`.
 */
class HangHoaSearch extends HangHoa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_loai_hang_hoa', 'nguoi_tao'], 'integer'],
            [['ma_hang_hoa', 'ten_hang_hoa', 'ngay_san_xuat', 'dvt', 'xuat_xu', 'ghi_chu', 'thoi_gian_tao', 'co_ton_kho'], 'safe'],
            [['so_luong', 'don_gia'], 'number'],
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
        $query = HangHoa::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'ma_hang_hoa', $cusomSearch],
            ['like', 'ten_hang_hoa', $cusomSearch],
            ['like', 'dvt', $cusomSearch],
            ['like', 'xuat_xu', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'id_loai_hang_hoa' => $this->id_loai_hang_hoa,
            'ngay_san_xuat' => $this->ngay_san_xuat,
            'so_luong' => $this->so_luong,
            'don_gia' => $this->don_gia,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        	'co_ton_kho' => $this->co_ton_kho
        ]);

        $query->andFilterWhere(['like', 'ma_hang_hoa', $this->ma_hang_hoa])
            ->andFilterWhere(['like', 'ten_hang_hoa', $this->ten_hang_hoa])
            ->andFilterWhere(['like', 'dvt', $this->dvt])
            ->andFilterWhere(['like', 'xuat_xu', $this->xuat_xu])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
}
