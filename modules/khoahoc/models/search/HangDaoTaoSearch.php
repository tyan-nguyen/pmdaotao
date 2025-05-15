<?php

namespace app\modules\khoahoc\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\khoahoc\models\HangDaoTao;

/**
 * HangDaoTaoSearch represents the model behind the search form about `app\modules\khoahoc\models\HangDaoTao`.
 */
class HangDaoTaoSearch extends HangDaoTao
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nguoi_tao'], 'integer'],
            [['ten_hang', 'ghi_chu', 'thoi_gian_tao', 'ma_hang'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // Bỏ qua việc triển khai scenarios() trong lớp cha
        return Model::scenarios();
    }

    /**
     * Tạo một instance của data provider với truy vấn tìm kiếm đã áp dụng
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = HangDaoTao::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Bỏ uncomment dòng sau nếu bạn không muốn trả về bất kỳ bản ghi nào khi xác thực thất bại
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
            'ma_hang' => $this->ma_hang
        ]);

        $query->andFilterWhere(['like', 'ten_hang', $this->ten_hang])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);

        return $dataProvider;
    }
}
