<?php

namespace app\modules\taisan\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\taisan\models\TaiSan;

/**
 * TaiSanSearch represents the model behind the search form about `app\modules\taisan\models\TaiSan`.
 */
class TaiSanSearch extends TaiSan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'loai_tai_san_id', 'danh_muc_id', 'nha_cung_cap_id', 'vi_tri_id', 'phong_ban_id', 'nguoi_chiu_trach_nhiem_id', 'nguoi_tao'], 'integer'],
            [['autoid', 'ma_tai_san', 'ten_tai_san', 'model', 'serial', 'so_hoa_don', 'so_hop_dong', 'ngay_mua', 'thoi_han_bao_hanh', 'ghi_chu_bao_hanh', 'muc_dich_su_dung', 'ngay_dua_vao_su_dung', 'trang_thai', 'ghi_chu', 'thoi_gian_tao'], 'safe'],
            [['so_tien'], 'number'],
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
        $query = TaiSan::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'autoid', $cusomSearch],
            ['like', 'ma_tai_san', $cusomSearch],
            ['like', 'ten_tai_san', $cusomSearch],
            ['like', 'model', $cusomSearch],
            ['like', 'serial', $cusomSearch],
            ['like', 'so_hoa_don', $cusomSearch],
            ['like', 'so_hop_dong', $cusomSearch],
            ['like', 'ghi_chu_bao_hanh', $cusomSearch],
            ['like', 'muc_dich_su_dung', $cusomSearch],
            ['like', 'trang_thai', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'loai_tai_san_id' => $this->loai_tai_san_id,
            'danh_muc_id' => $this->danh_muc_id,
            'so_tien' => $this->so_tien,
            'nha_cung_cap_id' => $this->nha_cung_cap_id,
            'ngay_mua' => $this->ngay_mua,
            'thoi_han_bao_hanh' => $this->thoi_han_bao_hanh,
            'vi_tri_id' => $this->vi_tri_id,
            'phong_ban_id' => $this->phong_ban_id,
            'nguoi_chiu_trach_nhiem_id' => $this->nguoi_chiu_trach_nhiem_id,
            'ngay_dua_vao_su_dung' => $this->ngay_dua_vao_su_dung,
            'thoi_gian_tao' => $this->thoi_gian_tao,
            'nguoi_tao' => $this->nguoi_tao,
        ]);

        $query->andFilterWhere(['like', 'autoid', $this->autoid])
            ->andFilterWhere(['like', 'ma_tai_san', $this->ma_tai_san])
            ->andFilterWhere(['like', 'ten_tai_san', $this->ten_tai_san])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'serial', $this->serial])
            ->andFilterWhere(['like', 'so_hoa_don', $this->so_hoa_don])
            ->andFilterWhere(['like', 'so_hop_dong', $this->so_hop_dong])
            ->andFilterWhere(['like', 'ghi_chu_bao_hanh', $this->ghi_chu_bao_hanh])
            ->andFilterWhere(['like', 'muc_dich_su_dung', $this->muc_dich_su_dung])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
}
