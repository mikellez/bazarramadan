<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "bazar".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $shop_name
 * @property string $cover_image
 * @property string|null $tagline
 * @property int $whatsapp_no
 * @property int|null $pbt_location_id
 * @property int|null $bazar_location_id
 * @property int|null $status
 * @property int|null $active
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $click_count
 *
 * @property BazarImage[] $bazarImages
 * @property BazarItems[] $bazarItems
 * @property BazarLocation $bazarLocation
 * @property PbtLocation $pbtLocation
 * @property User $user
 */
class Bazar extends \yii\db\ActiveRecord
{
    const SCENARIO_UPLOAD = 'upload';

    const STATUS_REJECT = -1;
    const STATUS_PENDING = 2;
    const STATUS_APPROVE = 10;

    public $cover_imageFile;
    public $_image;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
             
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bazar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'whatsapp_no', 'pbt_location_id', 'bazar_location_id', 'status', 'active', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status_by', 'status_at', 'click_count','tag'], 'integer'],
            [['shop_name', 'cover_image', 'whatsapp_no', 'pbt_location_id', 'bazar_location_id', 'created_by', 'created_at', 'updated_at', 'updated_by'], 'required', 'message'=>'{attribute} tidak boleh kosong.'],
            [['cover_imageFile'], 'required', 'on'=>'upload'],
            [['cover_image', 'tagline'], 'string'],
            [['cover_imageFile'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles'=>5, 'on'=>'upload'],
            [['shop_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['pbt_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => PbtLocation::class, 'targetAttribute' => ['pbt_location_id' => 'id']],
            [['bazar_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => BazarLocation::class, 'targetAttribute' => ['bazar_location_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['_image', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'shop_name' => 'Nama Kedai',
            'cover_image' => 'Gambar Muka Depan',
            'tagline' => 'Tagline',
            'tag' => 'Kategori',
            'description' => 'Description',
            'whatsapp_no' => 'No Whatsapp',
            'pbt_location_id' => 'Lokasi Pbt ID',
            'bazar_location_id' => 'Lokasi Bazar ID',
            'status' => 'Status',
            'status_by' => 'Status Daripada',
            'active' => 'Aktif',
            'created_at' => 'Dicipta Di',
            'updated_at' => 'Dikemas Kini Pada',
            'click_count' => 'Click Count',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->cover_image->saveAs('uploads/' . $this->cover_image->baseName . '.' . $this->cover_image->extension);
            return true;
        } else {
            return false;
        }
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_APPROVE => 'Approve', 
            self::STATUS_PENDING => 'Pending',
            self::STATUS_REJECT => 'Reject',
        ];
    }

    public function getCoverImageUrl() 
    {
        if(!$this->cover_image) {
            return Yii::$app->params['backendUrl'].'/img/noimg.jpeg';
        }
        return Yii::$app->params['backendUrl'].'/storage/uploads'.$this->cover_image.'?v='.time();
    }

    public static function getTagList()
    {
        return ArrayHelper::map(Tag::find()->asArray()->all(), 'id', 'name');
    }

    public static function getPbtLocationList()
    {
        return ArrayHelper::map(PbtLocation::find()->asArray()->all(), 'id', 'name');
    }

    public static function getBazarLocationList($id)
    {
        return BazarLocation::find()->where(['pbt_location_id'=>$id])->asArray()->all();
    }

    public function save($runValidation = true, $attributeNames = null) 
    {
        if($this->isNewRecord) {
            if($this->cover_imageFile) {
                //$this->image =  Yii::getAlias('/products/'.Yii::$app->security->generateRandomString(32).'/'.$this->imageFile->name);
                $this->cover_image =  Yii::getAlias('/'.time().'_'.$this->cover_imageFile->name);
            }

            $transaction = Yii::$app->db->beginTransaction();
            $ok = parent::save($runValidation, $attributeNames);


            if($ok && $this->cover_imageFile) {
                $fullPath = Yii::getAlias('@backend/web/storage/uploads'.$this->cover_image);
                $dir = dirname($fullPath);
                if(!FileHelper::createDirectory($dir) | !$this->cover_imageFile->saveAs($fullPath)) {
                    $transaction->rollBack();
                    return false;
                }
            }

            $transaction->commit();
            return $ok;

        } else {
            return parent::save($runValidation, $attributeNames);
        }
    }

     /**
     * Gets query for [[BazarItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBazarItems()
    {
        return $this->hasMany(BazarItem::class, ['bazar_id' => 'id']);
    }

    /**
     * Gets query for [[BazarImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBazarImages()
    {
        return $this->hasMany(BazarImage::class, ['bazar_id' => 'id']);
    }

    /**
     * Gets query for [[BazarLocation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBazarLocation()
    {
        return $this->hasOne(BazarLocation::class, ['id' => 'bazar_location_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[PbtLocation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPbtLocation()
    {
        return $this->hasOne(PbtLocation::class, ['id' => 'pbt_location_id']);
    }

     /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    
     /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatusBy()
    {
        return $this->hasOne(User::class, ['id' => 'status_by']);
    }
}
