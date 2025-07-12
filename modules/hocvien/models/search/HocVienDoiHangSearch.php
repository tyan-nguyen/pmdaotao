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
class HocVienDoiHangSearch extends DangKyHv
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_khoa_hoc', 'nguoi_tao', 'id_hang','gioi_tinh', 'da_nhan_ao'], 'integer'],
            [['ho_ten', 'so_dien_thoai', 'so_cccd', 'trang_thai', 'thoi_gian_tao', 'ngay_sinh', 'nguoi_tao', 'thoi_gian_hoan_thanh_ho_so', 'dia_chi', 'size', 'ngay_nhan_ao', 'noi_dang_ky', 'huy_ho_so', 'ghi_chu',
                'thoi_gian_thay_doi', 'so_tien'
            ], 'safe'],
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
        $query = DangKyHv::find()->alias('t');
        //important
        //$query->joinWith('thayDoiHangs', false); // false = inner join
        $query->innerJoin('hv_hoc_vien_thay_doi_hoc_phi', 'hv_hoc_vien_thay_doi_hoc_phi.id_hoc_vien = t.id');
        //$query->distinct();
        $query->select(['t.*', 'hv_hoc_vien_thay_doi_hoc_phi.so_tien as so_tien', 'hv_hoc_vien_thay_doi_hoc_phi.thoi_gian_thay_doi as thoi_gian_thay_doi']);
        
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
        if($this->thoi_gian_tao){
            $this->thoi_gian_tao = CustomFunc::convertDMYToYMD($this->thoi_gian_tao);
            $query->where("DATE(thoi_gian_tao) = '" . $this->thoi_gian_tao."'");
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'id_khoa_hoc' => $this->id_khoa_hoc,
            'nguoi_tao' => $this->nguoi_tao,
            //'thoi_gian_tao' => $this->thoi_gian_tao,
            'gioi_tinh'=>$this->gioi_tinh,
            'id_hang'=>$this->id_hang,
            'nguoi_tao'=>$this->nguoi_tao,
            'da_nhan_ao' => $this->da_nhan_ao,
            'ngay_nhan_ao' => $this->ngay_nhan_ao,
            'size' => $this->size,
            'noi_dang_ky' => $this->noi_dang_ky,
        ]);
        
        if($this->huy_ho_so){
            $query->andFilterWhere([
                'huy_ho_so' => $this->huy_ho_so,
            ]);
        } else {
            $query->andFilterWhere([
                'huy_ho_so' => 0,
            ]);
        }
        
        $query->andFilterWhere(['like', 'ho_ten', $this->ho_ten])
        ->andFilterWhere(['like', 'dia_chi', $this->dia_chi])
        ->andFilterWhere(['like', 'so_dien_thoai', $this->so_dien_thoai])
        ->andFilterWhere(['like', 'so_cccd', $this->so_cccd])
        ->andFilterWhere(['like', 'trang_thai', $this->trang_thai])
        // ->andFilterWhere(['like', 'id_hang', $this->id_hang])
        ->andFilterWhere(['like', 'ngay_sinh', $this->ngay_sinh])
        ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
        
        //load danh sách của cơ sở nhân viên nhận hồ sơ
        /* $user = User::getCurrentUser();
         if(!$user->superadmin && $user->noi_dang_ky){
         $query->andFilterWhere([
         'noi_dang_ky' => $user->noi_dang_ky
         ]);
         } */
        
        return $dataProvider;
    }
}
