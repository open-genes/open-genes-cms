<?php

namespace cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class ProteinActivityObject extends \common\models\ProteinActivityObject
{
    public $name;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public static function getAllNamesAsArray()
    {
        $result = self::find()
            ->select(['id', 'concat(name_ru, \' \', \'(\', name_en, \')\') as name'])
            ->all();
        return ArrayHelper::map($result, 'id', 'name');
    }

    public static function createFromNameString(string $name)
    {
        if(strpos($name, '(')) {
            list($nameRu, $nameEn) = explode('(', trim($name));
            $nameEn = trim($nameEn, '()');
        } else {
            $nameRu = $name;
            $nameEn = null;
        }
        $nameRu = trim($nameRu);
        $nameEn = trim($nameEn);

        $proteinActivityObjectQuery = self::find()
            ->where(['name_ru' => $nameRu]);
        if($nameEn) {
            $proteinActivityObjectQuery->orWhere(['name_en' => $nameEn]);
        }
        $arProteinActivityObject = $proteinActivityObjectQuery->one();
        if(!$arProteinActivityObject) {
            $arProteinActivityObject = new self();
        }
        $arProteinActivityObject->name_ru = $nameRu;
        $arProteinActivityObject->name_en = $nameEn;
        $arProteinActivityObject->save();
        return $arProteinActivityObject;
    }
}
