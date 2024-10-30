<?php

namespace app\modules\thuexe\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\thuexe\models\PhieuThueXe;

/**
 * PhieuThueXeSearch represents the model behind the search form about `app\modules\thuexe\models\PhieuThueXe`.
 */
class PhieuThueXeSearch extends PhieuThueXe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_hoc_vien', 'id_xe', 'id_loai_hinh_thue', 'id_nhan_vien_cho_thue', 'id_nhan_vien_ky_tra', 'id_nguoi_gui', 'id_nguoi_duyet', 'nguoi_tao'], 'integer'],
            [['ngay_thue_xe', 'ho_ten_nguoi_thue', 'so_cccd_nguoi_thue', 'dia_chi_nguoi_thue', 'so_dien_thoai_nguoi_thue', 'thoi_gian_bat_dau_thue', 'thoi_gian_tra_xe_du_kien', 'thoi_gian_tra_xe', 'noi_dung_thue', 'ngay_tra_xe', 'tinh_trang_xe_khi_tra', 'thoi_gian_gui', 'ghi_chu_nguoi_gui', 'thoi_gian_duyet', 'ghi_chu_nguoi_duyet', 'trang_thai', 'thoi_gian_tao'], 'safe'],
            [['chi_phi_thue_du_kien', 'chi_phi_thue_phat_sinh'], 'number'],
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
        $query = PhieuThueXe::find();

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
            'ngay_thue_xe' => $this->ngay_thue_xe,
            'id_hoc_vien' => $this->id_hoc_vien,
            'id_xe' => $this->id_xe,
            'id_loai_hinh_thue' => $this->id_loai_hinh_thue,
            'thoi_gian_bat_dau_thue' => $this->thoi_gian_bat_dau_thue,
            'thoi_gian_tra_xe_du_kien' => $this->thoi_gian_tra_xe_du_kien,
            'chi_phi_thue_du_kien' => $this->chi_phi_thue_du_kien,
            'thoi_gian_tra_xe' => $this->thoi_gian_tra_xe,
            'chi_phi_thue_phat_sinh' => $this->chi_phi_thue_phat_sinh,
            'id_nhan_vien_cho_thue' => $this->id_nhan_vien_cho_thue,
            'ngay_tra_xe' => $this->ngay_tra_xe,
            'id_nhan_vien_ky_tra' => $this->id_nhan_vien_ky_tra,
            'id_nguoi_gui' => $this->id_nguoi_gui,
            'thoi_gian_gui' => $this->thoi_gian_gui,
            'id_nguoi_duyet' => $this->id_nguoi_duyet,
            'thoi_gian_duyet' => $this->thoi_gian_duyet,
            'ghi_chu_nguoi_duyet' => $this->ghi_chu_nguoi_duyet,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'ho_ten_nguoi_thue', $this->ho_ten_nguoi_thue])
            ->andFilterWhere(['like', 'so_cccd_nguoi_thue', $this->so_cccd_nguoi_thue])
            ->andFilterWhere(['like', 'dia_chi_nguoi_thue', $this->dia_chi_nguoi_thue])
            ->andFilterWhere(['like', 'so_dien_thoai_nguoi_thue', $this->so_dien_thoai_nguoi_thue])
            ->andFilterWhere(['like', 'noi_dung_thue', $this->noi_dung_thue])
            ->andFilterWhere(['like', 'tinh_trang_xe_khi_tra', $this->tinh_trang_xe_khi_tra])
            ->andFilterWhere(['like', 'ghi_chu_nguoi_gui', $this->ghi_chu_nguoi_gui])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai]);

        return $dataProvider;
    }
}
