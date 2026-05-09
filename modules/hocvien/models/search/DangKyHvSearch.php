<?php

namespace app\modules\hocvien\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\hocvien\models\DangKyHv;
use app\custom\CustomFunc;
use app\modules\hocvien\models\BaoLuu;
use yii\db\Expression;
use app\modules\user\models\User;

/**
 * DangKyHvSearch represents the model behind the search form about `app\modules\hocvien\models\DangKyHv`.
 */
class DangKyHvSearch extends DangKyHv
{
    public $noiNhanAo; //search noi nhan ao
    public $noiNhanTaiLieu; //search noi nhan ho so
    public $ngay_dang_ky_tu;
    public $ngay_dang_ky_den;
    public $co_lien_ket; //checkbox có liên kết hay không
    public $co_nhan_ho_so_ho; //checkbox có nhận hồ sơ hộ hay không
    public $co_bao_luu; //checkbox có bảo lưu hay không

    public function attributeLabels()
    {
        // Lấy các label mặc định từ model cha (nếu có)
        $labels = parent::attributeLabels();

        // Ghi đè hoặc thêm mới label cho thuộc tính ảo
        $labels['co_lien_ket'] = 'HV liên kết';
        $labels['co_nhan_ho_so_ho'] = 'Nhận HS hộ';

        return $labels;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_khoa_hoc', 'nguoi_tao', 'id_hang', 'gioi_tinh', 'da_nhan_ao', 'da_nhan_tai_lieu', 'id_lien_ket', 'id_nhan_ho_so_ho'], 'integer'],
            [[
                'ho_ten',
                'so_dien_thoai',
                'so_cccd',
                'trang_thai',
                'thoi_gian_tao',
                'ngay_sinh',
                'nguoi_tao',
                'thoi_gian_hoan_thanh_ho_so',
                'dia_chi',
                'size',
                'ngay_nhan_ao',
                'noi_dang_ky',
                'huy_ho_so',
                'ghi_chu',
                'ngay_dang_ky_tu',
                'ngay_dang_ky_den',
                'ngay_nhan_tai_lieu',
                'noiNhanAo',
                'noiNhanTaiLieu',
                'label',
                'co_lien_ket',
                'co_nhan_ho_so_ho',
                'co_bao_luu'
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->noiNhanAo != null && $this->noiNhanTaiLieu != null) {
            $query->joinWith(['nguoiGiaoAo ga', 'nguoiGiaoTaiLieu gtl']);
        } else if ($this->noiNhanAo != null) {
            $query->joinWith(['nguoiGiaoAo ga']);
        } else if ($this->noiNhanTaiLieu != null) {
            $query->joinWith(['nguoiGiaoTaiLieu gtl']);
        }

        if ($this->noiNhanAo != null) {
            $query->andFilterWhere(['ga.noi_dang_ky' => $this->noiNhanAo]);
        }
        if ($this->noiNhanTaiLieu != null) {
            $query->andFilterWhere(['gtl.noi_dang_ky' => $this->noiNhanTaiLieu]);
        }

        if ($this->ngay_nhan_ao) {
            $this->ngay_nhan_ao = CustomFunc::convertDMYToYMD($this->ngay_nhan_ao);
        }
        if ($this->ngay_nhan_tai_lieu) {
            $this->ngay_nhan_tai_lieu = CustomFunc::convertDMYToYMD($this->ngay_nhan_tai_lieu);
        }
        if ($this->thoi_gian_hoan_thanh_ho_so) {
            $this->thoi_gian_hoan_thanh_ho_so = CustomFunc::convertDMYToYMD($this->thoi_gian_hoan_thanh_ho_so);
            $query->where("DATE(t.thoi_gian_hoan_thanh_ho_so) = '" . $this->thoi_gian_hoan_thanh_ho_so . "'");
        }

        /* if($this->thoi_gian_tao){
            $this->thoi_gian_tao = CustomFunc::convertDMYToYMD($this->thoi_gian_tao);
            $query->where("DATE(t.thoi_gian_tao) = '" . $this->thoi_gian_tao."'");
        } */

        //xử lý ngày đăng ký từ - đến
        // form search d/m/Y -> convert về Y-m-d
        $tuNgay = null;
        $denNgay = null;

        if (!empty($this->ngay_dang_ky_tu)) {
            $tuNgay = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $this->ngay_dang_ky_tu)));
        }

        if (!empty($this->ngay_dang_ky_den)) {
            $denNgay = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $this->ngay_dang_ky_den)));
        }

        // Tìm kiếm between
        if ($tuNgay && $denNgay) {
            $query->andWhere(['between', 'thoi_gian_tao', $tuNgay, $denNgay]);
        }

        // Chỉ có từ ngày
        if ($tuNgay && !$denNgay) {
            $query->andWhere(['>=', 'thoi_gian_tao', $tuNgay]);
        }

        // Chỉ có đến ngày
        if (!$tuNgay && $denNgay) {
            $query->andWhere(['<=', 'thoi_gian_tao', $denNgay]);
        }

        $query->andFilterWhere([
            't.id' => $this->id,
            't.id_khoa_hoc' => $this->id_khoa_hoc,
            't.nguoi_tao' => $this->nguoi_tao,
            //'thoi_gian_tao' => $this->thoi_gian_tao,
            't.gioi_tinh' => $this->gioi_tinh,
            't.id_hang' => $this->id_hang,
            //'nguoi_tao'=>$this->nguoi_tao,
            't.da_nhan_ao' => $this->da_nhan_ao,
            't.ngay_nhan_ao' => $this->ngay_nhan_ao,
            't.ngay_nhan_tai_lieu' => $this->ngay_nhan_tai_lieu,
            't.size' => $this->size,
            't.da_nhan_tai_lieu' => $this->da_nhan_tai_lieu,
            't.noi_dang_ky' => $this->noi_dang_ky,
            't.label' => $this->label,
            't.id_lien_ket' => $this->id_lien_ket,
            't.id_nhan_ho_so_ho' => $this->id_nhan_ho_so_ho,
        ]);

        if ($this->huy_ho_so) {
            $query->andFilterWhere([
                't.huy_ho_so' => $this->huy_ho_so,
            ]);
        } else {
            $query->andFilterWhere([
                't.huy_ho_so' => 0,
            ]);
        }

        $query->andFilterWhere(['like', 't.ho_ten', $this->ho_ten])
            ->andFilterWhere(['like', 't.dia_chi', $this->dia_chi])
            ->andFilterWhere(['like', 't.so_dien_thoai', $this->so_dien_thoai])
            ->andFilterWhere(['like', 't.so_cccd', $this->so_cccd])
            ->andFilterWhere(['like', 't.trang_thai', $this->trang_thai])
            // ->andFilterWhere(['like', 'id_hang', $this->id_hang])
            ->andFilterWhere(['like', 't.ngay_sinh', $this->ngay_sinh])
            ->andFilterWhere(['like', 't.ghi_chu', $this->ghi_chu]);

        if ($this->co_lien_ket) {
            $query->andWhere('id_lien_ket > 0');
        }
        if ($this->co_nhan_ho_so_ho) {
            $query->andWhere('id_nhan_ho_so_ho > 0');
        }

        //check bao luu
        if ($this->co_bao_luu) {
            $query->andWhere(['exists', BaoLuu::find()->where('id_hoc_vien = t.id')]);
        }
        //load danh sách của cơ sở nhân viên nhận hồ sơ 
        /* $user = User::getCurrentUser();
        if(!$user->superadmin && $user->noi_dang_ky){
            $query->andFilterWhere([
                'noi_dang_ky' => $user->noi_dang_ky
            ]);
        } */

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
            //'sort'=> ['defaultOrder' => ['thoi_gian_hoan_thanh_ho_so'=>SORT_DESC, 'id' => SORT_DESC]],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
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
        // $query->andWhere('t.thoi_gian_hoan_thanh_ho_so IS NOT NULL'); //an theo yeu cau phong dao tao
        $query->andFilterWhere([
            't.id' => $this->id,
            't.id_khoa_hoc' => $this->id_khoa_hoc,
            't.nguoi_tao' => $this->nguoi_tao,
            't.thoi_gian_tao' => $this->thoi_gian_tao,
            't.gioi_tinh' => $this->gioi_tinh,
            't.id_hang' => $this->id_hang,
            't.noi_dang_ky' => $this->noi_dang_ky,
            //'t.nguoi_tao'=>$this->nguoi_tao,
        ]);

        if ($this->huy_ho_so) {
            $query->andFilterWhere([
                't.huy_ho_so' => $this->huy_ho_so,
            ]);
        } else {
            $query->andFilterWhere([
                't.huy_ho_so' => 0,
            ]);
        }

        $query->andFilterWhere(['like', 't.ho_ten', $this->ho_ten])
            ->andFilterWhere(['like', 'dia_chi', $this->dia_chi])
            ->andFilterWhere(['like', 't.so_dien_thoai', $this->so_dien_thoai])
            ->andFilterWhere(['like', 't.so_cccd', $this->so_cccd])
            ->andFilterWhere(['like', 't.trang_thai', $this->trang_thai])
            // ->andFilterWhere(['like', 'id_hang', $this->id_hang])
            ->andFilterWhere(['like', 't.ngay_sinh', $this->ngay_sinh]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchHuyHoSo($params)
    {
        $query = DangKyHv::find()->alias('t');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['thoi_gian_huy_ho_so' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->noiNhanAo != null && $this->noiNhanTaiLieu != null) {
            $query->joinWith(['nguoiGiaoAo ga', 'nguoiGiaoTaiLieu gtl']);
        } else if ($this->noiNhanAo != null) {
            $query->joinWith(['nguoiGiaoAo ga']);
        } else if ($this->noiNhanTaiLieu != null) {
            $query->joinWith(['nguoiGiaoTaiLieu gtl']);
        }

        if ($this->noiNhanAo != null) {
            $query->andFilterWhere(['ga.noi_dang_ky' => $this->noiNhanAo]);
        }
        if ($this->noiNhanTaiLieu != null) {
            $query->andFilterWhere(['gtl.noi_dang_ky' => $this->noiNhanTaiLieu]);
        }

        if ($this->ngay_nhan_ao) {
            $this->ngay_nhan_ao = CustomFunc::convertDMYToYMD($this->ngay_nhan_ao);
        }
        if ($this->ngay_nhan_tai_lieu) {
            $this->ngay_nhan_tai_lieu = CustomFunc::convertDMYToYMD($this->ngay_nhan_tai_lieu);
        }
        if ($this->thoi_gian_hoan_thanh_ho_so) {
            $this->thoi_gian_hoan_thanh_ho_so = CustomFunc::convertDMYToYMD($this->thoi_gian_hoan_thanh_ho_so);
            $query->where("DATE(t.thoi_gian_hoan_thanh_ho_so) = '" . $this->thoi_gian_hoan_thanh_ho_so . "'");
        }
        if ($this->thoi_gian_tao) {
            $this->thoi_gian_tao = CustomFunc::convertDMYToYMD($this->thoi_gian_tao);
            $query->where("DATE(t.thoi_gian_tao) = '" . $this->thoi_gian_tao . "'");
        }

        $query->andFilterWhere([
            't.id' => $this->id,
            't.id_khoa_hoc' => $this->id_khoa_hoc,
            't.nguoi_tao' => $this->nguoi_tao,
            //'thoi_gian_tao' => $this->thoi_gian_tao,
            't.gioi_tinh' => $this->gioi_tinh,
            't.id_hang' => $this->id_hang,
            //'nguoi_tao'=>$this->nguoi_tao,
            't.da_nhan_ao' => $this->da_nhan_ao,
            't.ngay_nhan_ao' => $this->ngay_nhan_ao,
            't.ngay_nhan_tai_lieu' => $this->ngay_nhan_tai_lieu,
            't.size' => $this->size,
            't.da_nhan_tai_lieu' => $this->da_nhan_tai_lieu,
            't.noi_dang_ky' => $this->noi_dang_ky,
            't.label' => $this->label,
        ]);

        /* if($this->huy_ho_so){
            $query->andFilterWhere([
                't.huy_ho_so' => $this->huy_ho_so,
            ]);
        } else { */
        $query->andFilterWhere([
            't.huy_ho_so' => 1,
        ]);
        /* } */

        $query->andFilterWhere(['like', 't.ho_ten', $this->ho_ten])
            ->andFilterWhere(['like', 't.dia_chi', $this->dia_chi])
            ->andFilterWhere(['like', 't.so_dien_thoai', $this->so_dien_thoai])
            ->andFilterWhere(['like', 't.so_cccd', $this->so_cccd])
            ->andFilterWhere(['like', 't.trang_thai', $this->trang_thai])
            // ->andFilterWhere(['like', 'id_hang', $this->id_hang])
            ->andFilterWhere(['like', 't.ngay_sinh', $this->ngay_sinh])
            ->andFilterWhere(['like', 't.ghi_chu', $this->ghi_chu]);

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
