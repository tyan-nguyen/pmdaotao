<?php

namespace app\modules\taisan\models\search;

use app\custom\CustomFunc;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\taisan\models\PhieuDeNghi;
use app\modules\user\models\User;

/**
 * PhieuDeNghiSearch represents the model behind the search form about `app\modules\taisan\models\PhieuDeNghi`.
 */
class PhieuSuaXeSearch extends PhieuDeNghi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_tham_chieu', 'nguoi_de_nghi', 'so_km_luc_yeu_cau', 'nguoi_duyet', 'id_dot_tong_hop', 'nguoi_tao'], 'integer'],
            [['loai_phieu', 'loai_tai_san', 'loai_yeu_cau', 'noi_dung_de_nghi', 'ngay_bat_dau', 'ngay_hoan_thanh', 'trang_thai', 
            'ngay_duyet', 'ghi_chu_duyet', 'phieu_co_chi_tiet', 'thoi_gian_tao', 'id_don_vi_thuc_hien'], 'safe'],
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
            $query->andFilterWhere([
                'loai_phieu' => PhieuDeNghi::LOAIPHIEU_SUACHUA,
                'loai_tai_san' => PhieuDeNghi::LOAITAISAN_XE
            ]);
        } else {

            if ($this->ngay_bat_dau) {
                $this->ngay_bat_dau = CustomFunc::convertDMYToYMD($this->ngay_bat_dau);
            }
            if ($this->ngay_hoan_thanh) {
                $this->ngay_hoan_thanh = CustomFunc::convertDMYToYMD($this->ngay_hoan_thanh);
            }

            $user = User::getcurrentUser();
            if ($user->superadmin || User::hasRole('Admin')) {
                $query->andFilterWhere([
                    'nguoi_tao' => $this->nguoi_tao,
                ]);
            } else {
                 $query->andFilterWhere([
                    'nguoi_tao' => Yii::$app->user->id, //chỉ lấy của người đang đăng nhập
                ]);
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
                'loai_phieu' => PhieuDeNghi::LOAIPHIEU_SUACHUA,
                'loai_tai_san' => PhieuDeNghi::LOAITAISAN_XE,
                'id_don_vi_thuc_hien' => $this->id_don_vi_thuc_hien,
            ]);

            $query->andFilterWhere(['like', 'loai_yeu_cau', $this->loai_yeu_cau])
                ->andFilterWhere(['like', 'noi_dung_de_nghi', $this->noi_dung_de_nghi])
                ->andFilterWhere(['like', 'trang_thai', $this->trang_thai])
                ->andFilterWhere(['like', 'ghi_chu_duyet', $this->ghi_chu_duyet]);
        }
        return $dataProvider;
    }
}
