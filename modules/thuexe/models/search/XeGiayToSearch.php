<?php

namespace app\modules\thuexe\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\thuexe\models\XeGiayTo;
use app\modules\thuexe\models\base\XeGiayToBase;
use app\modules\thuexe\models\base\LoaiGiayToBase;
use app\custom\CustomFunc;

/**
 * XeGiayToSearch represents the model behind the search form about `app\modules\thuexe\models\XeGiayTo`.
 */
class XeGiayToSearch extends XeGiayTo
{
    public $tinh_trang_han;
    public $bien_so_xe;

    /**
     * Danh mục tình trạng hạn cho search
     * @return array
     */
    public static function getDmTinhTrangHan()
    {
        return [
            'HET_HAN' => 'Hết hạn',
            'SAP_HET' => 'Sắp hết hạn',
            'TRONG_HAN' => 'Trong hạn',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_xe', 'id_loai_giay_to', 'is_active', 'nguoi_tao'], 'integer'],
            [['ngay_bat_dau', 'ngay_ket_thuc', 'ghi_chu', 'thoi_gian_tao', 'tinh_trang_han', 'bien_so_xe'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'tinh_trang_han' => 'Tình trạng hết hạn',
            'bien_so_xe' => 'Biển số xe',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = XeGiayTo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ptx_xe_giay_to.id' => $this->id,
            'ptx_xe_giay_to.id_xe' => $this->id_xe,
            'ptx_xe_giay_to.id_loai_giay_to' => $this->id_loai_giay_to,
            'ptx_xe_giay_to.is_active' => $this->is_active,
            'ptx_xe_giay_to.nguoi_tao' => $this->nguoi_tao,
        ]);

        if ($this->bien_so_xe) {
            $query->joinWith('xe');
            $query->andFilterWhere(['like', 'ptx_xe.bien_so_xe', $this->bien_so_xe]);
        }

        if ($this->ngay_bat_dau) {
            $dateBatDau = strpos($this->ngay_bat_dau, '/') !== false ? CustomFunc::convertDMYToYMD($this->ngay_bat_dau) : $this->ngay_bat_dau;
            $query->andFilterWhere(['>=', 'ptx_xe_giay_to.ngay_bat_dau', $dateBatDau . ' 00:00:00']);
        }

        if ($this->ngay_ket_thuc) {
            $dateKetThuc = strpos($this->ngay_ket_thuc, '/') !== false ? CustomFunc::convertDMYToYMD($this->ngay_ket_thuc) : $this->ngay_ket_thuc;
            $query->andFilterWhere(['between', 'ptx_xe_giay_to.ngay_ket_thuc', $dateKetThuc . ' 00:00:00', $dateKetThuc . ' 23:59:59']);
        }

        // Lọc theo tình trạng hết hạn (Hết hạn / Sắp hết hạn / Trong hạn)
        if ($this->tinh_trang_han === 'HET_HAN') {
            $query->joinWith('loaiGiayTo');
            $query->andWhere(['ptx_xe_giay_to.is_active' => XeGiayToBase::STATUS_ACTIVE]);
            $query->andWhere(['ptx_xe_loai_giay_to.check_het_han' => LoaiGiayToBase::CHECK_HET_HAN_CO]);
            $query->andWhere([
                'or',
                'EXISTS (SELECT 1 FROM ptx_xe_giay_to sub WHERE sub.id_xe = ptx_xe_giay_to.id_xe AND sub.id_loai_giay_to = ptx_xe_giay_to.id_loai_giay_to AND sub.is_active = 1 AND sub.id > ptx_xe_giay_to.id)',
                ['and',
                    'NOT EXISTS (SELECT 1 FROM ptx_xe_giay_to sub WHERE sub.id_xe = ptx_xe_giay_to.id_xe AND sub.id_loai_giay_to = ptx_xe_giay_to.id_loai_giay_to AND sub.is_active = 1 AND sub.id > ptx_xe_giay_to.id)',
                    ['<', 'ptx_xe_giay_to.ngay_ket_thuc', date('Y-m-d 00:00:00')]
                ]
            ]);
        } elseif ($this->tinh_trang_han === 'SAP_HET' || $this->tinh_trang_han === 'SAP_HET_HAN') {
            $query->joinWith('loaiGiayTo');
            $query->andWhere(['ptx_xe_giay_to.is_active' => XeGiayToBase::STATUS_ACTIVE]);
            $query->andWhere(['ptx_xe_loai_giay_to.check_het_han' => LoaiGiayToBase::CHECK_HET_HAN_CO]);
            // Phải là bản ghi active mới nhất
            $query->andWhere('NOT EXISTS (SELECT 1 FROM ptx_xe_giay_to sub WHERE sub.id_xe = ptx_xe_giay_to.id_xe AND sub.id_loai_giay_to = ptx_xe_giay_to.id_loai_giay_to AND sub.is_active = 1 AND sub.id > ptx_xe_giay_to.id)');
            // Chưa hết hạn
            $query->andWhere(['>=', 'ptx_xe_giay_to.ngay_ket_thuc', date('Y-m-d 00:00:00')]);
            // Nằm trong số ngày báo trước của loại giấy tờ (mặc định 30 ngày)
            $query->andWhere('DATE(ptx_xe_giay_to.ngay_ket_thuc) <= DATE_ADD(CURDATE(), INTERVAL COALESCE(ptx_xe_loai_giay_to.so_ngay_bao_truoc, 30) DAY)');
        } elseif ($this->tinh_trang_han === 'TRONG_HAN') {
            $query->joinWith('loaiGiayTo');
            $query->andWhere(['ptx_xe_giay_to.is_active' => XeGiayToBase::STATUS_ACTIVE]);
            // Phải là bản ghi active mới nhất
            $query->andWhere('NOT EXISTS (SELECT 1 FROM ptx_xe_giay_to sub WHERE sub.id_xe = ptx_xe_giay_to.id_xe AND sub.id_loai_giay_to = ptx_xe_giay_to.id_loai_giay_to AND sub.is_active = 1 AND sub.id > ptx_xe_giay_to.id)');
            // Và loại giấy tờ không theo dõi hạn HOẶC ngày kết thúc >= ngày hiện tại
            $query->andWhere([
                'or',
                ['ptx_xe_loai_giay_to.check_het_han' => LoaiGiayToBase::CHECK_HET_HAN_KHONG],
                ['>=', 'ptx_xe_giay_to.ngay_ket_thuc', date('Y-m-d 00:00:00')]
            ]);
        }

        $query->andFilterWhere(['like', 'ptx_xe_giay_to.ghi_chu', $this->ghi_chu]);

        return $dataProvider;
    }
}
