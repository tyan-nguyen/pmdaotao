<?php

namespace app\modules\banhang\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\banhang\models\HoaDon;
use app\custom\CustomFunc;

/**
 * HoaDonSearch represents the model behind the search form about `app\modules\banhang\models\HoaDon`.
 */
class HoaDonSearch extends HoaDon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_khach_hang', 'so_don_hang', 'so_vao_so', 'nam', 'so_lan_in', 'da_giao_hang', 'nguoi_tao', 'edit_mode'], 'integer'],
            [['trang_thai', 'ngay_dat_hang', 'ngay_xuat', 'hinh_thuc_thanh_toan', 'ngay_giao_hang', 'ghi_chu', 'thoi_gian_tao', 'idHocVien', 'idKhachNgoai', 'loai_khach_hang'], 'safe'],
            [['chi_phi_van_chuyen'], 'number'],
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
        $query = HoaDon::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		if($cusomSearch != NULL){
			$query->andFilterWhere ( [ 'OR' ,['like', 'trang_thai', $cusomSearch],
            ['like', 'hinh_thuc_thanh_toan', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
		    if($this->ngay_dat_hang){
		        $this->ngay_dat_hang = CustomFunc::convertDMYToYMD($this->ngay_dat_hang);
		    }
		    if($this->ngay_xuat){
		        $this->ngay_xuat = CustomFunc::convertDMYToYMD($this->ngay_xuat);
		    }
		    if($this->ngay_giao_hang){
		        $this->ngay_giao_hang = CustomFunc::convertDMYToYMD($this->ngay_giao_hang);
		    }
        	$query->andFilterWhere([
                'id' => $this->id,
                //'id_khach_hang' => $this->id_khach_hang,
        	    'loai_khach_hang' => $this->loai_khach_hang,
                'so_don_hang' => $this->so_don_hang,
                'so_vao_so' => $this->so_vao_so,
                'nam' => $this->nam,
                'ngay_dat_hang' => $this->ngay_dat_hang,
                'ngay_xuat' => $this->ngay_xuat,
                'so_lan_in' => $this->so_lan_in,
                'da_giao_hang' => $this->da_giao_hang,
                'ngay_giao_hang' => $this->ngay_giao_hang,
                'chi_phi_van_chuyen' => $this->chi_phi_van_chuyen,
                'nguoi_tao' => $this->nguoi_tao,
                'thoi_gian_tao' => $this->thoi_gian_tao,
            	'edit_mode' => $this->edit_mode
            ]);
        	
        	if($this->idHocVien){
        	    $query->andFilterWhere([
        	        'id_khach_hang' => $this->idHocVien,
        	    ]);
        	}
        	if($this->idKhachNgoai){
        	    $query->andFilterWhere([
        	        'id_khach_hang' => $this->idKhachNgoai,
        	    ]);
        	}

        $query->andFilterWhere(['like', 'trang_thai', $this->trang_thai])
            ->andFilterWhere(['like', 'hinh_thuc_thanh_toan', $this->hinh_thuc_thanh_toan])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
}
