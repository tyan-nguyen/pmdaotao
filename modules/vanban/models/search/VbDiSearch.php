<?php

namespace app\modules\vanban\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\vanban\models\VanBanDi;

/**
 * VBDenSearch represents the model behind the search form about `app\modules\vanban\models\VanBanDen`.
 */
class VbDiSearch extends VanBanDi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_loai_van_ban', 'so_vao_so', 'vbden_nguoi_nhan', 'vbdi_so_luong_ban', 'nguoi_tao'], 'integer'],
            [['so_vb', 'ngay_ky', 'trich_yeu', 'nguoi_ky', 'vbden_ngay_den', 'vbden_ngay_chuyen', 'vbdi_noi_nhan', 'vbdi_ngay_chuyen', 'ghi_chu', 'thoi_gian_tao', 'so_loai_van_ban'], 'safe'],
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
        $query = VanBanDi::find();

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
			$query->andFilterWhere ( [ 'OR' ,
          
            ['like', 'nguoi_nhan', $cusomSearch],
            ['like', 'nguoi_ky', $cusomSearch],
            ['like', 'vbdi_noi_nhan', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch],
            ['like', 'so_loai_van_ban', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'id_loai_van_ban' => $this->id_loai_van_ban,
            'ngay_ky' => $this->ngay_ky,
            'vbden_ngay_den' => $this->vbden_ngay_den,
            'so_vao_so' => $this->so_vao_so,
            'vbden_nguoi_nhan' => $this->vbden_nguoi_nhan,
            'vbden_ngay_chuyen' => $this->vbden_ngay_chuyen,
            'vbdi_so_luong_ban' => $this->vbdi_so_luong_ban,
            'vbdi_ngay_chuyen' => $this->vbdi_ngay_chuyen,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
        ]);

        $query->andFilterWhere(['like', 'so_vb', $this->so_vb])
            ->andFilterWhere(['like', 'trich_yeu', $this->trich_yeu])
            ->andFilterWhere(['like', 'nguoi_ky', $this->nguoi_ky])
            ->andFilterWhere(['like', 'vbdi_noi_nhan', $this->vbdi_noi_nhan])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu])
            ->andFilterWhere(['like', 'so_loai_van_ban', $this->so_loai_van_ban]);
          
		}
        return $dataProvider;
    }
}
