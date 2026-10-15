<?php

namespace app\modules\thuexe\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\thuexe\models\XeLuotRaVao;

/**
 * XeLuotRaVaoSearch represents the model behind the search form about `app\modules\thuexe\models\XeLuotRaVao`.
 */
class XeLuotRaVaoSearch extends XeLuotRaVao
{
    public $tu_ngay;
    public $den_ngay;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_xe', 'log_di_id', 'log_ve_id', 'so_phut_o_ngoai', 'qua_dem', 'is_deleted'], 'integer'],
            [['ma_xe', 'bien_so_xe', 'loai_xe', 'kieu_luot', 'camera_di', 'camera_ve', 'trang_thai', 'trang_thai_ke_hoach', 'thoi_gian_di', 'thoi_gian_ve', 'tu_ngay', 'den_ngay'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = XeLuotRaVao::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'thoi_gian_di' => SORT_DESC,
                    'id' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Lọc trạng thái xóa mềm: mặc định chỉ hiển thị chưa xóa
        if ($this->is_deleted !== null && $this->is_deleted !== '') {
            $query->andFilterWhere(['is_deleted' => $this->is_deleted]);
        } else {
            $query->andWhere(['or', ['is_deleted' => 0], ['is_deleted' => null]]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_xe' => $this->id_xe,
            'loai_xe' => $this->loai_xe,
            'kieu_luot' => $this->kieu_luot,
            'qua_dem' => $this->qua_dem,
            'trang_thai' => $this->trang_thai,
            'trang_thai_ke_hoach' => $this->trang_thai_ke_hoach,
            'camera_di' => $this->camera_di,
            'camera_ve' => $this->camera_ve,
        ]);

        $query->andFilterWhere(['like', 'ma_xe', $this->ma_xe])
            ->andFilterWhere(['like', 'bien_so_xe', $this->bien_so_xe]);

        // Lọc theo khoảng ngày (dựa trên thoi_gian_di hoặc thoi_gian_ve)
        if (!empty($this->tu_ngay)) {
            $query->andWhere(['>=', 'thoi_gian_di', $this->tu_ngay . ' 00:00:00']);
        }
        if (!empty($this->den_ngay)) {
            $query->andWhere(['<=', 'thoi_gian_di', $this->den_ngay . ' 23:59:59']);
        }

        return $dataProvider;
    }
}
