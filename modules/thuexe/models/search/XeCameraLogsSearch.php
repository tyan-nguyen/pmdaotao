<?php

namespace app\modules\thuexe\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\thuexe\models\XeCameraLogs;

/**
 * XeCameraLogsSearch represents the model behind the search form about `app\modules\thuexe\models\XeCameraLogs`.
 */
class XeCameraLogsSearch extends XeCameraLogs
{
    public $tu_ngay;
    public $den_ngay;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'camera_log_id', 'nguoi_tao', 'is_deleted'], 'integer'],
            [['camera', 'su_kien', 'trang_thai_ke_hoach', 'ma_xe', 'bien_so_xe', 'thoi_gian', 'thoi_gian_tao', 'deleted_at', 'deleted_by', 'tu_ngay', 'den_ngay'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = XeCameraLogs::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['thoi_gian' => SORT_DESC, 'id' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Lọc theo trạng thái xóa: nếu không chọn cụ thể thì mặc định chỉ hiển thị bản ghi chưa xóa
        if ($this->is_deleted !== null && $this->is_deleted !== '') {
            $query->andFilterWhere(['is_deleted' => $this->is_deleted]);
        } else {
            $query->andWhere(['or', ['is_deleted' => 0], ['is_deleted' => null]]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'camera_log_id' => $this->camera_log_id,
            'camera' => $this->camera,
            'su_kien' => $this->su_kien,
            'trang_thai_ke_hoach' => $this->trang_thai_ke_hoach,
            'nguoi_tao' => $this->nguoi_tao,
        ]);

        $query->andFilterWhere(['like', 'ma_xe', $this->ma_xe])
            ->andFilterWhere(['like', 'bien_so_xe', $this->bien_so_xe]);

        if (!empty($this->tu_ngay)) {
            $query->andWhere(['>=', 'thoi_gian', $this->tu_ngay . ' 00:00:00']);
        }
        if (!empty($this->den_ngay)) {
            $query->andWhere(['<=', 'thoi_gian', $this->den_ngay . ' 23:59:59']);
        }

        return $dataProvider;
    }
}
