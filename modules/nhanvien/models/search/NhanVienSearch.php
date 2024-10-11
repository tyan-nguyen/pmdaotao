<?php

namespace app\modules\nhanvien\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\nhanvien\models\NhanVien;

/**
 * NhanVienSearch đại diện cho mô hình phía sau form tìm kiếm về `app\modules\nhanvien\models\NhanVien`.
 */
class NhanVienSearch extends NhanVien
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_phong_ban', 'tai_khoan', 'nguoi_tao', 'gioi_tinh','doi_tuong'], 'integer'],
            [['ho_ten', 'chuc_vu', 'so_cccd', 'dia_chi', 'dien_thoai', 'email', 'trinh_do', 'chuyen_nganh', 'vi_tri_cong_viec', 'kinh_nghiem_lam_viec', 'ma_so_thue', 'trang_thai', 'thoi_gian_tao'], 'safe'],
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
        $query = NhanVien::find();

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
            'id_phong_ban' => $this->id_phong_ban,
            'tai_khoan' => $this->tai_khoan,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'ho_ten', $this->ho_ten])
            ->andFilterWhere(['like', 'chuc_vu', $this->chuc_vu])
            ->andFilterWhere(['like', 'so_cccd', $this->so_cccd])
            ->andFilterWhere(['like', 'dia_chi', $this->dia_chi])
            ->andFilterWhere(['like', 'dien_thoai', $this->dien_thoai])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'trinh_do', $this->trinh_do])
            ->andFilterWhere(['like', 'chuyen_nganh', $this->chuyen_nganh])
            ->andFilterWhere(['like', 'vi_tri_cong_viec', $this->vi_tri_cong_viec])
            ->andFilterWhere(['like', 'kinh_nghiem_lam_viec', $this->kinh_nghiem_lam_viec])
            ->andFilterWhere(['like', 'ma_so_thue', $this->ma_so_thue])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai])
            ->andFilterWhere(['like', 'doi_tuong', $this->doi_tuong])
            ->andFilterWhere(['like', 'gioi_tinh', $this->gioi_tinh]);

        return $dataProvider;
    }
}
