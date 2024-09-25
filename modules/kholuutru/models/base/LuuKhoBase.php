<?php

namespace app\modules\kholuutru\models\base;

use Yii;
use app\modules\kholuutru\models\Ngan;
use app\modules\kholuutru\models\Kho;
use app\modules\kholuutru\models\Ke;
use app\modules\kholuutru\models\Hop;
/**
 * This is the model class for table "kho_luu_kho".
 *
 * @property int $id
 * @property string|null $loai_file
 * @property int $id_file
 * @property int $id_kho
 * @property int $id_ke
 * @property int $id_ngan
 * @property int $id_hop
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $doi_tuong 
 * @property int $id_doi_tuong
 * @property Hop $hop
 * @property Ke $ke
 * @property Kho $kho
 * @property Ngan $ngan
 */
class LuuKhoBase extends \app\models\KhoLuuKho
{
    /**
     * xoa tat ca file tham chieu
     */
    public static function deleteKhoThamChieu($doiTuong, $idDoiTuong){
        $khos = LuuKhoBase::findAll(['doi_tuong'=>$doiTuong, 'id_doi_tuong'=>$idDoiTuong]);
        if($khos){
            foreach ($khos as $kho){
                $kho->delete();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doi_tuong', 'id_doi_tuong'], 'required'],
            [['id_file', 'id_kho', 'id_ke', 'id_ngan', 'id_hop', 'id_doi_tuong','nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['loai_file'], 'string', 'max' => 255],
            [['doi_tuong'], 'string', 'max' => 20],
            [['id_hop'], 'exist', 'skipOnError' => true, 'targetClass' => Hop::class, 'targetAttribute' => ['id_hop' => 'id']],
            [['id_ke'], 'exist', 'skipOnError' => true, 'targetClass' => Ke::class, 'targetAttribute' => ['id_ke' => 'id']],
            [['id_kho'], 'exist', 'skipOnError' => true, 'targetClass' => Kho::class, 'targetAttribute' => ['id_kho' => 'id']],
            [['id_ngan'], 'exist', 'skipOnError' => true, 'targetClass' => Ngan::class, 'targetAttribute' => ['id_ngan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai_file' => 'Loại File',
            'id_file' => 'File',
            'id_kho' => 'Kho',
            'id_ke' => 'Kệ',
            'id_ngan' => 'Ngăn',
            'id_hop' => 'Hộp',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'doi_tuong'=>'Đối tượng',
            'id_doi_tuong'=>'ID đối tượng',
        ];
    }

    /**
     * Gets query for [[Hop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHop()
    {
        return $this->hasOne(Hop::class, ['id' => 'id_hop']);
    }

    /**
     * Gets query for [[Ke]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKe()
    {
        return $this->hasOne(Ke::class, ['id' => 'id_ke']);
    }

    /**
     * Gets query for [[Kho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKho()
    {
        return $this->hasOne(Kho::class, ['id' => 'id_kho']);
    }

    /**
     * Gets query for [[Ngan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNgan()
    {
        return $this->hasOne(Ngan::class, ['id' => 'id_ngan']);
    }
}
