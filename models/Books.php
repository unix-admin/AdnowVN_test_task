<?php

namespace app\models;

use app\components\behaviors\DateBehavior;
use Yii;

/**
 * This is the model class for table "books".
 *
 * @property integer $id
 * @property string $name
 * @property string $date_create
 * @property string $date_update
 * @property string $preview
 * @property string $date
 * @property integer $author_id
 *
 * @property Authors $author
 */
class Books extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'DateBehavior' => [
                'class' => DateBehavior::className(),
                'createdAtAttribute' => 'date_create',
                'updatedAtAttribute' => 'date_update',
            ]
        ];
    }


    public $image;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date_create', 'date_update', 'date'], 'safe'],
            [['author_id'], 'integer'],
            [['name', 'preview'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'date_create' => 'Дата добавления',
            'date_update' => 'Дата обновления',
            'preview' => 'Превью',
            'date' => 'Дата выхода',
            'author_id' => 'Автор',
            'image' => 'Файл изображения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Authors::className(), ['id' => 'author_id']);
    }

    public function beforeSave($insert)
    {
        if ($this->date){
            $this->date = Yii::$app->formatter->asDate($this->date,'yyyy-MM-dd');
        }

        return parent::beforeSave($insert);
    }

    public function upload()
    {
        if ($this->validate()) {
            $filepath = Yii::getAlias('@app/web/uploads');
            if (!(file_exists($filepath) && is_dir($filepath))){
                mkdir($filepath,0755);
            }
            $this->image->saveAs('uploads/' . $this->image->baseName . '.' . $this->image->extension);
            $this->preview = '/uploads/' . $this->image->baseName . '.' . $this->image->extension;
            return true;
        } else {
            return false;
        }
    }
}
