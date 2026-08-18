<?php

namespace app\modules\daotao\models;

use app\custom\CustomFunc;
use Yii;

/**
 * This is the model class for table "gd_hinh_anh".
 *
 * @property int $id
 * @property string $loai KEHOACH,LICHDUNGXE
 * @property int $id_giao_vien
 * @property string $date
 * @property int|string $file_name
 * @property int $file_size
 * @property string $extension
 * @property string|null $luot DI, VE
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 */
class HinhAnh extends \app\models\GdHinhAnh
{
    const LOAI_KEHOACH = 'KEHOACH';
    const LOAI_LICHDUNGXE = 'LICHDUNGXE';

    const LUOT_DI = 'DI';
    const LUOT_VE = 'VE';

    /**
     * Mảng loại hình ảnh mặc định
     */
    public static $loaiHinhAnh = [
        self::LOAI_KEHOACH => 'Kế hoạch',
        self::LOAI_LICHDUNGXE => 'Lịch dùng xe',
    ];

    /**
     * Mảng phân loại lượt đi / về
     */
    public static $luotList = [
        self::LUOT_DI => 'Lượt đi',
        self::LUOT_VE => 'Lượt về',
    ];

    /**
     * Danh sách loại hình ảnh dùng cho dropdownlist
     */
    public static function getLoaiHinhAnhList()
    {
        return self::$loaiHinhAnh;
    }

    /**
     * Truy xuất label của loại hình ảnh
     */
    public static function getLoaiHinhAnhLabel($loai)
    {
        $list = self::getLoaiHinhAnhList();
        return isset($list[$loai]) ? $list[$loai] : $loai;
    }

    /**
     * Danh sách lượt đi / về
     */
    public static function getLuotList()
    {
        return self::$luotList;
    }

    /**
     * Truy xuất label lượt đi / về
     */
    public static function getLuotLabel($luot)
    {
        $list = self::getLuotList();
        return isset($list[$luot]) ? $list[$luot] : $luot;
    }

    /**
     * Lấy đường dẫn URL hình ảnh
     */
    public function getUrlAnh()
    {
        if (empty($this->file_name)) {
            return '';
        }
        if (strpos($this->file_name, '/') !== false) {
            return Yii::getAlias('@web/') . ltrim($this->file_name, '/');
        }
        return Yii::getAlias('@web/uploads/giangday/') . $this->file_name;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['luot'], 'default', 'value' => self::LUOT_DI],
            [['loai', 'id_giao_vien', 'date', 'file_name', 'file_size', 'extension'], 'required'],
            [['id_giao_vien', 'file_size', 'nguoi_tao'], 'integer'],
            [['date', 'thoi_gian_tao'], 'safe'],
            [['loai'], 'string', 'max' => 20],
            [['luot'], 'string', 'max' => 10],
            [['file_name', 'extension'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai' => 'Loại',
            'luot' => 'Lượt (Đi/Về)',
            'id_giao_vien' => 'Giáo viên',
            'date' => 'Ngày',
            'file_name' => 'Tên file lưu',
            'file_size' => 'Dung lượng file',
            'extension' => 'Phần mở rộng file',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (empty($this->date)) {
                $this->date = date('Y-m-d');
            } else {
                $this->date = CustomFunc::convertDMYToYMD($this->date);
            }

            if ($this->isNewRecord) {
                if (empty($this->nguoi_tao) && isset(Yii::$app->user) && !Yii::$app->user->isGuest) {
                    $this->nguoi_tao = Yii::$app->user->id;
                }
                if (empty($this->thoi_gian_tao)) {
                    $this->thoi_gian_tao = date('Y-m-d H:i:s');
                }
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function afterDelete()
    {
        parent::afterDelete();

        if (!empty($this->file_name)) {
            $filePath = Yii::getAlias('@webroot') . '/' . ltrim($this->file_name, '/');
            if (file_exists($filePath) && is_file($filePath)) {
                @unlink($filePath);
            } else {
                $filePathUploads = Yii::getAlias('@webroot') . '/uploads/giangday/' . $this->file_name;
                if (file_exists($filePathUploads) && is_file($filePathUploads)) {
                    @unlink($filePathUploads);
                }
            }
        }
    }
}
