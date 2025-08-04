<?php

namespace app\modules\thuexe\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\thuexe\models\LichThue;
use app\custom\CustomFunc;

/**
 * LichThueSearch represents the model behind the search form about `app\modules\thuexe\models\LichThue`.
 */
class LichThueSearch extends LichThue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_giao_vien', 'id_khach_hang', 'id_xe', 'nguoi_tao'], 'integer'],
            [['loai_giao_vien', 'loai_khach_hang', 'thoi_gian_bat_dau', 'thoi_gian_ket_thuc', 'trang_thai', 'ghi_chu', 'thoi_gian_tao', 'ngay_bat_dau', 'idHocVien', 'idKhachNgoai', 'idGiaoVien', 'idGiaoVienNgoai'], 'safe'],
            [['so_gio', 'don_gia'], 'number'],
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
        $query = LichThue::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'loai_giao_vien', $cusomSearch],
            ['like', 'loai_khach_hang', $cusomSearch],
            ['like', 'trang_thai', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
		    if($this->ngay_bat_dau){
		        $this->ngay_bat_dau = CustomFunc::convertDMYToYMD($this->ngay_bat_dau);
		        $query->where("DATE(thoi_gian_bat_dau) = '" . $this->ngay_bat_dau."'");
		    }
		    
        	$query->andFilterWhere([
            'id' => $this->id,
            'id_giao_vien' => $this->id_giao_vien,
            'id_khach_hang' => $this->id_khach_hang,
            'id_xe' => $this->id_xe,
            'thoi_gian_bat_dau' => $this->thoi_gian_bat_dau,
            'thoi_gian_ket_thuc' => $this->thoi_gian_ket_thuc,
            'so_gio' => $this->so_gio,
            'don_gia' => $this->don_gia,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
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
    	
    	if($this->idGiaoVien){
    	    $query->andFilterWhere([
    	        'id_giao_vien' => $this->idGiaoVien,
    	    ]);
    	}
    	if($this->idGiaoVienNgoai){
    	    $query->andFilterWhere([
    	        'id_giao_vien' => $this->idGiaoVienNgoai,
    	    ]);
    	}

        $query->andFilterWhere(['like', 'loai_giao_vien', $this->loai_giao_vien])
            ->andFilterWhere(['like', 'loai_khach_hang', $this->loai_khach_hang])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
}
