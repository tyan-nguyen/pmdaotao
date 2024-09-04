<?php

namespace app\modules\kholuutru\models\base;

use Yii;

/**
 * This is the model class for table "kho_file".
 *
 * @property int $id
 * @property int $ten_loai
 * @property string|null $file_name
 * @property string|null $file_type
 * @property string|null $file_size
 * @property string $file_display_name
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $doi_tuong
 * @property int $id_doi_tuong
 *
 * @property KhoLoaiFile $tenLoai
 */
class FileBase extends \app\models\KhoFile
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_loai', 'file_display_name', 'id_doi_tuong'], 'required'],
            [['ten_loai', 'nguoi_tao', 'id_doi_tuong'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['file_name', 'file_type', 'file_size', 'file_display_name'], 'string', 'max' => 255],
            [['doi_tuong'], 'string', 'max' => 20],
            [['ten_loai'], 'exist', 'skipOnError' => true, 'targetClass' => LoaiFileBase::class, 'targetAttribute' => ['ten_loai' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai' => 'Tên loại file',
            'file_name' => 'Tên loại',
            'file_type' => 'Loại tệp',
            'file_size' => 'Dung lượng',
            'file_display_name' => 'Tên hiển thị',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'doi_tuong' => 'Đối tượng', //<vanban/hocvien..>
            'id_doi_tuong' => 'ID đối tượng tham chiếu', //id từ table van_ban, hoc_vien...
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
}
