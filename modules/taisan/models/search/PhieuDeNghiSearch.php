<?php

namespace app\modules\taisan\models\search;

use app\custom\CustomFunc;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\taisan\models\PhieuDeNghi;

/**
 * PhieuDeNghiSearch represents the model behind the search form about `app\modules\taisan\models\PhieuDeNghi`.
 */
class PhieuDeNghiSearch extends PhieuDeNghi
{
    public $ngay_hoan_thanh_tu;
    public $ngay_hoan_thanh_den;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'id',
                'id_tham_chieu',
                'nguoi_de_nghi',
                'so_km_luc_yeu_cau',
                'nguoi_duyet',
                'id_dot_tong_hop',
                'nguoi_tao',
                'so_phieu',
                'nam',
                'so_vao_so',
                'da_thanh_toan',
                'so_lan_in',
                'edit_mode',
                'nguoi_thanh_toan'
            ], 'integer'],
            [[
                'loai_phieu',
                'loai_tai_san',
                'loai_yeu_cau',
                'noi_dung_de_nghi',
                'ngay_bat_dau',
                'ngay_hoan_thanh',
                'trang_thai',
                'ngay_duyet',
                'ghi_chu_duyet',
                'phieu_co_chi_tiet',
                'thoi_gian_tao',
                'hinh_thuc_thanh_toan',
                'loai_thanh_toan',
                'ngay_thanh_toan',
                'id_don_vi_thuc_hien',
                'ngay_hoan_thanh_tu',
                'ngay_hoan_thanh_den',
            ], 'safe'],
            [['tong_tien_du_kien', 'tong_tien_thuc_te'], 'number'],
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
    public function search($params, $cusomSearch = NULL)
    {
        $query = PhieuDeNghi::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'ngay_bat_dau' => SORT_DESC,
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($cusomSearch != NULL) {
            $query->andFilterWhere([
                'OR',
                ['like', 'loai_phieu', $cusomSearch],
                ['like', 'loai_tai_san', $cusomSearch],
                ['like', 'loai_yeu_cau', $cusomSearch],
                ['like', 'noi_dung_de_nghi', $cusomSearch],
                ['like', 'trang_thai', $cusomSearch],
                ['like', 'ghi_chu_duyet', $cusomSearch],
                ['like', 'phieu_co_chi_tiet', $cusomSearch]
            ]);
        } else {

            if ($this->ngay_bat_dau) {
                $this->ngay_bat_dau = CustomFunc::convertDMYToYMD($this->ngay_bat_dau);
            }
            $tuNgay = null;
            $denNgay = null;
            if (!empty($this->ngay_hoan_thanh_tu)) {
                $tuNgay = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $this->ngay_hoan_thanh_tu)));
            }

            if (!empty($this->ngay_hoan_thanh_den)) {
                $denNgay = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $this->ngay_hoan_thanh_den)));
            }

            // Tìm kiếm between
            if ($tuNgay && $denNgay) {
                $query->andWhere(['between', 'ngay_hoan_thanh', $tuNgay, $denNgay]);
            }

            // Chỉ có từ ngày
            if ($tuNgay && !$denNgay) {
                $query->andWhere(['>=', 'ngay_hoan_thanh', $tuNgay]);
            }

            // Chỉ có đến ngày
            if (!$tuNgay && $denNgay) {
                $query->andWhere(['<=', 'ngay_hoan_thanh', $denNgay]);
            }

            if ($this->ngay_thanh_toan) {
                $this->ngay_thanh_toan = CustomFunc::convertDMYToYMD($this->ngay_thanh_toan);
                $ngayThanhToanTu = $this->ngay_thanh_toan . ' 00:00:00';
                $ngayThanhToanDen = $this->ngay_thanh_toan . ' 23:59:59';
                $query->andWhere(['>=', 'ngay_thanh_toan', $ngayThanhToanTu])->andWhere(['<=', 'ngay_thanh_toan', $ngayThanhToanDen]);
            }

            $query->andFilterWhere([
                'id' => $this->id,
                'id_tham_chieu' => $this->id_tham_chieu,
                'nguoi_de_nghi' => $this->nguoi_de_nghi,
                'so_km_luc_yeu_cau' => $this->so_km_luc_yeu_cau,
                'ngay_bat_dau' => $this->ngay_bat_dau,
                'ngay_hoan_thanh' => $this->ngay_hoan_thanh,
                'nguoi_duyet' => $this->nguoi_duyet,
                'ngay_duyet' => $this->ngay_duyet,
                'tong_tien_du_kien' => $this->tong_tien_du_kien,
                'tong_tien_thuc_te' => $this->tong_tien_thuc_te,
                'id_dot_tong_hop' => $this->id_dot_tong_hop,
                'thoi_gian_tao' => $this->thoi_gian_tao,
                'nguoi_tao' => $this->nguoi_tao,
                'so_phieu' => $this->so_phieu,
                'nam' => $this->nam,
                'so_vao_so' => $this->so_vao_so,
                'da_thanh_toan' => $this->da_thanh_toan,
                'so_lan_in' => $this->so_lan_in,
                'edit_mode' => $this->edit_mode,
                'nguoi_thanh_toan' => $this->nguoi_thanh_toan,
                'hinh_thuc_thanh_toan' => $this->hinh_thuc_thanh_toan,
                'loai_thanh_toan' => $this->loai_thanh_toan,
                //'ngay_thanh_toan' => $this->ngay_thanh_toan,
                'id_don_vi_thuc_hien' => $this->id_don_vi_thuc_hien,
            ]);

            $query->andFilterWhere(['like', 'loai_phieu', $this->loai_phieu])
                ->andFilterWhere(['like', 'loai_tai_san', $this->loai_tai_san])
                ->andFilterWhere(['like', 'loai_yeu_cau', $this->loai_yeu_cau])
                ->andFilterWhere(['like', 'noi_dung_de_nghi', $this->noi_dung_de_nghi])
                ->andFilterWhere(['like', 'trang_thai', $this->trang_thai])
                ->andFilterWhere(['like', 'ghi_chu_duyet', $this->ghi_chu_duyet]);
        }
        return $dataProvider;
    }
}
