<?php

namespace app\modules\daotao\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\daotao\models\KeHoach;
use app\custom\CustomFunc;
use yii\db\Expression;
use app\modules\user\models\User;

/**
 * KeHoachSearch represents the model behind the search form about `app\modules\daotao\models\KeHoach`.
 */
class KeHoachSearch extends KeHoach
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_giao_vien', 'id_nguoi_duyet', 'nguoi_tao'], 'integer'],
            [['ngay_thuc_hien', 'trang_thai_duyet', 'noi_dung_duyet', 'thoi_gian_duyet', 'thoi_gian_tao', 'ghi_chu'], 'safe'],
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
        $query = KeHoach::find();

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
			$query->andFilterWhere ( [ 'OR' ,['like', 'trang_thai_duyet', $cusomSearch],
            ['like', 'noi_dung_duyet', $cusomSearch]] );
 
		} else {
		    if($this->ngay_thuc_hien){
		        $this->ngay_thuc_hien = CustomFunc::convertDMYToYMD($this->ngay_thuc_hien);
		    }
		    if($this->thoi_gian_duyet){
		        $this->thoi_gian_duyet = CustomFunc::convertDMYToYMD($this->thoi_gian_duyet);
		        $query->andWhere("DATE(thoi_gian_duyet) = '" . $this->thoi_gian_duyet . "'");
		    }
        	$query->andFilterWhere([
            'id' => $this->id,
            'id_giao_vien' => $this->id_giao_vien,
            'ngay_thuc_hien' => $this->ngay_thuc_hien,
            'id_nguoi_duyet' => $this->id_nguoi_duyet,
            'thoi_gian_tao' => $this->thoi_gian_tao,
            'nguoi_tao' => $this->nguoi_tao,
        ]);

        $query->andFilterWhere(['like', 'trang_thai_duyet', $this->trang_thai_duyet])
            ->andFilterWhere(['like', 'noi_dung_duyet', $this->noi_dung_duyet]);
		}
        return $dataProvider;
    }
    
    /**
     * search for Kế hoạch của giáo viên
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchGiaoVien($params, $cusomSearch=NULL)
    {
        $query = KeHoach::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $user = User::findOne(Yii::$app->user->id);
        if($user->getIdGiaoVien()!=null){
            $query->andFilterWhere([
                'id_giao_vien' => $user->getIdGiaoVien(),
            ]);
        } else {
            $query->where('0=1');
        }
        
        if($cusomSearch != NULL){
            $query->andFilterWhere ( [ 'OR' ,['like', 'trang_thai_duyet', $cusomSearch],
                ['like', 'noi_dung_duyet', $cusomSearch]] );
            
        } else {
            if($this->ngay_thuc_hien){
                $this->ngay_thuc_hien = CustomFunc::convertDMYToYMD($this->ngay_thuc_hien);
            }
            if($this->thoi_gian_duyet){
                $this->thoi_gian_duyet = CustomFunc::convertDMYToYMD($this->thoi_gian_duyet);
                $query->andWhere("DATE(thoi_gian_duyet) = '" . $this->thoi_gian_duyet . "'");
            }
            $query->andFilterWhere([
                'id' => $this->id,
                //'id_giao_vien' => $this->id_giao_vien,
                'ngay_thuc_hien' => $this->ngay_thuc_hien,
                'id_nguoi_duyet' => $this->id_nguoi_duyet,
                'thoi_gian_tao' => $this->thoi_gian_tao,
                'nguoi_tao' => $this->nguoi_tao,
            ]);
            
            $query->andFilterWhere(['like', 'trang_thai_duyet', $this->trang_thai_duyet])
            ->andFilterWhere(['like', 'noi_dung_duyet', $this->noi_dung_duyet]);
        }
        return $dataProvider;
    }
}
