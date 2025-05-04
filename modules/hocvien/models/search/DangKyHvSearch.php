<?php

namespace app\modules\hocvien\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\hocvien\models\DangKyHv;
use app\custom\CustomFunc;
use yii\db\Expression;
use app\modules\user\models\User;

/**
 * DangKyHvSearch represents the model behind the search form about `app\modules\hocvien\models\DangKyHv`.
 */
class DangKyHvSearch extends DangKyHv
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_khoa_hoc', 'nguoi_tao', 'id_hang','gioi_tinh', 'da_nhan_ao'], 'integer'],
            [['ho_ten', 'so_dien_thoai', 'so_cccd', 'trang_thai', 'thoi_gian_tao', 'ngay_sinh', 'nguoi_tao', 'thoi_gian_hoan_thanh_ho_so', 'dia_chi', 'size', 'ngay_nhan_ao', 'noi_dang_ky'], 'safe'],
        ];
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
        $query = DangKyHv::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if($this->ngay_nhan_ao){
            $this->ngay_nhan_ao = CustomFunc::convertDMYToYMD($this->ngay_nhan_ao);
        }
        if($this->thoi_gian_hoan_thanh_ho_so){
            $this->thoi_gian_hoan_thanh_ho_so = CustomFunc::convertDMYToYMD($this->thoi_gian_hoan_thanh_ho_so);
            $query->where("DATE(thoi_gian_hoan_thanh_ho_so) = '" . $this->thoi_gian_hoan_thanh_ho_so."'");
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_khoa_hoc' => $this->id_khoa_hoc,
            'nguoi_tao' => $this->nguoi_tao,
            'thoi_gian_tao' => $this->thoi_gian_tao,
            'gioi_tinh'=>$this->gioi_tinh,
            'id_hang'=>$this->id_hang,
            'nguoi_tao'=>$this->nguoi_tao,
            'da_nhan_ao' => $this->da_nhan_ao,
            'ngay_nhan_ao' => $this->ngay_nhan_ao,
            'size' => $this->size,
            'noi_dang_ky' => $this->noi_dang_ky
        ]);

        $query->andFilterWhere(['like', 'ho_ten', $this->ho_ten])
            ->andFilterWhere(['like', 'dia_chi', $this->dia_chi])
            ->andFilterWhere(['like', 'so_dien_thoai', $this->so_dien_thoai])
            ->andFilterWhere(['like', 'so_cccd', $this->so_cccd])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai])
           // ->andFilterWhere(['like', 'id_hang', $this->id_hang])
            ->andFilterWhere(['like', 'ngay_sinh', $this->ngay_sinh]);
        
       //load danh sách của cơ sở nhân viên nhận hồ sơ 
        $user = User::getCurrentUser();
        if(!$user->superadmin && $user->noi_dang_ky){
            $query->andFilterWhere([
                'noi_dang_ky' => $user->noi_dang_ky
            ]);
        }

        return $dataProvider;
    }
    
    /* Creates data provider instance with search query applied
     * search hồ sơ đã nộp 50% học phí
    *
    * @param array $params
    *
    * @return ActiveDataProvider
    */
    public function searchHoSo($params)
    {
        $query = DangKyHv::find()->alias('t');
        $query->joinWith(['hocPhi as hp']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['thoi_gian_hoan_thanh_ho_so'=>SORT_DESC, 'id' => SORT_DESC]],
        ]);
        
        $this->load($params);
        
        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //'(SELECT thoi_gian_tao as ngayhoanthanhhoso FROM hv_nop_hoc_phi AS i, hv_hoc_phi as h WHERE t.id = i.id_hoc_vien AND h.id=t._id_hoc_phi AND i.so_tien_con_lai <= h.hoc_phi/2)'
        /* $query=$query->andFilterWhere(['>', '(SELECT SUM(i.so_tien_nop) FROM hv_nop_hoc_phi AS i WHERE t.id = i.id_hoc_vien)', 2000000]); */ //tạm sét > 2tr là đóng 50% học phí
        //$query->andFilterWhere([]);
       
        /* 
        $query->andWhere('(SELECT i.so_tien_con_lai FROM hv_nop_hoc_phi AS i WHERE t.id = i.id_hoc_vien) <= hp.hoc_phi'); */
        $query->andWhere('t.thoi_gian_hoan_thanh_ho_so IS NOT NULL');
        $query->andFilterWhere([
            't.id' => $this->id,
            't.id_khoa_hoc' => $this->id_khoa_hoc,
            't.nguoi_tao' => $this->nguoi_tao,
            't.thoi_gian_tao' => $this->thoi_gian_tao,
            't.gioi_tinh'=>$this->gioi_tinh,
            't.id_hang'=>$this->id_hang,
            //'t.nguoi_tao'=>$this->nguoi_tao,
        ]);
        
        $query->andFilterWhere(['like', 't.ho_ten', $this->ho_ten])
        ->andFilterWhere(['like', 'dia_chi', $this->dia_chi])
        ->andFilterWhere(['like', 't.so_dien_thoai', $this->so_dien_thoai])
        ->andFilterWhere(['like', 't.so_cccd', $this->so_cccd])
        ->andFilterWhere(['like', 't.trang_thai', $this->trang_thai])
        // ->andFilterWhere(['like', 'id_hang', $this->id_hang])
        ->andFilterWhere(['like', 't.ngay_sinh', $this->ngay_sinh]);
        
        return $dataProvider;
    }
}
