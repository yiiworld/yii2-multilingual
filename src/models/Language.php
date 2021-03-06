<?php

namespace DevGroup\Multilingual\models;

use DevGroup\Multilingual\traits\FileActiveRecord;
use Yii;
use yii2tech\filedb\ActiveRecord;

/**
 * Class Language
 *
 * @property integer $id
 * @property string $name
 * @property string $name_native
 * @property string $iso_639_1 ISO 639-1
 * @property string $iso_639_2t ISO 639-2/T
 * @property string $domain
 * @property string $yii_language
 * @property string $hreflang
 * @property array  $context_rules
 * @property string $db_table_postfix
 */
class Language extends ActiveRecord implements LanguageInterface
{
    use FileActiveRecord;

    public function rules()
    {
        return [
            [['name', 'domain', 'yii_language', 'iso_639_1', 'iso_639_2t'], 'required'],
            [['name', 'name_native', 'domain', 'yii_language', 'hreflang'], 'string'],
            [['iso_639_1'], 'string', 'max' => 2],
            [['iso_639_2t'], 'string', 'max' => 3],
            [['context_id', 'sort_order'], 'integer'],
            [['context_rules',], 'safe'],
        ];
    }

    public static function getById($id)
    {
        return self::findOne(['id' => $id]);
    }

    public static function getAll()
    {
        return static::find()->orderBy(['sort_order' => SORT_ASC])->all();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function rulesForContext($context_id)
    {
        return isset($this->context_rules[$context_id]) ? $this->context_rules[$context_id] : null;
    }
}
