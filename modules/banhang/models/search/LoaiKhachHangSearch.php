<?php

namespace app\modules\banhang\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\banhang\models\LoaiKhachHang;

/**
 * LoaiKhachHangSearch represents the model behind the search form about `app\modules\khachhang\models\LoaiKhachHang`.
 */
class LoaiKhachHangSearch extends LoaiKhachHang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ten_loai_khach_hang', 'ghi_chu', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
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
        $query = LoaiKhachHang::find();

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
			 
		} else {
        	$query->andFilterWhere([
                'id' => $this->id,
                'ten_loai_khach_hang' => $this->ten_loai_khach_hang,
                'ghi_chu' => $this->ghi_chu,
                'nguoi_tao' => $this->nguoi_tao,
                'thoi_gian_tao' => $this->thoi_gian_tao,
            ]);
        	$query->andWhere(['<>', 'id', 1]);//không hiển thị id 1
		}
        return $dataProvider;
    }
}
