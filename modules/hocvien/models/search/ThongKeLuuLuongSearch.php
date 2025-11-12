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
class ThongKeLuuLuongSearch extends DangKyHv
{
    public $noiNhanAo;//search noi nhan ao
    public $noiNhanTaiLieu;//search noi nhan ho so
    
    public $ngay_sinh_tu;
    public $ngay_sinh_den;
    public $tuoi_tu;
    public $tuoi_den;
    
    public $id_hangs;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_khoa_hoc', 'nguoi_tao', 'id_hang','gioi_tinh', 'da_nhan_ao', 
                'da_nhan_tai_lieu'], 'integer'],
            [['ho_ten', 'so_dien_thoai', 'so_cccd', 'trang_thai', 'thoi_gian_tao', 
                'ngay_sinh', 'nguoi_tao', 'thoi_gian_hoan_thanh_ho_so', 'dia_chi', 'size', 
                'ngay_nhan_ao', 'noi_dang_ky', 'huy_ho_so', 'ghi_chu', 'ngay_nhan_tai_lieu', 
                'noiNhanAo', 'noiNhanTaiLieu',
                'ngay_sinh_tu', 'ngay_sinh_den', 'tuoi_tu', 'tuoi_den', 'id_xa', 'id_tinh', 
                'id_hangs'], 'safe'],
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
        
        if($this->noiNhanAo != null && $this->noiNhanTaiLieu != null){
            $query->joinWith(['nguoiGiaoAo ga', 'nguoiGiaoTaiLieu gtl']);
        } else if($this->noiNhanAo != null){
            $query->joinWith(['nguoiGiaoAo ga']);
        } else if($this->noiNhanTaiLieu != null){
            $query->joinWith(['nguoiGiaoTaiLieu gtl']);
        }
        
        if($this->noiNhanAo != null){
            $query->andFilterWhere(['ga.noi_dang_ky' => $this->noiNhanAo]);
        }
        if($this->noiNhanTaiLieu != null){
            $query->andFilterWhere(['gtl.noi_dang_ky' => $this->noiNhanTaiLieu]);
        }
        
        if($this->ngay_nhan_ao){
            $this->ngay_nhan_ao = CustomFunc::convertDMYToYMD($this->ngay_nhan_ao);
        }
        if($this->ngay_nhan_tai_lieu){
            $this->ngay_nhan_tai_lieu = CustomFunc::convertDMYToYMD($this->ngay_nhan_tai_lieu);
        }
        if($this->thoi_gian_hoan_thanh_ho_so){
            $this->thoi_gian_hoan_thanh_ho_so = CustomFunc::convertDMYToYMD($this->thoi_gian_hoan_thanh_ho_so);
            $query->where("DATE(thoi_gian_hoan_thanh_ho_so) = '" . $this->thoi_gian_hoan_thanh_ho_so."'");
        }
        if($this->thoi_gian_tao){
            $this->thoi_gian_tao = CustomFunc::convertDMYToYMD($this->thoi_gian_tao);
            $query->where("DATE(thoi_gian_tao) = '" . $this->thoi_gian_tao."'");
        }
        
        //có cả từ ngày & đến ngày
        if(!empty($this->ngay_sinh_tu) && !empty($this->ngay_sinh_den) ){
            $this->ngay_sinh_tu = CustomFunc::convertDMYToYMD($this->ngay_sinh_tu);
            $this->ngay_sinh_den = CustomFunc::convertDMYToYMD($this->ngay_sinh_den);
            $query->andFilterWhere(['between', 'ngay_sinh', $this->ngay_sinh_tu, $this->ngay_sinh_den]);
        }
        
        // Nếu chỉ có từ ngày
        if (!empty($this->ngay_sinh_tu) && empty($this->ngay_sinh_den)) {
            $this->ngay_sinh_tu = CustomFunc::convertDMYToYMD($this->ngay_sinh_tu);
            $query->andFilterWhere(['>=', 'ngay_sinh', $this->ngay_sinh_tu]);
        }
        
        // Nếu chỉ có đến ngày
        if (empty($this->ngay_sinh_tu) && !empty($this->ngay_sinh_den)) {
            $this->ngay_sinh_den = CustomFunc::convertDMYToYMD($this->ngay_sinh_den);
            $query->andFilterWhere(['<=', 'ngay_sinh', $this->ngay_sinh_den]);
        }
        
        // có cả tuổi từ, tuổi đến
        if (!empty($this->tuoi_tu) && !empty($this->tuoi_den)) {
            if ($this->tuoi_tu == $this->tuoi_den) {
                $from = date('Y-m-d', strtotime('-' . $this->tuoi_tu . ' years'));
                $to   = date('Y-m-d', strtotime('-' .  ($this->tuoi_tu + 1) . ' years +1 day'));
                
                $query->andFilterWhere([
                    'between',
                    'ngay_sinh',
                    $to,
                    $from,
                ]);
                
            } else {
                $query->andFilterWhere([
                    'between',
                    'ngay_sinh',
                    date('Y-m-d', strtotime('-'.$this->tuoi_den.' years')),
                    date('Y-m-d', strtotime('-'.$this->tuoi_tu.' years')),
                ]);
            }
        }elseif (!empty($this->tuoi_tu)) {
            // --- CHỈ CÓ tuoi_tu (tìm lớn hơn hoặc bằng) ---
            $to = date('Y-m-d', strtotime('-' . $this->tuoi_tu . ' years'));
            $query->andFilterWhere(['<=', 'ngay_sinh', $to]);
            
        } elseif (!empty($this->tuoi_den)) {
            // --- CHỈ CÓ tuoi_den (tìm nhỏ hơn hoặc bằng) ---
            $from = date('Y-m-d', strtotime('-' . $this->tuoi_den . ' years'));
            $query->andFilterWhere(['>=', 'ngay_sinh', $from]);
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
            'ngay_nhan_tai_lieu' => $this->ngay_nhan_tai_lieu,
            'size' => $this->size,
            'da_nhan_tai_lieu' => $this->da_nhan_tai_lieu,
            'noi_dang_ky' => $this->noi_dang_ky,
            
            'id_xa'=>$this->id_xa,
            'id_tinh'=>$this->id_tinh,
        ]);
        
        /* if($this->id_hang){
            if(count($this->id_hang) ==1 ){
                $query->andFilterWhere([
                    'id_hang'=>$this->id_hang,
                ]);
            }
        } */
        
        if($this->id_hangs){
            $cauLenh = '';
            $cauLenh = implode(',', $this->id_hangs);
            $cauLenh = 'IN (' . $cauLenh . ')';
            $query->andWhere('id_hang '.$cauLenh);
        }
                
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
